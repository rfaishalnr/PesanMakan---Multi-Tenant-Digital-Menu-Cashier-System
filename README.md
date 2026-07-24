<div align="center">

# PesanMakan - SaaS Digital Menu & Point of Sales

Platform SaaS multi-tenant untuk digitalisasi menu restoran, pesanan via QR Code, dan manajemen kasir terintegrasi.

![Laravel](https://img.shields.io/badge/Laravel-11-red?style=flat-square&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.2-blue?style=flat-square&logo=php)
![Filament](https://img.shields.io/badge/Filament-v3-orange?style=flat-square)
![MySQL](https://img.shields.io/badge/MySQL-Database-blue?style=flat-square&logo=mysql)

</div>

---

## Features

- Multi-tenant Dashboard (SaaS)
- Pesanan via QR Code Meja (Scan to Order)
- Integrasi Pembayaran (Midtrans & Manual)
- Manajemen Langganan (Subscription)
- Dynamic QR Generator
- Sistem Ulasan & Rating Menu
- Auto-Expire Transaksi
- Keranjang Belanja (Smart Cart)

---

## Tech Stack

- Laravel
- PHP 8.2
- Filament
- Livewire
- MySQL
- Tailwind CSS
- HTML
- CSS
- JavaScript
- Midtrans API

---

## Installation

Clone repository

```bash
git clone https://github.com/username/repository-name.git
cd repository-name
```

Install dependency

```bash
composer install
```

Copy file environment

```bash
cp .env.example .env
```

Generate application key

```bash
php artisan key:generate
```

Configure database pada file `.env`, kemudian jalankan:

```bash
php artisan migrate --seed
```

Buat symbolic link

```bash
php artisan storage:link
```

Jalankan aplikasi

```bash
php artisan serve
```

Akses melalui

```
http://127.0.0.1:8000
```

Admin Panel

```
http://127.0.0.1:8000/admin
```
