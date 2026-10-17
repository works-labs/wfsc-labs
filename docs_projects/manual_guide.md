# Panduan Ukuran Foto dan Video

Gunakan panduan ini saat menyiapkan gambar atau video untuk diunggah ke website WFSC Clinic.

## Ketentuan umum gambar

- Format yang diterima: **JPG, PNG, atau WebP**.
- Jangan menambahkan border, canvas, atau ruang kosong di luar ukuran desain.
- Gunakan ukuran pixel dan rasio yang sesuai agar gambar tidak terpotong atau terlihat gepeng.
- Pada form yang sudah memakai cropper, pilih gambar lalu geser dan zoom di dalam grid crop sebelum menekan `Gunakan Gambar`.
- Cropper menghasilkan file baru sesuai ukuran output. Resolusi tidak mengikuti ukuran asli upload.
- Jika hasil crop masih di bawah batas maksimal file, kualitasnya dipertahankan. Kompresi tambahan hanya dilakukan jika melewati batas.
- Jika ingin menggunakan resolusi lebih tinggi, pertahankan rasio yang sama.

## Ukuran gambar banner

| Keperluan | Rasio | Ukuran yang disarankan | Maksimal file |
| --- | ---: | ---: | ---: |
| Banner halaman Treatment, Promo, Skincare, News, Before After, dan Contact — Desktop | **9:2** | **1890 × 420 px** atau lebih tinggi dengan rasio yang sama | **5 MB** |
| Banner/hero publik Treatment, Promo, Skincare, Before After, News, Contact, dan detail Treatment — Mobile | **402:420** | maksimal **402 × 420 px** dengan rasio yang sama | **5 MB** |
| Banner homepage / Hero Banner | **16:9** | **1920 × 1080 px** | **4 MB** |

Untuk banner halaman desktop, ukuran minimalnya adalah **1890 × 420 px**. Contoh resolusi lebih tinggi yang tetap benar: **3780 × 840 px**.

Untuk banner halaman mobile, gunakan ukuran maksimal **402 × 420 px** dengan rasio **402:420**. Di menu `/admin/banners/create`, pilih `Placement` halaman dan `Mode` **Mobile**. Banner desktop dan mobile disimpan sebagai data terpisah dengan placement yang sama. Hero News, Before After, dan detail Treatment juga mengikuti batas tinggi mobile yang sama.

## Catatan fitur banner publik

- Placement banner yang dikelola melalui Banner Manager: `treatments`, `before-after`, `promos`, `skincare`, dan `contact-us`.
- Setiap placement dapat memiliki data `Desktop` dan `Mobile` secara terpisah.
- Banner lama tanpa mode dianggap sebagai `Desktop` setelah migration.
- Pada layar mobile, banner memenuhi lebar layar dan tinggi hero maksimal **420 px**. Gambar menggunakan `object-cover` agar tidak muncul ruang kosong di sisi kiri/kanan.
- Jika banner mobile belum tersedia, halaman memakai banner desktop sebagai fallback.
- Hero publik yang mengikuti aturan tinggi mobile: daftar Treatment, Promo, Skincare, Before After, News, Contact Us, dan detail Treatment.

## Fitur interaktif publik

### Popup Promo

Pada halaman `/promos`, klik kartu promo untuk membuka popup. Popup dapat dinavigasi dengan:

- tombol sebelumnya/berikutnya;
- tombol panah kiri/kanan pada keyboard;
- swipe kiri/kanan pada gambar di mobile;
- tombol `Escape` atau klik backdrop untuk menutup.

Popup menampilkan counter posisi slide dan informasi promo mengikuti gambar yang sedang aktif.

### Filter chip publik

Filter chip pada `/treatments`, `/skincare`, dan `/before-after` memakai ukuran yang sama. Chip dapat digeser horizontal dengan jari pada mobile. Indikator dots menunjukkan posisi scroll; pada Skincare dots juga sudah tersedia dan dapat ditekan untuk berpindah posisi.

## Pencarian dan filter admin

Search dan filter di bawah ini berjalan bersamaan dan menggunakan pagination server-side:

| Halaman | Search | Filter |
| --- | --- | --- |
| `/admin/treatments` | nama, slug, deskripsi, kategori | kategori, status, featured |
| `/skincare/products` | nama, slug, deskripsi, kategori, atribut | kategori, atribut, status |
| `/admin/news` | judul, slug, ringkasan, kategori, penulis | kategori, penulis, status publikasi/aktif, featured |

Saat nilai search atau filter berubah, hasil otomatis kembali ke halaman pertama.

Untuk menjaga tampilan konsisten, dropdown filter admin menggunakan class UI `admin-filter-select` di `resources/css/public.css`.

## Ukuran thumbnail dan foto konten

| Keperluan | Rasio | Ukuran gambar | Maksimal file |
| --- | ---: | ---: | ---: |
| Foto cover Treatment | **5:4** | **1280 × 1024 px** | **5 MB** |
| Foto kategori Treatment di homepage | **4:5** | **1080 × 1350 px** | **5 MB** |
| Thumbnail Promo | **4:5** | **1080 × 1350 px** | **5 MB** |
| Foto produk Skincare | **4:5** | **1080 × 1350 px** | **2 MB** |
| Foto produk Treatment / Products Used | **1:1** | **1080 × 1080 px** | **2 MB** |
| Thumbnail News / Artikel | **16:10** | **1600 × 1000 px** | **2 MB** |
| Foto Before After | **4:5** | **1080 × 1350 px** | **5 MB** |
| Foto Dokter | **3:4** | **1080 × 1440 px** | **5 MB** |
| Foto Fasilitas | **4:3** | **1280 × 960 px** | **2 MB** |

## Before After

Before After menggunakan **satu foto gabungan** yang sudah menampilkan hasil before dan after dalam satu gambar.

- Ukuran: **1080 × 1350 px**
- Rasio: **4:5 portrait**
- Format: **JPG, PNG, atau WebP**
- Maksimal: **5 MB**

## Video prosedur Treatment

- Maksimal **2 video** untuk setiap treatment.
- Rasio: **9:16 portrait**
- Ukuran ideal: **1080 × 1920 px**
- Gunakan video vertikal agar tidak muncul ruang kosong di sisi kiri dan kanan.
- Video dapat menggunakan URL YouTube Shorts, Instagram Reel, atau TikTok sesuai ketentuan platform.
- Instagram tetap menggunakan embed resmi Instagram, sehingga elemen UI dari Instagram tidak dapat dihilangkan sepenuhnya.

## Ringkasan cepat

| Jenis konten | Ukuran utama |
| --- | ---: |
| Banner halaman desktop | **1890 × 420 px** |
| Banner/hero publik mobile | **402 × 420 px** |
| Hero homepage | **1920 × 1080 px** |
| Treatment | **1280 × 1024 px** |
| Kategori Treatment | **1080 × 1350 px** |
| Promo | **1080 × 1350 px** |
| Skincare | **1080 × 1350 px** |
| Produk Treatment | **1080 × 1080 px** |
| News / Artikel | **1600 × 1000 px** |
| Before After | **1080 × 1350 px** |
| Dokter | **1080 × 1440 px** |
| Fasilitas | **1280 × 960 px** |
| Video Treatment | **1080 × 1920 px** |
