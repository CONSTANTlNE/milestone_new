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
        Schema::table('carrier_dispatchers', function (Blueprint $table) {
            $table->string('w9_upload')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('carrier_dispatchers', function (Blueprint $table) {
            $table->string('w9_upload')->nullable(false)->change();
        });
    }
};
