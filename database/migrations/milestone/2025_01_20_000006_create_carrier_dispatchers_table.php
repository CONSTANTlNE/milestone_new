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
        Schema::create('carrier_dispatchers', function (Blueprint $table) {
            $table->id();
            
            // Basic Information
            $table->string('mc_number');
            $table->string('dot_number');
            $table->integer('cars_under_management');
            $table->string('website_url')->nullable();
            $table->string('presentation_file')->nullable();
            $table->string('vehicle_list_file')->nullable();
            
            // Company Information
            $table->string('legal_business_name');
            $table->string('dba')->nullable();
            $table->string('business_type');
            $table->integer('years_operation');
            
            // Primary Contact
            $table->string('contact_name');
            $table->string('contact_title');
            $table->string('contact_phone');
            $table->string('contact_email');
            
            // Location & Operations
            $table->text('main_address');
            $table->enum('multiple_locations', ['yes', 'no']);
            $table->text('additional_addresses')->nullable();
            
            // Billing & Payment
            $table->string('billing_contact');
            $table->string('billing_email');
            $table->json('payment_method'); // ACH, Credit Card, Check, Other
            
            // Verification & Documents
            $table->enum('nda_required', ['yes', 'no']);
            $table->string('w9_upload')->nullable();
            $table->string('insurance_certificate')->nullable();
            
            // Status and tracking
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('admin_notes')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carrier_dispatchers');
    }
};
