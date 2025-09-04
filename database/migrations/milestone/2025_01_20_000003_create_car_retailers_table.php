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
        Schema::create('car_retailers', function (Blueprint $table) {
            $table->id();
            
            // Company Information
            $table->string('legal_business_name');
            $table->string('dba')->nullable();
            $table->string('business_type');
            $table->json('platform_type'); // Marketplace, Direct Seller, Hybrid
            $table->integer('years_operation');
            $table->string('website_url')->nullable();
            
            // Primary Contact
            $table->string('contact_name');
            $table->string('contact_title');
            $table->string('contact_phone');
            $table->string('contact_email');
            
            // Logistics & Operations
            $table->text('fulfillment_address');
            $table->enum('multiple_warehouses', ['yes', 'no']);
            $table->text('shipping_nodes')->nullable();
            $table->enum('inventory_api_access', ['yes', 'no']);
            $table->string('api_url_docs')->nullable();
            $table->string('vehicle_list')->nullable();
            
            // Transport Preferences
            $table->integer('cars_shipped');
            $table->json('vehicle_types'); // New, Used, EVs, Luxury, Oversized
            $table->enum('transport_type', ['open', 'enclosed']);
            $table->enum('preferred_delivery', ['door_to_door', 'terminal_to_terminal']);
            $table->enum('unattended_pickup', ['yes', 'no']);
            
            // Billing & Payment
            $table->string('billing_contact');
            $table->string('billing_email');
            $table->enum('payment_method', ['ach', 'credit_card', 'check', 'other']);
            $table->string('vendor_platforms')->nullable();
            
            // Verification Documents
            $table->string('ein_tax_id');
            $table->string('w9_upload');
            $table->string('insurance_certificate')->nullable();
            $table->enum('nda_required', ['yes', 'no']);
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
        Schema::dropIfExists('car_retailers');
    }
};
