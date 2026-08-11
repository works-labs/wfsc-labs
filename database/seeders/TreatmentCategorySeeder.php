<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TreatmentCategory;
class TreatmentCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ini buat seeder treatmenttt
         $categories = [
            [
                'name' => 'Skin Quality',
                'slug' => 'skin-quality',
                'description' => 'Treatment untuk membantu meningkatkan kualitas, kesehatan, dan tampilan kulit.',
                'sort_order' => 1,
            ],
            [
                'name' => 'Anti Aging & Contouring',
                'slug' => 'anti-aging-contouring',
                'description' => 'Treatment untuk perawatan anti-aging dan pembentukan kontur wajah.',
                'sort_order' => 2,
            ],
            [
                'name' => 'Body & Hair Treatment',
                'slug' => 'body-hair-treatment',
                'description' => 'Perawatan tubuh dan rambut untuk menunjang penampilan dan kesehatan.',
                'sort_order' => 3,
            ],
            [
                'name' => 'Facial',
                'slug' => 'facial',
                'description' => 'Berbagai perawatan facial untuk menjaga kebersihan dan kesehatan kulit wajah.',
                'sort_order' => 4,
            ],
        ];

        foreach ($categories as $category) {
            TreatmentCategory::create($category);
        }
    }
}
