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
        //coupons
        Schema::create('promocodes', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->enum('discount_type', ['NORMAL','SOLO'])->default('NORMAL')->index();
            $table->boolean('status')->default(true)->index();
            $table->unsignedInteger('percent')->default(0)->index();
            $table->unsignedInteger('usage_limit')->default(10)->index();
            $table->double('minimum_amount')->nullable();
            $table->double('maximum_amount')->nullable();
            $table->datetime('start');
            $table->datetime('end');
            $table->json('brand_ids')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promocodes');
    }
};
