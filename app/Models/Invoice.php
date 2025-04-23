<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $primaryKey = 'invoice_id'; // Sesuaikan primary key

    protected $fillable = [
        'external_id',
        'xendit_invoice_id',
        'transaction_id',
        'user_id',
        'lesson_package_id',
        'amount',
        'payer_email',
        'description',
        'status',
        'invoice_url',
        'expires_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id', 'transaction_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function lessonPackage()
    {
        return $this->belongsTo(LessonPackage::class, 'lesson_package_id', 'lesson_package_id');
    }

    // public function logKeuangan()
    // {
    //     return $this->hasOne(LogKeuangan::class, 'invoice_id', 'invoice_id');
    // }
}