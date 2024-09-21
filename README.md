# Project COPRASS-APP

Project ini adalah aplikasi untuk melakukan penilaian berbasis Sistem Pendukung Keputusan menggunakan metode COPRAS. Aplikasi ini dibangun menggunakan framework Laravel.


## Cara Clone Project

Untuk melakukan clone project ini, ikuti langkah-langkah berikut:

1. Buka terminal atau command prompt.

2. Navigasi ke direktori dimana Anda ingin menyimpan project.

3. Jalankan perintah berikut untuk melakukan clone repository:
   ```
   git clone https://github.com/RanoLangari/SPK-COPRAS.git
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


8. Jika Anda menggunakan Laragon sebagai lingkungan pengembangan, Anda dapat mengikuti langkah-langkah berikut:

   a. Pastikan Laragon sudah terinstal dan semua layanan (Apache/Nginx, MySQL, PHP) sudah berjalan.

   b. Clone repository project Anda ke dalam direktori `www` Laragon dengan menggunakan perintah `git clone https://github.com/RanoLangari/SPK-COPRAS.git`.

   c. Buka Laragon, klik kanan, pilih `Terminal`, dan jalankan perintah `composer install` untuk menginstal semua dependency PHP yang diperlukan dan `npm install` untuk menginstal semua dependency JavaScript yang diperlukan.

   d. Salin file `.env.example` menjadi `.env` dan sesuaikan konfigurasi database dan aplikasi sesuai dengan kebutuhan Anda. Pastikan untuk mengatur `DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, dan `DB_PASSWORD` sesuai dengan pengaturan MySQL di Laragon.

   e. Buka Laragon, klik kanan, lalu pilih `Start All` untuk memulai layanan MySQL.

   f. Jalankan perintah `php artisan key:generate` untuk menghasilkan kunci aplikasi.

   g. Jalankan perintah `php artisan migrate` untuk menjalankan migration dan membuat struktur database.

   h. (Opsional) Jalankan perintah `php artisan db:seed` untuk mengisi database dengan data awal.

    i. Jalankan perintah `npm run dev` untuk mengkompilasi aset JavaScript dan CSS.

   j. Akses project melalui browser dengan URL yang disediakan oleh Laragon (biasanya http://nama-project.test).



