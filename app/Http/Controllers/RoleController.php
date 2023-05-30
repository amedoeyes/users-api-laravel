<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleStoreRequest;
use App\Http\Requests\RoleUpdateRequest;
use App\Http\Resources\RoleResource;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        return RoleResource::collection(Role::all());
    }

    public function show(Role $role)
    {
        return new RoleResource($role);
    }

    public function store(RoleStoreRequest $request)
    {
        $role = Role::create([
            'name' => $request->name,
        ]);

        if ($request->permissions) {
            $role->syncPermissions($request->permissions);
        }

        return new RoleResource($role);
    }

    public function update(Role $role, RoleUpdateRequest $request)
    {
        if ($role->id === 1 && !auth()->user()->hasRole('admin')) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 401);
        }

        $role->update([
            'name' => $request->name ?? $role->name,
        ]);

        if ($request->permissions) {
            $role->syncPermissions($request->permissions);
        }

        return new RoleResource($role);
    }

    public function destroy(Role $role)
    {
        if ($role->id === 1) {
            return response()->json([
                'message' => 'Cannot delete admin role',
            ], 401);
        }

        $role->revokeAllPermissions();
        $role->delete();

        return response()->json([
            'message' => 'Role deleted successfully'
        ]);
    }
}
