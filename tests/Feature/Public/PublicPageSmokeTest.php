<?php

use App\Models\Doctor;
use App\Models\News;
use App\Models\Treatment;
use Database\Seeders\DatabaseSeeder;

beforeEach(function () {
    $this->seed(DatabaseSeeder::class);
});

test('all public listing pages render successfully', function () {
    foreach ([
        'home',
        'treatments.index',
        'news.index',
        'before-after.index',
        'promos.index',
        'skincare.index',
        'contact-us.index',
    ] as $routeName) {
        $this->get(route($routeName))->assertSuccessful();
    }
});

test('public detail pages render seeded records', function () {
    $this->get(route('doctor.show', Doctor::query()->firstOrFail()))->assertSuccessful();
    $this->get(route('treatment.show', Treatment::query()->firstOrFail()))->assertSuccessful();
    $this->get(route('news.show', News::query()->firstOrFail()))->assertSuccessful();
});

test('unknown public slugs return not found instead of server error', function () {
    $this->get('/doctors/does-not-exist')->assertNotFound();
    $this->get('/treatments/does-not-exist')->assertNotFound();
    $this->get('/news/does-not-exist')->assertNotFound();
    $this->get('/skincare/does-not-exist')->assertNotFound();
});
