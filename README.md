# Sistem Informasi Pelayanan Fatimah

## Deskripsi Project

Sistem Informasi Pelayanan merupakan aplikasi berbasis web yang dibangun menggunakan framework Laravel. Aplikasi ini bertujuan untuk membantu proses pengelolaan data pelayanan secara terkomputerisasi sehingga proses pencatatan, verifikasi, serta pelaporan dapat dilakukan dengan lebih cepat, akurat, dan efisien.

Aplikasi menyediakan hak akses berdasarkan peran pengguna sehingga setiap pengguna hanya dapat mengakses fitur sesuai kewenangannya.

---

## Teknologi yang Digunakan

- PHP 8.x
- Laravel 11
- MySQL
- Bootstrap 5
- JavaScript
- Chart.js
- Laravel Excel (Maatwebsite)
- DomPDF

---

## Fitur Utama

### Admin

- Login
- Dashboard
- Manajemen Data User
- Manajemen Data Pelayanan
- Verifikasi Data
- Export Data ke Excel
- Export Data ke PDF
- Manajemen Laporan

### Petugas

- Login
- Dashboard
- Input Data Pelayanan
- Mengelola Data Pelayanan
- Melihat Status Verifikasi

---

## Struktur Project

```
app/
bootstrap/
config/
database/
public/
resources/
routes/
storage/
```

Project menggunakan struktur standar Laravel sehingga mudah dikembangkan dan dipelihara.

---

## Instalasi

### 1. Clone Repository

```bash
git clone https://github.com/sitiiftmh/mpp-batam 
```

atau download project dalam bentuk ZIP.

---

### 2. Masuk ke Folder Project

```bash
cd nama-project
```

---

### 3. Install Dependency

```bash
composer install
```

---

### 4. Install Dependency Frontend

```bash
npm install
```

---

### 5. Salin File Environment

```bash
cp .env.example .env
```

Windows

```bash
copy .env.example .env
```

---

### 6. Generate Application Key

```bash
php artisan key:generate
```

---

### 7. Konfigurasi Database

Edit file **.env**

```
DB_DATABASE=nama_database
DB_USERNAME=root
DB_PASSWORD=
```

---

### 8. Jalankan Migration

```bash
php artisan migrate
```

Jika tersedia seeder

```bash
php artisan db:seed
```

---

### 9. Jalankan Project

```bash
php artisan serve
```

Kemudian buka browser

```
http://127.0.0.1:8000
```

---

## Hak Akses

Aplikasi memiliki dua jenis pengguna yaitu:

- Admin
- Petugas

Masing-masing memiliki hak akses sesuai tugas dan tanggung jawabnya.

---

## Keamanan

Project menerapkan beberapa mekanisme keamanan bawaan Laravel, antara lain:

- Authentication Laravel
- Middleware Authorization
- Validasi Form
- CSRF Protection
- Session Management
- Password Hashing

---

## Library yang Digunakan

- Laravel Framework
- Laravel Excel
- DomPDF
- Bootstrap
- Chart.js

---

## Pengembang

Nama Mahasiswa : Siti Fatimah
NIM            : 3312311011
Program Studi  : Teknik Informatika
Universitas    : Politeknik Batam

---

## Lisensi

Project ini dibuat sebagai media pembelajaran dan penyelesaian tugas akademik.