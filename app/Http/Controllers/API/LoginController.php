<?php


namespace App\Http\Controllers\API;


use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class LoginController extends Controller
{

    public function index(Request $request)
    {
        $rules = [
            'email' => 'required|exists:users,email',
            'password' => 'required'
        ];
        $validator = validator()->make($request->json()->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first(),
                'data' => ''
            ]);
        }
        $data = ['email' => $request->json('email'), 'password' => $request->json('password')];
        if (Auth::validate($data)) {
            Auth::attempt($data);
            $user = Auth::user();
            $user->api_token = \hash('sha256', Str::random(60));
            $user->update();
            return response()->json([
                'status' => 'ok',
                'message' => '',
                'data' => $user
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found',
                'data' => ''
            ]);
        }
    }

}
