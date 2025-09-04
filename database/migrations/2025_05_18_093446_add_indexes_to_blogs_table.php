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
        Schema::table('blogs', function (Blueprint $table) {
            $table->index(['status', 'created_at']);
            $table->index(['user_id', 'status']);
            $table->index('created_at');
            $table->index('deleted_at');
            $table->ginIndex('title');
            $table->ginIndex('slug');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->dropIndex(['status', 'created_at']);
            $table->dropIndex(['user_id', 'status']);
            $table->dropIndex('created_at');
            $table->dropIndex('deleted_at');
            $table->dropGinIndex('title');
            $table->dropGinIndex('slug');
        });
    }
};
