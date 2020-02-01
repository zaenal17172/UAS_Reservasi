<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|unique:user',
            'password' => 'required',
            'no_telp' => 'required',
            'alamat' => 'required',
            'role' => 'required|in:Admin,User'
        ]);

        //create user
        $user = new User;
        $user->email = $request->input('email');
        $plainPassword = $request->input('password');
        $user->password = app('hash')->make($plainPassword);
        $user->no_telp = $request->input('no_telp');
        $user->alamat = $request->input('alamat');
        $user->role = $request->input('role');
        $user->save();

        return response()->json($user, 200);
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|unique:user',
            'password' => 'required',
        ]);

        $credentials = $request->only(['email', 'password']);

        if (!$token = Auth::attempt($credentials)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $user = User::where('email', $request->input('email'));

        return response()->json([
            'user' => $user,
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60 * 24
        ], 200);
    }

    public function show($id)
    {
        $user = User::find($id);
        if (!$user) {
            abort(404);
        }
        return response()->json($user, 200);
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();
        $user = User::find($id);
        if (!$user) {
            abort(404);
        }

        $this->validate($request, [
            'email' => 'required|email|unique:user',
            'password' => 'required',
            'no_telp' => 'required',
            'alamat' => 'required',
            'role' => 'required|in:Admin,User'
        ]);

        $user->fill($input);
        $plainPassword = $request->input('password');
        $user->password = app('hash')->make($plainPassword);
        $user->save();
        return response()->json($user, 200);
    }
}