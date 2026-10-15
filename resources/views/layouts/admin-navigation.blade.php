@php
    $itemClass = 'flex items-center gap-3 rounded-xl px-4 py-2.5 text-sm transition-all duration-200';
    $activeClass = 'bg-rose-50 text-[var(--color-wfsc-coral)] font-bold';
    $idleClass = 'text-gray-500 font-medium hover:bg-gray-50 hover:text-[var(--color-wfsc-dark)]';
    $subIcon = '<svg class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M5 6h14M5 18h14"/></svg>';
    $groups = [
        'home' => request()->routeIs('admin.home.hero-banners.*', 'admin.home.doctor-home-sections.*', 'admin.home.why-choose-items.*', 'admin.home.site-statistics.*', 'admin.facilities.*'),
        'treatments' => request()->routeIs('admin.treatment-categories.*', 'admin.treatments.*'),
        'skincare' => request()->routeIs('admin.skincare.*'),
        'promo' => request()->routeIs('admin.home.promos.*'),
        'news' => request()->routeIs('admin.news.*'),
        'global' => request()->routeIs('admin.doctors.*', 'admin.branches.*', 'admin.banners.*'),
        'system' => request()->routeIs('admin.profile', 'admin.settings.*'),
    ];
@endphp

<a href="{{ route('admin.dashboard') }}" wire:navigate class="{{ $itemClass }} mb-6 {{ request()->routeIs('admin.dashboard') ? 'bg-gradient-to-r from-[var(--color-wfsc-coral)] to-[#ff7676] text-white shadow-lg shadow-[var(--color-wfsc-coral)]/30 font-bold' : $idleClass }}">
    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l9-9 9 9M5 10v10h14V10M9 20v-6h6v6"/></svg>Dashboard
</a>

@php
    $fixedGroups = [
        ['key' => 'home', 'label' => 'Home', 'icon' => 'M3 12l9-9 9 9M5 10v10h14V10', 'links' => [
            ['route' => 'admin.home.hero-banners.index', 'label' => 'Hero Banner', 'active' => 'admin.home.hero-banners.*'],
            ['route' => 'admin.home.doctor-home-sections.index', 'label' => 'Dokter Beranda', 'active' => 'admin.home.doctor-home-sections.*'],
            ['route' => 'admin.home.why-choose-items.index', 'label' => 'Mengapa Memilih Kami', 'active' => 'admin.home.why-choose-items.*'],
            ['route' => 'admin.home.site-statistics.index', 'label' => 'Statistik Situs', 'active' => 'admin.home.site-statistics.*'],
            ['route' => 'admin.facilities.index', 'label' => 'Fasilitas', 'active' => 'admin.facilities.*'],
        ]],
        ['key' => 'treatments', 'label' => 'Treatments', 'icon' => 'M12 3v18M3 12h18M5.6 5.6l12.8 12.8M18.4 5.6 5.6 18.4', 'links' => [
            ['route' => 'admin.treatment-categories.index', 'label' => 'Kategori Perawatan', 'active' => 'admin.treatment-categories.*'],
            ['route' => 'admin.treatments.index', 'label' => 'Daftar Treatment', 'active' => 'admin.treatments.index', 'extra' => ['admin.treatments.create', 'admin.treatments.edit']],
            ['route' => 'admin.treatments.order', 'label' => 'Atur Urutan', 'active' => 'admin.treatments.order'],
        ]],
        ['key' => 'skincare', 'label' => 'Skincare', 'icon' => 'M6 3h12v4H6zM4 7h16l-1 14H5L4 7z', 'links' => [
            ['route' => 'admin.skincare.categories.index', 'label' => 'Kategori', 'active' => 'admin.skincare.categories.*'],
            ['route' => 'admin.skincare.attributes.index', 'label' => 'Atribut', 'active' => 'admin.skincare.attributes.*'],
            ['route' => 'admin.skincare.products.index', 'label' => 'Daftar Produk', 'active' => 'admin.skincare.products.index', 'extra' => ['admin.skincare.products.create', 'admin.skincare.products.edit']],
            ['route' => 'admin.skincare.products.order', 'label' => 'Atur Urutan', 'active' => 'admin.skincare.products.order'],
        ]],
        ['key' => 'promo', 'label' => 'Promo', 'icon' => 'M12 3v18m9-9H3', 'links' => [
            ['route' => 'admin.home.promos.index', 'label' => 'Semua Promo', 'active' => 'admin.home.promos.index', 'extra' => ['admin.home.promos.create', 'admin.home.promos.edit']],
            ['route' => 'admin.home.promos.order', 'label' => 'Atur Urutan', 'active' => 'admin.home.promos.order'],
        ]],
        ['key' => 'news', 'label' => 'News', 'icon' => 'M4 5h16v14H4zM8 9h8M8 13h5', 'links' => [
            ['route' => 'admin.news.index', 'label' => 'Artikel', 'active' => 'admin.news.index', 'extra' => ['admin.news.create', 'admin.news.edit', 'admin.news.related']],
            ['route' => 'admin.news.categories.index', 'label' => 'Kategori Berita', 'active' => 'admin.news.categories.*'],
        ]],
        ['key' => 'global', 'label' => 'Global / Footer', 'icon' => 'M12 21a9 9 0 1 0 0-18 9 9 0 0 0 0 18zM3 12h18', 'links' => [
            ['route' => 'admin.doctors.index', 'label' => 'Dokter', 'active' => 'admin.doctors.*'],
            ['route' => 'admin.branches.index', 'label' => 'Cabang', 'active' => 'admin.branches.*'],
            ['route' => 'admin.banners.index', 'label' => 'Banner Placement', 'active' => 'admin.banners.*'],
        ]],
        ['key' => 'system', 'label' => 'Sistem', 'icon' => 'M12 15.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7zM4 12a8 8 0 0 1 1-4m15 4a8 8 0 0 1-4 1', 'links' => [
            ['route' => 'admin.profile', 'label' => 'Profil', 'active' => 'admin.profile'],
            ['route' => 'admin.settings.index', 'label' => 'Pengaturan Situs', 'active' => 'admin.settings.*'],
        ]],
    ];
@endphp

@foreach ($fixedGroups as $group)
    <div x-data="{ open: {{ $groups[$group['key']] ? 'true' : 'false' }} }" class="pt-1">
        <button type="button" @click="open = !open" class="flex w-full items-center justify-between rounded-xl px-4 py-2.5 text-sm {{ $groups[$group['key']] ? 'text-[var(--color-wfsc-coral)] font-bold' : $idleClass }}">
            <span class="flex items-center gap-3"><svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $group['icon'] }}"/></svg>{{ $group['label'] }}</span>
            <svg :class="open ? 'rotate-180 text-[var(--color-wfsc-coral)]' : 'text-gray-400'" class="h-4 w-4 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m19 9-7 7-7-7"/></svg>
        </button>
        <div x-show="open" x-collapse x-cloak class="mt-1 space-y-1 border-l-2 border-rose-100 ml-7 pl-3">
            @foreach ($group['links'] as $link)
                <a href="{{ route($link['route']) }}" wire:navigate class="{{ $itemClass }} {{ request()->routeIs($link['active'], ...($link['extra'] ?? [])) ? $activeClass : $idleClass }}">{!! $subIcon !!}{{ $link['label'] }}</a>
            @endforeach
        </div>
    </div>
@endforeach
