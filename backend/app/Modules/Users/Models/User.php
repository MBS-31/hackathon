<?php

namespace App\Modules\Users\Models;

use App\Abstracts\BaseModel;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * User Model
 *
 * Core authentication entity. Supports soft deletes, roles, permissions, and JWT.
 *
 * @property int    $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $status      active|inactive|suspended
 * @property string|null $avatar_url
 * @property \Carbon\Carbon|null $email_verified_at
 * @property \Carbon\Carbon|null $last_login_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 */
class User extends BaseModel implements AuthenticatableContract, JWTSubject
{
    use Authenticatable;
    use HasFactory;
    use HasRoles;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
        'avatar_url',
        'email_verified_at',
        'last_login_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at'     => 'datetime',
        'created_at'        => 'datetime',
        'updated_at'        => 'datetime',
        'deleted_at'        => 'datetime',
        'password'          => 'hashed',
    ];

    // -------------------------------------------------------------------------
    // JWTSubject interface
    // -------------------------------------------------------------------------

    public function getJWTIdentifier(): mixed
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims(): array
    {
        return [
            'email'  => $this->email,
            'name'   => $this->name,
            'status' => $this->status,
        ];
    }
}
