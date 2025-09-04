<?php

namespace Database\Seeders;

use App\Models\CarrierDispatcher;
use Illuminate\Database\Seeder;

class CarrierDispatcherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $carrierDispatchers = [
            [
                'mc_number' => '123456',
                'dot_number' => '1234567',
                'cars_under_management' => 50,
                'website_url' => 'https://www.samplecarrier.com',
                'legal_business_name' => 'Sample Carrier LLC',
                'dba' => 'Sample Carrier',
                'business_type' => 'LLC',
                'years_operation' => 5,
                'contact_name' => 'John Smith',
                'contact_title' => 'Operations Manager',
                'contact_phone' => '(555) 123-4567',
                'contact_email' => 'john@samplecarrier.com',
                'main_address' => '123 Main Street, Anytown, CA 90210',
                'multiple_locations' => 'no',
                'billing_contact' => 'Jane Doe',
                'billing_email' => 'billing@samplecarrier.com',
                'payment_method' => ['ach', 'credit_card'],
                'nda_required' => 'yes',
                'status' => 'pending',
            ],
            [
                'mc_number' => '789012',
                'dot_number' => '7890123',
                'cars_under_management' => 100,
                'website_url' => 'https://www.transportpro.com',
                'legal_business_name' => 'Transport Pro Corporation',
                'business_type' => 'Corporation',
                'years_operation' => 10,
                'contact_name' => 'Mike Johnson',
                'contact_title' => 'CEO',
                'contact_phone' => '(555) 987-6543',
                'contact_email' => 'mike@transportpro.com',
                'main_address' => '456 Business Ave, Somewhere, TX 75001',
                'multiple_locations' => 'yes',
                'additional_addresses' => '789 Second St, Other City, FL 33101',
                'billing_contact' => 'Sarah Wilson',
                'billing_email' => 'billing@transportpro.com',
                'payment_method' => ['ach'],
                'nda_required' => 'no',
                'status' => 'approved',
            ],
        ];

        foreach ($carrierDispatchers as $carrierDispatcher) {
            CarrierDispatcher::create($carrierDispatcher);
        }
    }
}
