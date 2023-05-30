<?php

namespace App\Http\Controllers;

use App\Http\Requests\PermissionStoreRequest;
use App\Http\Resources\PermissionResource;
use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index()
    {
        return PermissionResource::collection(Permission::all());
    }

    public function show(Permission $permission)
    {
        return new PermissionResource($permission);
    }

    public function store(PermissionStoreRequest $request)
    {
        $permission = Permission::create([
            'name' => $request->name
        ]);

        return new PermissionResource($permission);
    }

    public function update(Permission $permission, PermissionStoreRequest $request)
    {
        $permission->update([
            'name' => $request->name ?? $permission->name
        ]);

        return new PermissionResource($permission);
    }


    public function destroy(Permission $permission)
    {
        $permission->delete();

        return response()->json([
            'message' => 'Permission deleted successfully'
        ]);
    }
}
