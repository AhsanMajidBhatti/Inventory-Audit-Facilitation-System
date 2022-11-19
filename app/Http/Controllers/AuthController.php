<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    public function login(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'email' => 'required|email|ends_with:nu.edu.pk',
            'password' => 'required|min:5'
        ]);

        if ($validation->fails()) {
            return response()->json(['invalid' => $validation->errors()]);
        }

        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            $token = $user->createToken($request->password)->plainTextToken;
            return response()->json(['data' => $user, 'token' => $token]);
        } else {
            return response()->json(['invalid' => ['Invalid Credentials']], 401);
        }
    }

    public function index(Request $request)
    {
        $users = User::paginate(5);
        return response()->json($users);
    }

    public function logout(Request $request)
    {
        return $request->user()->currentAccessToken()->delete();
    }

    public function alluser(Request $request)
    {
        $users = User::where('admin', 0)->get();
        return response()->json($users->count());
    }

    public function alladmin(Request $request)
    {
        $admins = User::where('admin', '1')->get();
        return response()->json($admins->count());
    }

    public function allproduct(Request $request)
    {
        $products = Product::all();
        return response()->json($products->count());
    }
}