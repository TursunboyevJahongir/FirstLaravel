<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Region;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        return \response()->json(Region::paginate(15));
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
            'name' => 'required'
        ]);
        $data = Region::create($request->all());

        return response()->json([
            'status' => 'ok',
            'message' => 'Great success! New District created',
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
        $data = Region::query()->where('id', '=', $id)->first();
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
     * @param Region $id
     * @return JsonResponse
     */
    public function update(Request $request, Region $id)
    {
        $request->validate([
            'name' => 'nullable',
        ]);

        $id->update($request->all());

        return response()->json([
            'message' => 'Great success! updated',
            'data' => $id,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Region $id
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Region $id)
    {
        $id->delete();
        return \response()->json([
            'status' => 'ok',
            'message' => ' deleted',
            'data' => null
        ]);
    }
}
