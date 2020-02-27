<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Favourite;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FavouriteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        return \response()->json(Favourite::paginate(15));
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
            'product_id'=>'required',
            'user_id'=>'required'
        ]);
        $data = Favourite::create($request->all());

        return response()->json([
            'status' => 'ok',
            'message' => 'Great success! New',
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
        $data = Favourite::where('id', '=', $id)->with('product','user')->first();
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
     * @param Favourite $id
     * @return JsonResponse
     */
    public function update(Request $request,Favourite $id)
    {
        $request->validate([
            'product_id'=>'nullable',
            'user_id'=>'nullable',
        ]);

        $id->update($request->all());

        return response()->json([
            'message' => 'Great success! updated',
            'task' => $id,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Favourite $id
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Favourite $id)
    {
        $id->delete();
        return \response()->json([
            'status' => 'ok',
            'message' => ' deleted',
            'data' => null
        ]);
    }
}
