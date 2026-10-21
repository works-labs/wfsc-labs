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
        $publishedAtNow = now('Asia/Jakarta')->format('Y-m-d H:i:s');

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
            [
                'category_slug'  => 'tips-and-trick',
                'title'          => 'Rutinitas Skincare Pagi untuk Kulit yang Lebih Sehat',
                'slug'           => 'rutinitas-skincare-pagi-untuk-kulit-yang-lebih-sehat',
                'excerpt'        => 'Rutinitas skincare pagi yang sederhana dan konsisten dapat membantu menjaga kulit tetap bersih, lembap, dan terlindungi.',
                'content'        => '<p>Rutinitas skincare pagi tidak harus panjang untuk memberikan manfaat bagi kulit. Mulailah dengan membersihkan wajah menggunakan pembersih yang sesuai dengan kondisi kulit, kemudian lanjutkan dengan pelembap agar skin barrier tetap terjaga.</p><p>Gunakan sunscreen dengan perlindungan yang cukup sebagai langkah terakhir. Pemakaian sunscreen secara rutin membantu melindungi kulit dari paparan sinar ultraviolet yang dapat mempercepat munculnya tanda-tanda penuaan.</p><p>Kenali kebutuhan kulit masing-masing dan konsultasikan dengan tenaga medis profesional apabila mengalami masalah kulit yang menetap.</p>',
                'thumbnail'      => null,
                'published_at'   => $publishedAtNow,
                'is_featured'    => false,
                'is_active'      => true,
                'baca_juga_slug' => 'tren-perawatan-anti-aging-cara-menjaga-kulit-tetap-kencang-dan-fresh',
            ],
            [
                'category_slug'  => 'artikel',
                'title'          => 'Pentingnya Konsultasi Sebelum Memilih Treatment Estetika',
                'slug'           => 'pentingnya-konsultasi-sebelum-memilih-treatment-estetika',
                'excerpt'        => 'Konsultasi membantu menentukan treatment estetika yang sesuai dengan kondisi kulit, kebutuhan, dan tujuan perawatan setiap individu.',
                'content'        => '<p>Setiap orang memiliki kondisi kulit, struktur wajah, dan kebutuhan perawatan yang berbeda. Karena itu, konsultasi menjadi langkah penting sebelum memilih treatment estetika.</p><p>Dalam sesi konsultasi, tenaga medis dapat mengevaluasi kondisi kulit, menjelaskan pilihan treatment, serta menyampaikan manfaat, risiko, dan perawatan setelah tindakan. Informasi tersebut membantu pasien membuat keputusan yang lebih tepat dan realistis.</p><p>Pastikan treatment dilakukan di fasilitas kesehatan terpercaya oleh tenaga medis yang kompeten agar proses perawatan berlangsung dengan aman.</p>',
                'thumbnail'      => null,
                'published_at'   => $publishedAtNow,
                'is_featured'    => false,
                'is_active'      => true,
                'baca_juga_slug' => 'mengenal-facial-contouring-untuk-wajah-yang-lebih-proporsional',
            ],
            [
                'category_slug'  => 'tips-and-trick',
                'title'          => '5 Kebiasaan Sederhana untuk Menjaga Kesehatan Kulit',
                'slug'           => '5-kebiasaan-sederhana-untuk-menjaga-kesehatan-kulit',
                'excerpt'        => 'Kebiasaan sehari-hari yang konsisten dapat membantu menjaga kulit tetap sehat dan tampak segar.',
                'content'        => '<p>Menjaga kesehatan kulit dapat dimulai dari kebiasaan sederhana, seperti membersihkan wajah secara rutin, menggunakan sunscreen, dan mencukupi kebutuhan cairan tubuh.</p><p>Istirahat yang cukup, mengonsumsi makanan bergizi, serta menghindari kebiasaan menyentuh wajah dengan tangan kotor juga membantu menjaga kondisi kulit.</p>',
                'thumbnail'      => null,
                'published_at'   => $publishedAtNow,
                'is_featured'    => false,
                'is_active'      => true,
                'baca_juga_slug' => 'rutinitas-skincare-pagi-untuk-kulit-yang-lebih-sehat',
            ],
            [
                'category_slug'  => 'pengetahuan',
                'title'          => 'Mengenal Skin Quality dan Cara Merawatnya',
                'slug'           => 'mengenal-skin-quality-dan-cara-merawatnya',
                'excerpt'        => 'Skin quality mencakup kelembapan, tekstur, warna, dan kekenyalan kulit yang perlu dirawat secara menyeluruh.',
                'content'        => '<p>Skin quality menggambarkan kondisi kulit secara menyeluruh, termasuk tingkat kelembapan, tekstur, warna, dan kekenyalannya.</p><p>Perawatan yang tepat perlu disesuaikan dengan kondisi setiap orang. Konsultasi dapat membantu menentukan kombinasi skincare dan treatment yang sesuai untuk menjaga kulit tetap sehat.</p>',
                'thumbnail'      => null,
                'published_at'   => $publishedAtNow,
                'is_featured'    => false,
                'is_active'      => true,
                'baca_juga_slug' => 'pentingnya-konsultasi-sebelum-memilih-treatment-estetika',
            ],
            [
                'category_slug'  => 'tips-and-trick',
                'title'          => 'Mengapa Sunscreen Penting Dipakai Setiap Hari?',
                'slug'           => 'mengapa-sunscreen-penting-dipakai-setiap-hari',
                'excerpt'        => 'Sunscreen membantu melindungi kulit dari paparan sinar ultraviolet yang dapat memengaruhi kesehatan dan penampilan kulit.',
                'content'        => '<p>Paparan sinar ultraviolet dapat terjadi setiap hari, termasuk ketika beraktivitas di dalam ruangan dekat jendela. Karena itu, sunscreen sebaiknya menjadi bagian dari rutinitas pagi.</p><p>Pilih sunscreen sesuai kebutuhan kulit dan gunakan kembali sesuai aktivitas, terutama ketika banyak berada di luar ruangan.</p>',
                'thumbnail'      => null,
                'published_at'   => $publishedAtNow,
                'is_featured'    => false,
                'is_active'      => true,
                'baca_juga_slug' => 'rutinitas-skincare-pagi-untuk-kulit-yang-lebih-sehat',
            ],
            [
                'category_slug'  => 'pengetahuan',
                'title'          => 'Perbedaan Botox dan Dermal Filler',
                'slug'           => 'perbedaan-botox-dan-dermal-filler',
                'excerpt'        => 'Botox dan dermal filler memiliki fungsi serta cara kerja yang berbeda dalam perawatan estetika.',
                'content'        => '<p>Botox bekerja dengan membantu merelaksasi otot tertentu sehingga tampilan garis ekspresi dapat terlihat lebih halus. Dermal filler digunakan untuk menambah volume atau membantu membentuk area wajah tertentu.</p><p>Keduanya memiliki indikasi dan pertimbangan yang berbeda. Konsultasikan kebutuhan perawatan kepada tenaga medis sebelum menentukan pilihan.</p>',
                'thumbnail'      => null,
                'published_at'   => $publishedAtNow,
                'is_featured'    => false,
                'is_active'      => true,
                'baca_juga_slug' => 'pentingnya-konsultasi-sebelum-memilih-treatment-estetika',
            ],
            [
                'category_slug'  => 'tips-and-trick',
                'title'          => 'Tips Merawat Kulit Sensitif agar Tetap Nyaman',
                'slug'           => 'tips-merawat-kulit-sensitif-agar-tetap-nyaman',
                'excerpt'        => 'Kulit sensitif membutuhkan rutinitas yang lembut dan pemilihan produk yang sesuai agar tetap nyaman.',
                'content'        => '<p>Kulit sensitif dapat lebih mudah mengalami kemerahan, rasa perih, atau kering. Gunakan produk dengan formula lembut dan hindari terlalu sering mengganti produk dalam waktu singkat.</p><p>Jika keluhan berulang atau semakin berat, pemeriksaan oleh tenaga medis dapat membantu menemukan penyebab dan perawatan yang tepat.</p>',
                'thumbnail'      => null,
                'published_at'   => $publishedAtNow,
                'is_featured'    => false,
                'is_active'      => true,
                'baca_juga_slug' => 'mengenal-skin-quality-dan-cara-merawatnya',
            ],
            [
                'category_slug'  => 'produk-rilis',
                'title'          => 'Hydrafacial untuk Kulit yang Lebih Bersih dan Lembap',
                'slug'           => 'hydrafacial-untuk-kulit-yang-lebih-bersih-dan-lembap',
                'excerpt'        => 'Hydrafacial merupakan salah satu pilihan perawatan untuk membantu membersihkan dan menjaga kelembapan kulit.',
                'content'        => '<p>Hydrafacial menggabungkan beberapa tahapan perawatan, seperti pembersihan, eksfoliasi, dan pemberian hidrasi. Perawatan ini dapat membantu kulit terasa lebih bersih dan tampak lebih segar.</p><p>Kebutuhan kulit setiap orang berbeda, sehingga konsultasi tetap diperlukan sebelum menjalani treatment.</p>',
                'thumbnail'      => null,
                'published_at'   => $publishedAtNow,
                'is_featured'    => false,
                'is_active'      => true,
                'baca_juga_slug' => 'mengenal-skin-quality-dan-cara-merawatnya',
            ],
            [
                'category_slug'  => 'pengetahuan',
                'title'          => 'Mengenal Thread Lift untuk Membantu Mengencangkan Kulit',
                'slug'           => 'mengenal-thread-lift-untuk-membantu-mengencangkan-kulit',
                'excerpt'        => 'Thread lift dapat menjadi pilihan perawatan non-bedah untuk membantu mengencangkan dan mempertegas kontur wajah.',
                'content'        => '<p>Thread lift menggunakan benang khusus yang ditempatkan pada area tertentu untuk membantu memberikan efek lifting dan mendukung pembentukan kontur wajah.</p><p>Jenis benang, teknik, dan hasil yang diharapkan perlu dibahas melalui konsultasi agar sesuai dengan kondisi serta kebutuhan pasien.</p>',
                'thumbnail'      => null,
                'published_at'   => $publishedAtNow,
                'is_featured'    => false,
                'is_active'      => true,
                'baca_juga_slug' => 'mengenal-facial-contouring-untuk-wajah-yang-lebih-proporsional',
            ],
            [
                'category_slug'  => 'tips-and-trick',
                'title'          => 'Persiapan Sebelum Menjalani Treatment Estetika',
                'slug'           => 'persiapan-sebelum-menjalani-treatment-estetika',
                'excerpt'        => 'Persiapan yang tepat membantu proses treatment berjalan lebih nyaman dan sesuai dengan anjuran tenaga medis.',
                'content'        => '<p>Sebelum treatment, sampaikan riwayat kesehatan, alergi, obat yang sedang dikonsumsi, dan perawatan yang pernah dilakukan kepada tenaga medis.</p><p>Ikuti seluruh instruksi persiapan yang diberikan dan hindari mencoba produk atau tindakan baru tanpa arahan profesional.</p>',
                'thumbnail'      => null,
                'published_at'   => $publishedAtNow,
                'is_featured'    => false,
                'is_active'      => true,
                'baca_juga_slug' => 'pentingnya-konsultasi-sebelum-memilih-treatment-estetika',
            ],
            [
                'category_slug'  => 'artikel',
                'title'          => 'Panduan Perawatan Setelah Treatment Wajah',
                'slug'           => 'panduan-perawatan-setelah-treatment-wajah',
                'excerpt'        => 'Perawatan setelah tindakan menjadi bagian penting untuk membantu menjaga hasil dan kenyamanan kulit.',
                'content'        => '<p>Setelah treatment wajah, ikuti instruksi yang diberikan oleh tenaga medis. Hindari menyentuh area tindakan terlalu sering dan gunakan produk yang direkomendasikan.</p><p>Perlindungan dari sinar matahari serta menjaga kebersihan kulit juga penting selama masa pemulihan.</p>',
                'thumbnail'      => null,
                'published_at'   => $publishedAtNow,
                'is_featured'    => false,
                'is_active'      => true,
                'baca_juga_slug' => 'persiapan-sebelum-menjalani-treatment-estetika',
            ],
            [
                'category_slug'  => 'pengetahuan',
                'title'          => 'Mengenal Skin Barrier dan Fungsinya',
                'slug'           => 'mengenal-skin-barrier-dan-fungsinya',
                'excerpt'        => 'Skin barrier membantu melindungi kulit dan menjaga keseimbangan kelembapan pada permukaan kulit.',
                'content'        => '<p>Skin barrier adalah lapisan pelindung kulit yang membantu mempertahankan kelembapan serta melindungi kulit dari berbagai faktor lingkungan.</p><p>Pembersihan yang terlalu keras dan penggunaan terlalu banyak bahan aktif dapat mengganggu skin barrier. Rutinitas yang sederhana dan konsisten membantu menjaganya tetap sehat.</p>',
                'thumbnail'      => null,
                'published_at'   => $publishedAtNow,
                'is_featured'    => false,
                'is_active'      => true,
                'baca_juga_slug' => 'mengenal-skin-quality-dan-cara-merawatnya',
            ],
            [
                'category_slug'  => 'artikel',
                'title'          => 'Pilihan Perawatan untuk Membantu Menyamarkan Bekas Jerawat',
                'slug'           => 'pilihan-perawatan-untuk-membantu-menyamarkan-bekas-jerawat',
                'excerpt'        => 'Bekas jerawat membutuhkan pendekatan yang disesuaikan dengan jenis dan kondisi kulit masing-masing.',
                'content'        => '<p>Bekas jerawat dapat berupa perubahan warna maupun tekstur kulit. Karena jenisnya berbeda, pilihan perawatan juga perlu ditentukan berdasarkan evaluasi kondisi kulit.</p><p>Jangan memencet jerawat dan gunakan perlindungan sunscreen secara rutin. Konsultasi membantu menentukan perawatan yang aman dan realistis.</p>',
                'thumbnail'      => null,
                'published_at'   => $publishedAtNow,
                'is_featured'    => false,
                'is_active'      => true,
                'baca_juga_slug' => 'pentingnya-konsultasi-sebelum-memilih-treatment-estetika',
            ],
            [
                'category_slug'  => 'artikel',
                'title'          => 'Perawatan Rambut untuk Menunjang Penampilan',
                'slug'           => 'perawatan-rambut-untuk-menunjang-penampilan',
                'excerpt'        => 'Kesehatan rambut dan kulit kepala juga menjadi bagian penting dari penampilan yang terawat.',
                'content'        => '<p>Rambut yang sehat dimulai dari kulit kepala yang terawat. Pilih produk yang sesuai, jaga kebersihan kulit kepala, dan perhatikan perubahan yang muncul.</p><p>Jika mengalami kerontokan atau masalah kulit kepala yang menetap, konsultasikan kondisinya kepada tenaga profesional.</p>',
                'thumbnail'      => null,
                'published_at'   => $publishedAtNow,
                'is_featured'    => false,
                'is_active'      => true,
                'baca_juga_slug' => 'pentingnya-konsultasi-sebelum-memilih-treatment-estetika',
            ],
            [
                'category_slug'  => 'pengetahuan',
                'title'          => 'Mengenal Perawatan Body Contouring',
                'slug'           => 'mengenal-perawatan-body-contouring',
                'excerpt'        => 'Body contouring membantu membentuk tampilan tubuh sesuai kebutuhan melalui pendekatan perawatan yang terarah.',
                'content'        => '<p>Body contouring merupakan pendekatan perawatan yang berfokus pada pembentukan kontur tubuh. Jenis treatment dan target area disesuaikan dengan kondisi setiap individu.</p><p>Konsultasi diperlukan untuk memahami tujuan perawatan, pilihan yang tersedia, serta ekspektasi hasil yang realistis.</p>',
                'thumbnail'      => null,
                'published_at'   => $publishedAtNow,
                'is_featured'    => false,
                'is_active'      => true,
                'baca_juga_slug' => 'pentingnya-konsultasi-sebelum-memilih-treatment-estetika',
            ],
            [
                'category_slug'  => 'tips-and-trick',
                'title'          => 'Hubungan Hidrasi dengan Tampilan Kulit',
                'slug'           => 'hubungan-hidrasi-dengan-tampilan-kulit',
                'excerpt'        => 'Hidrasi yang cukup membantu mendukung kondisi tubuh dan menjaga kulit tampak lebih segar.',
                'content'        => '<p>Asupan cairan yang cukup membantu mendukung fungsi tubuh secara keseluruhan, termasuk menjaga keseimbangan cairan yang dibutuhkan kulit.</p><p>Selain minum air yang cukup, gunakan pelembap sesuai kondisi kulit dan jaga rutinitas perawatan secara konsisten.</p>',
                'thumbnail'      => null,
                'published_at'   => $publishedAtNow,
                'is_featured'    => false,
                'is_active'      => true,
                'baca_juga_slug' => 'mengenal-skin-quality-dan-cara-merawatnya',
            ],
            [
                'category_slug'  => 'artikel',
                'title'          => 'Cara Memilih Klinik Estetika yang Terpercaya',
                'slug'           => 'cara-memilih-klinik-estetika-yang-terpercaya',
                'excerpt'        => 'Memilih klinik estetika yang tepat penting untuk memastikan perawatan dilakukan dengan aman dan profesional.',
                'content'        => '<p>Pastikan klinik memiliki tenaga medis yang kompeten, fasilitas yang sesuai, serta memberikan penjelasan yang transparan mengenai treatment.</p><p>Jangan ragu untuk bertanya tentang manfaat, risiko, proses tindakan, dan perawatan setelah treatment sebelum mengambil keputusan.</p>',
                'thumbnail'      => null,
                'published_at'   => $publishedAtNow,
                'is_featured'    => false,
                'is_active'      => true,
                'baca_juga_slug' => 'pentingnya-konsultasi-sebelum-memilih-treatment-estetika',
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
