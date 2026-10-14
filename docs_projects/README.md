# Dokumentasi Audit & Serah Terima

Dokumen ini berisi hasil pemeriksaan statis project, status pengujian lokal, daftar risiko, dan checklist pengujian sebelum project diserahkan ke client.

## Ringkasan status

Status saat audit: **belum siap dinyatakan lulus serah-terima**.

- Build frontend: berhasil dengan warning font yang tidak ditemukan saat build.
- Pemeriksaan sintaks Blade/PHP: file yang diperiksa tidak memiliki syntax error.
- Route Laravel: berhasil dimuat; terdapat 12 route publik yang terdeteksi oleh `route:list` pada environment saat ini.
- Test suite: **PASS — 46 tests, 45 passed, 196 assertions**, 1 skipped (two-factor nonaktif), dan 1 risky (placeholder tanpa assertion), menggunakan MySQL sandbox lokal `wfsc_testing`.
- Audit domain publik: belum dilakukan; pemeriksaan ini terbatas pada source code dan konfigurasi lokal.

## Temuan keamanan prioritas

### Tinggi — kredensial SSH berada di `.env`

`.env` memuat komentar berisi password dan alamat SSH. File `.env` memang tidak ter-track oleh git pada checkout ini, tetapi tetap dapat bocor melalui backup, screenshot, log deployment, atau akses developer lain.

Tindakan wajib:

1. Rotasi password SSH dan gunakan key-based authentication.
2. Hapus kredensial dari `.env` dan seluruh catatan deployment yang tidak perlu.
3. Pastikan `.env` tidak pernah di-commit dan cek seluruh riwayat repository/backup.
4. Batasi akses SSH dengan firewall, user non-root, dan fail2ban/rate limit.

### Tinggi — stored XSS melalui HTML konten admin

`resources/views/public/news/show.blade.php` merender konten melalui `{!! $renderedContent !!}`. `NewsContentRenderer` mengembalikan konten mentah ketika tidak ada related news. Deskripsi treatment juga dirender sebagai HTML mentah ketika mengandung karakter `<`.

Jika akun admin diambil alih atau editor menerima HTML berbahaya, JavaScript dapat tersimpan dan dijalankan pada halaman publik.

Rekomendasi: sanitasi HTML dengan allowlist tag/attribute (misalnya hanya `p`, `h2`, `h3`, `strong`, `em`, `ul`, `ol`, `li`, `a`, `br`, dan `blockquote`), hapus `script`, event handler `on*`, `javascript:` URL, serta atribut berbahaya. Tambahkan Content-Security-Policy sebagai lapisan tambahan.

### Tinggi — URL CTA eksternal tidak dibatasi

Field `cta_target` bertipe string dan untuk tipe `external` dipakai langsung sebagai href pada `HeroBanner` dan `Promo`. Validasi hanya panjang string, bukan skema/domain.

Rekomendasi: izinkan hanya `https://` (dan `http://` jika benar-benar diperlukan), tolak `javascript:`, `data:`, `vbscript:`, protocol-relative URL, dan pertimbangkan allowlist domain. Tambahkan `rel="noopener noreferrer"` untuk link eksternal yang membuka tab baru.

### Sedang — input video YouTube belum diverifikasi

`video_path` hanya divalidasi sebagai string lalu digunakan dalam URL iframe. Input malformed dapat menghasilkan preview rusak; input yang tidak dibatasi juga memperbesar risiko penyalahgunaan embed.

Rekomendasi: parse URL/ID di server, terima hanya ID YouTube dengan format ketat `[A-Za-z0-9_-]{11}` atau URL YouTube resmi, lalu simpan ID canonical saja. Terapkan `allow` minimum pada iframe dan CSP `frame-src`.

### Sedang — otorisasi admin masih berupa `auth`

Semua route `/admin` hanya dilindungi middleware `auth`. Tidak terlihat middleware role/permission khusus. Jika sistem nantinya memiliki lebih dari satu user, setiap user yang dapat login berpotensi mengakses semua fungsi admin.

Rekomendasi: tambahkan role/permission (`admin`, `editor`, dan seterusnya), middleware/policy per resource, dan uji akses user non-admin ke route serta action Livewire.

## Validasi dan perilaku input kosong

Sebagian besar form create/edit sudah memakai rule `required`, `nullable`, `max`, `unique`, `url`, `email`, `integer`, dan validasi file. Namun pengujian langsung belum dapat dilakukan karena test runner/dependency tidak tersedia.

Kasus yang wajib diuji di browser:

1. Submit semua form tanpa mengisi field wajib: harus tetap di halaman, menampilkan error per field, dan tidak membuat record parsial.
2. Submit field opsional kosong: harus tersimpan sebagai `null`/nilai default tanpa exception.
3. Kirim nilai di atas batas panjang, angka negatif, format URL/email salah, slug duplikat, dan ID relasi yang tidak ada.
4. Upload file kosong, file bukan gambar, ekstensi dipalsukan, ukuran di atas batas, dan video dengan format tidak didukung.
5. Klik tombol simpan dua kali: tidak boleh membuat duplikasi.
6. Hapus record dengan relasi anak: harus mendapat pesan yang jelas dan tidak meninggalkan data yatim.

## Checklist fungsi manual

### Publik

- Beranda, navbar, footer, CTA WhatsApp, dan semua gambar tampil.
- Daftar/detail dokter, treatment, berita, promo, skincare, dan before-after.
- Filter/search kategori dan attribute pada halaman publik.
- Popup promo dapat di-slide dengan tombol, keyboard, dan swipe mobile.
- Chip filter Treatment, Skincare, dan Before After dapat di-swipe; indikator dots mengikuti posisi scroll.
- Banner responsive desktop/mobile pada Treatment, Promo, Skincare, Before After, News, Contact, dan detail Treatment.
- Slug yang tidak ada menghasilkan 404 yang aman, bukan stack trace.
- Konten kosong tidak merusak layout.
- Link CTA internal, WhatsApp, dan eksternal mengarah ke tujuan yang benar.
- Mobile/tablet/desktop; gambar besar dan koneksi lambat.

### Admin

- Login sukses, password salah, reset password, logout, session expiry, dan CSRF.
- Akses `/admin/*` tanpa login diarahkan ke login.
- CRUD seluruh resource: dokter, treatment, kategori, produk, berita, banner, promo, cabang, fasilitas, settings, video, before-after, skincare.
- Search dan filter gabungan pada admin Treatment, Skincare Products, dan News dengan pagination.
- Relasi parent-child tidak dapat tertukar melalui perubahan ID di request Livewire.
- Upload, replace, dan delete file tidak menghapus file milik record lain.
- User non-admin tidak dapat mengakses action admin.

## Perintah verifikasi yang disarankan

Jalankan di environment bersih setelah dependency terpasang dan database testing tersedia:

```bash
composer install
npm ci
php artisan migrate:fresh --seed --env=testing
php artisan test
php artisan pint --test
php artisan phpstan analyse
npm run build
```

Jika project memang memakai Pest secara langsung, pastikan binary test tersedia (`vendor/bin/pest`) dan konfigurasi `phpunit.xml` menunjuk database testing, bukan database production.

## Checklist deployment

- `APP_ENV=production`, `APP_DEBUG=false`.
- `APP_KEY` unik dan tidak dibagikan.
- `.env` tidak dipublikasikan oleh web server.
- `storage` dan `bootstrap/cache` permission sesuai kebutuhan, bukan writable seluruh project.
- `public/storage` hanya berisi asset yang memang boleh publik.
- HTTPS aktif, cookie Secure/HttpOnly/SameSite sesuai kebutuhan, dan security headers aktif.
- Backup database terenkripsi dan proses restore pernah diuji.
- Log tidak menulis password, token, atau data sensitif.
- Dependency Composer/NPM sudah diaudit dan dikunci versinya.
- Setelah rotasi secret, hapus secret lama dari server, CI/CD, backup, dan history yang dapat diakses.

## Keputusan akun admin

Untuk klinik dengan satu operator dan penggunaan internal, model satu akun admin masih masuk akal dan lebih sederhana. Menambahkan fitur banyak user hanya bermanfaat jika client membutuhkan salah satu dari hal berikut:

- beberapa staf mengelola CMS;
- pembatasan hak akses, misalnya editor tidak boleh menghapus data;
- audit trail berdasarkan orang yang melakukan perubahan;
- akun cadangan ketika admin utama tidak tersedia.

Jika kebutuhan itu belum ada, cukup pertahankan satu akun admin dan fokus pada password unik, 2FA jika tersedia, backup, serta pembatasan akses panel.

Jika fitur user management ditambahkan, desain yang direkomendasikan adalah:

1. Role `super_admin` dan `editor`/`admin`.
2. Tepat satu akun `super_admin` wajib selalu ada dan tidak boleh dihapus atau diturunkan rolenya melalui UI.
3. `super_admin` dapat membuat, menonaktifkan, mereset password, dan menghapus user lain.
4. User biasa tidak boleh membuat user, mengubah role, atau menghapus super admin.
5. Semua aksi user management wajib meminta password saat ini dan dicatat di audit log.
6. Jangan memakai password default yang tetap. Seeder saat ini membuat `admin@wfsc-labs.id` dengan password `password`; ini wajib diganti sebelum production, atau ubah seeder agar password diambil dari secret deployment dan hanya dijalankan pada instalasi awal.

Perhatian: fitur delete account bawaan saat ini memungkinkan user yang sedang login menghapus akunnya sendiri. Jika konsep super admin diterapkan, action tersebut harus menolak penghapusan akun terakhir/super admin agar panel tidak terkunci tanpa akun admin.

Rekomendasi untuk kondisi sekarang: **belum perlu menambahkan CRUD user**. Dokumentasikan satu akun admin resmi milik client, buat prosedur reset/backup, dan tambahkan user management hanya saat kebutuhan multi-operator benar-benar muncul.

## Batasan audit

Audit ini adalah review source/configuration lokal dan build check. Belum mencakup penetration test terotorisasi terhadap domain, konfigurasi web server/CDN, database production, DNS, firewall, atau secret history di remote repository. Pengujian eksternal sebaiknya dilakukan hanya dengan persetujuan tertulis client dan scope/rate limit yang jelas.
