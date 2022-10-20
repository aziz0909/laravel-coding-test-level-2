<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Validator;
use App\Http\Traits\ApiResponse;

class UserController extends Controller
{
    use ApiResponse;

    public function index()
    {
        $Users = User::all();

        return $this->successResponse($Users, "success", 200);
    }

    public function store(Request $request)
    {

        $fields = $request->validate([
            'username' => 'required|string|unique:users,username',
            'password' => 'required|string|confirmed',
            'role_id' => 'string',
        ]);

        $user = User::create([
            'username' => $fields['username'],
            'password' => bcrypt($fields['password']),
            'role_id' => $fields['role_id'] ?? 3,
        ]);

        $token = $user->createToken('$3cr37')->plainTextToken;

        $res = [
            'user' => $user,
            'token' => $token,
        ];

        return $this->successResponse($res, "Successfully create user", 201);
    }

    public function show(User $User)
    {
        return $this->successResponse($User, "success", 200);
    }

    public function update(Request $request, User $User)
    {
        $fields = $request->validate([
            'username' => 'string|unique:users,username',
            'password' => 'string|confirmed',
            'role_id' => 'string',
        ]);

        $User->update([
            'username' => $fields['username'] ?? $User->username,
            'password' => bcrypt( $fields['password'] ?? $User->password),
            'role_id' => $fields['role_id'] ?? $User->role_id,
        ]);

        return $this->successResponse($User, "Successfully update user", 201);
    }

    public function destroy(User $User)
    {
        $User->delete();

        return $this->successResponse($User, "Successfully delete user", 200);
    }
}
