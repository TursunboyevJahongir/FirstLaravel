<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Shop;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
//        $shop = Shop::get();
//        $shop = $shop->each(function ($el) {
//            return mb_substr($el->description, 0, 1, 1);
//        });
        return \response()->json(Shop::paginate(15));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'name' => 'required|min:3',
            'phone' => 'required|min:5',
            'description' => 'required|min:10',
            'image' => 'nullable',
            'longitude' => 'nullable',
            'latitude' => 'nullable',
            'open_time' => 'nullable',
            'close_time' => 'nullable',
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
            $path = public_path() . '/uploads/shops/';
            $fileName = $file->getATime() . '.' . $file->getClientOriginalExtension();
            $file->move($path, $fileName);
            $path = '/uploads/shops/' . $fileName;

            $all['image'] = '/uploads/shops/1024_' . $fileName;
            $all['thumb'] = '/uploads/shops/255_' . $fileName;

            \Intervention\Image\Facades\Image::make(public_path($path))->fit(1024)->save(public_path('/uploads/shops/') . '1024_' . $fileName)->save();
            \Intervention\Image\Facades\Image::make(public_path($path))->fit(255)->save(public_path('/uploads/shops/') . '255_' . $fileName)->save();
            @unlink(public_path() . $path);
        }
        $all['status'] = -1;
        $data = Shop::create($all);

        return response()->json([
            'status' => 'ok',
            'message' => 'Great success! New Shop created',
            'data' => $data,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $data = Shop::query()->where('id', '=', $id)->with('user')->first();
        // $check = $data->first();
        if (is_null($data)) {
            return \response()->json([
                'status' => 'error',
                'message' => 'Not found',
                'data' => '',
            ], 404);
        }

        // $check = $data;
        // $data->short_desc = false;
        return \response()->json([
            'status' => 'ok',
            'message' => '',
            'data' => $data,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Shop $id
     * @return JsonResponse
     */
    public function update(Request $request, Shop $id)
    {
        $request->validate([
            'user_id' => 'nullable',
            'name' => 'nullable|min:3',
            'phone' => 'nullable|min:5',
            'description' => 'nullable|min:10',
            'image' => 'nullable',
            'longitude' => 'nullable',
            'latitude' => 'nullable',
            'open_time' => 'nullable',
            'close_time' => 'nullable',
        ]);
        $all = $request->all();
        if ($request->file('image')) {
            @unlink(public_path() . $id->image);
            @unlink(public_path() . $id->thumb);
            if (!$request->hasFile('image')) {
                return response()->json(['upload_file_not_found'], 400);
            }
            $file = $request->file('image');
            if (!$file->isValid()) {
                return response()->json(['invalid_file_upload'], 400);
            }
            $path = public_path() . '/uploads/shops/';
            $fileName = $file->getATime() . '.' . $file->getClientOriginalExtension();
            $file->move($path, $fileName);
            $path = '/uploads/shops/' . $fileName;

            $all['image'] = '/uploads/shops/1024_' . $fileName;
            $all['thumb'] = '/uploads/shops/255_' . $fileName;

            \Intervention\Image\Facades\Image::make(public_path($path))->fit(1024)->save(public_path('/uploads/shops/') . '1024_' . $fileName)->save();
            \Intervention\Image\Facades\Image::make(public_path($path))->fit(255)->save(public_path('/uploads/shops/') . '255_' . $fileName)->save();
            @unlink(public_path() . $path);
        }

        $id->update($all);

        return response()->json([
            'message' => 'Great success! Task updated',
            'data' => $id,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Shop $id
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Shop $id)
    {
        @unlink(public_path() . $id->image);
        @unlink(public_path() . $id->thumb);
        $products = Product::where('shop_id', '=', $id->id)->get();
        foreach ($products as $product):
            $images = \App\Models\Image::where('product_id', '=', $product->id)->get();
            foreach ($images as $image):
                @unlink(public_path() . $image->path);
                @unlink(public_path() . $image->thumb_255);
                @unlink(public_path() . $image->thumb_1024);
                $image->delete();
            endforeach;
            $product->delete();
        endforeach;
        $id->delete();
        return \response()->json([
            'status' => 'ok',
            'message' => '',
            'data' => ''
        ]);
    }
}
