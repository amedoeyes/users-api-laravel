<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class AuthLoginResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $token = $this->createToken('auth_token')->plainTextToken;

        return [
            'user' => [
                'id' => $this->id,
                'name' => $this->name,
                'avatar' => asset(Storage::url($this->avatar)),
                'email' => $this->email,
                'phone_number' => $this->phone_number,
                'roles' => $this->roles->pluck('name'),
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at
            ],
            'token' => $token
        ];
    }
}
