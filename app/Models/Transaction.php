<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $primaryKey = 'transaction_id'; // Sesuaikan primary key

    protected $fillable = [
        'external_id',
        'lesson_package_id',
        'user_id',
        'amount',
        'status',
        'payment_method',
        'payer_email',
        'description',
        'invoice_url',
    ];

    public function lessonPackage()
    {
        return $this->belongsTo(LessonPackage::class, 'lesson_package_id', 'lesson_package_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'transaction_id', 'transaction_id');
    }
}