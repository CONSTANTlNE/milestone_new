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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->jsonb('title');
            $table->jsonb('working_hours')->nullable();
            $table->jsonb('address')->nullable();
            $table->string('phone')->nullable()->index();
            $table->string('email')->nullable()->index();
            $table->string('send_email')->nullable()->index();
            $table->integer('number_product_page')->nullable()->index();
            $table->string('lat')->nullable()->index();
            $table->string('lng')->nullable()->index();
            $table->text('g_map')->nullable()->index();
            $table->text('g_analytics')->nullable()->index();
            $table->string('fb_id')->nullable()->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
