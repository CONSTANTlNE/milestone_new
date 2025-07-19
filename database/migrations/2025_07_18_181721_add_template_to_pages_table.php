<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTemplateToPagesTable extends Migration
{
    public function up(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            // Add template column as string (without unique constraint)
            if (!Schema::hasColumn('pages', 'template')) {
                $table->string('template')->nullable(); // or remove nullable() if required
            }
        });
    }

    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn('template');
        });
    }
}
