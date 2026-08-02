<?php

namespace Database\Seeders;

use App\Models\JobTitle;
use Illuminate\Database\Seeder;

class JobTitleSeeder extends Seeder
{
    public function run(): void
    {
        $jobTitles = [
            'مدير',
            'محاسب',
            'موارد بشرية',
            'مطور برمجيات',
            'مصمم',
            'مسؤول مبيعات',
            'خدمة عملاء',
        ];

        foreach ($jobTitles as $jobTitle) {
            JobTitle::firstOrCreate([
                'name' => $jobTitle,
            ]);
        }
    }
}