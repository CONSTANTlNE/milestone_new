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
        Schema::create('thumbnails', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('src');
            $table->string('title')->nullable()->index();
            $table->integer('width')->nullable();
            $table->integer('height')->nullable();

            $table->foreignId('file_id')->constrained()->cascadeOnDelete();
            $table->softDeletes();
            $table->index('deleted_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('thumbnails');
    }
};
