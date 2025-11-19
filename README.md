<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

💰 Moneytor - Developer Handbook

Selamat datang di repository project Moneytor. Dokumen ini berisi panduan teknis, workflow, dan standar yang digunakan untuk pengembangan aplikasi ini.

🛠 Tech Stack & Requirements

Pastikan environment lokal kamu memenuhi syarat berikut sebelum memulai.

## Core Frameworks

• Backend: Laravel 10.x / 11.x (PHP Framework)
• Frontend: Blade Templates (Native Laravel Templating)
• Styling: Tailwind CSS (Utility-first CSS)
• Bundler: Vite (Asset Compilation)
• Database: SQLite (untuk Development) / MySQL (untuk Production)

## Prerequisites (Wajib Install)

• PHP >= 8.1
• Composer (PHP Package Manager)
• Node.js & NPM (Untuk compile Tailwind CSS)

## Git (Version Control)

🚀 Getting Started (Instalasi Awal)

Jika kamu baru saja clone repository ini, ikuti langkah berikut secara berurutan:

1. Clone & Masuk Directory

git clone <repository_url>
cd moneytor


2. Install Dependencies (Backend & Frontend)

composer install
npm install


3. Setup Environment Variables

Duplikat file .env.example menjadi .env:

cp .env.example .env

Buka file .env dan pastikan DB_CONNECTION=sqlite (atau sesuaikan dengan database lokalmu).

Generate App Key

php artisan key:generate


Setup Database
Jika menggunakan SQLite, buat file kosong di folder database:

Windows (PowerShell): New-Item database/database.sqlite

Mac/Linux: touch database/database.sqlite

Lalu jalankan migrasi:

php artisan migrate


⚙️ Development Workflow (Cara Menjalankan Project)

PENTING: Karena kita menggunakan Vite untuk Tailwind CSS, kamu harus menjalankan DUA TERMINAL secara bersamaan.

Terminal 1: Backend Server (Laravel)

Terminal ini menangani request PHP dan database.

php artisan serve
# Server akan jalan di [http://127.0.0.1:8000](http://127.0.0.1:8000)


Terminal 2: Frontend Watcher (Vite)

Terminal ini akan memantau perubahan di file CSS/Blade dan melakukan update otomatis (Hot Reload).

npm run dev
# Jangan tutup terminal ini saat coding!


⚠️ Troubleshooting Umum

Jika kamu melihat error ViteManifestNotFoundException:

Artinya npm run dev belum jalan, ATAU

Kamu perlu build aset statis (jika tidak ingin menjalankan npm run dev terus-menerus):

npm run build


📂 Struktur Folder Penting

Fokus utama pengembangan ada di folder-folder ini:

routes/web.php → Routing. Tempat mendefinisikan URL (misal: /login, /dashboard).

resources/views/ → Frontend (Blade).

layouts/ → Template induk (Header, Footer, Navbar).

components/ → Elemen ulang pakai (Button, Card, Input).

landing.blade.php → Halaman utama.

app/Http/Controllers/ → Logika Backend.

resources/css/app.css → Entry point Tailwind CSS.

🤝 Git Workflow & Collaboration

Agar tidak terjadi konflik kode (merge conflict), ikuti aturan ini:

Main Branch (main atau master)

Hanya berisi kode yang stabil dan siap deploy.

Jangan coding langsung di sini!

Membuat Fitur Baru
Selalu buat branch baru dari main:

git checkout -b fitur/nama-fitur-kamu
# Contoh: git checkout -b fitur/login-page


Commit Messages
Gunakan Bahasa Inggris/Indonesia yang jelas.

✅ feat: add login form UI

✅ fix: perbaiki tombol tidak bisa diklik

❌ update

❌ fix

Pull Request (PR)
Setelah selesai, push ke repository dan buat Pull Request untuk di-review oleh tim.

🎨 Tailwind CSS Guidelines

Kita tidak menggunakan CSS murni (style.css) kecuali terpaksa. Gunakan utility class Tailwind langsung di HTML.

Contoh Benar:

<button class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
    Simpan
</button>


Contoh Salah (Hindari Inline Style):

<button style="background-color: blue; padding: 10px;">
    Simpan
</button>


Happy Coding! 🚀
Jika ada kendala, hubungi Lead Developer atau cek dokumentasi Laravel.