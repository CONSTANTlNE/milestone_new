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
        Schema::create('locales', function (Blueprint $table) {
            $table->id();
            $table->string('title', 30)->index();
            $table->string('native', 50)->nullable()->index();
            $table->string('regional', 30)->nullable()->index();
            $table->string('script', 20)->nullable();
            $table->string('code', 2)->unique();
            $table->boolean('status')->default(false)->index();
            $table->boolean('default')->default(false)->index();
            $table->string('src')->nullable();
            $table->integer('position')->default(0)->index();
            $table->timestamps();
            $table->softDeletes();
            $table->index('deleted_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locales');
    }
};
