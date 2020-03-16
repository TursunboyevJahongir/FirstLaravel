<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\District;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DistrictController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        return \response()->json(District::paginate(15));
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
            'region_id'=>'required',
            'name'=>'required'
        ]);
        $data = District::create($request->all());

        return response()->json([
            'status' => 'ok',
            'message' => 'Great success! New District created',
            'data' => $data,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $data = District::query()->where('id', '=', $id)->with('region')->first();
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
     * @param District $id
     * @return JsonResponse
     */
    public function update(Request $request,District $id)
    {
        $request->validate([
            'region_id'=>'nullable',
            'name'=>'nullable',
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
     * @param District $id
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(District $id)
    {
        $id->delete();
        return \response()->json([
            'status' => 'ok',
            'message' => ' deleted',
            'data' => ''
        ]);
    }
}
