<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthenticationController extends Controller
{
    public function __invoke(Request $request){  // Register
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:5|confirmed',
            'firstname' => 'required'
        ]);
        if($validator ->fails()){
            return response()->json($validator->errors(), 422);
        }
        $user = User::create([
            'name' =>$request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'firstname' => $request->firstname
        ]);

        if($user){
            return response()->json([
                'success' => true,
                'user' =>$user,
            ], 201);
        }
        return response()->json([
            'success' => false,
        ], 409);
        
    }
    public function login(Request $request){
        $request -> validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        // dd($user);

        if (!$user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'account' => ['The provided credentials are incorrect'],
            ]);
        }

        return $user->createToken('user login')->plainTextToken;

    }
    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'berhasil logout'
        ]);
    }

    public function checkUser(){
        $user = Auth::user();
        return response()->json($user);
    }
}
