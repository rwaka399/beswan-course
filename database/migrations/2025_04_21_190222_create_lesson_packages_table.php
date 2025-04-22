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
        Schema::create('lesson_packages', function (Blueprint $table) {
            $table->id('lesson_package_id');
            $table->string('lesson_package_name', 100)->nullable();
            $table->string('lesson_package_description', 255)->nullable();
            $table->integer('lesson_duration')->nullable();
            $table->unsignedInteger('lesson_package_price')->nullable();

            $table->timestamps();

            $table->bigInteger('created_by')->unsigned()->nullable();
            $table->bigInteger('updated_by')->unsigned()->nullable();

            $table->foreign('created_by')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('updated_by')->references('user_id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lesson_packages');
    }
};
