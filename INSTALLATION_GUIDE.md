# Panduan Instalasi Database Laravel 9 - Aplikasi Pendataan Barang

## Perintah Artisan yang Harus Dijalankan

Setelah semua file Model, Migration, Factory, dan Seeder dibuat, jalankan perintah-perintah berikut secara berurutan:

### 1. Jalankan Migration
```bash
php artisan migrate
```
Perintah ini akan membuat semua tabel database sesuai dengan migration file yang telah dibuat:
- `users` (dengan field role, phone_number)
- `categories`
- `items`
- `invoices`
- `invoice_item` (tabel pivot)

### 2. Jalankan Database Seeder
```bash
php artisan db:seed
```
Perintah ini akan mengisi database dengan data awal:
- **CategorySeeder**: Membuat 5 kategori (Elektronik, Pakaian, Makanan, Peralatan Rumah Tangga, Buku)
- **UserSeeder**: Membuat 1 admin dan 5 user biasa

### 3. (Opsional) Jalankan Migration dan Seeder Sekaligus
```bash
php artisan migrate:fresh --seed
```
Perintah ini akan:
- Menghapus semua tabel yang ada
- Menjalankan ulang migration
- Mengisi database dengan data seeder

### 4. (Opsional) Generate Application Key
```bash
php artisan key:generate
```
Jika application key belum dibuat sebelumnya.

## Data yang Akan Dihasilkan

### User Data:
- **Admin**: 
  - Email: `admin@example.com`
  - Password: `password`
  - Role: `admin`
  - Phone: `08123456789`

- **5 Regular Users**: Dibuat menggunakan factory dengan data random

### Categories:
- Elektronik
- Pakaian
- Makanan
- Peralatan Rumah Tangga
- Buku

## Struktur Database:
```
users
├── id (primary key)
├── name
├── email (unique)
├── email_verified_at
├── password
├── phone_number
├── role (enum: admin, user)
├── remember_token
└── timestamps

categories
├── id (primary key)
├── name
└── timestamps

items
├── id (primary key)
├── category_id (foreign key)
├── name
├── price (integer)
├── quantity (integer)
├── photo (string, path)
└── timestamps

invoices
├── id (primary key)
├── invoice_number (unique, auto-generated)
├── user_id (foreign key)
├── shipping_address
├── postal_code
├── total_price (integer)
└── timestamps

invoice_item (pivot table)
├── id (primary key)
├── invoice_id (foreign key)
├── item_id (foreign key)
├── quantity (integer)
├── subtotal (integer)
└── timestamps
```

## Catatan Tambahan:
1. Pastikan file `.env` sudah dikonfigurasi dengan benar untuk koneksi database
2. Untuk generate nomor invoice otomatis, bisa ditambahkan logic di model atau observer
3. Validasi tingkat Controller/Form Request bisa ditambahkan sesuai kebutuhan
4. File upload untuk foto barang bisa disimpan di folder `storage/app/public/items/`
