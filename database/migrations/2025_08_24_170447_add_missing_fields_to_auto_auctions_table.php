<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('auto_auctions', function (Blueprint $table) {
            // Add missing fields
            $table->enum('unattended_pickup', ['yes', 'no'])->nullable()->after('inventory_system');
            $table->string('vehicle_list')->nullable()->after('unattended_pickup');
        });

        // Change payment_method from enum to json to support multiple values
        DB::statement('ALTER TABLE auto_auctions ALTER COLUMN payment_method TYPE json USING payment_method::json');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('auto_auctions', function (Blueprint $table) {
            $table->dropColumn(['unattended_pickup', 'vehicle_list']);
        });

        // Change payment_method back to enum
        DB::statement('ALTER TABLE auto_auctions ALTER COLUMN payment_method TYPE varchar(255)');
    }
};
