<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PublicDoctorController;
//Route::view('/', 'welcome')->name('home');
// Route::view('/', 'public.home')->name('home');

Route::middleware('auth')->group(function () {
    
    // doctor routes 
    Route::livewire('/admin', 'admin.dashboard')
    ->name('admin.dashboard');

    Route::livewire('/admin/doctors', 'admin.doctors.index')
        ->name('admin.doctors.index');

    Route::livewire('/admin/doctors/create', 'admin.doctors.create')
        ->name('admin.doctors.create');

    Route::livewire('/admin/doctors/{doctor}/edit', 'admin.doctors.edit')
        ->name('admin.doctors.edit');
    // end of doctor routes :3
    // treatement category routes
    Route::livewire('/admin/treatment-categories', 'admin.treatment-categories.index')
        ->name('admin.treatment-categories.index');

    Route::livewire('/admin/treatment-categories/create', 'admin.treatment-categories.create')
        ->name('admin.treatment-categories.create');

    Route::livewire('/admin/treatment-categories/{category}/edit', 'admin.treatment-categories.edit')
        ->name('admin.treatment-categories.edit');
    // end of treateent caaategry routes :3
    // treatement routes
    Route::livewire('/admin/treatments', 'admin.treatments.index')
        ->name('admin.treatments.index');

    Route::livewire('/admin/treatments/create', 'admin.treatments.create')
        ->name('admin.treatments.create');

    Route::livewire('/admin/treatments/{treatment}/edit', 'admin.treatments.edit')
        ->name('admin.treatments.edit');
    // end of treateent routes :3
    // treatement product routes
    Route::livewire('/admin/treatments/{treatment}/products', 'admin.treatments.products.index')
        ->name('admin.treatments.products.index');

    Route::livewire('/admin/treatments/{treatment}/products/create', 'admin.treatments.products.create')
        ->name('admin.treatments.products.create');

    Route::livewire('/admin/treatments/{treatment}/products/{product}/edit', 'admin.treatments.products.edit')
        ->name('admin.treatments.products.edit');
    // end of treateent prodduct routes :3
    // news routes 
    Route::livewire('/admin/news', 'admin.news.index')
        ->name('admin.news.index');

    Route::livewire('/admin/news/create', 'admin.news.create')
        ->name('admin.news.create');

    Route::livewire('/admin/news/{news}/edit', 'admin.news.edit')
        ->name('admin.news.edit');
    // end of news rutes >//<
    // routes facilities >//<
    Route::livewire('/admin/facilities', 'admin.facilities.index')
    ->name('admin.facilities.index');

    Route::livewire('/admin/facilities/create', 'admin.facilities.create')
        ->name('admin.facilities.create');

    Route::livewire('/admin/facilities/{facility}/edit', 'admin.facilities.edit')
        ->name('admin.facilities.edit');
        // end of faccilities routes >//<

        // ui home banners route
        Route::livewire('/admin/home/hero-banners', 'admin.home.hero-banners.index')
    ->name('admin.home.hero-banners.index');

    Route::livewire('/admin/home/hero-banners/create', 'admin.home.hero-banners.create')
        ->name('admin.home.hero-banners.create');

    Route::livewire('/admin/home/hero-banners/{heroBanner}/edit', 'admin.home.hero-banners.edit')
        ->name('admin.home.hero-banners.edit');
        // end of routes banner

         //route staistics
    Route::livewire('/admin/home/site-statistics', 'admin.home.site-statistics.index')
        ->name('admin.home.site-statistics.index');

    Route::livewire('/admin/home/site-statistics/create', 'admin.home.site-statistics.create')
    ->name('admin.home.site-statistics.create');

    Route::livewire('/admin/home/site-statistics/{statistic}/edit', 'admin.home.site-statistics.edit')
    ->name('admin.home.site-statistics.edit');
    // end of route statsiticcs :3

    // route why choose
    Route::livewire('/admin/home/why-choose-items', 'admin.home.why-choose-items.index')
    ->name('admin.home.why-choose-items.index');

    Route::livewire('/admin/home/why-choose-items/create', 'admin.home.why-choose-items.create')
    ->name('admin.home.why-choose-items.create');

    Route::livewire('/admin/home/why-choose-items/{item}/edit', 'admin.home.why-choose-items.edit')
    ->name('admin.home.why-choose-items.edit');
    //end of why coose

    // route prommos
    Route::livewire('/admin/home/promos', 'admin.home.promos.index')
    ->name('admin.home.promos.index');

    Route::livewire('/admin/home/promos/create', 'admin.home.promos.create')
    ->name('admin.home.promos.create');

    Route::livewire('/admin/home/promos/{promo}/edit', 'admin.home.promos.edit')
    ->name('admin.home.promos.edit');
    //end of route prmos

    //route doctor home setions
    Route::livewire('/admin/home/doctor-home-sections', 'admin.home.doctor-home-sections.index')
    ->name('admin.home.doctor-home-sections.index');

    Route::livewire('/admin/home/doctor-home-sections/create', 'admin.home.doctor-home-sections.create')
        ->name('admin.home.doctor-home-sections.create');

    Route::livewire('/admin/home/doctor-home-sections/{doctorHomeSection}/edit', 'admin.home.doctor-home-sections.edit')
        ->name('admin.home.doctor-home-sections.edit');
    //end of route doctors

    // branch routes
    Route::livewire('/admin/branches', 'admin.branches.index')
    ->name('admin.branches.index');

    Route::livewire('/admin/branches/create', 'admin.branches.create')
        ->name('admin.branches.create');

    Route::livewire('/admin/branches/{branch}/edit', 'admin.branches.edit')
        ->name('admin.branches.edit');
        // end of branh routes

        // booking route
    Route::livewire('/admin/bookings/create', 'admin.bookings.create')
    ->name('admin.bookings.create');
    
    Route::livewire('/admin/bookings', 'admin.bookings.index')
    ->name('admin.bookings.index');

    Route::livewire('/admin/bookings/{booking}/edit', 'admin.bookings.edit')
    ->name('admin.bookings.edit');

    Route::livewire('/admin/bookings/{booking}', 'admin.bookings.show')
    ->name('admin.bookings.show');


    // before-after 
    // before-after routes
    Route::livewire(
        '/admin/treatments/{treatment}/before-afters',
        'admin.treatments.before-afters.index'
    )->name('admin.treatments.before-afters.index');

    Route::livewire(
        '/admin/treatments/{treatment}/before-afters/create',
        'admin.treatments.before-afters.create'
    )->name('admin.treatments.before-afters.create');

    Route::livewire(
        '/admin/treatments/{treatment}/before-afters/{beforeAfter}/edit',
        'admin.treatments.before-afters.edit'
    )->name('admin.treatments.before-afters.edit');
/// ------------ home route ublics ///
    
});

Route::get('/', [HomeController::class, 'index'])
    ->name('home');

Route::get('/doctors/{doctor:slug}', [PublicDoctorController::class, 'show'])
    ->name('doctor.show');

require __DIR__.'/settings.php';
