<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class authController extends Controller
{
    //

    public function register(request $req)
    {
        $rules = [
            'firstName' => 'required | String',
            'lastName' => 'required | String',
            'phoneNumber' => 'required | String | unique:users',
            'email' => 'required | String | unique:users',
            'password' => 'required | String | min: 6',
        ];

        $validator = validator::make($req->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = User::create([
            'firstName' => $req->firstName,
            'lastName' => $req->lastName,
            'phoneNumber' => $req->phoneNumber,
            'email' => $req->email,
            'password' => Hash::make($req->password),
        ]);

        $token = $user->createToken('Personal Access Tokne')->plainTextToken;
        $response = ['user' => $user, 'token' => $token];
        return response()->json($response, 200);
    }

    public function login(request $req)
    {
        $rules = [
            'email' => 'required  ',
            'password' => 'required | String ',
        ];
        $req->validate($rules);
        $user = User::where('email', $req->email)->first();

        if ($user && Hash::check($req->password, $user->password)) {

            $token = $user->createToken('Personal Access Token')->plainTextToken;
            $response = ['user' => $user, 'token' => $token];
            return response()->json($response, 200);
        } else {

            $response = ['message' => ' Incorrect Email or Password'];
            return response()->json($response, 400);
        }
    }


    public function updateUser(Request $request, $id)
    {
        $user = User::find($id);
        $user->update($request->all());
        return $user;
    }

    public function getUser($id)
    {
        return User::find($id);
    }


    public function logout($id)
    {
        $user = User::find($id);
        $user->tokens()->delete();
        return response([
            'message' => 'Signed Out Successfully'
        ]);
    }
}
