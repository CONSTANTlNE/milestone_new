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
        Schema::create('auto_auctions', function (Blueprint $table) {
            $table->id();
            
            // Company Information
            $table->string('legal_business_name');
            $table->string('dba')->nullable();
            $table->string('business_type');
            $table->json('platform_type'); // Physical, Online, Hybrid
            $table->integer('years_operation');
            $table->string('website_url')->nullable();
            
            // Primary Contact
            $table->string('contact_name');
            $table->string('contact_title');
            $table->string('contact_phone');
            $table->string('contact_email');
            
            // Auction Logistics & Operations
            $table->text('main_address');
            $table->enum('multiple_locations', ['yes', 'no']);
            $table->text('additional_locations')->nullable();
            $table->string('primary_auction_days');
            $table->integer('lot_numbers');
            $table->enum('inventory_system', ['yes', 'no']);
            
            // Vehicle & Transport Preferences
            $table->integer('vehicles_shipped');
            $table->json('vehicle_types'); // New, Used, Salvage, Luxury, Inoperable
            $table->enum('transport_type', ['open', 'enclosed']);
            $table->text('pickup_protocols');
            $table->enum('condition_reports', ['yes', 'no']);
            $table->enum('carrier_preloading', ['yes', 'no']);
            
            // Billing & Payment
            $table->string('billing_contact');
            $table->string('billing_email');
            $table->enum('payment_method', ['ach', 'credit_card', 'net_terms']);
            $table->string('vendor_platforms')->nullable();
            
            // Verification Documents
            $table->string('ein_tax_id');
            $table->string('dealer_license');
            $table->string('w9_upload');
            $table->string('insurance_certificate');
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
        Schema::dropIfExists('auto_auctions');
    }
};
