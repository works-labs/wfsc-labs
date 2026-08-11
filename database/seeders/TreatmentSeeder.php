<?php

namespace Database\Seeders;

use App\Models\Treatment;
use App\Models\TreatmentCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TreatmentSeeder extends Seeder
{
    public function run(): void
    {
        $categories = TreatmentCategory::pluck('id', 'slug');

        $treatments = [
            [
                'category' => 'skin-quality',
                'name' => 'Hydrafacial',
                'short_description' => 'Perawatan intensif untuk membersihkan, menghidrasi, dan menyegarkan kulit.',
                'description' => 'Hydrafacial merupakan perawatan wajah yang membantu membersihkan pori-pori, mengangkat sel kulit mati, dan memberikan hidrasi pada kulit.',
                'is_featured' => true,
            ],
            [
                'category' => 'skin-quality',
                'name' => 'Skin Booster',
                'short_description' => 'Perawatan untuk membantu meningkatkan hidrasi dan kualitas kulit.',
                'description' => 'Skin Booster membantu meningkatkan kelembapan dan tampilan kulit agar terlihat lebih sehat dan bercahaya.',
                'is_featured' => true,
            ],
            [
                'category' => 'anti-aging-contouring',
                'name' => 'Botox',
                'short_description' => 'Perawatan untuk membantu mengurangi tampilan garis halus dan kerutan.',
                'description' => 'Perawatan Botox digunakan untuk membantu mengurangi tampilan garis halus dan kerutan pada area tertentu di wajah.',
                'is_featured' => true,
            ],
            [
                'category' => 'anti-aging-contouring',
                'name' => 'Dermal Filler',
                'short_description' => 'Perawatan untuk membantu membentuk dan meningkatkan kontur wajah.',
                'description' => 'Dermal filler merupakan perawatan yang dapat membantu meningkatkan volume dan membentuk kontur pada area wajah tertentu.',
                'is_featured' => false,
            ],
            [
                'category' => 'body-hair-treatment',
                'name' => 'Laser Hair Removal',
                'short_description' => 'Perawatan untuk membantu mengurangi pertumbuhan rambut yang tidak diinginkan.',
                'description' => 'Laser Hair Removal menggunakan teknologi laser untuk membantu mengurangi pertumbuhan rambut pada area tubuh tertentu.',
                'is_featured' => false,
            ],
            [
                'category' => 'facial',
                'name' => 'Acne Facial',
                'short_description' => 'Perawatan wajah yang ditujukan untuk kulit dengan masalah jerawat.',
                'description' => 'Acne Facial merupakan perawatan yang membantu membersihkan kulit dan merawat kondisi kulit yang rentan terhadap jerawat.',
                'is_featured' => false,
            ],
        ];

        foreach ($treatments as $data) {
            Treatment::updateOrCreate(
                ['slug' => Str::slug($data['name'])],
                [
                    'category_id' => $categories[$data['category']] ?? null,
                    'name' => $data['name'],
                    'slug' => Str::slug($data['name']),
                    'short_description' => $data['short_description'],
                    'description' => $data['description'],
                    'cover_image' => null,
                    'is_featured' => $data['is_featured'],
                    'is_active' => true,
                ]
            );
        }
    }
}