# 📚 Sistem Perpustakaan

Sistem Perpustakaan adalah aplikasi berbasis web yang dikembangkan menggunakan **Laravel 11** dan **AdminLTE 3** untuk membantu manajemen data perpustakaan, termasuk pengguna, buku, kategori, transaksi peminjaman, dan pengelolaan hak akses.

## ✨ Fitur Utama
- **Dashboard**: Menampilkan ringkasan informasi perpustakaan.
- **Koleksi Buku**
- **Manajemen Master Data**:
  - Pengguna
  - Kategori
  - Penerbit
  - Penulis
  - Buku
- **Transaksi**:
  - Booking Buku
  - Peminjaman Buku
- **Manajemen Hak Akses**:
  - Role & Permission menggunakan `laravel-permission`
  - Pengelolaan menu dan izin berdasarkan peran
- **Tampilan Responsive**: Menggunakan **AdminLTE 3** untuk UI yang modern dan responsif.

## 🛠 Teknologi yang Digunakan
- **Laravel 11** (Framework PHP)
- **AdminLTE 3** (Template Admin)
- **Laravel Permission** (Manajemen Role & Permission)
- **WSL + PHP 8.3-FPM** (Lingkungan Pengembangan)
- **MySQL / PostgreSQL** (Database Management)

## 🚀 Instalasi dan Konfigurasi
### 1️⃣ Clone Repository
```bash
git clone https://github.com/username/sistem-perpustakaan.git
cd sistem-perpustakaan
```

### 2️⃣ Install Dependencies
```bash
composer install
npm install && npm run build
```

### 3️⃣ Konfigurasi Environment
Salin file `.env.example` menjadi `.env` dan sesuaikan konfigurasi database:
```bash
cp .env.example .env
php artisan key:generate
```

### 4️⃣ Migrasi Database dan Seeder
```bash
php artisan migrate --seed
```

### 5️⃣ Menjalankan Server
```bash
php artisan serve
```
Akses aplikasi melalui `http://127.0.0.1:8000`

## 🔐 Hak Akses Default
| Role  | Email                 | Password |
|-------|-----------------------|----------|
| Admin | -----------------     | -------- |
| User  | -----------------     | -------- |

## 📜 Lisensi
Proyek ini dibuat oleh **Ahmad Mukmin Jamaludin** dan dapat digunakan sesuai dengan lisensi yang berlaku.

## 🤝 Kontribusi
Silakan buat **Pull Request** atau **Issue** jika ingin berkontribusi!

---

📌 **Kontak Pengembang:**
- ✉ Email: jamaludinscape@gmail.com
- 🔗 GitHub: [github.com/AhmadMukminJamaludin](https://github.com/AhmadMukminJamaludin)

