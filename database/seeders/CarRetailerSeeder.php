<?php

namespace Database\Seeders;

use App\Models\CarRetailer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CarRetailerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CarRetailer::create([
            'legal_business_name' => 'Premium Car Retailers LLC',
            'dba' => 'Premium Cars',
            'business_type' => 'LLC',
            'platform_type' => ['marketplace', 'direct_seller'],
            'years_operation' => 12,
            'website_url' => 'https://premiumcars.com',
            'contact_name' => 'Michael Johnson',
            'contact_title' => 'Operations Director',
            'contact_phone' => '(555) 123-4567',
            'contact_email' => 'michael@premiumcars.com',
            'fulfillment_address' => '123 Premium Drive, Los Angeles, CA 90210',
            'multiple_warehouses' => 'yes',
            'shipping_nodes' => 'Los Angeles, CA; Phoenix, AZ; Las Vegas, NV',
            'inventory_api_access' => 'yes',
            'api_url_docs' => 'https://api.premiumcars.com/docs',
            'vehicle_list' => 'car_retailers/vehicle_lists/sample_vehicle_list.pdf',
            'cars_shipped' => 150,
            'vehicle_types' => ['new', 'used', 'luxury', 'evs'],
            'transport_type' => 'enclosed',
            'preferred_delivery' => 'door_to_door',
            'unattended_pickup' => 'yes',
            'billing_contact' => 'Sarah Wilson',
            'billing_email' => 'billing@premiumcars.com',
            'payment_method' => 'ach',
            'vendor_platforms' => 'QuickBooks, BILL',
            'ein_tax_id' => '12-3456789',
            'trade_references' => 'ABC Transport, XYZ Logistics',
            'w9_upload' => 'car_retailers/w9/sample_w9.pdf',
            'insurance_certificate' => 'car_retailers/insurance/sample_insurance.pdf',
            'nda_required' => 'yes',
            'status' => 'pending',
            'admin_notes' => 'Sample car retailer for testing purposes',
        ]);

        CarRetailer::create([
            'legal_business_name' => 'Budget Auto Sales Inc',
            'dba' => null,
            'business_type' => 'Corporation',
            'platform_type' => ['direct_seller'],
            'years_operation' => 8,
            'website_url' => 'https://budgetautosales.com',
            'contact_name' => 'David Brown',
            'contact_title' => 'General Manager',
            'contact_phone' => '(555) 987-6543',
            'contact_email' => 'david@budgetautosales.com',
            'fulfillment_address' => '456 Budget Street, Phoenix, AZ 85001',
            'multiple_warehouses' => 'no',
            'shipping_nodes' => null,
            'inventory_api_access' => 'no',
            'api_url_docs' => null,
            'vehicle_list' => null,
            'cars_shipped' => 75,
            'vehicle_types' => ['used', 'oversized'],
            'transport_type' => 'open',
            'preferred_delivery' => 'terminal_to_terminal',
            'unattended_pickup' => 'no',
            'billing_contact' => 'David Brown',
            'billing_email' => 'david@budgetautosales.com',
            'payment_method' => 'credit_card',
            'vendor_platforms' => 'QuickBooks',
            'ein_tax_id' => '98-7654321',
            'trade_references' => 'Budget Transport',
            'w9_upload' => 'car_retailers/w9/sample_w9_2.pdf',
            'insurance_certificate' => null,
            'nda_required' => 'no',
            'status' => 'approved',
            'admin_notes' => 'Approved for partnership',
        ]);

        CarRetailer::create([
            'legal_business_name' => 'Luxury Auto Marketplace',
            'dba' => 'Luxury Cars',
            'business_type' => 'LLC',
            'platform_type' => ['marketplace', 'hybrid'],
            'years_operation' => 15,
            'website_url' => 'https://luxurycars.com',
            'contact_name' => 'Jennifer Smith',
            'contact_title' => 'CEO',
            'contact_phone' => '(555) 456-7890',
            'contact_email' => 'jennifer@luxurycars.com',
            'fulfillment_address' => '789 Luxury Lane, Miami, FL 33101',
            'multiple_warehouses' => 'yes',
            'shipping_nodes' => 'Miami, FL; Orlando, FL; Tampa, FL',
            'inventory_api_access' => 'yes',
            'api_url_docs' => 'https://api.luxurycars.com',
            'vehicle_list' => 'car_retailers/vehicle_lists/luxury_vehicle_list.pdf',
            'cars_shipped' => 300,
            'vehicle_types' => ['luxury', 'new', 'evs'],
            'transport_type' => 'enclosed',
            'preferred_delivery' => 'door_to_door',
            'unattended_pickup' => 'yes',
            'billing_contact' => 'Robert Davis',
            'billing_email' => 'robert@luxurycars.com',
            'payment_method' => 'ach',
            'vendor_platforms' => 'QuickBooks, BILL, PayPal',
            'ein_tax_id' => '45-6789012',
            'trade_references' => 'Luxury Transport, Elite Logistics, Premium Shipping',
            'w9_upload' => 'car_retailers/w9/sample_w9_3.pdf',
            'insurance_certificate' => 'car_retailers/insurance/sample_insurance_3.pdf',
            'nda_required' => 'yes',
            'status' => 'rejected',
            'admin_notes' => 'Rejected due to incomplete documentation',
        ]);
    }
}
