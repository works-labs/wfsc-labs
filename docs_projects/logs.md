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
