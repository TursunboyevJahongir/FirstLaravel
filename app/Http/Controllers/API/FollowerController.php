<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Follower;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FollowerController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function index()
    {
        return \response()->json(Follower::paginate(15));
    }

    public function show($id)
    {
        $data = Follower::where('id', '=', $id)->with('shop','user')->first();
        return \response()->json([
            'status' => 'ok',
            'message' => '',
            'data' => $data
        ]);
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
            'shop_id'=>'required',
            'user_id'=>'required',
        ]);

        $data = Follower::create($request->all());

        return response()->json([
            'status' => 'ok',
            'message' => 'New follower',
            'data' => $data,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Follower $id
     * @return JsonResponse
     */
    public function update(Request $request,Follower $id)
    {
        $request->validate([
            'product_id'=>'->nullable',
            'user_id'=>'->nullable',
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
     * @param Follower $id
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Follower $id)
    {
        $id->delete();
        return \response()->json([
            'status' => 'ok',
            'message' => ' deleted',
            'data' => null
        ]);
    }
}
