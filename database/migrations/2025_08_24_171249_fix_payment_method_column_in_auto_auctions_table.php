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
        // Drop the existing check constraint
        DB::statement('ALTER TABLE auto_auctions DROP CONSTRAINT IF EXISTS auto_auctions_payment_method_check');
        
        // Change the column type to json
        DB::statement('ALTER TABLE auto_auctions ALTER COLUMN payment_method TYPE json USING payment_method::json');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Change back to enum
        DB::statement('ALTER TABLE auto_auctions ALTER COLUMN payment_method TYPE varchar(255)');
        
        // Add back the check constraint
        DB::statement('ALTER TABLE auto_auctions ADD CONSTRAINT auto_auctions_payment_method_check CHECK (payment_method IN (\'ach\', \'credit_card\', \'net_terms\'))');
    }
};
