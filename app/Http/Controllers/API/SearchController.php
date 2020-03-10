<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
       public function search($q)
       {
              $count = Product::where('name', 'LIKE', '%' . $q . '%')->orWhere('description', 'LIKE', '%' . $q . '%')->count();
              $product = Product::select('id', 'name', 'description', 'price', 'default_image', 'discount')->where('name', 'LIKE', '%' . $q . '%')->orWhere('description', 'LIKE', '%' . $q . '%')->limit(10)->get();

              $ShopCount = Shop::where('name', 'LIKE', '%' . $q . '%')->orWhere('description', 'LIKE', '%' . $q . '%')->count();
              $Shop = Shop::where('name', 'LIKE', '%' . $q . '%')->orWhere('description', 'LIKE', '%' . $q . '%')->limit(10)->get();

              if (count($product) > 0)
                     return response()->json([
                            'status' => 'ok',
                            'message' => '',
                            'data' => [
                                   'ProductCount' => $count,
                                   'Product' => $product,
                                   'ShopCount' => $ShopCount,
                                   'Shops' => $Shop
                            ],
                            "Show All Shops" => "/api/searchShops/" . $q,
                            "Show All Products" => "/api/searchProducts/" . $q,
                     ]);
              else
                     return response()->json([
                            'status' => 'ok',
                            'message' => 'not found',
                            'data' => null,

                     ]);
       }

       public function searchShops($q)
       {
              // $Shop = Shop::where('name', 'LIKE', '%' . $q . '%')->orWhere('description', 'LIKE', '%' . $q . '%')->count();
              $Shop = Shop::where('name', 'LIKE', '%' . $q . '%')->orWhere('description', 'LIKE', '%' . $q . '%')->Paginate(15);
              if (count($Shop) > 0)
                     return response()->json([
                            'status' => 'ok',
                            'message' => '',
                            'data' => $Shop,
                     ]);
              else
                     return response()->json([
                            'status' => 'ok',
                            'message' => 'not found',
                            'data' => null,
                     ]);
       }

       public function searchProducts(Request $request, $q)
       {
              $order = $request->get('order') ?: 'created_at';
              $sort = $request->get('sort') ?: 'desc';

              // $count = Product::where('name', 'LIKE', '%' . $q . '%')->orWhere('description', 'LIKE', '%' . $q . '%')->count();
              $product = Product::select('id', 'name', 'description', 'price', 'default_image', 'discount')->where('name', 'LIKE', '%' . $q . '%')->orWhere('description', 'LIKE', '%' . $q . '%')->orderBy($order, $sort);
              if ($request->get('min')) {
                     $product->where('price', '>=', $request->get('min'));
              }
              if ($request->get('max')) {
                     $product->where('price', '<=', $request->get('max'));
              }

              return response()->json([
                     'status' => 'ok',
                     'message' => '',
                     'data' => $product->Paginate(15),
              ]);
       }
}
