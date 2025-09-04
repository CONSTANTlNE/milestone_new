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
        Schema::create('vehicle_manufacturers', function (Blueprint $table) {
            $table->id();
            
            // Organization Information
            $table->string('legal_business_name');
            $table->string('dba')->nullable();
            $table->enum('business_type', ['manufacturer', 'distributor', 'oem_partner']);
            $table->integer('years_operation');
            $table->string('website_url')->nullable();
            $table->string('us_office_location')->nullable();
            
            // Primary Contact
            $table->string('contact_name');
            $table->string('contact_title');
            $table->string('contact_phone');
            $table->string('contact_email');
            
            // Factory & Logistics Details
            $table->text('primary_port_factory');
            $table->text('us_distribution_centers');
            $table->enum('delivery_frequency', ['daily', 'weekly', 'monthly', 'varies']);
            $table->integer('monthly_volume');
            $table->string('vin_batching_format')->nullable();
            $table->text('new_car_prep');
            
            // Vehicle & Transport Preferences
            $table->enum('transport_type', ['open', 'enclosed']);
            $table->json('vehicle_types'); // New, EV, High-End, Fleet, Prototypes
            $table->text('load_prep_protocols');
            $table->text('special_handling')->nullable();
            $table->text('delivery_destinations');
            $table->text('compliance_procedures')->nullable();
            
            // Billing & Payment
            $table->string('billing_contact');
            $table->string('billing_email');
            $table->json('payment_method');
            $table->enum('vendor_management_system', ['yes', 'no']);
            $table->string('system_name')->nullable();
            
            // Verification Documents
            $table->string('w9_upload');
            $table->string('insurance_certificate');
            $table->string('business_registration');
            $table->text('trade_references')->nullable();
            
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
        Schema::dropIfExists('vehicle_manufacturers');
    }
};
