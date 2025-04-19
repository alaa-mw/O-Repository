<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //
    public function adminLogin(Request $request)
    {

        $admin = User::query()->where('phone_number', '=',  $request['phone_number'])->first();

        if (!$admin || !Hash::check($request['password'], $admin->password)) {
            return response()->json([
                'message' => trans('auth.failed')
            ], 422);
        }

        $token = $admin->createToken('token')->plainTextToken;
        $admin->save();

        $role = $admin->roles()->pluck('name');

        return response()->json([
            'message' => trans('auth.login'),
            'role' => $role,
            'token' => $token,
        ], 200);
    }

    public function adminLogout(Request $request)
    {

        $request->user()->tokens()->delete();
        return response()->json([
            'message' => trans('auth.logout')
        ], 200);
    }
}
