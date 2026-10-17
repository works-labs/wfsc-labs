<?php

namespace Database\Seeders;

use App\Models\SkincareAttribute;
use App\Models\SkincareCategory;
use App\Models\SkincareProduct;
use Illuminate\Database\Seeder;

class SkincareSeeder extends Seeder
{
    public function run(): void
    {
        $categories = collect([
            ['name' => 'Skin Quality', 'slug' => 'skin-quality', 'sort_order' => 1],
            ['name' => 'Brightening', 'slug' => 'brightening', 'sort_order' => 2],
            ['name' => 'Acne Care', 'slug' => 'acne-care', 'sort_order' => 3],
            ['name' => 'Hydration', 'slug' => 'hydration', 'sort_order' => 4],
        ])->mapWithKeys(function (array $category) {
            return [
                $category['slug'] => SkincareCategory::updateOrCreate(
                    ['slug' => $category['slug']],
                    [
                        'name' => $category['name'],
                        'sort_order' => $category['sort_order'],
                        'is_active' => true,
                    ]
                ),
            ];
        });

        $attributes = collect([
            ['name' => 'Dermatologist Recommended', 'slug' => 'dermatologist-recommended'],
            ['name' => 'Daily Care', 'slug' => 'daily-care'],
            ['name' => 'Oil Control', 'slug' => 'oil-control'],
            ['name' => 'Sensitive Skin', 'slug' => 'sensitive-skin'],
            ['name' => 'Vitamin C', 'slug' => 'vitamin-c'],
        ])->mapWithKeys(function (array $attribute) {
            return [
                $attribute['slug'] => SkincareAttribute::updateOrCreate(
                    ['slug' => $attribute['slug']],
                    [
                        'name' => $attribute['name'],
                        'is_active' => true,
                    ]
                ),
            ];
        });

        $products = [
            [
                'name' => 'Gentle Foaming Cleanser',
                'slug' => 'gentle-foaming-cleanser',
                'description' => 'Pembersih wajah lembut untuk mengangkat kotoran dan minyak tanpa membuat kulit terasa kering.',
                'price' => 185000,
                'sort_order' => 1,
                'categories' => ['skin-quality', 'hydration'],
                'attributes' => ['daily-care', 'sensitive-skin'],
            ],
            [
                'name' => 'Hydra Balance Toner',
                'slug' => 'hydra-balance-toner',
                'description' => 'Toner ringan untuk membantu menjaga kelembapan dan mempersiapkan kulit sebelum skincare berikutnya.',
                'price' => 210000,
                'sort_order' => 2,
                'categories' => ['skin-quality', 'hydration'],
                'attributes' => ['daily-care', 'sensitive-skin'],
            ],
            [
                'name' => 'Bright C Serum',
                'slug' => 'bright-c-serum',
                'description' => 'Serum vitamin C untuk membantu membuat kulit tampak lebih cerah dan merata.',
                'price' => 325000,
                'sort_order' => 3,
                'categories' => ['skin-quality', 'brightening'],
                'attributes' => ['vitamin-c', 'dermatologist-recommended'],
            ],
            [
                'name' => 'Niacinamide Clear Serum',
                'slug' => 'niacinamide-clear-serum',
                'description' => 'Serum ringan dengan niacinamide untuk membantu mengontrol minyak dan merawat tampilan pori-pori.',
                'price' => 295000,
                'sort_order' => 4,
                'categories' => ['skin-quality', 'acne-care'],
                'attributes' => ['oil-control', 'daily-care'],
            ],
            [
                'name' => 'Calming Recovery Cream',
                'slug' => 'calming-recovery-cream',
                'description' => 'Krim pemulih dengan tekstur nyaman untuk membantu menenangkan kulit sensitif.',
                'price' => 280000,
                'sort_order' => 5,
                'categories' => ['skin-quality', 'hydration'],
                'attributes' => ['sensitive-skin', 'dermatologist-recommended'],
            ],
            [
                'name' => 'Clarifying Spot Gel',
                'slug' => 'clarifying-spot-gel',
                'description' => 'Gel perawatan lokal untuk membantu merawat area kulit yang rentan mengalami masalah.',
                'price' => 165000,
                'sort_order' => 6,
                'categories' => ['acne-care'],
                'attributes' => ['oil-control', 'dermatologist-recommended'],
            ],
            [
                'name' => 'Daily Shield Moisturizer',
                'slug' => 'daily-shield-moisturizer',
                'description' => 'Moisturizer harian yang membantu menjaga kulit tetap lembap dan terasa nyaman sepanjang hari.',
                'price' => 245000,
                'sort_order' => 7,
                'categories' => ['skin-quality', 'hydration'],
                'attributes' => ['daily-care', 'sensitive-skin'],
            ],
            [
                'name' => 'Radiance Night Cream',
                'slug' => 'radiance-night-cream',
                'description' => 'Krim malam untuk membantu merawat kulit agar tampak lebih segar dan bercahaya saat bangun.',
                'price' => 310000,
                'sort_order' => 8,
                'categories' => ['skin-quality', 'brightening'],
                'attributes' => ['vitamin-c', 'dermatologist-recommended'],
            ],
            [
                'name' => 'Daily Gentle Micellar Water',
                'slug' => 'daily-gentle-micellar-water',
                'description' => 'Micellar water ringan untuk membantu membersihkan sisa makeup dan kotoran sehari-hari.',
                'price' => 155000,
                'sort_order' => 9,
                'categories' => ['skin-quality', 'hydration'],
                'attributes' => ['daily-care', 'sensitive-skin'],
            ],
            [
                'name' => 'Enzyme Renewal Exfoliant',
                'slug' => 'enzyme-renewal-exfoliant',
                'description' => 'Eksfoliator lembut untuk membantu mengangkat sel kulit mati dan membuat tekstur kulit terasa lebih halus.',
                'price' => 275000,
                'sort_order' => 10,
                'categories' => ['skin-quality', 'brightening'],
                'attributes' => ['dermatologist-recommended', 'daily-care'],
            ],
            [
                'name' => 'Pore Reset Clay Mask',
                'slug' => 'pore-reset-clay-mask',
                'description' => 'Masker clay untuk membantu menyerap minyak berlebih dan membersihkan tampilan pori-pori.',
                'price' => 225000,
                'sort_order' => 11,
                'categories' => ['acne-care'],
                'attributes' => ['oil-control', 'dermatologist-recommended'],
            ],
            [
                'name' => 'Barrier Repair Essence',
                'slug' => 'barrier-repair-essence',
                'description' => 'Essence dengan tekstur ringan untuk membantu menjaga skin barrier dan kelembapan kulit.',
                'price' => 265000,
                'sort_order' => 12,
                'categories' => ['skin-quality', 'hydration'],
                'attributes' => ['sensitive-skin', 'daily-care'],
            ],
            [
                'name' => 'Acne Defense Facial Wash',
                'slug' => 'acne-defense-facial-wash',
                'description' => 'Sabun wajah untuk membantu membersihkan minyak dan kotoran pada kulit yang rentan berjerawat.',
                'price' => 195000,
                'sort_order' => 13,
                'categories' => ['acne-care'],
                'attributes' => ['oil-control', 'daily-care'],
            ],
            [
                'name' => 'Tone Correcting Moisturizer',
                'slug' => 'tone-correcting-moisturizer',
                'description' => 'Moisturizer harian untuk membantu menjaga kelembapan sekaligus merawat tampilan warna kulit.',
                'price' => 290000,
                'sort_order' => 14,
                'categories' => ['brightening', 'hydration'],
                'attributes' => ['daily-care', 'vitamin-c'],
            ],
            [
                'name' => 'Soothing Centella Ampoule',
                'slug' => 'soothing-centella-ampoule',
                'description' => 'Ampoule yang membantu menenangkan kulit dan memberikan rasa nyaman pada kulit sensitif.',
                'price' => 305000,
                'sort_order' => 15,
                'categories' => ['skin-quality', 'hydration'],
                'attributes' => ['sensitive-skin', 'dermatologist-recommended'],
            ],
            [
                'name' => 'Oil Control Gel Moisturizer',
                'slug' => 'oil-control-gel-moisturizer',
                'description' => 'Gel moisturizer bertekstur ringan untuk membantu menjaga kelembapan tanpa rasa berat atau berminyak.',
                'price' => 235000,
                'sort_order' => 16,
                'categories' => ['acne-care', 'hydration'],
                'attributes' => ['oil-control', 'daily-care'],
            ],
            [
                'name' => 'Peptide Firming Concentrate',
                'slug' => 'peptide-firming-concentrate',
                'description' => 'Konsentrat peptide untuk membantu merawat elastisitas dan tampilan kulit yang lebih kencang.',
                'price' => 385000,
                'sort_order' => 17,
                'categories' => ['skin-quality'],
                'attributes' => ['dermatologist-recommended', 'daily-care'],
            ],
            [
                'name' => 'Overnight Hydration Mask',
                'slug' => 'overnight-hydration-mask',
                'description' => 'Masker malam dengan tekstur lembut untuk membantu menjaga kulit tetap lembap hingga pagi hari.',
                'price' => 255000,
                'sort_order' => 18,
                'categories' => ['hydration', 'skin-quality'],
                'attributes' => ['sensitive-skin', 'daily-care'],
            ],
        ];

        foreach ($products as $data) {
            $categorySlugs = $data['categories'];
            $attributeSlugs = $data['attributes'];
            unset($data['categories'], $data['attributes']);

            $product = SkincareProduct::firstOrNew(['slug' => $data['slug']]);
            $product->fill(array_merge($data, ['is_active' => true]));
            $product->save();

            $product->categories()->sync(
                collect($categorySlugs)->map(fn (string $slug) => $categories[$slug]->id)->all()
            );
            $product->attributes()->sync(
                collect($attributeSlugs)->map(fn (string $slug) => $attributes[$slug]->id)->all()
            );
        }
    }
}
