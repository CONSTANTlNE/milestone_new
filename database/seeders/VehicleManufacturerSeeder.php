<?php

namespace Database\Seeders;

use App\Models\VehicleManufacturer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VehicleManufacturerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        VehicleManufacturer::create([
            'legal_business_name' => 'Toyota Motor Manufacturing USA',
            'dba' => 'Toyota USA',
            'business_type' => 'manufacturer',
            'years_operation' => 35,
            'website_url' => 'https://www.toyota.com',
            'us_office_location' => 'Plano, TX',
            'contact_name' => 'David Rodriguez',
            'contact_title' => 'Logistics Director',
            'contact_phone' => '(555) 123-4567',
            'contact_email' => 'david.rodriguez@toyota.com',
            'primary_port_factory' => 'Georgetown, KY - Toyota Motor Manufacturing Kentucky',
            'us_distribution_centers' => 'Georgetown, KY; Princeton, IN; Huntsville, AL; Buffalo, WV',
            'delivery_frequency' => 'daily',
            'monthly_volume' => 5000,
            'vin_batching_format' => 'Sequential by model and date',
            'new_car_prep' => 'PDI inspection, protective wrapping removal, fuel top-off',
            'transport_type' => 'enclosed',
            'vehicle_types' => ['new', 'ev'],
            'load_prep_protocols' => 'VIN verification, damage inspection, documentation package',
            'special_handling' => 'EV batteries must be at 50% charge, no smoking in transport',
            'delivery_destinations' => 'Northeast, Southeast, Midwest, Southwest regions',
            'compliance_procedures' => 'EPA compliance check, safety inspection, emissions testing',
            'billing_contact' => 'Maria Garcia',
            'billing_email' => 'billing@toyota.com',
            'payment_method' => ['ach', 'net_terms'],
            'vendor_management_system' => 'yes',
            'system_name' => 'Ariba',
            'w9_upload' => 'vehicle_manufacturers/w9/toyota_w9.pdf',
            'insurance_certificate' => 'vehicle_manufacturers/insurance/toyota_insurance.pdf',
            'business_registration' => 'vehicle_manufacturers/business_registration/toyota_registration.pdf',
            'trade_references' => 'Honda, Ford, GM - 15+ years of partnership',
            'status' => 'approved',
            'admin_notes' => 'Approved for Tier 3 partnership - high volume manufacturer',
        ]);

        VehicleManufacturer::create([
            'legal_business_name' => 'Honda North America Inc',
            'dba' => 'Honda USA',
            'business_type' => 'manufacturer',
            'years_operation' => 40,
            'website_url' => 'https://www.honda.com',
            'us_office_location' => 'Torrance, CA',
            'contact_name' => 'Jennifer Kim',
            'contact_title' => 'Supply Chain Manager',
            'contact_phone' => '(555) 987-6543',
            'contact_email' => 'jennifer.kim@honda.com',
            'primary_port_factory' => 'Marysville, OH - Honda of America Manufacturing',
            'us_distribution_centers' => 'Marysville, OH; Lincoln, AL; Greensburg, IN; East Liberty, OH',
            'delivery_frequency' => 'weekly',
            'monthly_volume' => 3500,
            'vin_batching_format' => 'Date-based with model grouping',
            'new_car_prep' => 'PDI completion, protective film removal, quality assurance check',
            'transport_type' => 'enclosed',
            'vehicle_types' => ['new', 'ev', 'high_end'],
            'load_prep_protocols' => 'Pre-delivery inspection, documentation verification, damage assessment',
            'special_handling' => 'Acura models require premium transport, EV charging protocols',
            'delivery_destinations' => 'West Coast, Central, Eastern regions',
            'compliance_procedures' => 'Safety standards compliance, emissions verification',
            'billing_contact' => 'Robert Chen',
            'billing_email' => 'robert.chen@honda.com',
            'payment_method' => ['ach', 'credit_card', 'net_terms'],
            'vendor_management_system' => 'yes',
            'system_name' => 'Coupa',
            'w9_upload' => 'vehicle_manufacturers/w9/honda_w9.pdf',
            'insurance_certificate' => 'vehicle_manufacturers/insurance/honda_insurance.pdf',
            'business_registration' => 'vehicle_manufacturers/business_registration/honda_registration.pdf',
            'trade_references' => 'Toyota, Nissan, Subaru - long-term partnerships',
            'status' => 'pending',
            'admin_notes' => 'Under review for Tier 2 partnership',
        ]);

        VehicleManufacturer::create([
            'legal_business_name' => 'Luxury Auto Distributors LLC',
            'dba' => 'Luxury Auto',
            'business_type' => 'distributor',
            'years_operation' => 12,
            'website_url' => 'https://www.luxuryauto.com',
            'us_office_location' => 'Miami, FL',
            'contact_name' => 'Carlos Mendez',
            'contact_title' => 'Operations Director',
            'contact_phone' => '(555) 456-7890',
            'contact_email' => 'carlos@luxuryauto.com',
            'primary_port_factory' => 'Port of Miami - Luxury Vehicle Processing Center',
            'us_distribution_centers' => 'Miami, FL; Los Angeles, CA; New York, NY; Chicago, IL',
            'delivery_frequency' => 'monthly',
            'monthly_volume' => 200,
            'vin_batching_format' => 'Model-based grouping',
            'new_car_prep' => 'Premium detailing, protective coating application, quality inspection',
            'transport_type' => 'enclosed',
            'vehicle_types' => ['high_end', 'luxury', 'prototypes'],
            'load_prep_protocols' => 'Premium vehicle handling, climate control monitoring, security protocols',
            'special_handling' => 'Climate-controlled transport required, security escort for high-value vehicles',
            'delivery_destinations' => 'Major metropolitan areas, luxury dealerships',
            'compliance_procedures' => 'Import compliance, luxury vehicle regulations',
            'billing_contact' => 'Ana Rodriguez',
            'billing_email' => 'ana@luxuryauto.com',
            'payment_method' => ['credit_card', 'net_terms'],
            'vendor_management_system' => 'no',
            'system_name' => null,
            'w9_upload' => 'vehicle_manufacturers/w9/luxury_w9.pdf',
            'insurance_certificate' => 'vehicle_manufacturers/insurance/luxury_insurance.pdf',
            'business_registration' => 'vehicle_manufacturers/business_registration/luxury_registration.pdf',
            'trade_references' => 'European luxury brands, premium dealerships',
            'status' => 'rejected',
            'admin_notes' => 'Rejected - insufficient volume for partnership',
        ]);
    }
}
