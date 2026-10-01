<?php

use App\Models\NewsCategory;
use App\Models\TreatmentCategory;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;

test('all named admin routes require authentication', function () {
    $adminRoutes = collect(Route::getRoutes()->getRoutes())
        ->filter(fn ($route) => str_starts_with((string) $route->getName(), 'admin.'))
        ->filter(fn ($route) => in_array('GET', $route->methods(), true));

    expect($adminRoutes)->not->toBeEmpty();

    foreach ($adminRoutes as $route) {
        $uri = preg_replace('/\{[^}]+\??\}/', '1', $route->uri());
        $response = $this->get('/'.ltrim($uri, '/'));

        expect($response->status())
            ->toBeIn([302, 303], "Route {$route->getName()} is not protected");
    }
});

test('authenticated user can open the admin dashboard', function () {
    $this->actingAs(User::factory()->create());

    $this->get(route('admin.dashboard'))->assertOk();
});

test('doctor create rejects missing required name', function () {
    $this->actingAs(User::factory()->create());

    Livewire::test('admin.doctors.create')
        ->call('save')
        ->assertHasErrors(['name']);
});

test('treatment create rejects missing name and category', function () {
    $this->actingAs(User::factory()->create());

    Livewire::test('admin.treatments.create')
        ->call('save')
        ->assertHasErrors(['name', 'category_id']);
});

test('news create rejects missing title and content', function () {
    $this->actingAs(User::factory()->create());

    Livewire::test('admin.news.create')
        ->call('save')
        ->assertHasErrors(['title', 'content']);
});

test('doctor create stores a valid doctor', function () {
    $this->actingAs(User::factory()->create());

    Livewire::test('admin.doctors.create')
        ->set('name', 'Dokter Test')
        ->call('save')
        ->assertHasNoErrors()
        ->assertRedirect(route('admin.doctors.index'));

    $this->assertDatabaseHas('doctors', [
        'name' => 'Dokter Test',
        'slug' => 'dokter-test',
    ]);
});

test('treatment create stores a valid treatment with category', function () {
    $this->actingAs(User::factory()->create());
    $category = TreatmentCategory::create([
        'name' => 'Kategori Test',
        'slug' => 'kategori-test',
        'is_active' => true,
    ]);

    Livewire::test('admin.treatments.create')
        ->set('name', 'Treatment Test')
        ->set('category_id', $category->id)
        ->call('save')
        ->assertHasNoErrors()
        ->assertRedirect(route('admin.treatments.index'));

    $this->assertDatabaseHas('treatments', [
        'name' => 'Treatment Test',
        'category_id' => $category->id,
    ]);
});

test('news create stores valid news owned by authenticated user', function () {
    $user = User::factory()->create();
    $this->actingAs($user);
    $category = NewsCategory::create([
        'name' => 'Kategori Berita Test',
        'slug' => 'kategori-berita-test',
        'is_active' => true,
    ]);

    Livewire::test('admin.news.create')
        ->set('title', 'Berita Test')
        ->set('content', '<p>Konten test</p>')
        ->set('category_id', $category->id)
        ->call('save')
        ->assertHasNoErrors()
        ->assertRedirect(route('admin.news.index'));

    $this->assertDatabaseHas('news', [
        'title' => 'Berita Test',
        'author_id' => $user->id,
        'category_id' => $category->id,
    ]);
});
