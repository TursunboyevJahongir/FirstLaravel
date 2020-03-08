<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\District;
use App\Models\Image;
use App\Models\Manufacturer;
use App\Models\Product;
use App\Models\Region;
use App\Models\Shop;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $order = $request->get('order') ?: 'created_at';
        $sort = $request->get('sort') ?: 'desc';
        // return $this->all(columns);
        // return \response()->json(Product::all('id','name'));
        // Table::where('id', 1)->get(['name','surname']);
        $data = Product::select('id', 'name', 'description', 'price', 'image_id', 'discount', 'district_id')->orderBy($order, $sort);
        if ($request->get('min')) {
            $data->where('price', '>=', $request->get('min'));
        }
        if ($request->get('max')) {
            $data->where('price', '<=', $request->get('max'));
        }

        if ($request->get('category')) {
            $cat_id = Category::where('name', '=', $request->get('category'))->first();
            if ($cat_id) {
                $data->where('category_id', '=', $cat_id->id);
            }
        }

        if ($request->get('region')) {
            $data->where('region_id', '=', $request->get('region'));
        }


        return \response()->json($data->paginate(15)->appends($request->all(['category', 'max', 'min', 'order', 'sort'])));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'district_id' => 'required',
            'category_id' => 'required',
            'shop_id' => 'required',
            'manufacturer_id' => 'required',
            'name' => 'required|min:3',
            'price' => 'required|min:5',
            'description' => 'nullable',
            'discount' => 'nullable|digits_between:0,100',
            'photos' => 'nullable|image'
        ]);

        $all = $request->all();
        $reg_id = District::where('id', '=', $all['district_id'])->first();
        $all['region_id'] = $reg_id->region_id;

        $data = Product::create($all);

        $index = null;
        if ($request->file('photos')) {
            if (!$request->hasFile('photos')) {
                return response()->json(['upload_file_not_found'], 400);
            }

            $allowedfileExtension = ['jpg', 'png', 'jpeg'];
            $files[] = $request->file('photos');

            foreach ($files as $mediaFile) {
                $extension = $mediaFile->getClientOriginalExtension();
                $check = in_array($extension, $allowedfileExtension);
                if ($check) {
                    $media = new Image();
                    $File = uniqid() . '.' . $extension;
                    $mediaFile->move(public_path() . '/uploads/products/', $File);
                    $path = 'uploads/products/' . $File;
                    \Intervention\Image\Facades\Image::make(public_path($path))->fit(1024)->save(public_path('/uploads/products/') . '1024_' . $File);
                    \Intervention\Image\Facades\Image::make(public_path($path))->fit(255)->save(public_path('/uploads/products/') . '255_' . $File);
                    $media->thumb_1024 = '/uploads/products/1024_' . $File;
                    $media->thumb_255 = '/uploads/products/255_' . $File;
                    $media->path = '/uploads/products/' . $File;
                    $media->product_id = $data->id;
                    $media->save();
                    if (is_null($index)) {
                        $index = $media->id;
                    }
                } else {
                    return response()->json(['invalid_file_format'], 422);
                }
            }
            $data->update([
                'image_id' => $index
            ]);
        }
        return response()->json([
            'status' => 'ok',
            'message' => 'Great success! Product created',
            'data' => $data,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     *
     * @property Category $category
     * @property Manufacturer $manufacturer
     * @property Shop $shop
     * @property Image $image
     * @property District $district
     */
    public function show($id)
    {
        $data = Product::query()->where('id', '=', $id)->with('district', 'district.region', 'category', 'shop', 'image')->first();
        $image = Image::query()->where('product_id', '=', $data->id)->get();
        if (is_null($data)) {
            return \response()->json([
                'status' => 'error',
                'message' => '',
                'data' => null
            ]);
        } else {
            /**
             * view Counter
             *
             * UPDATE `products` SET `view` = `view`+1 WHERE id = (count)
             */
            $view = Product::where('id', '=', $id)->first();
            $view->view += 1;
            DB::table('products')
                ->where('id', $id)
                ->update(['view' => $view->view]);
            return \response()->json([
                'status' => 'ok',
                'message' => '',
                'data' => $data,
                'images' => $image
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Product $id
     * @return JsonResponse
     */
    public function update(Request $request, Product $id)
    {
        $request->validate([
            'district_id' => 'nullable',
            'category_id' => 'nullable',
            'shop_id' => 'nullable',
            'manufacturer_id' => 'nullable',
            'image' => 'nullable',
            'name' => 'nullable|min:3',
            'price' => 'nullable|min:5',
            'description' => 'nullable',
            'discount' => 'nullable',
        ]);

        $all = $request->all();
        if ($request->file('image')) {
            if (!$request->hasFile('image')) {
                return response()->json(['upload_file_not_found'], 400);
            }
            $file = $request->file('image');
            if (!$file->isValid()) {
                return response()->json(['invalid_file_upload'], 400);
            }
            $path = public_path() . '/uploads/products/';
            $fileName = $file->getATime() . '.' . $file->getClientOriginalExtension();
            $file->move($path, $fileName);
            $path = '/uploads/products/' . $fileName;

            $all = $request->all();
            $all['image'] = $path;
        }

        $id->update($all);

        return response()->json([
            'message' => 'Great success! Product updated',
            'task' => $id,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Product $id
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Product $id)
    {
        $id->delete();
        return \response()->json([
            'status' => 'ok',
            'message' => '',
            'data' => null
        ]);
    }
}
