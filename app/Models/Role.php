<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    use HasFactory;

    protected $primaryKey = 'role_id';

    protected $fillable = [
        'role_name',
        'role_description',
        'created_by',
        'updated_by',
    ];

    public function userRole():HasMany
    {
        return $this->hasMany(UserRole::class, 'role_id', 'role_id');
    }

    // public function roleMenu():HasMany
    // {
    //     return $this->hasMany(RoleMenu::class, 'role_id', 'role_id');
    // }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'user_id');
    }
}
