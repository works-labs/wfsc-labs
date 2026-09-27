<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SiteContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ==========================================
        // HERO BANNERS
        // ==========================================
        DB::table('hero_banners')->updateOrInsert(
            ['id' => 1],
            [
                'title'            => 'WFSC Aesthetic & Anti Aging Clinic',
                'subtitle'         => 'Selamat Datang di WFSC CLINIC',
                'background_image' => null,
                'cta_text'         => 'Book Now',
                'cta_type'         => 'treatment',
                'cta_target'       => 'korean-nose-lift',
                'sort_order'       => 0,
                'is_active'        => true,
                'created_at'       => now(),
                'updated_at'       => now(),
            ]
        );

        // ==========================================
        // BANNERS
        // ==========================================
        $banners = [
            ['title' => 'Test Promo Banner',  'placement' => 'promos',     'sort_order' => 0],
            ['title' => 'Treatemnts',          'placement' => 'treatments', 'sort_order' => 0],
            ['title' => 'test',                'placement' => 'skincare',   'sort_order' => 0],
        ];

        foreach ($banners as $banner) {
            $existing = DB::table('banners')->where('placement', $banner['placement'])->first();

            if ($existing) {
                // Hanya update non-image fields agar tidak override image yang sudah upload
                DB::table('banners')
                    ->where('placement', $banner['placement'])
                    ->update([
                        'title'      => $banner['title'],
                        'subtitle'   => null,
                        'sort_order' => $banner['sort_order'],
                        'is_active'  => true,
                        'updated_at' => now(),
                    ]);
            } else {
                DB::table('banners')->insert([
                    'title'      => $banner['title'],
                    'subtitle'   => null,
                    'image'      => 'placeholder.jpg', // placeholder, upload manual di cpanel
                    'placement'  => $banner['placement'],
                    'sort_order' => $banner['sort_order'],
                    'is_active'  => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // ==========================================
        // WHY CHOOSE ITEMS
        // ==========================================
        $whyChooseItems = [
            [
                'title'       => 'Professional Treatment',
                'description' => 'Perawatan estetika dengan prosedur yang terarah untuk membantu mencapai hasil perawatan sesuai kebutuhan setiap pasien.',
                'icon'        => '1',
                'sort_order'  => 1,
                'is_active'   => true,
            ],
            [
                'title'       => 'Modern Technology',
                'description' => 'Menghadirkan pilihan treatment estetika dengan teknologi dan metode perawatan modern untuk menunjang hasil yang optimal.',
                'icon'        => '2',
                'sort_order'  => 2,
                'is_active'   => true,
            ],
            [
                'title'       => 'Comfortable Experience',
                'description' => 'Memberikan pengalaman perawatan yang nyaman dengan fasilitas treatment yang bersih, privat, dan mendukung kebutuhan pasien.',
                'icon'        => '3',
                'sort_order'  => 3,
                'is_active'   => true,
            ],
        ];

        foreach ($whyChooseItems as $item) {
            DB::table('why_choose_items')->updateOrInsert(
                ['title' => $item['title']],
                array_merge($item, ['created_at' => now(), 'updated_at' => now()])
            );
        }

        // ==========================================
        // SITE STATISTICS
        // ==========================================
        $statistics = [
            ['label' => 'Years of Experience', 'value' => '10',   'suffix' => '+', 'icon' => '-', 'sort_order' => 1, 'is_active' => true],
            ['label' => 'Happy Patients',       'value' => '1000', 'suffix' => '+', 'icon' => '-', 'sort_order' => 2, 'is_active' => true],
            ['label' => 'Patient Satisfaction', 'value' => '98',   'suffix' => '+', 'icon' => '-', 'sort_order' => 3, 'is_active' => true],
        ];

        foreach ($statistics as $stat) {
            DB::table('site_statistics')->updateOrInsert(
                ['label' => $stat['label']],
                array_merge($stat, ['created_at' => now(), 'updated_at' => now()])
            );
        }

        // ==========================================
        // SITE SETTINGS
        // ==========================================
        $settings = [
            ['key' => 'whatsapp_number', 'value' => '+6282243833309'],
            ['key' => 'instagram_url',   'value' => 'https://www.instagram.com/wfsc_clinic?igsi=MWpxN2JjajhnZzBoZA=='],
            ['key' => 'tiktok_url',      'value' => 'https://www.tiktok.com/@wfsc_clinic'],
            ['key' => 'threads_url',     'value' => 'https://www.threads.com/@wfsc_clinic'],
        ];

        foreach ($settings as $setting) {
            DB::table('site_settings')->updateOrInsert(
                ['key' => $setting['key']],
                array_merge($setting, ['created_at' => now(), 'updated_at' => now()])
            );
        }

        // ==========================================
        // FACILITIES
        // ==========================================
        $facilities = [
            [
                'name'        => 'Consultation Room',
                'description' => 'Ruang konsultasi yang nyaman untuk membantu pasien mendapatkan informasi dan rekomendasi treatment sesuai kebutuhan.',
                'image'       => null,
                'sort_order'  => 1,
                'is_active'   => true,
            ],
            [
                'name'        => 'Treatment Room',
                'description' => 'Ruang treatment yang nyaman, bersih, dan privat untuk menunjang berbagai prosedur perawatan estetika.',
                'image'       => null,
                'sort_order'  => 2,
                'is_active'   => true,
            ],
            [
                'name'        => 'Beauty Lounge',
                'description' => 'Area nyaman untuk bersantai dan mempersiapkan diri sebelum maupun setelah melakukan treatment.',
                'image'       => null,
                'sort_order'  => 3,
                'is_active'   => true,
            ],
        ];

        foreach ($facilities as $facility) {
            DB::table('facilities')->updateOrInsert(
                ['name' => $facility['name']],
                array_merge($facility, ['created_at' => now(), 'updated_at' => now()])
            );
        }

        // ==========================================
        // BRANCHES
        // ==========================================
        $branches = [
            [
                'name'            => 'WFSC Aesthetic & Anti Aging Clinic Surabaya',
                'address'         => 'Ruko North Junction Blok RA-20, Jl. Taman Puspa Raya, Citraland, Kel. Sambikerep, Kec. Sambikerep, Kota Surabaya, Jawa Timur 60217',
                'phone'           => '(031) 5116-3309',
                'whatsapp'        => '(031) 5116-3309',
                'email'           => 'surabaya.branch@wfscclinic.com',
                'google_maps_url' => 'https://maps.app.goo.gl/zn47caYSDEyA4cnS8',
                'latitude'        => '-7.2575000',
                'longitude'       => '112.6422200',
                'is_active'       => true,
            ],
            [
                'name'            => 'WFSC Berau',
                'address'         => 'Jl. Gajah Mada No. 511, Tanjung Redeb, Kabupaten Berau, Kalimantan Timur',
                'phone'           => '0811-3116-149',
                'whatsapp'        => '(031) 5116-3309',
                'email'           => '',
                'google_maps_url' => 'https://maps.app.goo.gl/LzTXcm5icNyiSHdbA',
                'latitude'        => '2.1539000',
                'longitude'       => '117.4970000',
                'is_active'       => true,
            ],
        ];

        foreach ($branches as $branch) {
            DB::table('branches')->updateOrInsert(
                ['name' => trim($branch['name'])],
                array_merge($branch, ['created_at' => now(), 'updated_at' => now()])
            );
        }
    }
}
