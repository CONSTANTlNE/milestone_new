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
        Schema::create('sliders', function (Blueprint $table) {
            $table->id();
            $table->jsonb('title');
            $table->jsonb('content');
            $table->enum('align', ['CENTER', 'LEFT', 'RIGHT'])->nullable();
            $table->boolean('has_link')->default(0)->index();
            $table->jsonb('links');
            $table->enum('link_target', ['_blank', '_parent', '_self', '_top'])->default('_self');
            $table->string('src')->nullable();
            $table->boolean('status')->default(true)->index();
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
        Schema::dropIfExists('sliders');
    }
};
