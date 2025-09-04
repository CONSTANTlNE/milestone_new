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
        Schema::create('corporate_government_fleets', function (Blueprint $table) {
            $table->id();
            
            // Organization Information
            $table->string('legal_organization_name');
            $table->string('dba')->nullable();
            $table->enum('business_type', ['corporate', 'government', 'non_profit']);
            $table->string('department')->nullable();
            $table->integer('years_operation');
            $table->string('website_url')->nullable();
            
            // Primary Contact
            $table->string('contact_name');
            $table->string('contact_title');
            $table->string('contact_phone');
            $table->string('contact_email');
            
            // Fleet Logistics & Operations
            $table->text('fulfillment_address');
            $table->integer('fleet_locations');
            $table->string('vehicle_release_contact');
            $table->string('fleet_management_software')->nullable();
            $table->json('usage_type'); // Law Enforcement, Utility, Passenger, Construction, Mixed
            $table->enum('vehicle_condition', ['mostly_new', 'mostly_used', 'mixed', 'varies']);
            
            // Transport Needs & Preferences
            $table->integer('vehicles_per_month');
            $table->enum('transport_type', ['open', 'enclosed']);
            $table->enum('transport_scope', ['local', 'regional', 'nationwide']);
            $table->string('security_requirements')->nullable();
            $table->text('pickup_protocols');
            $table->text('special_handling')->nullable();
            
            // Billing & Payment
            $table->string('billing_contact');
            $table->string('billing_email');
            $table->enum('payment_method', ['ach', 'credit_card', 'government_po', 'net_terms']);
            $table->enum('vendor_portal_invoicing', ['yes', 'no']);
            $table->string('payment_platform')->nullable();
            
            // Verification Documents
            $table->string('government_corporate_id');
            $table->string('w9_upload');
            $table->string('insurance_certificate');
            $table->string('purchase_order_format')->nullable();
            $table->text('references_contractors')->nullable();
            
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
        Schema::dropIfExists('corporate_government_fleets');
    }
};
