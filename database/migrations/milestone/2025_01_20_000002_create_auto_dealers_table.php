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
        Schema::create('auto_dealers', function (Blueprint $table) {
            $table->id();
            
            // Company Information
            $table->string('legal_business_name');
            $table->string('dba')->nullable();
            $table->string('business_type');
            $table->integer('years_operation');
            $table->string('website_url')->nullable();
            
            // Primary Contact
            $table->string('contact_name');
            $table->string('contact_title');
            $table->string('contact_phone');
            $table->string('contact_email');
            
            // Location & Operations
            $table->text('main_address');
            $table->enum('multiple_locations', ['yes', 'no']);
            $table->text('additional_addresses')->nullable();
            
            // Licenses & IDs
            $table->string('dealer_license');
            $table->string('federal_tax_id');
            $table->string('duns_number')->nullable();
            
            // Vehicle Transport Details
            $table->integer('cars_per_month');
            $table->json('vehicle_types'); // New, Used, Luxury, Oversized, Inoperable
            $table->enum('transport_preference', ['open', 'enclosed']);
            $table->enum('delivery_type', ['door_to_door', 'terminal_to_terminal']);
            
            // Logistics Preferences
            $table->string('inventory_contact')->nullable();
            $table->string('pickup_times');
            $table->string('delivery_days');
            
            // Billing & Payment
            $table->string('billing_contact');
            $table->string('billing_email');
            $table->enum('payment_method', ['ach', 'credit_card', 'check', 'other']);
            $table->string('vendor_platforms')->nullable();
            
            // Verification & Optional Docs
            $table->enum('nda_required', ['yes', 'no']);
            $table->enum('trade_reference', ['yes', 'no']);
            $table->string('w9_upload');
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
        Schema::dropIfExists('auto_dealers');
    }
};
