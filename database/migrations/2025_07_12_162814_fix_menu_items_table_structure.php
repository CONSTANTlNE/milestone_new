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
        Schema::table('menu_items', function (Blueprint $table) {
            // Drop the old column if it exists
            if (Schema::hasColumn('menu_items', 'fileable_type')) {
                $table->dropColumn('fileable_type');
            }
            
            // Add the correct column
            if (!Schema::hasColumn('menu_items', 'model_type')) {
                $table->string('model_type', 100)->nullable()->after('model_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('menu_items', function (Blueprint $table) {
            // Drop the correct column
            if (Schema::hasColumn('menu_items', 'model_type')) {
                $table->dropColumn('model_type');
            }
            
            // Add back the old column
            if (!Schema::hasColumn('menu_items', 'fileable_type')) {
                $table->string('fileable_type', 100)->nullable()->after('model_id');
            }
        });
    }
};
