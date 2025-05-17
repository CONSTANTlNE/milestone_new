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
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('src');
            $table->string('title')->nullable()->index();
            $table->integer('width')->nullable();
            $table->integer('height')->nullable();
            $table->enum('type', ['image', 'document', 'video'])->index();
            $table->string('extension', 10)->default('webp');
            $table->string('caption')->nullable();
            $table->string('video_id')->nullable()->index();
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
        Schema::dropIfExists('files');
    }
};
