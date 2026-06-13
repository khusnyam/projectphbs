# 🔧 Setup Instructions untuk Mengatasi Error 403

Jika Anda mengalami error **"403 This action is unauthorized"** setelah login, ikuti langkah-langkah di bawah ini:

## ✅ Opsi 1: Automatic Setup (Recommended)

### Windows Users:
1. Buka **File Explorer**
2. Navigasi ke: `c:\laragon\laragon\www\projectphbs\`
3. Double-click file **`setup.bat`**
4. Tunggu hingga selesai (akan ada beberapa error messages, it's normal)
5. Tutup terminal window

### Mac/Linux Users:
Buka terminal dan jalankan:
```bash
cd /path/to/projectphbs
bash setup.sh
```

---

## ✅ Opsi 2: Manual Setup (Step by Step)

Buka **Terminal/Command Prompt** dan navigasi ke folder project:

```bash
cd c:\laragon\laragon\www\projectphbs
```

### Step 1: Run Database Migrations
```bash
php artisan migrate --force
```
Output yang diharapkan: akan ada list migrations yang di-run

### Step 2: Seed Database dengan User Data
```bash
php artisan db:seed --class=UserSeeder
```
Output yang diharapkan: "UserSeeder: Seeded successfully"

### Step 3: Clear All Cache
```bash
php artisan cache:clear
php artisan config:clear  
php artisan route:clear
```

---

## 🚀 Setelah Setup Selesai

Refresh browser Anda dan coba login kembali dengan:

**DINKES (Admin Dinas Kesehatan):**
- 📧 Email: `dkk.sleman@dinkes.com`
- 🔑 Password: `dkk123`

**PUSKESMAS:**
- 📧 Email: `gamping1@puskesmas.go.id`
- 🔑 Password: `pkm123`

---

## 🐛 Jika Masih Error 403

Jika masih error 403 setelah setup, cek log file:
```bash
cat storage/logs/laravel.log
```

Dan bagikan output error tersebut untuk debugging lebih lanjut.

---

## 📝 Apa yang dilakukan setup?

1. **Migrate** - Membuat semua table di database (users, roles, puskesmas, data_phbs, dll)
2. **Seed** - Mengisi user data dengan credentials untuk login
3. **Clear Cache** - Menghapus cache Laravel agar perubahan langsung ter-apply

Ini adalah setup yang hanya perlu dilakukan **SEKALI** saja di awal development.
