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
        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('menu_id')->constrained()->cascadeOnDelete();
            $table->json('title');
            $table->json('slug');
            $table->boolean('status')->default(true)->index();
            $table->string('route')->nullable();
            $table->boolean('is_prefix')->default(true)->index();
            $table->unsignedBigInteger('parent_id')->nullable()->index();
            $table->integer('sort')->default(0)->index();
            $table->integer('depth')->default(0)->index();
            $table->string('class', 100)->nullable();
            $table->string('icon_class')->nullable();
            $table->unsignedBigInteger('model_id')->nullable()->index();
            $table->string('fileable_type', 100)->nullable();
            $table->enum('target', ['_blank', '_parent', '_self', '_top'])->default('_self');
            $table->string('url')->nullable()->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_items');
    }
};
