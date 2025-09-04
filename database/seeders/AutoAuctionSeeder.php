<?php

namespace Database\Seeders;

use App\Models\AutoAuction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AutoAuctionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AutoAuction::create([
            'legal_business_name' => 'ABC Auto Auctions LLC',
            'dba' => 'ABC Auctions',
            'business_type' => 'LLC',
            'platform_type' => ['physical', 'online'],
            'years_operation' => 15,
            'website_url' => 'https://abcauctions.com',
            'contact_name' => 'John Smith',
            'contact_title' => 'Operations Manager',
            'contact_phone' => '(555) 123-4567',
            'contact_email' => 'john@abcauctions.com',
            'main_address' => '123 Auction Lane, Detroit, MI 48201',
            'multiple_locations' => 'yes',
            'additional_locations' => 'Chicago, IL; Atlanta, GA',
            'primary_auction_days' => 'Monday, Wednesday, Friday',
            'lot_numbers' => 500,
            'inventory_system' => 'yes',
            'unattended_pickup' => 'yes',
            'vehicles_shipped' => 200,
            'vehicle_types' => ['used', 'salvage', 'luxury'],
            'transport_type' => 'open',
            'pickup_protocols' => 'Gate pass required, lot ID must be provided',
            'condition_reports' => 'yes',
            'carrier_preloading' => 'yes',
            'billing_contact' => 'Jane Doe',
            'billing_email' => 'billing@abcauctions.com',
            'payment_method' => ['ach', 'credit_card', 'net_terms'],
            'vendor_platforms' => 'QuickBooks, BILL',
            'ein_tax_id' => '12-3456789',
            'dealer_license' => 'DL123456',
            'w9_upload' => 'auto_auctions/w9/sample_w9.pdf',
            'insurance_certificate' => 'auto_auctions/insurance/sample_insurance.pdf',
            'trade_references' => 'XYZ Transport, ABC Logistics',
            'status' => 'pending',
            'admin_notes' => 'Sample auto auction for testing purposes',
        ]);

        AutoAuction::create([
            'legal_business_name' => 'Premium Auto Sales Inc',
            'dba' => null,
            'business_type' => 'Corporation',
            'platform_type' => ['hybrid'],
            'years_operation' => 8,
            'website_url' => 'https://premiumautosales.com',
            'contact_name' => 'Sarah Johnson',
            'contact_title' => 'General Manager',
            'contact_phone' => '(555) 987-6543',
            'contact_email' => 'sarah@premiumautosales.com',
            'main_address' => '456 Premium Drive, Los Angeles, CA 90210',
            'multiple_locations' => 'no',
            'additional_locations' => null,
            'primary_auction_days' => 'Tuesday, Thursday',
            'lot_numbers' => 300,
            'inventory_system' => 'yes',
            'unattended_pickup' => 'no',
            'vehicles_shipped' => 150,
            'vehicle_types' => ['new', 'used', 'luxury'],
            'transport_type' => 'enclosed',
            'pickup_protocols' => 'Appointment required, photo ID needed',
            'condition_reports' => 'yes',
            'carrier_preloading' => 'no',
            'billing_contact' => 'Mike Wilson',
            'billing_email' => 'mike@premiumautosales.com',
            'payment_method' => ['ach', 'net_terms'],
            'vendor_platforms' => 'QuickBooks',
            'ein_tax_id' => '98-7654321',
            'dealer_license' => 'DL789012',
            'w9_upload' => 'auto_auctions/w9/sample_w9_2.pdf',
            'insurance_certificate' => 'auto_auctions/insurance/sample_insurance_2.pdf',
            'trade_references' => 'Premium Transport, Elite Logistics',
            'status' => 'approved',
            'admin_notes' => 'Approved for partnership',
        ]);

        AutoAuction::create([
            'legal_business_name' => 'Budget Auto Auctions',
            'dba' => 'Budget Auctions',
            'business_type' => 'Sole Proprietorship',
            'platform_type' => ['physical'],
            'years_operation' => 5,
            'website_url' => null,
            'contact_name' => 'Bob Brown',
            'contact_title' => 'Owner',
            'contact_phone' => '(555) 456-7890',
            'contact_email' => 'bob@budgetauctions.com',
            'main_address' => '789 Budget Street, Phoenix, AZ 85001',
            'multiple_locations' => 'no',
            'additional_locations' => null,
            'primary_auction_days' => 'Saturday',
            'lot_numbers' => 100,
            'inventory_system' => 'no',
            'unattended_pickup' => 'no',
            'vehicles_shipped' => 50,
            'vehicle_types' => ['used', 'inoperable'],
            'transport_type' => 'open',
            'pickup_protocols' => 'Cash payment required, no returns',
            'condition_reports' => 'no',
            'carrier_preloading' => 'no',
            'billing_contact' => 'Bob Brown',
            'billing_email' => 'bob@budgetauctions.com',
            'payment_method' => ['net_terms'],
            'vendor_platforms' => null,
            'ein_tax_id' => '45-6789012',
            'dealer_license' => 'DL345678',
            'w9_upload' => 'auto_auctions/w9/sample_w9_3.pdf',
            'insurance_certificate' => 'auto_auctions/insurance/sample_insurance_3.pdf',
            'trade_references' => null,
            'status' => 'rejected',
            'admin_notes' => 'Rejected due to insufficient documentation',
        ]);
    }
}
