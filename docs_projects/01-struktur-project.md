# Struktur Project

## Teknologi

- Backend: Laravel 13.24, PHP 8.5.
- UI/admin: Livewire 4, Livewire Volt, Flux.
- Frontend asset: Vite 8, Tailwind CSS.
- Authentication: Laravel Fortify.
- Database default lokal: MySQL; konfigurasi test mengarah ke SQLite in-memory.
- Storage upload: disk `public`, diakses melalui `public/storage`.

## Direktori utama

| Direktori | Tanggung jawab |
|---|---|
| `app/Http/Controllers` | Controller halaman publik. |
| `app/Models` | Model Eloquent dan relasi data. |
| `app/Livewire` | Action Livewire reusable, termasuk logout. |
| `resources/views/public` | Halaman dan section website publik. |
| `resources/views/components/admin` | Halaman CRUD admin berbasis Volt/Livewire. |
| `resources/views/pages/auth` | Login dan reset password. |
| `resources/views/pages/settings` | Profile, password, dan delete account. |
| `routes` | Route publik, admin, dan settings. |
| `database/migrations` | Struktur tabel dan pivot relation. |
| `database/seeders` | Data awal website dan admin. |
| `tests` | Unit dan feature test yang sudah tersedia. |
| `public` | Entry point web, asset build, dan storage link. |
| `docs_projects` | Dokumentasi audit, testing, dan alur aplikasi. |

## Modul data

Konten utama meliputi dokter, kategori/treatment, produk treatment, before-after, video prosedur, banner, promo, fasilitas, cabang, statistik, settings, berita, kategori berita, skincare, dan user.

## Catatan struktur

Admin route berada di `routes/web.php` dalam group `auth`, sedangkan halaman publik berada di luar group tersebut. Saat audit, semua route admin memakai autentikasi umum dan belum memakai role/permission khusus.
