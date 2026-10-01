# Black-box Testing

## Definisi

Black-box testing menguji perilaku dari luar aplikasi tanpa mengandalkan detail implementasi internal. Fokusnya adalah URL, form, respons, validasi, redirect, dan perubahan yang terlihat oleh pengguna.

## Hasil eksekusi lokal

| Area | Hasil | Catatan |
|---|---|---|
| Laravel bootstrap | PASS | `php artisan about` berhasil. |
| Route registration | PASS | `php artisan route:list` berhasil memuat route publik dan settings. |
| Guest access ke admin | BELUM TERUJI PENUH | Test tersedia, tetapi runner PHPUnit/Pest tidak terpasang. |
| Login/logout/reset password | BELUM TERUJI PENUH | Test source tersedia, belum bisa dieksekusi. |
| CRUD admin | BELUM TERUJI | Perlu browser test dengan database testing. |
| Empty required fields | BELUM TERUJI | Rule validasi terlihat pada banyak form, tetapi belum diverifikasi lewat request aktual. |
| Upload file | BELUM TERUJI | Perlu file valid, invalid MIME, ukuran besar, dan file kosong. |
| Frontend build | PASS WITH WARNING | Build berhasil; font DIN Pro tidak resolve saat build dan akan dicari runtime. |

## Skenario black-box wajib

### Publik

1. Buka `/`, `/doctors/{slug}`, `/treatments`, `/treatments/{slug}`, `/news`, `/news/{slug}`, `/promos`, `/skincare`, `/before-after`, dan `/contact-us`.
2. Uji slug acak dan pastikan hasilnya 404 aman tanpa stack trace.
3. Uji database kosong atau konten tidak aktif; halaman tetap merender layout tanpa exception.
4. Uji CTA internal, WhatsApp, YouTube, dan external URL.
5. Uji mobile, desktop, gambar hilang, dan koneksi lambat.

### Admin

1. Buka `/admin/*` tanpa login; hasil yang diharapkan redirect ke login.
2. Login dengan password benar dan salah.
3. Untuk setiap modul CRUD, submit form kosong, data valid, data melebihi batas, data duplikat, dan relasi tidak valid.
4. Pastikan error muncul di field yang benar, record tidak tersimpan sebagian, dan tidak ada exception.
5. Uji upload format salah, ukuran terlalu besar, penggantian gambar, dan penghapusan record.
6. Klik Save/Delete dua kali dan pastikan tidak ada duplikasi atau error race yang terlihat.
7. Uji logout, session expired, reset password, dan perubahan password.

## Kriteria lulus

Black-box dianggap lulus jika semua skenario di atas telah dijalankan pada database testing/staging, semua expected result terpenuhi, dan tidak ada error 5xx atau data production yang berubah.
