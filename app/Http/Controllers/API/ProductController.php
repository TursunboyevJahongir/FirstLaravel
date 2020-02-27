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
        $data = Product::select('id', 'name', 'description', 'price', 'default_image', 'discount', 'district_id')->orderBy($order, $sort);
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
            'default_image' => 'nullable',
            'name' => 'required|min:3',
            'price' => 'required|min:5',
            'description' => 'nullable',
            'discount' => 'nullable',
        ]);

        $data = Product::create($request->all());

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
        if (is_null($data)) {
            return \response()->json([
                'status' => 'error',
                'message' => '',
                'data' => null
            ]);
        } else {
            return \response()->json([
                'status' => 'ok',
                'message' => '',
                'data' => $data
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
            'default_image' => 'nullable',
            'name' => 'nullable|min:3',
            'price' => 'nullable|min:5',
            'description' => 'nullable',
            'discount' => 'nullable',
        ]);

        $id->update($request->all());

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
