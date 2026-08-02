<?php

namespace Database\Seeders;

use App\Models\MaritalStatus;
use Illuminate\Database\Seeder;

class MaritalStatusSeeder extends Seeder
{
    public function run(): void
    {
        $statuses = [
            'أعزب',
            'متزوج',
            'مطلق',
            'أرمل',
        ];

        foreach ($statuses as $status) {
            MaritalStatus::firstOrCreate([
                'name' => $status,
            ]);
        }
    }
}