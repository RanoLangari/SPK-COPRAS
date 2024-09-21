# Project COPRASS-APP

Project ini adalah aplikasi untuk melakukan penilaian berbasis Sistem Pendukung Keputusan menggunakan metode COPRAS. Aplikasi ini dibangun menggunakan framework Laravel.

## Cara Clone Project

Untuk melakukan clone project ini, ikuti langkah-langkah berikut:

1. Buka terminal atau command prompt.
2. Navigasi ke direktori dimana Anda ingin menyimpan project.
3. Jalankan perintah berikut untuk melakukan clone repository:
   ```
   git clone https://github.com/username/coprass-app.git
   ```
4. Setelah proses clone selesai, navigasi ke direktori project:
   ```
   cd coprass-app
   ```

## Cara Menjalankan Project

Ikuti langkah-langkah berikut untuk menjalankan project:

1. Salin file `.env.example` menjadi `.env` dan sesuaikan konfigurasi database dan aplikasi sesuai dengan kebutuhan Anda:
   ```
   cp .env.example .env
   ```
2. Install semua dependency yang diperlukan menggunakan npm:
   ```
   npm install
   ```
3. Install semua dependency yang diperlukan menggunakan composer:
   ```
   composer install
   ```
4. Generate key aplikasi:
   ```
   php artisan key:generate
   ```
5. Jalankan migration untuk membuat struktur database:
   ```
   php artisan migrate
   ```
6. (Opsional) Jalankan seeder untuk mengisi database dengan data awal:
   ```
   php artisan db:seed
   ```
7. Jalankan Vite Menggunakan perintah:
   ```
   npm run dev
   ```
6. Jalankan server pengembangan Laravel menggunakan perintah:
   ```
   php artisan serve
   ```
7. Buka browser dan akses aplikasi melalui URL yang diberikan oleh server pengembangan (biasanya http://localhost:8000).

