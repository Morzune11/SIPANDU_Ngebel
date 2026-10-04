# Sistem Informasi Pelayanan Perizinan Kecamatan (Kecamatan Ngebel)

Aplikasi berbasis web untuk digitalisasi pelayanan perizinan di tingkat kecamatan. Sistem ini memfasilitasi alur permohonan surat dari masyarakat hingga disahkan (di-ACC) secara elektronik oleh Camat, lengkap dengan fitur pratinjau dan unduh berkas PDF.

## 🚀 Teknologi yang Digunakan
* **Framework:** Laravel (PHP)
* **Frontend:** Tailwind CSS, Blade Templating
* **Database:** MySQL
* **PDF Generator:** Barryvdh / DomPDF

## 👥 Hak Akses (Role Based Access Control)
Sistem ini menggunakan 3 peran (*role*) yang saling terintegrasi:

1. **Pemohon (Masyarakat)**
   * Melengkapi data diri (biodata otomatis masuk ke cetakan surat).
   * Membuat pengajuan izin baru dan mengunggah dokumen persyaratan.
   * Memantau status pengajuan dan melakukan revisi berkas jika diminta.
   * Mengunduh surat final berformat PDF yang telah disahkan Camat.
   
2. **Admin (Staf Pelayanan)**
   * Menerima notifikasi pengajuan baru secara *real-time*.
   * Memeriksa dan memverifikasi kelengkapan berkas.
   * Mengubah status (Proses / Revisi / Lanjut ke Camat).
   * Melihat pratinjau (preview) HTML surat sebelum diajukan ke pimpinan.

3. **Camat (Pimpinan)**
   * Menerima antrean dokumen yang sudah diverifikasi (bebas dari proses pengecekan berkas mentah).
   * Melakukan ACC / Pengesahan satu klik (TTE).
   * Memantau riwayat seluruh pengesahan dokumen.

## ✨ Fitur Unggulan Sejauh Ini
* **Smart Dashboard:** Tampilan metrik dinamis yang menyesuaikan dengan *role* yang sedang login.
* **Sistem Revisi Mandiri:** Masyarakat tidak perlu mengulang pengisian form dari awal jika ada berkas yang salah, cukup mengunggah ulang dokumen yang ditandai admin.
* **Auto-Expired Revision (Cron Job):** Pembatalan otomatis sistem untuk berkas revisi yang diabaikan pemohon lebih dari 30 hari.
* **Database Notifications:** Sistem lonceng notifikasi (di navbar atas) yang memberitahu *progress* dokumen tanpa harus merefresh halaman.
* **Secure PDF Generation:** PDF hanya bisa di-generate dan diunduh setelah status benar-benar disahkan oleh Camat.

## ⚙️ Cara Instalasi Lokal
1. Clone repositori ini: `git clone <link-repo-anda>`
2. Install dependencies: `composer install`
3. Salin file environment: `cp .env.example .env`
4. Generate key aplikasi: `php artisan key:generate`
5. Atur koneksi database MySQL di file `.env`
6. Jalankan migrasi: `php artisan migrate`
7. Sambungkan folder storage: `php artisan storage:link`
8. Jalankan server: `php artisan serve`
