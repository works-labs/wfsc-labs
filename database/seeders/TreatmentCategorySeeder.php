<?php

namespace Database\Seeders;

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
                'name'        => 'Skin Quality',
                'slug'        => 'skin-quality',
                'description' => 'Rangkaian perawatan estetika yang berfokus pada pembentukan kontur tubuh, membantu mengurangi lemak di area tertentu, serta mendukung tampilan tubuh yang lebih proporsional dan kencang.',
                'image'       => null,
                'sort_order'  => 1,
                'is_active'   => true,
            ],
            [
                'name'        => 'Anti Aging & Contouring',
                'slug'        => 'anti-aging-contouring',
                'description' => 'Anti Aging & Contouring merupakan kategori perawatan estetika yang mencakup berbagai treatment untuk membantu menyamarkan tanda-tanda penuaan, mengencangkan kulit, membentuk kontur wajah, serta memberikan tampilan yang lebih fresh dan proporsional. Pilihan treatment dalam kategori ini meliputi Botox, Premium Korean V-Shape, L-Shape Nose Lift, Korean Nose Lift, Volumizing Thread, Dermal Filler, Ultra HIFU for Face, dan Mesolipolysis for Face.',
                'image'       => null,
                'sort_order'  => 2,
                'is_active'   => true,
            ],
            [
                'name'        => 'Body & Hair Treatment',
                'slug'        => 'body-hair-treatment',
                'description' => 'Rangkaian perawatan estetika yang berfokus pada membantu menjaga kesehatan, kelembapan, tekstur, dan tampilan kulit agar terlihat lebih cerah, halus, fresh, dan terawat.',
                'image'       => null,
                'sort_order'  => 3,
                'is_active'   => true,
            ],
            [
                'name'        => 'Facial',
                'slug'        => 'facial',
                'description' => 'Rangkaian perawatan estetika yang berfokus pada membantu merawat kulit berjerawat, menyamarkan bekas jerawat, memperbaiki tekstur kulit, serta menjaga kulit agar terlihat lebih sehat, bersih, dan terawat.',
                'image'       => null,
                'sort_order'  => 4,
                'is_active'   => true,
            ],
        ];

        foreach ($categories as $category) {
            TreatmentCategory::updateOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }
    }
}
