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
        $data = Product::select('id', 'name', 'description', 'price', 'image_id', 'discount', 'district_id', 'category_id')->orderBy($order, $sort)->with('image');
        if ($request->get('min')) {
            $data->where('price', '>=', $request->get('min'));
        }
        if ($request->get('max')) {
            $data->where('price', '<=', $request->get('max'));
        }

//        if ($request->get('category')) {
//            $cat_id = Category::where('name', '=', $request->get('category'))->first();
//            if ($cat_id) {
//                $data->where('category_id', '=', $cat_id->id);
//            }
//        }

        if ($request->get('category')) {
            $data->where('category_id', '=', $request->get('category'));
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
            'price' => 'required',
            'description' => 'nullable',
            'discount' => 'nullable|digits_between:0,100',
            'images' => 'nullable'
        ]);

        $all = $request->all();
        $reg_id = District::where('id', '=', $all['district_id'])->first();
        $all['region_id'] = $reg_id->region_id;

        $data = Product::create($all);

        $index = null;
        if ($request->file('images')) {
            if (!$request->hasFile('images')) {
                return response()->json(['upload_file_not_found'], 400);
            }

            $allowedfileExtension = ['jpg', 'png', 'jpeg'];
            $files = $request->file('images');

            foreach ($files as $mediaFile) {
                $extension = $mediaFile->getClientOriginalExtension();
                $check = in_array($extension, $allowedfileExtension);
                if ($check) {
                    $media = new Image();
                    $mFile = uniqid() . '.' . $extension;
                    $mediaFile->move(public_path() . '/uploads/products/', $mFile);
                    $path = 'uploads/products/' . $mFile;
                    \Intervention\Image\Facades\Image::make(public_path($path))->fit(1024)->save(public_path('/uploads/products/') . '1024_' . $mFile);
                    \Intervention\Image\Facades\Image::make(public_path($path))->fit(255)->save(public_path('/uploads/products/') . '255_' . $mFile);
                    $media->thumb_1024 = '/uploads/products/1024_' . $mFile;
                    $media->thumb_255 = '/uploads/products/255_' . $mFile;
                    $media->path = '/uploads/products/' . $mFile;
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
            DB::table('images')
                ->where('id', $index)
                ->update(['main_img' => 1]);
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
        $data = Product::query()->where('id', '=', $id)->with('district', 'district.region', 'category', 'shop', 'image', 'images')->first();
        if (is_null($data)) {
            return \response()->json([
                'status' => 'error',
                'message' => 'not found',
                'data' => ''
            ]);
        } else {
            /**
             * view Counter
             *
             * UPDATE `products` SET `view` = `view`+1 WHERE id = (count)
             */
            $view = Product::where('id', '=', $id)->first();
            $view->view_count += 1;
            DB::table('products')
                ->where('id', $id)
                ->update(['view_count' => $view->view_count]);
            return \response()->json([
                'status' => 'ok',
                'message' => '',
                'data' => $data,
            ]);
        }
    }

    public function SetGlobalImage(Product $id, Request $request)
    {
        $past_image = $produt_id = Image::where('id', $id->image_id)->first();
        $image = $request->post('image_id');

        $produt_id = Image::where('id', $image)->first();
        if (empty($produt_id))
            return response()->json([
                'status' => 'error',
                'message' => ' bunday rasm mavjud emas !',
                'data' => '',
            ]);
        if ($id->id != $produt_id->product_id)
            return response()->json([
                'status' => 'error',
                'message' => ' Ma\'lumotlarda xatolik !',
                'data' => '',
            ]);
        if ($image And $id->id = $produt_id->product_id) {
            $produt_id->update(['main_img'=>true]);
            $past_image->update(['main_img'=>false]);
            $id->update([
                'image_id' => $image
            ]);
            return response()->json([
                'status' => 'ok',
                'message' => 'asosiy rasm tanlandi',
                'data' => $produt_id,
            ]);
        } else
            return response()->json([
                'status' => 'error',
                'message' => " ma'lumotlarda xatolik !",
                'data' => '',
            ]);
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
            'name' => 'nullable|min:3',
            'price' => 'nullable',
            'description' => 'nullable',
            'discount' => 'nullable',
            'images' => 'nullable',
        ]);

        $all = $request->all();
        if ($request->file('images')) {
            if (!$request->hasFile('images')) {
                return response()->json(['upload_file_not_found'], 400);
            }

            $allowedfileExtension = ['jpg', 'png', 'jpeg'];
            $files = $request->file('images');

            foreach ($files as $mediaFile) {
                $extension = $mediaFile->getClientOriginalExtension();
                $check = in_array($extension, $allowedfileExtension);
                if ($check) {
                    $media = new Image();
                    $mFile = uniqid() . '.' . $extension;
                    $mediaFile->move(public_path() . '/uploads/products/', $mFile);
                    $path = 'uploads/products/' . $mFile;
                    \Intervention\Image\Facades\Image::make(public_path($path))->fit(1024)->save(public_path('/uploads/products/') . '1024_' . $mFile);
                    \Intervention\Image\Facades\Image::make(public_path($path))->fit(255)->save(public_path('/uploads/products/') . '255_' . $mFile);
                    $media->thumb_1024 = '/uploads/products/1024_' . $mFile;
                    $media->thumb_255 = '/uploads/products/255_' . $mFile;
                    $media->path = '/uploads/products/' . $mFile;
                    $media->product_id = $id->id;
                    $media->save();

                } else {
                    return response()->json(['invalid_file_format'], 422);
                }
            }
        }

        $id->update($all);

        return response()->json([
            'message' => 'Great success! Product updated',
            'data' => $id,
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
        $images = Image::where('product_id', '=', $id->id)->get();
        foreach ($images as $image):
            @unlink(public_path() . $image->path);
            @unlink(public_path() . $image->thumb_255);
            @unlink(public_path() . $image->thumb_1024);
            $image->delete();
        endforeach;

        $id->delete();
        return \response()->json([
            'status' => 'ok',
            'message' => '',
            'data' => ''
        ]);
    }
}
