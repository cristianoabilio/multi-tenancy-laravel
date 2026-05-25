<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    public const ROLE_ADMIN = 1;
    public const ROLE_MANAGER = 2;
    public const ROLE_SELLER = 3;
    public const ROLE_CLIENT = 4;

    protected $fillable = [
        'name'
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
