<?php

namespace Database\Seeders;

use App\Models\Treatment;
use App\Models\TreatmentProduct;
use Illuminate\Database\Seeder;

class TreatmentProductSeeder extends Seeder
{
    public function run(): void
    {
        // treatment_products berdasarkan data aktual di database
        // Kedua produk ini terhubung ke treatment id=6 (Plasma Pro)
        $products = [
            [
                'treatment' => 'plasma-pro',
                'products'  => [
                    [
                        'name'        => 'Skincare ',
                        'description' => 'Saran produk perawatan setelah oprasi berlangsung ',
                        'image'       => null,
                        'sort_order'  => 1,
                    ],
                    [
                        'name'        => 'Skincare ',
                        'description' => 'Pengunaan produk ini untuk menunjang penampilan lebih oke',
                        'image'       => null,
                        'sort_order'  => 2,
                    ],
                ],
            ],
        ];

        foreach ($products as $item) {
            $treatment = Treatment::where('slug', $item['treatment'])->first();

            if (!$treatment) {
                continue;
            }

            foreach ($item['products'] as $product) {
                TreatmentProduct::firstOrCreate(
                    [
                        'treatment_id' => $treatment->id,
                        'name'         => $product['name'],
                        'sort_order'   => $product['sort_order'],
                    ],
                    [
                        'description' => $product['description'],
                        'image'       => $product['image'],
                        'is_active'   => true,
                    ]
                );
            }
        }
    }
}