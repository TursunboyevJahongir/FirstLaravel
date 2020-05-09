<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Intervention\Image\Facades\Image;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        return \response()->json(Category::paginate(15));
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
            'parent_id' => 'nullable',
            'name' => 'required|unique:categories',
            'slug' => 'required|unique:categories',
            'thumb' => 'nullable',
        ]);
        $all = $request->all();
        if ($request->file('thumb')) {
            if (!$request->hasFile('thumb')) {
                return response()->json(['upload_file_not_found'], 400);
            }
            $file = $request->file('thumb');
            if (!$file->isValid()) {
                return response()->json(['invalid_file_upload'], 400);
            }
            $path = public_path() . '/uploads/categories/';
            $fileName = $file->getATime() . '.' . $file->getClientOriginalExtension();
            $file->move($path, $fileName);
            $path = '/uploads/categories/' . $fileName;
            $all['thumb'] = $path;
            $all['thumb_128'] = '/uploads/categories/128_' . $fileName;
            Image::make(public_path($path))->fit(128)->save(public_path('/uploads/categories/') . '128_' . $fileName)->save();
            Image::make(public_path($path))->fit(1024)->save();
        }
        $data = Category::create($all);

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
        $data = Category::query()->where('id', '=', $id)->with('category')->first();
        return \response()->json([
            'status' => 'ok',
            'message' => '',
            'data' => $data
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Category $id
     * @return JsonResponse
     */
    public function update(Request $request, Category $id)
    {
        $request->validate([
            'parent_id' => 'nullable',
            'name' => 'nullable',
            'slug' => 'nullable',
            'thumb' => 'nullable',
        ]);

        $all = $request->all();
        if ($request->file('thumb')) {
            @unlink(public_path() . $id->thumb);
            @unlink(public_path() . $id->thumb_128);
            if (!$request->hasFile('thumb')) {
                return response()->json(['upload_file_not_found'], 400);
            }
            $file = $request->file('thumb');
            if (!$file->isValid()) {
                return response()->json(['invalid_file_upload'], 400);
            }
            $path = public_path() . '/uploads/categories/';
            $fileName = $file->getATime() . '.' . $file->getClientOriginalExtension();
            $file->move($path, $fileName);
            $path = '/uploads/categories/' . $fileName;
            $all['thumb'] = $path;
            $all['thumb_128'] = '/uploads/categories/128_' . $fileName;
            Image::make(public_path($path))->fit(128)->save(public_path('/uploads/categories/') . '128_' . $fileName)->save();
            Image::make(public_path($path))->fit(1024)->save();
        }
        $id->update($all);

        return response()->json([
            'message' => 'Great success! Category updated',
            'data' => $id,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Category $id
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Category $id)
    {
        @unlink(public_path() . $id->thumb);
        @unlink(public_path() . $id->thumb_128);
        $products = \App\Models\Product::where('category_id', '=', $id->id)->get();
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
            'message' => 'category deleted',
            'data' => ''
        ]);
    }
}
