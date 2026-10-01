# White-box Testing

## Definisi

White-box testing memeriksa jalur logic, validasi, relasi, boundary keamanan, dan implementasi internal berdasarkan source code.

## Pemeriksaan yang berhasil

| Pemeriksaan | Hasil |
|---|---|
| Syntax seluruh model/controller/provider/support | PASS |
| Syntax route | PASS |
| Blade/PHP component yang diperiksa | PASS |
| Laravel bootstrap | PASS |
| Route listing | PASS |
| Composer manifest validation | PASS WITH WARNING |
| Vite production build | PASS WITH WARNING |

## Jalur logic penting

- `HomeController` mengambil hanya konten aktif, mengurutkan berdasarkan sort order/featured, membatasi berita dan treatment tertentu, lalu mengirim data ke view home.
- Controller publik mengambil data berdasarkan slug atau model binding dan mengirim detail beserta relasinya.
- Komponen admin Volt mengikat field ke property Livewire, menjalankan `validate()`, menyimpan model, mengelola file public, lalu redirect dengan flash message.
- Model `HeroBanner` dan `Promo` membentuk URL CTA berdasarkan tipe internal, treatment, doctor, news, WhatsApp, atau external.
- `NewsContentRenderer` menyisipkan callout “Baca juga” ke HTML artikel.
- Fortify menangani autentikasi, reset password, rate limit login, dan view auth.

## Temuan white-box

### Tinggi

- `.env` lokal berisi credential SSH yang ditulis sebagai komentar; rotasi dan hapus.
- HTML berita/treatment dirender dengan raw output. Sanitasi allowlist belum terlihat.
- Seeder admin memakai password default `password`; wajib diganti sebelum production.

### Sedang

- Semua admin route hanya memakai `auth`; role/permission belum terlihat.
- CTA external hanya divalidasi sebagai string; skema URL belum dibatasi.
- `video_path` hanya divalidasi string dan disisipkan ke iframe; sebaiknya canonicalize menjadi YouTube ID.
- Environment lokal masih `APP_DEBUG=true`; production harus `false`.
- Fitur delete account memungkinkan user terakhir menghapus dirinya sendiri.

### Rendah/operasional

- `livewire/volt` memakai constraint `*` pada Composer.
- Build memberi warning font DIN Pro yang tidak ditemukan saat build.
- Test suite source ada, tetapi dependency runner tidak lengkap pada checkout ini.

## Boundary yang harus diberi test

1. Semua mutation harus menolak input invalid sebelum `create/update/delete`.
2. Semua upload harus membatasi MIME, ukuran, extension, dan lokasi penyimpanan.
3. Semua output raw HTML harus melalui sanitizer.
4. Semua external link harus menolak `javascript:`, `data:`, `vbscript:`, protocol-relative URL, dan skema tak dikenal.
5. Semua route/action admin harus memeriksa autentikasi dan, jika multi-user, authorization.
6. Semua delete file harus memeriksa path milik record yang sedang dihapus.
