<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PromoSeeder extends Seeder
{
    public function run(): void
    {
        $promos = [
            [
                'title'       => 'Anti-Aging Skin Treatment',
                'slug'        => 'anti-aging-skin-treatment',
                'description' => 'Perawatan khusus untuk membantu menyamarkan garis halus, menjaga elastisitas kulit, dan membuat kulit tampak lebih muda.',
                'image'       => null,
                'cta_type'    => 'treatment',
                'cta_target'  => 'premium-korean-v-shape',
                'cta_text'    => 'Book Appointment',
                'start_date'  => '2026-08-25',
                'end_date'    => '2026-10-29',
                'sort_order'  => 1,
                'is_active'   => true,
            ],
            [
                'title'       => 'Brightening Skin Treatment',
                'slug'        => 'brightening-skin-treatment',
                'description' => 'Perawatan untuk membantu mencerahkan kulit kusam dan membuat wajah tampak lebih cerah, segar, dan glowing.',
                'image'       => null,
                'cta_type'    => 'whatsapp',
                'cta_target'  => '',
                'cta_text'    => 'Book Appointment',
                'start_date'  => '2026-08-25',
                'end_date'    => '2026-12-30',
                'sort_order'  => 2,
                'is_active'   => true,
            ],
            [
                'title'       => 'Acne Care Treatment',
                'slug'        => 'acne-care-treatment',
                'description' => 'Perawatan khusus untuk membantu merawat kulit berjerawat, mengurangi minyak berlebih, dan menjaga kulit tetap sehat.',
                'image'       => null,
                'cta_type'    => 'internal',
                'cta_target'  => 'doctors',
                'cta_text'    => 'Book Appointment',
                'start_date'  => '2026-08-25',
                'end_date'    => '2026-10-16',
                'sort_order'  => 3,
                'is_active'   => true,
            ],
        ];

        foreach ($promos as $promo) {
            DB::table('promos')->updateOrInsert(
                ['slug' => $promo['slug']],
                array_merge($promo, [
                    'treatment_product_id' => null,
                    'created_at'           => now(),
                    'updated_at'           => now(),
                ])
            );
        }
    }
}
