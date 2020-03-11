<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Models\Product;
use App\Models\Shop;
use Exception;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $shop = Shop::get();
        $shop = $shop->each(function ($el) {
            return mb_substr($el->description, 0, 5);
        });
        return \response()->json($shop);
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
            'name' => 'required|min:3',
            'phone' => 'required|min:5',
            'password' => 'required|min:6',
            'description' => 'required|min:10',
            'longitude' => 'required',
            'latitude' => 'required',
        ]);

        $data = Shop::create($request->all());

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
        $data = Shop::query()->where('id', '=', $id)->first();
        // $check = $data->first();
        if (is_null($data)) {
            return \response()->json([
                'status' => 'error',
                'message' => 'Not found',
                'data' => null,
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
            'name' => 'nullable',
            'phone' => 'nullable',
            'password' => 'nullable',
            'description' => 'nullable',
            'longitude' => 'nullable',
            'latitude' => 'nullable',
        ]);

        $id->update($request->all());

        return response()->json([
            'message' => 'Great success! Task updated',
            'task' => $id,
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
            'data' => null
        ]);
    }
}
