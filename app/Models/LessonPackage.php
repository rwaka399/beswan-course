<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LessonPackage extends Model
{
    use HasFactory;

    protected $primaryKey = 'lesson_package_id';  // Tentukan primary key jika bukan id default
    protected $fillable = [
        'lesson_package_name',
        'lesson_duration',
        'lesson_package_price',
        'created_by',
        'updated_by',
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'lesson_package_id', 'lesson_package_id');
    }

    // Relasi dengan Invoice
    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'lesson_package_id', 'lesson_package_id');
    }
}
