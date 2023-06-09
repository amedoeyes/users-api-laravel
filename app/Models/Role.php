<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function hasPermission($permission)
    {
        return $this->permissions->contains('name', $permission);
    }

    public function syncPermissions($permissions)
    {
        $permissions = Permission::whereIn('name', $permissions)->get();

        $this->permissions()->sync($permissions);
    }

    public function assignPermission(Permission $permission)
    {
        $permission = Permission::where('name', $permission->name)->first();

        $this->permissions()->attach($permission);

        return $this->save();
    }

    public function revokeAllPermissions()
    {
        $this->permissions()->detach();

        return $this->save();
    }

    public function revokePermission(Permission $permission)
    {
        $permission = Permission::where('name', $permission->name)->first();

        $this->permissions()->detach($permission);

        return $this->save();
    }
}
