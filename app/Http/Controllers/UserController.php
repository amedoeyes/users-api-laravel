<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Storage;

class UserController extends Controller
{
    public function index()
    {
        return UserResource::collection(User::all());
    }

    public function show(User $user)
    {
        return new UserResource($user);
    }

    public function store(UserStoreRequest $request)
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

        return new UserResource($user);
    }

    public function update(User $user, UserUpdateRequest $request)
    {
        if ($user->id === 1 && auth()->user()->id !== 1) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 401);
        }

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

        if ($request->roles) {
            if (!auth()->user()->hasPermission('update_users_roles')) {
                return response()->json([
                    'message' => 'Unauthorized',
                ], 401);
            }

            if ($request->roles->contains('admin') && !auth()->user()->hasRole('admin')) {
                return response()->json([
                    'message' => 'Unauthorized',
                ], 401);
            }

            $user->syncRoles($request->roles);
        }

        return new UserResource($user);
    }

    public function destroy(User $user)
    {
        if ($user->id === 1) {
            return response()->json([
                'message' => 'Cannot delete admin user',
            ], 401);
        }

        if ($user->avatar !== 'avatars/default.png') {
            Storage::delete('public' . $user->avatar);
        }

        $user->delete();

        return response()->json([
            'message' => 'User deleted successfully'
        ]);
    }
}
