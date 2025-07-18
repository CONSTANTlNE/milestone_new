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
        Schema::create('quotations', function (Blueprint $table) {
            $table->id();
            $table->string('start_place_id')->nullable();
            $table->string('destination_place_id')->nullable();
            $table->text('start_address')->nullable()->index();
            $table->text('destination_address')->nullable()->index();
            $table->string('transport_type')->nullable();
            $table->string('vehicle')->nullable();
            $table->foreignId('car_brand_id')->nullable()->constrained();
            $table->foreignId('car_model_id')->nullable()->constrained();
            $table->string('operable')->nullable();
            $table->string('email')->nullable()->index();
            $table->string('phone')->nullable()->index();
            $table->string('availability')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotations');
    }
};
