<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthLoginRequest;
use App\Http\Requests\AuthRegisterRequest;
use App\Http\Requests\AuthUpdateRequest;
use App\Http\Resources\AuthLoginResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    public function register(AuthRegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'password' => bcrypt($request->password),
        ]);

        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $user->update(['avatar' => $avatarPath]);
        }

        $user->assignRole('client');

        $user->refresh();

        return response()->json([
            'message' => 'User created successfully',
        ]);
    }

    public function login(AuthLoginRequest $request)
    {
        if (
            $request->email && !auth()->attempt($request->only('email', 'password')) ||
            $request->phone_number && !auth()->attempt($request->only('phone_number', 'password'))
        ) {
            return response()->json([
                'message' => 'Invalid credentials',
            ], 401);
        }

        if (auth()->user()->hasRole('admin')) {
            redirect('/admin');
        }

        if (auth()->user()->hasRole('client')) {
            redirect('/client');
        }

        return new AuthLoginResource(auth()->user());
    }

    public function me()
    {
        return new UserResource(auth()->user());
    }

    public function update(AuthUpdateRequest $request)
    {
        $user = auth()->user();

        $user->update([
            'name' => $request->name ?? $user->name,
            'email' => $request->email ?? $user->email,
            'phone_number' => $request->phone_number ?? $user->phone_number,
            'password' => $request->password ? bcrypt($request->password) : $user->password,
        ]);

        if ($request->hasFile('avatar')) {
            Storage::delete('public' . $user->avatar);
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $user->update(['avatar' => $avatarPath]);
        }

        return new UserResource($user);
    }


    public function logout()
    {
        auth()->logout();

        return response()->json([
            'message' => 'logged out successfully',
        ]);
    }
}
