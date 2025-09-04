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
        Schema::create('quotationb2bs', function (Blueprint $table) {
            $table->id();
            $table->string('quotation_identifier')->index();
            $table->string('start_place_id')->nullable();
            $table->string('destination_place_id')->nullable();
            $table->text('start_address')->nullable()->index();
            $table->text('destination_address')->nullable()->index();
            $table->float('distance_mile')->nullable();
            $table->string('body_weight')->nullable();
            $table->string('width')->nullable();
            $table->string('height')->nullable();
            $table->string('length')->nullable();
            $table->string('car_type')->nullable();
            $table->jsonb('specs_links')->nullable();
            $table->jsonb('ai_response')->nullable();
            $table->string('transport_type')->nullable();
            $table->string('vehicle')->nullable();
            $table->foreignId('car_brand_id')->nullable()->constrained();
            $table->foreignId('car_model_id')->nullable()->constrained();
            $table->string('operable')->nullable();
            $table->string('email')->nullable()->index();
            $table->string('phone')->nullable()->index();
            $table->string('availability')->nullable();
            $table->boolean('suv')->default(false);
            $table->boolean('luxury')->default(false);
            $table->json('surcharges')->nullable();
            $table->float('calculated_cost')->nullable();
            $table->string('comment')->nullable();
            $table->enum('request_type',['individual','business']);
            $table->boolean('approved')->default(false);
            $table->boolean('quotation_sent')->default(false);
            $table->dateTime('quotation_sent_date')->nullable();
            $table->foreignId('sent_by_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotationb2bs');
    }
};
