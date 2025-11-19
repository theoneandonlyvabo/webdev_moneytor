<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# 💰 Moneytor

Aplikasi manajemen keuangan pribadi yang modern, responsif, dan mudah digunakan. Dirancang untuk membantu pengguna melacak arus kas, menetapkan anggaran, dan menganalisis kebiasaan belanja demi mencapai kebebasan finansial.

## 📖 Tentang Project

Moneytor bertujuan menyelesaikan masalah pencatatan keuangan yang seringkali rumit dan membosankan. Dengan antarmuka yang bersih dan visualisasi data yang intuitif, pengguna dapat memahami kondisi keuangan mereka hanya dalam sekilas pandang.

## ✨ Fitur Utama

- **Smart Budgeting** — Atur batas pengeluaran per kategori
- **Visual Analytics** — Grafik dan diagram interaktif untuk analisis pengeluaran
- **Expense Tracking** — Pencatatan pemasukan dan pengeluaran real-time
- **Responsive Design** — Tampilan optimal di Desktop, Tablet, dan Mobile

## 🛠 Teknologi

| Komponen | Teknologi | Deskripsi |
|----------|-----------|-----------|
| Framework | Laravel 10.x | Framework PHP yang ekspresif dan elegan |
| Frontend | Blade Templates | Templating engine bawaan Laravel |
| Styling | Tailwind CSS | Utility-first CSS framework untuk styling cepat |
| Bundler | Vite | Frontend build tool generasi baru |
| Database | SQLite / MySQL | Penyimpanan data (SQLite default untuk dev) |

## 💻 Prasyarat Sistem

Pastikan environment lokal Anda memenuhi kriteria berikut:

- PHP >= 8.1
- Composer (Dependency Manager untuk PHP)
- Node.js & NPM (Versi LTS disarankan)
- Git

## 🚀 Instalasi

### 1. Clone Repository

```bash
git clone https://github.com/username/moneytor.git
cd moneytor
```

### 2. Install Dependencies

```bash
# Install dependencies backend
composer install

# Install dependencies frontend
npm install
```

### 3. Konfigurasi Environment

```bash
cp .env.example .env
```

### 4. Generate App Key

```bash
php artisan key:generate
```

### 5. Setup Database (SQLite)

Untuk pengembangan cepat menggunakan SQLite:

```bash
# Windows (PowerShell)
New-Item database/database.sqlite

# Mac / Linux
touch database/database.sqlite
```

Kemudian jalankan migrasi:

```bash
php artisan migrate
```

## ⚙️ Workflow Pengembangan

Project ini menggunakan Vite, yang memerlukan dua proses terminal berjalan secara paralel.

### 1️⃣ Terminal Backend (Laravel)

Menjalankan server aplikasi PHP:

```bash
php artisan serve
```

Akses aplikasi di: `http://127.0.0.1:8000`

### 2️⃣ Terminal Frontend (Vite)

Menjalankan server aset untuk Hot Module Replacement (HMR):

```bash
npm run dev
```

**PENTING:** Terminal ini harus tetap terbuka selama proses coding agar perubahan CSS/JS terlihat.

### Troubleshooting Umum

Jika Anda menemui error: `Illuminate\Foundation\ViteManifestNotFoundException`

**Solusi A:** Pastikan `npm run dev` sedang berjalan.

**Solusi B:** Jika ingin menjalankan tanpa server dev, build aset untuk produksi:

```bash
npm run build
```

## 📂 Struktur Folder

```
moneytor/
├── app/
│   └── Http/Controllers/    # Logika Bisnis (Controller)
├── resources/
│   ├── css/                 # Konfigurasi Tailwind
│   └── views/               # Tampilan Frontend (Blade)
│       ├── layouts/         # Template Induk
│       └── landing.blade.php
├── routes/
│   └── web.php              # Definisi URL/Routing
└── database/                # Migrasi dan Seeder
```

## 🤝 Cara Berkontribusi

Kontribusi sangat dihargai! Silakan ikuti langkah-langkah standar GitHub Flow berikut:

1. Fork repository ini
2. Buat branch fitur baru (`git checkout -b feat/fitur-keren`)
3. Commit perubahan Anda (`git commit -m 'feat: menambahkan fitur keren'`)
4. Push ke branch tersebut (`git push origin feat/fitur-keren`)
5. Buat Pull Request baru

### Konvensi Commit

Kami menggunakan format Semantic Commit Messages:

- `feat:` Fitur baru
- `fix:` Perbaikan bug
- `docs:` Perubahan dokumentasi
- `ui:` Perubahan tampilan/CSS
- `refactor:` Perubahan kode tanpa mengubah fungsi

## 📝 Lisensi

Project ini dilisensikan di bawah [MIT License](LICENSE).

---

<p align="center">Dibuat dengan ❤️ oleh Tim Moneytor</p>