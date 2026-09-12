<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PublicDoctorController;
use App\Http\Controllers\PublicTreatmentController;
use App\Http\Controllers\PublicNewsController;
use App\Http\Controllers\PublicBeforeAfterController;
use App\Http\Controllers\PublicPromoController;
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


    Route::livewire(
        '/admin/treatments/{treatment}/videos',
        'admin.treatments.videos.index'
    )->name('admin.treatments.videos.index');

    Route::livewire(
        '/admin/treatments/{treatment}/videos/create',
        'admin.treatments.videos.create'
    )->name('admin.treatments.videos.create');

    Route::livewire(
        '/admin/treatments/{treatment}/videos/{video}/edit',
        'admin.treatments.videos.edit'
    )->name('admin.treatments.videos.edit');

        // site settings
    Route::livewire('/admin/settings', 'admin.settings.index')
        ->name('admin.settings.index');

    Route::livewire('/admin/settings/create', 'admin.settings.create')
        ->name('admin.settings.create');

    Route::livewire('/admin/settings/{setting}/edit', 'admin.settings.edit')
        ->name('admin.settings.edit');
    // end site settings

    Route::livewire('admin/banners', 'admin.banners.index')
    ->name('admin.banners.index');

    Route::livewire('admin/banners/create', 'admin.banners.create')
        ->name('admin.banners.create');

    Route::livewire('admin/banners/{banner}/edit', 'admin.banners.edit')
        ->name('admin.banners.edit');

    Route::livewire('/skincare/categories', 'admin.skincare.categories.index')
    ->name('admin.skincare.categories.index');

    Route::livewire('/skincare/categories/create', 'admin.skincare.categories.create')
        ->name('admin.skincare.categories.create');

    Route::livewire('/skincare/categories/{skincareCategory}/edit', 'admin.skincare.categories.edit')
        ->name('admin.skincare.categories.edit');

    Route::livewire('/skincare/attributes', 'admin.skincare.attributes.index')
    ->name('admin.skincare.attributes.index');

    Route::livewire('/skincare/attributes/create', 'admin.skincare.attributes.create')
        ->name('admin.skincare.attributes.create');

    Route::livewire('/skincare/attributes/{skincareAttribute}/edit', 'admin.skincare.attributes.edit')
        ->name('admin.skincare.attributes.edit');

    Route::livewire('/skincare/products', 'admin.skincare.products.index')
    ->name('admin.skincare.products.index');

    Route::livewire('/skincare/products/create', 'admin.skincare.products.create')
        ->name('admin.skincare.products.create');

    Route::livewire('/skincare/products/{skincareProduct}/edit', 'admin.skincare.products.edit')
        ->name('admin.skincare.products.edit');

    Route::livewire('/treatments', 'admin.treatments.index')
    ->name('admin.treatments.index');

Route::livewire('/treatments/create', 'admin.treatments.create')
    ->name('admin.treatments.create');

Route::livewire('/treatments/{treatment}/edit', 'admin.treatments.edit')
    ->name('admin.treatments.edit');

Route::livewire(
    '/treatments/{treatment}/related-treatments',
    'admin.treatments.related-treatments.index'
)->name('admin.treatments.related-treatments.index');

Route::livewire(
    'admin/news/categories',
    'admin.news.categories.index'
)->name('admin.news.categories.index');

Route::livewire(
    'admin/news/categories/create',
    'admin.news.categories.create'
)->name('admin.news.categories.create');

Route::livewire(
    'admin/news/categories/{category}/edit',
    'admin.news.categories.edit'
)->name('admin.news.categories.edit');

Route::livewire(
    'admin/news/{news}/related',
    'admin.news.related'
)->name('admin.news.related');
    
/// ------------ home route ublics ///
    
});

Route::get('/', [HomeController::class, 'index'])
    ->name('home');

Route::get('/doctors/{doctor:slug}', [PublicDoctorController::class, 'show'])
    ->name('doctor.show');

Route::get('/treatments', [PublicTreatmentController::class, 'index'])
    ->name('treatments.index');

Route::get('/treatments/{treatment:slug}', [PublicTreatmentController::class, 'show'])
    ->name('treatment.show');

Route::get('/news/{news:slug}', [PublicNewsController::class, 'show'])
    ->name('news.show');

Route::get('/before-after', [PublicBeforeAfterController::class, 'index'])
    ->name('before-after.index');

Route::get('/promos', [PublicPromoController::class, 'index'])
    ->name('promos.index');

Route::get('/news', [PublicNewsController::class, 'index'])
    ->name('news.index');

require __DIR__.'/settings.php';
