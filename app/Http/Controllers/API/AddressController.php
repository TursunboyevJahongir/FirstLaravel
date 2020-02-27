<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Address;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        return \response()->json(Address::paginate(15));
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
            'district_id' => 'required',
            'name' => 'required',
        ]);

        $data = Address::create($request->all());

        return response()->json([
            'status' => 'ok',
            'message' => 'Great success! New Shop created',
            'data' => $data,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show($id){
        $data = Address::query()->where('id', '=', $id)->with('district', 'district.region')->first();
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
     * @param Address $id
     * @return JsonResponse
     */
    public function update(Request $request,Address $id)
    {
        $request->validate([
            'district_id' => 'nullable',
            'name' => 'nullable',
        ]);

        $id->update($request->all());
        return response()->json([
            'message' => 'Great success! Address updated',
            'task' => $id,
        ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return void
     */
    public function destroy($id)
    {
        //
    }
}
