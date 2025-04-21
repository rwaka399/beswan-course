<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserRole extends Model
{
    use HasFactory;

    protected $primaryKey = 'user_role_id';
    protected $fillable = ['user_id', 'role_id', 'created_by', 'updated_by'];

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
    public function role():BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id', 'role_id');
    }
}
