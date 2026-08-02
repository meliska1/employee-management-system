<?php

namespace Database\Seeders;

use App\Models\Bank;
use Illuminate\Database\Seeder;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $banks = [
            'الراجحي',
            'الأهلي',
            'الرياض',
            'البلاد',
            'الإنماء',
            'ساب',
        ];

        foreach ($banks as $bank) {
            Bank::firstOrCreate([
                'name' => $bank,
            ]);
        }
    }
}

