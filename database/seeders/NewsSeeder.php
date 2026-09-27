<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NewsSeeder extends Seeder
{
    public function run(): void
    {
        // ==========================================
        // NEWS CATEGORIES
        // ==========================================
        $categories = [
            ['name' => 'Tips And Trick',  'slug' => 'tips-and-trick',  'description' => '', 'is_active' => true],
            ['name' => 'Artikel',          'slug' => 'artikel',          'description' => '', 'is_active' => true],
            ['name' => 'Produk Rilis',     'slug' => 'produk-rilis',     'description' => '', 'is_active' => true],
            ['name' => 'Pengetahuan',      'slug' => 'pengetahuan',      'description' => '', 'is_active' => true],
            ['name' => 'Tentang Kami',     'slug' => 'tentang-kami',     'description' => '', 'is_active' => true],
        ];

        foreach ($categories as $cat) {
            DB::table('news_categories')->updateOrInsert(
                ['slug' => $cat['slug']],
                array_merge($cat, ['created_at' => now(), 'updated_at' => now()])
            );
        }

        // ==========================================
        // NEWS ARTICLES
        // ==========================================
        $catIds = DB::table('news_categories')->pluck('id', 'slug');
        $authorId = DB::table('users')->value('id');

        $articles = [
            [
                'category_slug'  => 'tips-and-trick',
                'title'          => 'Tren Perawatan Anti Aging: Cara Menjaga Kulit Tetap Kencang dan Fresh',
                'slug'           => 'tren-perawatan-anti-aging-cara-menjaga-kulit-tetap-kencang-dan-fresh',
                'excerpt'        => 'Perawatan anti aging semakin banyak dipilih untuk membantu menjaga kulit tetap kencang, halus, dan tampak lebih muda.',
                'content'        => '<p>Tanda-tanda penuaan seperti garis halus, kerutan, dan kulit yang mulai kehilangan kekencangan merupakan hal yang umum terjadi seiring bertambahnya usia. Saat ini tersedia berbagai pilihan perawatan estetika non-bedah yang dapat membantu menjaga tampilan kulit agar tetap fresh dan terawat.

Beberapa treatment seperti Botox, Dermal Filler, dan Ultra HIFU for Face memiliki tujuan perawatan yang berbeda. Botox membantu merelaksasi otot tertentu sehingga kerutan akibat ekspresi wajah tampak lebih halus, sementara Ultra HIFU for Face membantu mengencangkan kulit dan mempertegas kontur wajah.

Pemilihan treatment sebaiknya disesuaikan dengan kondisi kulit dan kebutuhan masing-masing individu melalui konsultasi dengan tenaga medis profesional.</p>',
                'thumbnail'      => null,
                'published_at'   => '2026-08-21 06:44:00',
                'is_featured'    => true,
                'is_active'      => true,
                'baca_juga_slug' => 'kenali-pilihan-nose-lift-untuk-membentuk-kontur-hidung',
            ],
            [
                'category_slug'  => 'produk-rilis',
                'title'          => 'Mengenal Facial Contouring untuk Wajah yang Lebih Proporsional',
                'slug'           => 'mengenal-facial-contouring-untuk-wajah-yang-lebih-proporsional',
                'excerpt'        => 'Facial contouring menjadi salah satu pilihan perawatan untuk membantu menciptakan tampilan wajah yang lebih tegas, seimbang, dan proporsional.',
                'content'        => '<p>Facial contouring adalah pendekatan perawatan estetika yang bertujuan membantu menciptakan tampilan wajah yang lebih tegas, seimbang, dan proporsional tanpa prosedur bedah.

Berbagai treatment seperti Dermal Filler, Premium Korean V-Shape, dan Botox dapat digunakan untuk membentuk kontur wajah sesuai kebutuhan. Filler membantu menambah volume di area tertentu, sementara thread lift membantu mengencangkan dan mengangkat area wajah yang mengalami penurunan.

Setiap individu memiliki struktur wajah yang berbeda, sehingga konsultasi dengan tenaga medis profesional sangat diperlukan untuk menentukan kombinasi treatment yang paling tepat.</p>',
                'thumbnail'      => null,
                'published_at'   => '2026-08-21 06:45:00',
                'is_featured'    => true,
                'is_active'      => true,
                'baca_juga_slug' => 'kenali-pilihan-nose-lift-untuk-membentuk-kontur-hidung',
            ],
            [
                'category_slug'  => 'pengetahuan',
                'title'          => 'Kenali Pilihan Nose Lift untuk Membentuk Kontur Hidung',
                'slug'           => 'kenali-pilihan-nose-lift-untuk-membentuk-kontur-hidung',
                'excerpt'        => 'Nose lift menjadi salah satu pilihan perawatan non-bedah untuk membantu membuat bentuk hidung terlihat lebih tegas dan proporsional.',
                'content'        => '<p>Bentuk hidung dapat memengaruhi keseimbangan proporsi wajah secara keseluruhan. Bagi yang ingin mempertegas kontur hidung tanpa menjalani operasi, tersedia beberapa pilihan treatment estetika non-bedah.

L-Shape Nose Lift menggunakan benang khusus untuk membantu mengoreksi batang hidung, columella, dan nose tip. Sementara itu, Korean Nose Lift menggunakan threadlift dengan benang COG canulla khusus untuk hidung.

Kedua treatment tersebut memiliki tujuan dan teknik yang berbeda. Konsultasi dengan tenaga medis diperlukan untuk menentukan pilihan treatment yang sesuai dengan kondisi dan kebutuhan setiap pasien.</p>',
                'thumbnail'      => null,
                'published_at'   => '2026-08-20 06:45:00',
                'is_featured'    => false,
                'is_active'      => true,
                'baca_juga_slug' => 'mengenal-facial-contouring-untuk-wajah-yang-lebih-proporsional',
            ],
        ];

        foreach ($articles as $article) {
            $categoryId  = $catIds[$article['category_slug']] ?? null;
            $bacaJugaId  = DB::table('news')->where('slug', $article['baca_juga_slug'])->value('id');

            DB::table('news')->updateOrInsert(
                ['slug' => $article['slug']],
                [
                    'author_id'    => $authorId,
                    'category_id'  => $categoryId,
                    'baca_juga_id' => $bacaJugaId,
                    'title'        => $article['title'],
                    'slug'         => $article['slug'],
                    'excerpt'      => $article['excerpt'],
                    'content'      => $article['content'],
                    'thumbnail'    => $article['thumbnail'],
                    'published_at' => $article['published_at'],
                    'is_featured'  => $article['is_featured'],
                    'is_active'    => $article['is_active'],
                    'created_at'   => now(),
                    'updated_at'   => now(),
                ]
            );
        }

        // Update baca_juga_id setelah semua artikel tersimpan
        $slugIdMap = DB::table('news')->pluck('id', 'slug');
        foreach ($articles as $article) {
            $bacaJugaId = $slugIdMap[$article['baca_juga_slug']] ?? null;
            DB::table('news')
                ->where('slug', $article['slug'])
                ->update(['baca_juga_id' => $bacaJugaId]);
        }
    }
}
