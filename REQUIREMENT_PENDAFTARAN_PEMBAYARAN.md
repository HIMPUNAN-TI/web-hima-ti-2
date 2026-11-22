# Requirement Pendaftaran dan Pembayaran Peserta

Dokumen ini merupakan usulan requirement tugas pengembangan web, bukan pernyataan bahwa seluruh fitur sudah tersedia pada proyek.

## 1. Daftar atau Login

- Login melalui Google OAuth, Microsoft OAuth, atau email/password.
- Akun lokal wajib melakukan verifikasi email.
- Tersedia fitur lupa password melalui tautan email dengan masa berlaku.
- Pengiriman email menggunakan SMTP mailer.

## 2. Lengkapi Data Peserta

- Data peserta meliputi nama, NIM jika diperlukan, nomor HP, dan institusi.
- Data wajib lengkap sebelum peserta mendaftar kegiatan.

## 3. Pilih dan Daftar Kegiatan

- Peserta dapat melihat detail, jadwal, biaya, dan batas pendaftaran kegiatan.
- Sistem memeriksa kuota, tenggat, dan pendaftaran ganda.
- Pendaftaran berhasil memperoleh nomor unik dan status **menunggu pembayaran**.
- Kegiatan gratis langsung memperoleh status **terdaftar**, tanpa proses pembayaran.

## 4. Lakukan Pembayaran

- Peserta melihat nominal, rekening tujuan, dan batas pembayaran.
- Rekening tujuan dikelola melalui panel admin.
- Pembayaran menggunakan transfer manual, tanpa integrasi payment gateway.
- Peserta mengunggah bukti pembayaran.
- Bukti pembayaran disimpan di **Cloudflare R2** dengan validasi jenis dan ukuran file, maksimal 2 MB.
- Setelah bukti diunggah, status pembayaran menjadi **menunggu verifikasi**.

## 5. Verifikasi Pembayaran

- Admin atau panitia yang memiliki izin dapat memeriksa bukti pembayaran.
- Jika diterima, status pembayaran menjadi **lunas** dan peserta menjadi **terdaftar**.
- Jika ditolak, sistem menyimpan dan menampilkan alasan penolakan.
- Peserta dapat mengunggah ulang bukti selama batas pembayaran masih berlaku.
- Pendaftaran yang belum mengirim bukti hingga batas pembayaran ditandai **kedaluwarsa**.
- Bukti yang sudah dikirim tepat waktu tetap dapat diverifikasi setelah tenggat.

## 6. Kirim Konfirmasi dan Kuitansi

- Setelah pembayaran disetujui, sistem menghasilkan **kuitansi PDF**.
- Kuitansi memuat nomor kuitansi, identitas peserta, kegiatan, nominal, dan tanggal pembayaran yang disetujui.
- Konfirmasi beserta kuitansi dikirim melalui SMTP mailer.
- Peserta dapat mengunduh kuitansi melalui dashboard.
- Kegagalan pengiriman email tidak membatalkan pembayaran yang sudah disetujui.

## 7. Terbitkan Tiket Peserta dan Catat Kehadiran

- Peserta berstatus terdaftar memperoleh tiket dengan **QR code unik**, termasuk peserta kegiatan gratis.
- Panitia memindai QR code untuk mencatat kehadiran saat kegiatan.
- Sistem memeriksa validitas tiket dan kesesuaiannya dengan kegiatan.
- Sistem mencegah pencatatan kehadiran ganda.

## 8. Dashboard dan Laporan

- Peserta dapat melihat kegiatan yang diikuti, status pendaftaran, status pembayaran, alasan penolakan, kuitansi, dan tiket.
- Admin atau panitia berwenang dapat melihat daftar peserta dan status pembayaran.
- Tersedia ekspor **CSV/Excel** untuk data peserta dan pembayaran.

## 9. Hak Akses

- **Peserta:** mengelola pendaftaran serta mengakses bukti pembayaran, kuitansi, dan tiket miliknya sendiri.
- **Panitia:** mengelola peserta, memverifikasi pembayaran, mencatat kehadiran, dan mengekspor laporan sesuai izin pada kegiatan yang ditugaskan.
- **Admin:** mengelola kegiatan, rekening pembayaran, pengguna, hak akses, dan seluruh laporan.
- Pemeriksaan hak akses dilakukan di server, termasuk pada akses file dan ekspor laporan.

## 10. Penyimpanan Aset di Cloudflare R2

- Poster dan aset publik dapat diakses umum.
- Bukti pembayaran, kuitansi, dan tiket disimpan secara privat.
- File privat hanya dapat diakses setelah pemeriksaan hak akses, melalui tautan sementara dengan masa berlaku.
- Kredensial R2 disimpan pada konfigurasi server dan tidak ditampilkan kepada pengguna.

## Alur Utama

Login → lengkapi profil → pilih kegiatan → daftar → transfer → unggah bukti → verifikasi → konfirmasi email dan kuitansi PDF → tiket QR → absensi.

Untuk kegiatan gratis: login → lengkapi profil → daftar → tiket QR → absensi.

## Kriteria Selesai

- Peserta dapat menyelesaikan alur pendaftaran dan pembayaran hingga memperoleh kuitansi serta tiket.
- Pembayaran ditolak dapat diperbaiki dengan unggah ulang sesuai tenggat.
- Pendaftaran ganda dan akses data peserta lain ditolak.
- Panitia dapat memverifikasi pembayaran, mencatat kehadiran, dan mengekspor laporan sesuai izin.
- File tersimpan di R2 dengan akses publik atau privat sesuai kategorinya.
