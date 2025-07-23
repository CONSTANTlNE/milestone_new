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
        Schema::table('quotations', function (Blueprint $table) {
            $table->float('distance_mile')->nullable()->after('destination_address');
            $table->foreignId('quotation_request_type_id')->nullable()->after('email')->constrained()->nullOnDelete();
            $table->string('body_weight')->nullable()->after('availability');
            $table->string('width')->nullable()->after('body_weight');
            $table->string('height')->nullable()->after('width');
            $table->string('length')->nullable()->after('height');
            $table->string('car_type')->nullable()->after('length');
            $table->jsonb('specs_links')->nullable()->after('car_type');
            $table->jsonb('ai_response')->nullable()->after('specs_links');
            $table->softDeletes()->after('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quotations', function (Blueprint $table) {
            //
        });
    }
};
