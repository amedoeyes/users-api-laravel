<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'avatar',
        'email',
        'phone_number',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function hasRole($role)
    {
        return $this->roles->contains('name', $role);
    }

    public function syncRoles($roles)
    {
        $roles = Role::whereIn('name', $roles)->get();

        $this->roles()->sync($roles);
    }

    public function assignRole($role)
    {
        $role = Role::where('name', $role)->first();

        $this->roles()->attach($role);

        return $this->save();
    }

    public function removeRole($role)
    {
        $role = Role::where('name', $role)->first();

        $this->roles()->detach($role);

        return $this->save();
    }

    public function removeAllRoles()
    {
        $this->roles()->detach();

        return $this->save();
    }

    public function hasPermission($permission)
    {
        return $this->roles->contains(function ($role) use ($permission) {
            return $role->hasPermission($permission);
        });
    }
}
