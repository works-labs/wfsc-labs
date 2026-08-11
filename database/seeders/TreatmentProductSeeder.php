<?php

namespace Database\Seeders;

use App\Models\Treatment;
use App\Models\TreatmentProduct;
use Illuminate\Database\Seeder;

class TreatmentProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'treatment' => 'hydrafacial',
                'products' => [
                    [
                        'name' => 'Hydrafacial Basic',
                        'description' => 'Perawatan dasar untuk membersihkan, mengangkat sel kulit mati, dan menghidrasi kulit.',
                        'sort_order' => 1,
                    ],
                    [
                        'name' => 'Hydrafacial Premium',
                        'description' => 'Perawatan intensif dengan tahapan perawatan dan hidrasi kulit yang lebih lengkap.',
                        'sort_order' => 2,
                    ],
                ],
            ],

            [
                'treatment' => 'skin-booster',
                'products' => [
                    [
                        'name' => 'Skin Booster Basic',
                        'description' => 'Perawatan untuk membantu meningkatkan hidrasi dan kualitas kulit.',
                        'sort_order' => 1,
                    ],
                    [
                        'name' => 'Skin Booster Premium',
                        'description' => 'Perawatan skin booster dengan rangkaian perawatan yang lebih lengkap.',
                        'sort_order' => 2,
                    ],
                ],
            ],

            [
                'treatment' => 'botox',
                'products' => [
                    [
                        'name' => 'Botox Forehead',
                        'description' => 'Perawatan untuk membantu mengurangi tampilan garis halus pada area dahi.',
                        'sort_order' => 1,
                    ],
                    [
                        'name' => 'Botox Frown Lines',
                        'description' => 'Perawatan untuk membantu mengurangi tampilan garis kerutan di antara alis.',
                        'sort_order' => 2,
                    ],
                ],
            ],

            [
                'treatment' => 'dermal-filler',
                'products' => [
                    [
                        'name' => 'Dermal Filler Cheek',
                        'description' => 'Perawatan filler untuk membantu membentuk dan menambah volume pada area pipi.',
                        'sort_order' => 1,
                    ],
                    [
                        'name' => 'Dermal Filler Lip',
                        'description' => 'Perawatan filler untuk membantu memberikan volume dan membentuk area bibir.',
                        'sort_order' => 2,
                    ],
                ],
            ],

            [
                'treatment' => 'laser-hair-removal',
                'products' => [
                    [
                        'name' => 'Laser Hair Removal Face',
                        'description' => 'Perawatan laser untuk membantu mengurangi pertumbuhan rambut pada area wajah.',
                        'sort_order' => 1,
                    ],
                    [
                        'name' => 'Laser Hair Removal Body',
                        'description' => 'Perawatan laser untuk membantu mengurangi pertumbuhan rambut pada area tubuh.',
                        'sort_order' => 2,
                    ],
                ],
            ],

            [
                'treatment' => 'acne-facial',
                'products' => [
                    [
                        'name' => 'Acne Facial Basic',
                        'description' => 'Perawatan facial untuk membantu membersihkan dan merawat kulit yang rentan berjerawat.',
                        'sort_order' => 1,
                    ],
                    [
                        'name' => 'Acne Facial Premium',
                        'description' => 'Perawatan facial dengan rangkaian yang lebih lengkap untuk kulit rentan berjerawat.',
                        'sort_order' => 2,
                    ],
                ],
            ],
        ];

        foreach ($products as $item) {
            $treatment = Treatment::where('slug', $item['treatment'])->firstOrFail();

            foreach ($item['products'] as $product) {
                TreatmentProduct::create([
                    'treatment_id' => $treatment->id,
                    'name' => $product['name'],
                    'description' => $product['description'],
                    'sort_order' => $product['sort_order'],
                    'is_active' => true,
                ]);
            }
        }
    }
}