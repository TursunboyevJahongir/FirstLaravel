<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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
            'name' => 'required',
            'thumb' => 'nullable',
            'thumb_128' => 'nullable',
        ]);
        $data = Category::create($request->all());

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
            'thumb' => 'nullable',
            'thumb_128' => 'nullable',
        ]);

        $id->update($request->all());

        return response()->json([
            'message' => 'Great success! Category updated',
            'task' => $id,
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
        $id->delete();
        return \response()->json([
            'status' => 'ok',
            'message' => 'category deleted',
            'data' => null
        ]);
    }
}
