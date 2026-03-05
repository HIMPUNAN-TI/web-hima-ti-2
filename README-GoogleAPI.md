# Panduan Setup Google Sheets API

Fitur sinkronisasi data event ke Google Sheets menggunakan API dari Google. Mengingat file kredensial tidak disertakan dalam repository ini demi keamanan, Anda perlu membuat file kredensial tersebut secara manual terlebih dahulu.

Berikut adalah langkah-langkah **Step-by-Step** untuk menjalankan integrasi tersebut.

## 1. Persiapkan File `.env`
Pastikan Anda sudah memiliki file `.env` di project Anda (biasanya dari proses *copy* file `.env.example`).
Tambahkan atau sesuaikan variabel `GOOGLE_SPREADSHEET_ID` di dalam `config` / file `.env` Anda dengan ID dokumen Spreadsheet yang akan Anda gunakan:

```env
GOOGLE_SPREADSHEET_ID=1mMPbjdfgyCaMcL65Ja1wU5UbpcI4fHCJFI2YPUTlMbM
```


## 2. Buat File `credential.json`
\
```json
https://drive.google.com/drive/folders/1JL_mCMkzEDL5UxfF6NQXVd_FUB_YzeJV?usp=sharing
```
Download file credential.json dari link di atas
Masuklah ke folder `storage/app` pada *directory* project Anda. 
Setelah itu, **salin (*copy*) file JSON dari google drive* 


## 3. Jalankan command untuk instalasi library google
Setelah sudah buat file credential.json

jalankan command
composer install

lalu jalankan server
php artisan serve

npm install
npm run dev
```

## 4. Jalankan Command Sinkronisasi
Setelah semua persiapan di atas selesai, Anda kini siap untuk mulai menyinkronkan data.

- Jika ini adalah **sinkronisasi pertama kali**, Anda bisa mengirimkan struktur header kolom (berada di Baris 1) menggunakan parameter `--init` pada command:
  ```bash
  php artisan sheets:sync-events --init
  ```

- Untuk **sinkronisasi rutin** selanjutnya (memperbarui baris data di bawah *header*), jalankan command:
  ```bash
  php artisan sheets:sync-events
  ```

Selamat, data Event Anda seharusnya sudah tersinkronisasi ke Google Sheets!






