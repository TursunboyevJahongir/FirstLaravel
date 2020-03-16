<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
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
            'name' => 'required|unique:users',
            'email' => 'required|unique:users',
            'photo' => 'nullable',
            'email_verified_at' => 'nullable',
            'phone' => 'nullable|unique:users',
            'password' => 'required',
        ]);

        if (!$request->hasFile('photo')) {
            return response()->json(['upload_file_not_found'], 400);
        }
        $file = $request->file('photo');
        if (!$file->isValid()) {
            return response()->json(['invalid_file_upload'], 400);
        }
        $path = public_path() . '/uploads/users/';
        $fileName = $file->getATime() . '.' . $file->getClientOriginalExtension();
        $file->move($path, $fileName);
        $path = '/uploads/users/' . $fileName;

        $all = $request->all();
        $all['photo'] = $path;
        $photo = Image::make(public_path($path))->fit(300);
        $photo->save();
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
            'photo' => 'nullable|mimes:jpeg,bmp,png,jpg',
            'email_verified_at' => 'nullable',
            'phone' => 'nullable|regex:/(0)[0-9]{10}/',
            'password' => 'nullable',
        ]);

        $all = $request->all();
        if ($request->file('photo')) {
            @unlink(public_path() . $id->photo);
            if (!$request->hasFile('photo')) {
                return response()->json(['upload_file_not_found'], 400);
            }
            $file = $request->file('photo');
            if (!$file->isValid()) {
                return response()->json(['invalid_file_upload'], 400);
            }
            $path = public_path() . '/uploads/users/';
            $fileName = $file->getATime() . '.' . $file->getClientOriginalExtension();
            $file->move($path, $fileName);
            $path = '/uploads/users/' . $fileName;

            $all['photo'] = $path;
            $photo = Image::make(public_path($path))->fit(300);
            $photo->save();
//        $data = User::create($all);
        }
        $id->update($all);

        return response()->json([
            'message' => 'Great success! User updated',
            'data' => $id,
        ]);
    }

    public function login()
    {
        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $user = Auth::user();
            $success['token'] = $user->createToken('appToken')->accessToken;
            //After successfull authentication, notice how I return json parameters
            return response()->json([
                'status' => 'ok',
                'token' => $success,
                'data' => $user
            ]);
        }
        elseif (Auth::attempt(['phone' => request('phone'), 'password' => request('password')])) {
            $user = Auth::user();
            $success['token'] = $user->createToken('appToken')->accessToken;
            //After successfull authentication, notice how I return json parameters
            return response()->json([
                'status' => 'ok',
                'token' => $success,
                'data' => $user
            ]);
        }
        else {
            //if authentication is unsuccessfull, notice how I return json parameters
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid Email|Name or Password',
            ], 401);
        }
    }

    /**
     * Register api.
     *
     * @return JsonResponse
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required|unique:users|regex:/[0-9]{10}/',
            'email' => 'required|email|unique:users',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
            ], 401);
        }
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] = $user->createToken('appToken')->accessToken;
        return response()->json([
            'success' => true,
            'token' => $success,
            'user' => $user
        ]);
    }

    public function logout(Request $res)
    {
        if (Auth::user()) {
            $user = Auth::user()->token();
            $user->revoke();

            return response()->json([
                'success' => true,
                'message' => 'Logout successfully'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Unable to Logout'
            ]);
        }
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
        @unlink(public_path() . $id->photo);
        $id->delete();
        return \response()->json([
            'status' => 'ok',
            'message' => '',
            'data' => null
        ]);
    }
}
