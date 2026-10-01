# Unit dan Integration Testing

## Test yang tersedia

Test source yang ditemukan:

- Authentication: login valid/invalid, two-factor branch, logout.
- Password reset: request reset, reset screen, token valid.
- Settings: render security/profile, update password, update profile, delete account.
- Dashboard: guest redirect dan authenticated access.
- Unit smoke test: assertion sederhana.

## Status eksekusi terbaru

Dependency development berhasil dipasang melalui `composer install`. Database lokal sandbox `wfsc_testing` berhasil dibuat, migration dan seed berhasil dijalankan.

- Full Pest suite: **PASS — 46 tests, 45 passed, 196 assertions**.
- 1 test skipped karena fitur two-factor tidak aktif.
- 1 test risky karena test placeholder two-factor tidak memiliki assertion.
- Database: MySQL lokal `wfsc_testing`, terpisah dari `wfsc_labs`.

Coverage admin yang ditambahkan:

- seluruh named GET route admin diverifikasi membutuhkan autentikasi;
- dashboard admin setelah login;
- validasi field wajib dokter, treatment, dan berita;
- create dokter, treatment dengan kategori, dan berita dengan author/category;
- verifikasi record hasil create di database sandbox.

Coverage publik yang ditambahkan:

- seluruh halaman listing publik utama;
- detail dokter, treatment, dan berita dari data seed;
- slug publik yang tidak ditemukan menghasilkan 404, bukan error 5xx.

Coverage content/admin lanjutan yang ditambahkan:

- create/edit/delete promo;
- create banner dan fake image upload;
- create skincare product;
- validasi URL dan foreign key pivot skincare;
- sync kategori dan atribut skincare;
- before-after upload dua media dan deteksi tipe media;
- create video prosedur YouTube Shorts;
- verifikasi file tersimpan pada disk public.
- delete individual pada banner, promo, skincare product, before-after, dan video prosedur;
- verifikasi file media ikut terhapus saat record terkait dihapus.

Catatan: angka di atas adalah coverage perilaku/functional test. Test edit/delete individual untuk modul content utama sudah ditambahkan. Persentase line/branch coverage 100% belum dapat diklaim karena PCOV/Xdebug belum tersedia pada PHP lokal; perintah `vendor/bin/pest --coverage-text` belum dapat menghasilkan laporan coverage.

Untuk mengaktifkan line/branch coverage, pasang Xdebug atau PCOV sebagai extension PHP CLI lokal, lalu jalankan:

```bash
vendor/bin/pest --coverage-text
vendor/bin/pest --coverage=coverage
```

Test suite berhasil berjalan setelah konfigurasi test dipindahkan dari SQLite ke MySQL sandbox dan `APP_KEY` testing ditambahkan.

## Penyebab dan perbaikan environment

Jalankan pada environment testing bersih:

```bash
composer install
npm ci
php artisan migrate:fresh --seed --env=testing
vendor/bin/pest
```

Pastikan PHP CLI memiliki `pdo_sqlite` dan `sqlite3`. Setelah itu jalankan `vendor/bin/pest`. Jangan menggunakan `.env` production untuk testing.

## Coverage yang masih kurang

Tambahkan test untuk:

- seluruh route publik dan 404 slug;
- semua Livewire create/edit/delete;
- validasi field wajib, nullable, unique, URL, email, integer, date, dan file;
- relasi parent-child dan pivot `sync`;
- upload dan cleanup file lama;
- CTA type dan URL yang tidak valid;
- parsing video YouTube;
- sanitasi HTML berita/treatment;
- larangan menghapus satu-satunya akun super admin jika fitur tersebut dibuat.

## Isolasi database

`phpunit.xml` sudah mendefinisikan SQLite `:memory:` untuk test. Pastikan semua migration kompatibel dengan SQLite dan tidak ada test yang membaca database production. Gunakan factory/seed khusus test untuk data relasi.

Untuk cPanel production, dependency test tidak wajib dipasang. Gunakan `composer install --no-dev --optimize-autoloader` jika server hanya menjalankan aplikasi. Dependency test tetap dipasang di laptop developer atau CI.

## Database sandbox MySQL

Konfigurasi test sekarang menggunakan MySQL database `wfsc_testing`, bukan SQLite dan bukan database production. Credential host/user/password harus disimpan di `.env.testing` lokal yang tidak di-commit. Sebelum test dijalankan, buat database dan user khusus dengan privilege hanya ke database sandbox.

```bash
php artisan migrate:fresh --seed --env=testing
vendor/bin/pest
```

Perintah `migrate:fresh` destruktif terhadap database yang sedang dipilih, sehingga nama `wfsc_testing` wajib diverifikasi terlebih dahulu.
