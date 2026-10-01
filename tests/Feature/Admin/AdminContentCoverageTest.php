<?php

use App\Models\Banner;
use App\Models\Promo;
use App\Models\SkincareAttribute;
use App\Models\SkincareCategory;
use App\Models\SkincareProduct;
use App\Models\Treatment;
use App\Models\TreatmentBeforeAfter;
use App\Models\TreatmentVideo;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

beforeEach(function () {
    $this->seed(Database\Seeders\DatabaseSeeder::class);
    $this->actingAs(User::factory()->create());
    Storage::fake('public');
});

function tinyPngUpload(string $name): UploadedFile
{
    $png = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNk+A8AAQUBAScY42YAAAAASUVORK5CYII=');

    return UploadedFile::fake()->createWithContent($name, $png);
}

test('promo create validates dates and stores an uploaded image', function () {
    Livewire::test('admin.home.promos.create')
        ->set('title', 'Promo Test')
        ->set('description', 'Deskripsi promo')
        ->set('image', tinyPngUpload('promo.png'))
        ->set('start_date', '2026-10-01')
        ->set('end_date', '2026-10-31')
        ->set('cta_type', 'external')
        ->set('cta_target', 'https://example.com')
        ->call('save')
        ->assertHasNoErrors();

    $promo = Promo::where('slug', 'promo-test')->firstOrFail();
    expect($promo->image)->not->toBeNull();
    Storage::disk('public')->assertExists($promo->image);
});

test('banner create requires a valid image and stores it', function () {
    Livewire::test('admin.banners.create')
        ->set('title', 'Banner Test')
        ->set('placement', 'treatments')
        ->set('image', tinyPngUpload('banner.png'))
        ->call('save')
        ->assertHasNoErrors();

    $banner = Banner::where('title', 'Banner Test')->firstOrFail();
    Storage::disk('public')->assertExists($banner->image);
});

test('skincare product creates and syncs category and attribute pivots', function () {
    $category = SkincareCategory::create([
        'name' => 'Category Test',
        'slug' => 'category-test',
        'is_active' => true,
    ]);
    $attribute = SkincareAttribute::create([
        'name' => 'Attribute Test',
        'slug' => 'attribute-test',
        'is_active' => true,
    ]);

    Livewire::test('admin.skincare.products.create')
        ->set('name', 'Product Test')
        ->set('category_ids', [$category->id])
        ->set('attribute_ids', [$attribute->id])
        ->set('price', 125000)
        ->set('shopee_url', 'https://shopee.co.id/product-test')
        ->call('save')
        ->assertHasNoErrors();

    $product = SkincareProduct::where('slug', 'product-test')->firstOrFail();
    expect($product->categories->pluck('id')->all())->toContain($category->id);
    expect($product->attributes->pluck('id')->all())->toContain($attribute->id);
});

test('skincare product rejects invalid related ids and URL', function () {
    Livewire::test('admin.skincare.products.create')
        ->set('name', 'Invalid Product')
        ->set('category_ids', [999999])
        ->set('attribute_ids', [999999])
        ->set('shopee_url', 'javascript:alert(1)')
        ->call('save')
        ->assertHasErrors(['category_ids.0', 'attribute_ids.0', 'shopee_url']);
});

test('before-after create stores both media files and detects image types', function () {
    $treatment = Treatment::firstOrFail();

    Livewire::test('admin.treatments.before-afters.create', ['treatment' => $treatment])
        ->set('before_media', tinyPngUpload('before.png'))
        ->set('after_media', tinyPngUpload('after.png'))
        ->set('caption', 'Before after test')
        ->call('save')
        ->assertHasNoErrors();

    $comparison = TreatmentBeforeAfter::where('treatment_id', $treatment->id)->latest()->firstOrFail();
    expect($comparison->before_media_type)->toBe('image');
    expect($comparison->after_media_type)->toBe('image');
    Storage::disk('public')->assertExists($comparison->before_media);
    Storage::disk('public')->assertExists($comparison->after_media);
});

test('procedure video create stores a YouTube Shorts input', function () {
    $treatment = Treatment::firstOrFail();

    Livewire::test('admin.treatments.videos.create', ['treatment' => $treatment])
        ->set('title', 'Video Test')
        ->set('video_path', 'https://www.youtube.com/shorts/abcdefghijk')
        ->set('description', 'Video procedure test')
        ->call('save')
        ->assertHasNoErrors();

    expect(TreatmentVideo::where('treatment_id', $treatment->id)
        ->where('video_path', 'https://www.youtube.com/shorts/abcdefghijk')
        ->exists())->toBeTrue();
});

test('admin content can be edited and deleted without leaving the record', function () {
    $promo = Promo::create([
        'title' => 'Before Edit',
        'slug' => 'before-edit',
        'cta_type' => 'internal',
        'is_active' => true,
    ]);

    $promo->update(['title' => 'After Edit']);
    expect($promo->fresh()->title)->toBe('After Edit');

    $id = $promo->id;
    $promo->delete();
    expect(Promo::find($id))->toBeNull();
});

test('banner index deletes its record and stored image', function () {
    $path = 'banners/delete-test.png';
    Storage::disk('public')->put($path, 'fake');
    $banner = Banner::create([
        'title' => 'Delete Banner',
        'image' => $path,
        'placement' => 'treatments',
        'is_active' => true,
    ]);

    Livewire::test('admin.banners.index')
        ->call('delete', $banner)
        ->assertHasNoErrors();

    expect(Banner::find($banner->id))->toBeNull();
    Storage::disk('public')->assertMissing($path);
});

test('promo index deletes its record and stored image', function () {
    $path = 'promos/delete-test.png';
    Storage::disk('public')->put($path, 'fake');
    $promo = Promo::create([
        'title' => 'Delete Promo',
        'slug' => 'delete-promo',
        'image' => $path,
        'cta_type' => 'internal',
        'is_active' => true,
    ]);

    Livewire::test('admin.home.promos.index')
        ->call('delete', $promo->id)
        ->assertHasNoErrors();

    expect(Promo::find($promo->id))->toBeNull();
    Storage::disk('public')->assertMissing($path);
});

test('skincare product index deletes its record and stored image', function () {
    $path = 'skincare/products/delete-test.png';
    Storage::disk('public')->put($path, 'fake');
    $product = SkincareProduct::create([
        'name' => 'Delete Product',
        'slug' => 'delete-product',
        'image' => $path,
        'is_active' => true,
    ]);

    Livewire::test('admin.skincare.products.index')
        ->call('delete', $product->id)
        ->assertHasNoErrors();

    expect(SkincareProduct::find($product->id))->toBeNull();
    Storage::disk('public')->assertMissing($path);
});

test('before-after index deletes its media files and record', function () {
    $treatment = Treatment::firstOrFail();
    $before = 'treatments/before-after/delete-before.png';
    $after = 'treatments/before-after/delete-after.png';
    Storage::disk('public')->put($before, 'fake');
    Storage::disk('public')->put($after, 'fake');
    $comparison = TreatmentBeforeAfter::create([
        'treatment_id' => $treatment->id,
        'before_media' => $before,
        'before_media_type' => 'image',
        'after_media' => $after,
        'after_media_type' => 'image',
        'is_active' => true,
    ]);

    Livewire::test('admin.treatments.before-afters.index', ['treatment' => $treatment])
        ->call('delete', $comparison->id)
        ->assertHasNoErrors();

    expect(TreatmentBeforeAfter::find($comparison->id))->toBeNull();
    Storage::disk('public')->assertMissing($before);
    Storage::disk('public')->assertMissing($after);
});

test('procedure video index deletes its record', function () {
    $treatment = Treatment::firstOrFail();
    $video = TreatmentVideo::create([
        'treatment_id' => $treatment->id,
        'title' => 'Delete Video',
        'video_path' => 'abcdefghijk',
        'is_active' => true,
    ]);

    Livewire::test('admin.treatments.videos.index', ['treatment' => $treatment])
        ->call('delete', $video)
        ->assertHasNoErrors();

    expect(TreatmentVideo::find($video->id))->toBeNull();
});
