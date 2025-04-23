<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id('transaction_id');
            $table->string('external_id')->unique();
            $table->unsignedBigInteger('lesson_package_id');
            $table->unsignedBigInteger('user_id');
            $table->bigInteger('amount');
            $table->string('status');
            $table->string('payment_method')->nullable();
            $table->string('payer_email');
            $table->text('description')->nullable();
            $table->string('invoice_url')->nullable();
            $table->timestamps();
            
            $table->foreign('lesson_package_id')->references('lesson_package_id')->on('lesson_packages')->onDelete('cascade');
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
