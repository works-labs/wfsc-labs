# Project Logs

## 2026-10-13 — Rencana banner desktop/mobile

### Permintaan

Banner pada halaman publik `treatments`, `promos`, `skincare`, dan `contact-us` terlihat berbeda/kurang sesuai saat dibuka di mobile. Perlu mendukung gambar banner terpisah untuk mode `desktop` dan `mobile`, tanpa menambah menu admin baru. Pengaturan dilakukan dari halaman yang sudah ada:

`/admin/banners/create`

### Hasil pengecekan

- Tabel `banners` saat ini hanya memiliki satu kolom `image` per data banner dan belum memiliki kolom mode/perangkat.
- Admin Banner Manager sudah memiliki placement untuk:
  - `treatments`
  - `promos`
  - `skincare`
  - `contact-us`
- Form create/edit banner saat ini memvalidasi semua gambar dengan ukuran minimal `1890 × 420 px` dan rasio `9:2`, sehingga cocok untuk desktop tetapi tidak cocok untuk banner portrait mobile.
- Keempat halaman publik mengambil banner berdasarkan `placement`, `is_active`, lalu memilih satu data pertama berdasarkan `sort_order`.
- Tampilan hero saat ini menggunakan tinggi tetap `420px` dan gambar `object-contain`; pola ini belum membedakan breakpoint desktop dan mobile.
- Aset banner yang saat ini tersedia di `storage/app/public/banners`:
  - `1890 × 420 px` — rasio desktop `9:2`
  - `3780 × 840 px` — rasio desktop `9:2`
  - `736 × 981 px` — rasio portrait `3:4`, kandidat ukuran/aspek mobile yang sudah ada

### Rancangan implementasi (setelah aset mobile tersedia)

1. Tambahkan field `mode` pada banner dengan pilihan `desktop` dan `mobile`, termasuk migration, model, validasi, serta tampilan list/edit.
2. Tambahkan pilihan `Mode` pada form `/admin/banners/create` dan form edit yang sama; tetap menggunakan menu Banner Manager yang sudah tersedia.
3. Gunakan kombinasi `placement + mode` untuk mengambil banner yang aktif pada halaman publik.
4. Tampilkan aset desktop/mobile dengan mekanisme responsive (`picture`/source atau pasangan elemen responsive), sehingga browser memilih gambar sesuai breakpoint.
5. Pisahkan validasi ukuran/aspek gambar berdasarkan mode. Patokan awal dari aset yang ada: desktop `1890 × 420 px` (rasio `9:2`) dan mobile `736 × 981 px` (rasio `3:4`), untuk dikonfirmasi setelah gambar mobile final dibuat.
6. Perbarui test admin/public untuk memastikan empat placement dapat memiliki banner desktop dan mobile serta fallback tetap aman bila salah satu mode belum tersedia.

### Status

Implementasi mode desktop/mobile selesai. Aset mobile final dapat diunggah melalui form Banner Manager setelah migration dijalankan.

## 2026-10-13 — Slider pada popup promo

Popup promo di `/promos` sekarang menampilkan semua promo sebagai galeri slider. Saat kartu promo diklik, popup dibuka pada promo yang dipilih. Navigasi tersedia melalui tombol sebelumnya/berikutnya, tombol panah keyboard, dan swipe pada area gambar di perangkat mobile.

## 2026-10-13 — Revisi ukuran banner mobile

Standar banner mobile direvisi dari `736 × 981 px` (rasio `3:4`) menjadi `393 × 420 px` (rasio `393:420`) agar tinggi banner konsisten saat berpindah menu. Validasi upload dan aspect ratio hero mobile mengikuti ukuran baru ini.

## 2026-10-13 — Penyamaan ukuran banner mobile

Setelah pengecekan ulang banner Promo, Contact, dan Skincare di publik, standar mobile disamakan menjadi `402 × 420 px` dengan rasio `402:420` untuk seluruh placement banner.

## 2026-10-13 — Penyamaan hero mobile seluruh halaman publik

Hero/banner mobile pada `/treatments`, `/promos`, `/skincare`, `/before-after`, `/news`, `/contact-us`, dan detail treatment kini menggunakan utility `public-responsive-banner`. Tingginya maksimal `420px` dan mengikuti lebar layar dengan acuan bidang `402 × 420 px`.

## 2026-10-13 — Banner mobile full width

Banner mobile tidak lagi dibatasi `max-width: 402px`. Banner sekarang memenuhi lebar layar, tinggi maksimal tetap `420px`, dan gambar mobile menggunakan `object-cover` agar tidak muncul gap putih di sisi kiri/kanan. Resolusi sumber yang disarankan tetap `402 × 420 px`.

## 2026-10-13 — Penyamaan ukuran filter chip

Filter chip pada Treatment, Skincare, dan Before After disamakan menggunakan tinggi `36px` pada mobile dan `40px` pada layar lebih besar, dengan padding, font, dan alignment yang konsisten. Bar filter juga memakai padding vertikal yang sama agar perpindahan halaman tidak terlihat berbeda.

## 2026-10-13 — Dots dan swipe filter Skincare

Filter Skincare sekarang memakai struktur scroll chip yang sama dengan Treatment dan Before After: dapat digeser horizontal dengan jari, memiliki indikator tiga dots, dan dots mengikuti posisi scroll serta dapat ditekan untuk berpindah ke bagian scroll.

## 2026-10-13 — Search dan filter halaman admin

Halaman `/admin/treatments`, `/skincare/products`, dan `/admin/news` sekarang memiliki search server-side dan filter yang dapat digunakan bersamaan. Query tetap dipaginate agar aman saat data bertambah banyak; hasil kembali ke halaman pertama setiap kali search/filter berubah.

## 2026-10-14 — Dokumentasi fitur terbaru

Dokumentasi maintenance diperbarui di `manual_guide.md` dan `README.md` untuk mencatat seluruh perubahan terakhir:

- Banner desktop/mobile menggunakan field `mode`, dengan desktop `1890 × 420 px` dan sumber mobile `402 × 420 px`.
- Banner publik memenuhi lebar layar mobile dengan tinggi maksimal `420px`; `object-cover` mencegah gap putih.
- Hero yang mengikuti aturan tersebut mencakup Treatment, Promo, Skincare, Before After, News, Contact Us, dan detail Treatment.
- Popup promo mendukung slide dengan tombol, keyboard, dan swipe.
- Chip filter Treatment, Skincare, dan Before After memiliki ukuran konsisten, scroll jari, serta indikator dots.
- Admin Treatment, Skincare Products, dan News memiliki search dan filter gabungan dengan pagination server-side.
- Dropdown filter admin menggunakan class `admin-filter-select` agar UI tetap konsisten.

## 2026-10-14 — Perbaikan jarak rich text sebelum list

Pada detail produk skincare, jarak antara teks pengantar seperti `Kandungan & Manfaat` dan list terasa terlalu lebar karena margin bawah paragraf bertemu dengan margin atas `ul/ol`. Margin list yang langsung mengikuti paragraf atau heading sekarang diperkecil, sementara jarak antar-item list tetap dipertahankan. Editor admin juga mengikuti aturan adjacency yang sama.

## 2026-10-14 — Rencana pengembangan kontrol spacing rich text

Permintaan berikutnya pada editor rich text:

- Tambahkan pilihan spacing keempat yang lebih longgar dari `Rapat`, `Normal`, dan `Longgar`.
- Tambahkan kontrol untuk memberi jarak sebelum paragraf.
- Tambahkan kontrol untuk memberi jarak setelah paragraf.
- Pastikan kontrol dapat diterapkan pada blok teks yang dipilih dan tetap tersimpan sebagai HTML/style inline saat konten disimpan.

Implementasi selesai pada editor rich text.

## 2026-10-14 — Implementasi kontrol spacing rich text

- Pilihan `Spasi` sekarang memiliki empat tingkat: `Rapat`, `Normal`, `Longgar`, dan `Sangat longgar`.
- Ditambahkan kontrol `Sebelum` untuk mengatur jarak sebelum paragraf/blok aktif.
- Ditambahkan kontrol `Sesudah` untuk mengatur jarak setelah paragraf/blok aktif.
- Pengaturan dapat diterapkan ke satu atau beberapa blok yang dipilih dan disimpan sebagai inline style pada HTML rich text.
- Opsi `Default` menghapus inline margin sehingga blok kembali mengikuti style bawaan editor.
- Validasi berhasil dengan `git diff --check`, `php artisan view:cache`, dan `npm run build`.

## 2026-10-14 — Perbaikan reset spacing rich text

Memperbaiki kontrol `Sebelum` dan `Sesudah` agar pilihan `Default` dapat menghapus kembali inline margin setelah sebelumnya memilih jarak tambahan. Seleksi editor sekarang disimpan sebelum fokus berpindah ke dropdown toolbar, sehingga blok yang dipilih tetap menjadi target reset.

Validasi ulang berhasil dengan `git diff --check` dan `php artisan view:cache`.

## 2026-10-14 — Perbaikan target seleksi saat reset spacing

Perbaikan lanjutan pada reset `Default`: ketika fokus berpindah ke dropdown, fungsi pemilihan blok kini mengabaikan range yang berada di luar editor dan menggunakan seleksi terakhir yang tersimpan di dalam editor. Dengan begitu, margin `Sedikit`, `Sedang`, atau `Besar` dapat dikembalikan ke `Default` setelah konten disimpan maupun saat dropdown digunakan kembali.

## 2026-10-14 — Perbaikan penghapusan margin spacing

Memperbaiki format nama properti CSS saat opsi `Default` dipilih. Sebelumnya `marginTop`/`marginBottom` tidak terhapus karena `removeProperty` membutuhkan format CSS `margin-top`/`margin-bottom`. Validasi ulang berhasil dengan `git diff --check` dan `php artisan view:cache`.

## 2026-10-17 — Reusable image cropper native Canvas

### Keputusan

Upload gambar pada CRUD admin dibuat lebih ramah pengguna dengan cropper reusable berbasis JavaScript native dan Canvas. Implementasi tidak menggunakan npm/library eksternal sehingga tetap kompatibel dengan hosting cPanel yang tidak menyediakan Node.js/npm.

### Alur

1. Admin memilih gambar melalui field upload.
2. Modal crop menampilkan preview, grid 3×3, kontrol drag, dan zoom.
3. Gambar tidak dapat digeser sampai meninggalkan area crop.
4. Canvas menghasilkan file baru sesuai ukuran dan rasio field.
5. File dikirim ke Livewire hanya setelah crop selesai.
6. Jika hasil crop lebih dari batas file, kualitas JPEG diturunkan bertahap. Jika sudah di bawah batas, tidak dikompres lagi.
7. Validasi Laravel tetap menjadi pengaman terakhir.

### Component reusable

Component berada di `resources/views/components/admin/image-cropper.blade.php` dan dipanggil dengan konfigurasi model, rasio, lebar, serta tinggi output. Pilot awal sudah diterapkan pada create/edit produk skincare.

### Standar media admin

| Form | Ukuran output | Rasio | Maksimal file |
|---|---:|---:|---:|
| Banner desktop | 1890 × 420 px | 9:2 | 5 MB |
| Banner mobile | 402 × 420 px | 402:420 | 5 MB |
| Dokter | 1080 × 1440 px | 3:4 | 5 MB |
| News thumbnail | 1600 × 1000 px | 8:5 | 2 MB |
| Promo image | 1080 × 1350 px | 4:5 | 5 MB |
| Treatment | 1280 × 1024 px | 5:4 | 5 MB |
| Treatment category | 1080 × 1350 px | 4:5 | 5 MB |
| Hero homepage | 1920 × 1080 px | 16:9 | 4 MB |
| Facility | 1280 × 960 px | 4:3 | 2 MB |
| Skincare product | 1080 × 1350 px | 4:5 | 2 MB |

### Status

Reusable cropper sudah aktif pada create/edit produk skincare, banner, dokter, news, promo, treatment, kategori treatment, hero homepage, dan fasilitas. Field promo juga mendukung pemilihan beberapa gambar; setiap gambar dipotong satu per satu sebelum dikirim ke Livewire.
