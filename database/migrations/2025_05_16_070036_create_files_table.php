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
            $table->char('uuid', 36)->unique();
            $table->uuid('src');
            $table->string('title')->nullable();
            $table->integer('width');
            $table->integer('height');
            $table->enum('type', ['image', 'document', 'video']);
            $table->string('extension', 10)->default('webp');
            $table->string('caption');
            $table->string('video_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
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
