<?php

namespace Database\Seeders;

use App\Models\QuotationCharge;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ChargeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        QuotationCharge::create([
            'name' => 'width over 84',
            'surcharge' => 270
        ]);
        QuotationCharge::create([
            'name' => 'width over 88',
            'surcharge' => 450
        ]);
        QuotationCharge::create([
            'name' => 'Weight 6000-7500',
            'surcharge' => 210
        ]);
        QuotationCharge::create([
            'name' => 'Weight 7500',
            'surcharge' => 300
        ]);
        QuotationCharge::create([
            'name' => 'Weight 4000-6000',
            'surcharge' => 150
        ]);
        QuotationCharge::create([
            'name' => 'Length over 210',
            'surcharge' => 210
        ]);
        QuotationCharge::create([
            'name' => 'Height over 78',
            'surcharge' => 240
        ]);
        QuotationCharge::create([
            'name' => 'Non-Operational',
            'surcharge' => 210
        ]);
        QuotationCharge::create([
            'name' => 'Luxury vehicle',
            'surcharge' => 330
        ]);
        QuotationCharge::create([
            'name' => 'SUV',
            'surcharge' => 150
        ]);
        QuotationCharge::create([
            'name' => 'Base Rate',
            'surcharge' => 0.98,
        ]);

    }
}
