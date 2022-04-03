<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserAuthController extends Controller{

    public function Register(Request $request){

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required',
        ]);


        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // email verification


        return response()->json([
            'message' => 'User created successfully',
            'user' => $user,
        ], 201);


    }


    public function Login(Request $request){


        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }


        return response()->json([
            'message' => 'login success',
            'user' => $user,
            'token' => $user->createToken('default')->plainTextToken
        ]);


    }

    public function Logout(Request $request){

        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Successfully logged out'
        ]);


    }


    public function Me(Request $request){
        // return current logged in user
        return response()->json([
            "user" =>  $request->user()
        ]);

    }

    public function updateUserAccount(Request $request){

        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $user = $request->user();
        $user->name = $request->name;
        $user->save();

        return response()->json([
            'message' => 'User updated successfully',
            'user' => $user,
        ], 201);


    }

    public function resetPassword(Request $request){

        $request->validate([
            'password' => 'required',
            'new_password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json([
            'message' => 'Password updated successfully',
            'user' => $user,
        ], 201);

    }


}
