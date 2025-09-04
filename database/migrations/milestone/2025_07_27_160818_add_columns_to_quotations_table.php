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
            $table->boolean('suv')->default(false)->after('ai_response');
            $table->boolean('luxury')->default(false)->after('suv');
            $table->json('surcharges')->nullable()->after('luxury');
            $table->float('calculated_cost')->nullable()->after('ai_response');
            $table->string('comment')->nullable()->after('calculated_cost');
            $table->enum('request_type',['individual','business'])->default('comment');
            $table->boolean('approved')->default(false)->after('request_type');
            $table->boolean('quotation_sent')->default(false)->after('approved');
            $table->dateTime('quotation_sent_date')->nullable()->after('quotation_sent');
            $table->foreignId('sent_by_id')->nullable()->after('quotation_sent')->constrained('users')->onDelete('set null');
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
