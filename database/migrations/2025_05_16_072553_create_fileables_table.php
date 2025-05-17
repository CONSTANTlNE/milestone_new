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
        Schema::create('fileables', function (Blueprint $table) {
            $table->foreignId('file_id')->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('fileable_id');
            $table->string('fileable_type');
            $table->enum('cover', ['general','slider','social','default'])->default('default')->index();
            $table->unsignedInteger('position')->default(0)->index();
            $table->timestamps();

            $table->primary(['file_id', 'fileable_id', 'fileable_type'], 'fileables_primary');
            $table->index(['fileable_id', 'fileable_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fileables');
    }
};
