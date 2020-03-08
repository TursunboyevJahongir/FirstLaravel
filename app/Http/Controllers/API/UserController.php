<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\User;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        return \response()->json(User::paginate(15));
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
            'address_id' => 'nullable',
            'name' => 'required',
            'image' => 'nullable|',
            'email_verified_at' => 'nullable',
            'phone' => 'nullable',
            'password' => 'required',
            'api_token' => 'nullable',
            'remember_token' => 'nullable',
        ]);

        if (!$request->hasFile('image')) {
            return response()->json(['upload_file_not_found'], 400);
        }
        $file = $request->file('image');
        if (!$file->isValid()) {
            return response()->json(['invalid_file_upload'], 400);
        }
        $path = public_path() . '/uploads/users/';
        $fileName = $file->getATime() . '.' . $file->getClientOriginalExtension();
        $file->move($path, $fileName);
        $path = '/uploads/users/' . $fileName;

        $all = $request->all();
        $all['image'] = $path;
        $image = Image::make(public_path($path))->fit(300);
        $image->save();
        $data = User::create($all);

        return response()->json([
            'status' => 'ok',
            'message' => 'Great success!',
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
        $data = User::query()->where('id', '=', $id)->with('address', 'address.district', 'address.district.region')->first();
        if (is_null($data)) {
            return \response()->json([
                'status' => 'error',
                'message' => 'Not found',
                'data' => null
            ], 404);
        }

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
     * @param User $id
     * @return JsonResponse
     */
    public function update(Request $request, User $id)
    {
//        $request->input('name');
        $request->validate([
            'address_id' => 'nullable',
            'name' => 'nullable',
            'image' => 'nullable|mimes:jpeg,bmp,png,jpg',
            'email_verified_at' => 'nullable',
            'phone' => 'nullable',
            'password' => 'nullable',
            'api_token' => 'nullable',
            'remember_token' => 'nullable',
        ]);

        $all = $request->all();
        if ($request->file('image')) {
            if (!$request->hasFile('image')) {
                return response()->json(['upload_file_not_found'], 400);
            }
            $file = $request->file('image');
            if (!$file->isValid()) {
                return response()->json(['invalid_file_upload'], 400);
            }
            $path = public_path() . '/uploads/users/';
            $fileName = $file->getATime() . '.' . $file->getClientOriginalExtension();
            $file->move($path, $fileName);
            $path = '/uploads/users/' . $fileName;

            $all['image'] = $path;
            $image = Image::make(public_path($path))->fit(300);
            $image->save();
//        $data = User::create($all);
        }
        $id->update($all);

        return response()->json([
            'message' => 'Great success! User updated',
            'data' => $id,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $id
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(User $id)
    {
        $id->delete();
        return \response()->json([
            'status' => 'ok',
            'message' => '',
            'data' => null
        ]);
    }
}
