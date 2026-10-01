# Alur Logic Aplikasi

## Alur request publik

```text
Browser
  -> Route publik
  -> Controller publik / HomeController
  -> Query model + filter is_active/published
  -> Relasi Eloquent dan view composer
  -> Blade public view
  -> HTML response
```

Route publik menangani home, dokter, treatment, berita, promo, skincare, before-after, dan contact-us. Slug dipakai untuk detail resource. Konten yang tidak aktif umumnya difilter agar tidak tampil.

## Alur request admin

```text
Browser
  -> Route /admin/*
  -> middleware auth
  -> Livewire/Volt component
  -> mount model (edit) atau default state (create)
  -> validate input
  -> upload/simpan/sync/delete
  -> flash message
  -> redirect/navigate
```

Delete biasanya mencari model berdasarkan ID, menghapus file terkait jika ada, lalu menghapus record. Create/edit dengan relasi memakai `create`, `update`, atau `sync` pada model/pivot.

## Alur authentication

```text
Login form -> Fortify -> rate limiter -> credential check -> session auth
                                     |
                                     -> gagal: validation/session error
```

Route admin membutuhkan session auth. Login memiliki rate limit berdasarkan email dan IP. Logout melakukan guard logout, invalidate session, dan regenerate token.

## Alur artikel berita

```text
Admin isi title/slug/content
  -> validate
  -> simpan News
  -> public detail
  -> NewsContentRenderer
  -> optional “Baca juga” insertion
  -> raw HTML view
```

Boundary keamanan utama berada di tahap renderer dan raw output. Konten editor perlu disanitasi sebelum disimpan atau sebelum dirender.

## Alur video prosedur

```text
Admin memasukkan YouTube Shorts URL/ID
  -> validate string
  -> simpan video_path
  -> public/admin preview membentuk iframe embed
```

Alur bisnis ini valid, tetapi input idealnya diparse menjadi ID YouTube canonical dengan format ketat agar iframe hanya mengarah ke YouTube.

## Alur upload media

```text
File dipilih
  -> Livewire temporary upload
  -> validate image/video dan ukuran
  -> store ke disk public
  -> simpan path ke database
  -> saat replace/delete: hapus file lama
```

Pengujian harus memastikan file invalid ditolak dan cleanup tidak menghapus file milik record lain.

## Alur deployment yang diharapkan

```text
Install dependency -> configure .env -> migrate/seed testing
  -> run tests/lint/build -> deploy release
  -> APP_DEBUG=false -> cache config/routes/views
  -> smoke test -> backup/monitoring
```
