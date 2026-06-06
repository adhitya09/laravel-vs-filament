# Laporan Perhitungan LOC (Lines of Code)
## Sistem POS Laravel 12 Konvensional

> **Basis laporan:** Laporan ini disusun agar klasifikasi fiturnya seimbang dengan laporan Laravel Filament, terutama pada penempatan file migrasi user, pengecualian seeder, dan pemisahan file shared/common.

## 1. Identitas Perhitungan

| Komponen | Keterangan |
|---|---|
| Sistem | POS Laravel 12 Konvensional |
| Metode | Physical Lines of Code (PLOC) |
| Aturan hitung | Menghitung baris kode fisik aktif, tanpa blank line dan tanpa komentar |
| Basis data | Hasil scan file Laravel 12 Konvensional yang dikirimkan |
| Cakupan | Controller, middleware, model, helper, route, Blade view, JavaScript, config, migration, dan export custom |
| Pengecualian | File testing, seeder, factory, file log, asset hasil build, `vendor/`, `node_modules/`, `public/build/`, `storage/`, dan `bootstrap/cache/` |
| Catatan route | `routes/web.php` dipisahkan ke bagian Shared/Common karena pada Laravel konvensional file ini memuat banyak route manual lintas fitur |

## 2. Detail Perhitungan LOC per Fitur

### 2.1. Fitur: Login / Authentication

**Alasan pengelompokan:** Fitur Login/Authentication digunakan untuk proses autentikasi pengguna, validasi login, session, profil pengguna, konfigurasi autentikasi, dan struktur tabel user sebagai dasar autentikasi.

| No | File | Jenis File | LOC | Keterangan |
|---:|---|---|---:|---|
| 1 | `app/Http/Controllers/AuthController.php` | Controller | 74 | Mengelola proses login, logout, validasi kredensial, dan session pengguna |
| 2 | `app/Models/User.php` | Model | 101 | Shared File: digunakan pada Login / Authentication dan User Management |
| 3 | `app/Http/Middleware/PermissionMiddleware.php` | Middleware | 62 | Shared File: digunakan untuk pembatasan akses berdasarkan permission |
| 4 | `resources/views/auth/login.blade.php` | Blade View | 59 | Tampilan halaman login |
| 5 | `resources/views/auth/profile.blade.php` | Blade View | 60 | Tampilan profil pengguna |
| 6 | `config/auth.php` | Config | 28 | Konfigurasi autentikasi Laravel |
| 7 | `database/migrations/0001_01_01_000000_create_users_table.php` | Migration | 38 | Struktur tabel user sebagai dasar autentikasi dan manajemen user |

**Total LOC:** 422  
**Total File:** 7  
**Jenis File Dominan:** Model  
**Tingkat Kompleksitas:** Sedang

---

### 2.2. Fitur: Dashboard

**Alasan pengelompokan:** Dashboard digunakan untuk menampilkan ringkasan data utama sistem POS dalam bentuk tampilan dashboard.

| No | File | Jenis File | LOC | Keterangan |
|---:|---|---|---:|---|
| 1 | `app/Http/Controllers/DashboardController.php` | Controller | 97 | Controller untuk mengambil dan mengolah data ringkasan dashboard |
| 2 | `resources/views/pages/dashboard.blade.php` | Blade View | 200 | Tampilan dashboard utama sistem |

**Total LOC:** 297  
**Total File:** 2  
**Jenis File Dominan:** Blade View  
**Tingkat Kompleksitas:** Rendah

---

### 2.3. Fitur: POS / Kasir

**Alasan pengelompokan:** Fitur POS/Kasir merupakan fitur inti sistem yang mencakup proses transaksi penjualan, pemilihan produk, metode pembayaran, dan pencetakan resi.

| No | File | Jenis File | LOC | Keterangan |
|---:|---|---|---:|---|
| 1 | `app/Http/Controllers/PosController.php` | Controller | 161 | Controller utama proses POS/Kasir |
| 2 | `resources/views/pages/pos/index.blade.php` | Blade View | 831 | Tampilan utama halaman POS/Kasir |
| 3 | `resources/views/pages/pos/resi.blade.php` | Blade View | 166 | Tampilan resi transaksi |
| 4 | `app/Models/Product.php` | Model | 49 | Shared File: digunakan pada POS / Kasir dan Produk |
| 5 | `app/Models/Transaction.php` | Model | 32 | Shared File: digunakan pada POS / Kasir dan Transaksi |
| 6 | `app/Models/PaymentMethod.php` | Model | 32 | Shared File: digunakan pada POS / Kasir dan Payment Method |

**Total LOC:** 1.271  
**Total File:** 6  
**Jenis File Dominan:** Blade View  
**Tingkat Kompleksitas:** Sangat Tinggi

---

### 2.4. Fitur: Produk

**Alasan pengelompokan:** Fitur Produk digunakan untuk pengelolaan data produk, harga, stok, barcode, status produk, dan tampilan detail produk.

| No | File | Jenis File | LOC | Keterangan |
|---:|---|---|---:|---|
| 1 | `app/Http/Controllers/ProdukController.php` | Controller | 214 | Controller CRUD produk |
| 2 | `app/Models/Product.php` | Model | 49 | Shared File: digunakan pada POS / Kasir dan Produk |
| 3 | `resources/views/pages/produk/index.blade.php` | Blade View | 247 | Tampilan daftar produk |
| 4 | `resources/views/pages/produk/create.blade.php` | Blade View | 41 | Tampilan tambah produk |
| 5 | `resources/views/pages/produk/edit.blade.php` | Blade View | 42 | Tampilan edit produk |
| 6 | `resources/views/pages/produk/show.blade.php` | Blade View | 76 | Tampilan detail produk |
| 7 | `resources/views/pages/produk/barcode-pdf.blade.php` | Blade View | 117 | Tampilan cetak barcode produk |
| 8 | `database/migrations/2026_04_19_155812_create_products_table.php` | Migration | 26 | Struktur tabel produk |
| 9 | `database/migrations/2026_04_20_100000_add_cost_price_barcode_is_active_to_products_table.php` | Migration | 21 | Penambahan field harga modal, barcode, dan status aktif produk |

**Total LOC:** 833  
**Total File:** 9  
**Jenis File Dominan:** Blade View  
**Tingkat Kompleksitas:** Tinggi

---

### 2.5. Fitur: Kategori

**Alasan pengelompokan:** Fitur Kategori digunakan untuk mengelompokkan produk berdasarkan kategori tertentu sehingga data produk lebih terstruktur.

| No | File | Jenis File | LOC | Keterangan |
|---:|---|---|---:|---|
| 1 | `app/Http/Controllers/KategoriController.php` | Controller | 50 | Controller CRUD kategori |
| 2 | `app/Models/Category.php` | Model | 17 | Model data kategori |
| 3 | `resources/views/pages/kategori/index.blade.php` | Blade View | 69 | Tampilan daftar kategori |
| 4 | `resources/views/pages/kategori/create.blade.php` | Blade View | 51 | Tampilan tambah kategori |
| 5 | `resources/views/pages/kategori/edit.blade.php` | Blade View | 112 | Tampilan edit kategori |
| 6 | `database/migrations/2026_04_19_155753_create_categories_table.php` | Migration | 21 | Struktur tabel kategori |

**Total LOC:** 320  
**Total File:** 6  
**Jenis File Dominan:** Blade View  
**Tingkat Kompleksitas:** Sedang

---

### 2.6. Fitur: Inventory

**Alasan pengelompokan:** Inventory digunakan untuk pengelolaan stok barang, item inventory, stok masuk, stok keluar, dan penyesuaian stok.

| No | File | Jenis File | LOC | Keterangan |
|---:|---|---|---:|---|
| 1 | `app/Http/Controllers/InventoryController.php` | Controller | 128 | Controller utama inventory |
| 2 | `app/Models/Inventory.php` | Model | 23 | Model inventory |
| 3 | `app/Models/InventoryItem.php` | Model | 24 | Model item inventory |
| 4 | `resources/views/pages/inventory/index.blade.php` | Blade View | 395 | Tampilan daftar inventory |
| 5 | `resources/views/pages/inventory/create.blade.php` | Blade View | 229 | Tampilan tambah inventory |
| 6 | `resources/views/pages/inventory/edit.blade.php` | Blade View | 93 | Tampilan edit inventory |
| 7 | `resources/views/pages/inventory/show.blade.php` | Blade View | 94 | Tampilan detail inventory |
| 8 | `database/migrations/2026_04_19_155943_create_inventories_table.php` | Migration | 22 | Struktur tabel inventory |
| 9 | `database/migrations/2026_04_19_155947_create_inventory_items_table.php` | Migration | 22 | Struktur tabel item inventory |
| 10 | `database/migrations/2026_04_20_120000_add_source_and_total_modal_to_inventories_table.php` | Migration | 20 | Penambahan field sumber dan total modal inventory |

**Total LOC:** 1.050  
**Total File:** 10  
**Jenis File Dominan:** Blade View  
**Tingkat Kompleksitas:** Tinggi

---

### 2.7. Fitur: Transaksi

**Alasan pengelompokan:** Fitur Transaksi digunakan untuk mengelola daftar transaksi, pembuatan transaksi, edit transaksi, detail transaksi, item transaksi, dan dokumen transaksi.

| No | File | Jenis File | LOC | Keterangan |
|---:|---|---|---:|---|
| 1 | `app/Http/Controllers/TransaksiController.php` | Controller | 218 | Controller utama transaksi |
| 2 | `app/Models/Transaction.php` | Model | 32 | Shared File: digunakan pada POS / Kasir dan Transaksi |
| 3 | `app/Models/TransactionItem.php` | Model | 26 | Model item transaksi |
| 4 | `resources/views/pages/transaksi/index.blade.php` | Blade View | 360 | Tampilan daftar transaksi |
| 5 | `resources/views/pages/transaksi/create.blade.php` | Blade View | 51 | Tampilan tambah transaksi |
| 6 | `resources/views/pages/transaksi/edit.blade.php` | Blade View | 320 | Tampilan edit transaksi |
| 7 | `resources/views/pages/transaksi/show.blade.php` | Blade View | 192 | Tampilan detail transaksi |
| 8 | `resources/views/pages/transaksi/pdf.blade.php` | Blade View | 153 | Tampilan PDF transaksi |
| 9 | `database/migrations/2026_04_19_155931_create_transactions_table.php` | Migration | 26 | Struktur tabel transaksi |
| 10 | `database/migrations/2026_04_19_155938_create_transaction_items_table.php` | Migration | 23 | Struktur tabel item transaksi |

**Total LOC:** 1.401  
**Total File:** 10  
**Jenis File Dominan:** Blade View  
**Tingkat Kompleksitas:** Sangat Tinggi

---

### 2.8. Fitur: CashFlow

**Alasan pengelompokan:** CashFlow digunakan untuk pencatatan pemasukan, pengeluaran, sumber arus kas, dan pengelolaan cashbox flow.

| No | File | Jenis File | LOC | Keterangan |
|---:|---|---|---:|---|
| 1 | `app/Http/Controllers/CashFlowController.php` | Controller | 131 | Controller utama cashflow |
| 2 | `app/Models/CashFlow.php` | Model | 19 | Model cashflow |
| 3 | `app/Models/CashboxFlow.php` | Model | 56 | Model cashbox flow |
| 4 | `app/Models/CashFlowSource.php` | Model | 29 | Model sumber cashflow |
| 5 | `resources/views/pages/cashflow/index.blade.php` | Blade View | 335 | Tampilan cashflow |
| 6 | `database/migrations/2026_04_19_155953_create_cash_flows_table.php` | Migration | 25 | Struktur tabel cashflow |
| 7 | `database/migrations/2026_04_21_000001_create_cash_flow_sources_table.php` | Migration | 22 | Struktur tabel sumber cashflow |
| 8 | `database/migrations/2026_04_21_000002_create_cashbox_flows_table.php` | Migration | 27 | Struktur tabel cashbox flow |
| 9 | `database/migrations/2026_04_22_000000_add_fields_to_cashbox_flows.php` | Migration | 21 | Penambahan field cashbox flow |

**Total LOC:** 665  
**Total File:** 9  
**Jenis File Dominan:** Blade View  
**Tingkat Kompleksitas:** Sedang

---

### 2.9. Fitur: Payment Method

**Alasan pengelompokan:** Payment Method digunakan untuk mengelola metode pembayaran transaksi seperti tunai, QRIS, transfer, kartu, atau e-wallet.

| No | File | Jenis File | LOC | Keterangan |
|---:|---|---|---:|---|
| 1 | `app/Http/Controllers/PaymentMethodController.php` | Controller | 81 | Controller CRUD metode pembayaran |
| 2 | `app/Models/PaymentMethod.php` | Model | 32 | Shared File: digunakan pada POS / Kasir dan Payment Method |
| 3 | `resources/views/pages/payment-method/index.blade.php` | Blade View | 114 | Tampilan daftar metode pembayaran |
| 4 | `resources/views/pages/payment-method/create.blade.php` | Blade View | 43 | Tampilan tambah metode pembayaran |
| 5 | `resources/views/pages/payment-method/edit.blade.php` | Blade View | 41 | Tampilan edit metode pembayaran |
| 6 | `database/migrations/2026_04_19_155918_create_payment_methods_table.php` | Migration | 22 | Struktur tabel metode pembayaran |
| 7 | `database/migrations/2026_04_20_000000_add_logo_and_is_cash_to_payment_methods_table.php` | Migration | 20 | Penambahan field logo dan status cash |

**Total LOC:** 353  
**Total File:** 7  
**Jenis File Dominan:** Blade View  
**Tingkat Kompleksitas:** Rendah

---

### 2.10. Fitur: Report / Laporan

**Alasan pengelompokan:** Fitur Report/Laporan digunakan untuk menampilkan, mencetak, dan mengekspor laporan keuangan sistem.

| No | File | Jenis File | LOC | Keterangan |
|---:|---|---|---:|---|
| 1 | `app/Http/Controllers/ReportController.php` | Controller | 169 | Controller utama laporan |
| 2 | `app/Models/Report.php` | Model | 55 | Model laporan |
| 3 | `resources/views/pages/report/index.blade.php` | Blade View | 203 | Tampilan halaman laporan |
| 4 | `resources/views/pages/report/laporan-pdf.blade.php` | Blade View | 167 | Tampilan PDF laporan |
| 5 | `app/Exports/LaporanKeuanganExport.php` | Export | 103 | Export laporan keuangan |
| 6 | `database/migrations/2026_05_20_000001_create_reports_table.php` | Migration | 23 | Struktur tabel laporan |

**Total LOC:** 720  
**Total File:** 6  
**Jenis File Dominan:** Blade View  
**Tingkat Kompleksitas:** Tinggi

---

### 2.11. Fitur: User Management

**Alasan pengelompokan:** User Management digunakan untuk pengelolaan data pengguna sistem. File migration user tidak dimasukkan di sini karena sudah dihitung pada Login / Authentication agar seimbang dengan klasifikasi Laravel Filament.

| No | File | Jenis File | LOC | Keterangan |
|---:|---|---|---:|---|
| 1 | `app/Http/Controllers/UserController.php` | Controller | 80 | Controller CRUD user |
| 2 | `app/Models/User.php` | Model | 101 | Shared File: digunakan pada Login / Authentication dan User Management |
| 3 | `resources/views/pages/user/index.blade.php` | Blade View | 246 | Tampilan daftar user |
| 4 | `resources/views/pages/user/create.blade.php` | Blade View | 73 | Tampilan tambah user |
| 5 | `resources/views/pages/user/edit.blade.php` | Blade View | 59 | Tampilan edit user |
| 6 | `database/migrations/2026_05_05_000001_add_role_id_to_users_table.php` | Migration | 23 | Penambahan relasi role pada tabel user |

**Total LOC:** 582  
**Total File:** 6  
**Jenis File Dominan:** Blade View  
**Tingkat Kompleksitas:** Sedang

---

### 2.12. Fitur: Role / Permission

**Alasan pengelompokan:** Role/Permission digunakan untuk mengelola role, hak akses, middleware otorisasi, dan pembatasan akses fitur.

| No | File | Jenis File | LOC | Keterangan |
|---:|---|---|---:|---|
| 1 | `app/Http/Controllers/RoleController.php` | Controller | 166 | Controller CRUD role dan permission |
| 2 | `app/Http/Middleware/PermissionMiddleware.php` | Middleware | 62 | Shared File: digunakan untuk pembatasan akses |
| 3 | `app/Models/Role.php` | Model | 14 | Model role |
| 4 | `resources/views/pages/role/index.blade.php` | Blade View | 73 | Tampilan daftar role |
| 5 | `resources/views/pages/role/create.blade.php` | Blade View | 112 | Tampilan tambah role |
| 6 | `resources/views/pages/role/edit.blade.php` | Blade View | 131 | Tampilan edit role |
| 7 | `database/migrations/2026_04_19_160000_create_roles_table.php` | Migration | 21 | Struktur tabel role |

**Total LOC:** 579  
**Total File:** 7  
**Jenis File Dominan:** Controller  
**Tingkat Kompleksitas:** Sedang

---

### 2.13. Fitur: Setting

**Alasan pengelompokan:** Fitur Setting digunakan untuk konfigurasi umum sistem seperti identitas toko, alamat, telepon, logo, dan pengaturan printer.

| No | File | Jenis File | LOC | Keterangan |
|---:|---|---|---:|---|
| 1 | `app/Http/Controllers/SettingController.php` | Controller | 40 | Controller pengaturan sistem |
| 2 | `app/Models/Setting.php` | Model | 21 | Model setting |
| 3 | `resources/views/pages/setting/index.blade.php` | Blade View | 236 | Tampilan halaman setting |
| 4 | `database/migrations/2026_04_28_000001_create_settings_table.php` | Migration | 24 | Struktur tabel setting |

**Total LOC:** 321  
**Total File:** 4  
**Jenis File Dominan:** Blade View  
**Tingkat Kompleksitas:** Rendah

---

## 3. Rekapitulasi Total Seluruh Fitur Utama

| No | Fitur | Total LOC | Total File | Jenis File Dominan | Tingkat Kompleksitas |
|---:|---|---:|---:|---|---|
| 1 | Login / Authentication | 422 | 7 | Model | Sedang |
| 2 | Dashboard | 297 | 2 | Blade View | Rendah |
| 3 | POS / Kasir | 1.271 | 6 | Blade View | Sangat Tinggi |
| 4 | Produk | 833 | 9 | Blade View | Tinggi |
| 5 | Kategori | 320 | 6 | Blade View | Sedang |
| 6 | Inventory | 1.050 | 10 | Blade View | Tinggi |
| 7 | Transaksi | 1.401 | 10 | Blade View | Sangat Tinggi |
| 8 | CashFlow | 665 | 9 | Blade View | Sedang |
| 9 | Payment Method | 353 | 7 | Blade View | Rendah |
| 10 | Report / Laporan | 720 | 6 | Blade View | Tinggi |
| 11 | User Management | 582 | 6 | Blade View | Sedang |
| 12 | Role / Permission | 579 | 7 | Controller | Sedang |
| 13 | Setting | 321 | 4 | Blade View | Rendah |
|  | **Total** | **8.814** | **89** |  |  |

## 4. Ringkasan Keseluruhan Project

| Aspek | Hasil |
|---|---:|
| Total LOC Seluruh Fitur Utama | 8.814 LOC |
| Total File Seluruh Fitur Utama | 89 File/Entri |
| Total LOC Shared/Common | 1.598 LOC |
| Total File Shared/Common | 16 File/Entri |
| Total LOC Project Unik | 10.136 LOC |
| Total File Unik Project | 100 File |
| Rata-rata LOC per Fitur Utama | 678 LOC |
| Fitur dengan LOC Terbesar | Transaksi (1.401 LOC) |
| Fitur dengan LOC Terkecil | Dashboard (297 LOC) |
| Dominasi Arsitektur | Controller dan Blade View |
| Tingkat Otomatisasi Framework | Rendah |
| Dominasi Business Logic Manual | Transaksi dan POS / Kasir |

## 5. Shared/Common Code

Bagian ini berisi file pendukung global yang digunakan lintas fitur. Bagian ini dipisahkan dari 13 fitur utama agar struktur laporan lebih seimbang dengan laporan Laravel Filament.

| No | File | Jenis File | LOC | Keterangan |
|---:|---|---|---:|---|
| 1 | `app/Http/Controllers/Controller.php` | Controller | 5 | Base controller Laravel |
| 2 | `routes/web.php` | Route | 132 | Route manual lintas fitur |
| 3 | `config/app.php` | Config | 22 | Konfigurasi aplikasi |
| 4 | `config/database.php` | Config | 109 | Konfigurasi database |
| 5 | `app/Helpers/MenuHelper.php` | Helper | 106 | Helper menu/sidebar |
| 6 | `resources/views/layouts/app.blade.php` | Blade View | 108 | Layout utama aplikasi |
| 7 | `resources/views/components/confirm-modal.blade.php` | Blade View | 13 | Komponen modal konfirmasi |
| 8 | `resources/views/components/table-footer.blade.php` | Blade View | 46 | Komponen footer tabel |
| 9 | `resources/views/components/ui/badge.blade.php` | Blade View | 45 | Komponen badge UI |
| 10 | `resources/views/components/ui/button.blade.php` | Blade View | 52 | Komponen button UI |
| 11 | `resources/views/components/ui/modal.blade.php` | Blade View | 62 | Komponen modal UI |
| 12 | `resources/views/partials/navbar.blade.php` | Blade View | 90 | Navbar aplikasi |
| 13 | `resources/views/partials/sidebar.blade.php` | Blade View | 253 | Sidebar aplikasi |
| 14 | `resources/views/welcome.blade.php` | Blade View | 264 | Halaman awal aplikasi |
| 15 | `resources/js/app.js` | JavaScript | 288 | JavaScript utama aplikasi |
| 16 | `resources/js/bootstrap.js` | JavaScript | 3 | Bootstrap JavaScript aplikasi |

**Total LOC Shared/Common:** 1.598  
**Total File Shared/Common:** 16  

## 6. Fitur dengan LOC Terbesar dan Terkecil

### 6.1 LOC Terbesar

| Peringkat | Fitur | Total LOC | Keterangan |
|---:|---|---:|---|
| 1 | Transaksi | 1.401 | Fitur paling besar karena mencakup CRUD transaksi, item transaksi, detail transaksi, edit transaksi, dan PDF transaksi |
| 2 | POS / Kasir | 1.271 | Fitur inti kasir dengan tampilan POS, transaksi penjualan, produk, pembayaran, dan resi |
| 3 | Inventory | 1.050 | Mengelola stok, item inventory, form stok, dan struktur database inventory |
| 4 | Produk | 833 | Mengelola data produk, barcode, detail produk, form produk, dan struktur tabel produk |
| 5 | Report / Laporan | 720 | Mengelola laporan, PDF laporan, model laporan, export, dan struktur data laporan |

### 6.2 LOC Terkecil

| Peringkat | Fitur | Total LOC | Keterangan |
|---:|---|---:|---|
| 1 | Dashboard | 297 | Relatif sederhana karena hanya menampilkan ringkasan data |
| 2 | Kategori | 320 | CRUD kategori sederhana |
| 3 | Setting | 321 | Berisi konfigurasi sistem dan tampilan setting |
| 4 | Payment Method | 353 | CRUD metode pembayaran relatif sederhana |
| 5 | Login / Authentication | 422 | Autentikasi masih membutuhkan controller, view, model, config, middleware, dan migration user |

## 7. Persentase Kontribusi LOC Tiap Fitur Utama

Persentase berikut dihitung dari total LOC fitur utama sebesar **8.814 LOC**.

| Fitur | Total LOC | Persentase |
|---|---:|---:|
| Transaksi | 1.401 | 15,90% |
| POS / Kasir | 1.271 | 14,42% |
| Inventory | 1.050 | 11,91% |
| Produk | 833 | 9,45% |
| Report / Laporan | 720 | 8,17% |
| CashFlow | 665 | 7,55% |
| User Management | 582 | 6,60% |
| Role / Permission | 579 | 6,57% |
| Login / Authentication | 422 | 4,79% |
| Payment Method | 353 | 4,01% |
| Setting | 321 | 3,64% |
| Kategori | 320 | 3,63% |
| Dashboard | 297 | 3,37% |
| **Total** | **8.814** | **100,00%** |

## 8. Persentase Controller, Blade, Model, Middleware, dan Config terhadap Total Project Unik

Persentase berikut dihitung dari total LOC project unik sebesar **10.136 LOC**.

| Jenis File | Total LOC | Persentase |
|---|---:|---:|
| Blade View | 6.724 | 66,34% |
| Controller | 1.614 | 15,92% |
| Model | 498 | 4,91% |
| Middleware | 62 | 0,61% |
| Config | 159 | 1,57% |

## 9. Catatan File Shared

Beberapa file digunakan oleh lebih dari satu fitur. Dalam rekap fitur, file tersebut dapat muncul sesuai fungsi fiturnya. Namun, pada total project unik, file shared hanya dihitung satu kali.

| No | Shared File | Jenis File | LOC | Digunakan pada Fitur |
|---:|---|---|---:|---|
| 1 | `app/Models/User.php` | Model | 101 | Login / Authentication dan User Management |
| 2 | `app/Http/Middleware/PermissionMiddleware.php` | Middleware | 62 | Login / Authentication dan Role / Permission |
| 3 | `app/Models/Product.php` | Model | 49 | POS / Kasir dan Produk |
| 4 | `app/Models/Transaction.php` | Model | 32 | POS / Kasir dan Transaksi |
| 5 | `app/Models/PaymentMethod.php` | Model | 32 | POS / Kasir dan Payment Method |
| 6 | `routes/web.php` | Route | 132 | Route manual lintas fitur, dicatat pada Shared/Common agar tidak dihitung berulang |

## 11. Catatan Khusus Receipt/Invoice dan Barcode Scanner

### 11.1 Receipt / Invoice

Fitur receipt/invoice tidak dipisahkan sebagai fitur mandiri karena proses receipt merupakan bagian langsung dari POS/Kasir dan transaksi.

| File | Lokasi Fitur | LOC | Keterangan |
|---|---|---:|---|
| `resources/views/pages/pos/resi.blade.php` | POS / Kasir | 166 | Tampilan resi transaksi kasir |
| `resources/views/pages/transaksi/pdf.blade.php` | Transaksi | 153 | Dokumen PDF transaksi |
| `resources/views/pages/report/laporan-pdf.blade.php` | Report / Laporan | 167 | Dokumen PDF laporan |

### 11.2 Barcode Scanner

Fitur barcode tidak dipisahkan sebagai fitur mandiri karena file terkait berada pada fitur Produk dan POS/Kasir. LOC yang dihitung adalah LOC custom project, bukan LOC bawaan package/library.

| File | Lokasi Fitur | LOC | Keterangan |
|---|---|---:|---|
| `resources/views/pages/produk/barcode-pdf.blade.php` | Produk | 117 | Tampilan/print barcode produk |
| `database/migrations/2026_04_20_100000_add_cost_price_barcode_is_active_to_products_table.php` | Produk | 21 | Penambahan field barcode pada produk |
| `app/Models/Product.php` | POS / Kasir dan Produk | 49 | Model produk yang memuat atribut produk termasuk barcode |
| `resources/views/pages/pos/index.blade.php` | POS / Kasir | 831 | Tampilan POS yang dapat memanfaatkan data produk/barcode |

## 12. Analisis Hasil

Berdasarkan hasil perhitungan LOC yang telah diseimbangkan dengan struktur laporan Laravel Filament, sistem POS Laravel 12 Konvensional memiliki total **8.814 LOC** pada 13 fitur utama. Jika file pendukung global atau Shared/Common ikut dihitung sebagai bagian dari project, total LOC unik project menjadi **10.136 LOC** dari **100 file unik**.

Fitur dengan LOC terbesar adalah **Transaksi** sebesar **1.401 LOC**, diikuti oleh **POS / Kasir** sebesar **1.271 LOC**, **Inventory** sebesar **1.050 LOC**, dan **Produk** sebesar **833 LOC**. Hal ini menunjukkan bahwa fitur yang berkaitan dengan proses bisnis inti, seperti transaksi, kasir, stok, dan produk, membutuhkan penulisan kode manual yang lebih besar pada Laravel konvensional.

Fitur dengan LOC terkecil adalah **Dashboard** sebesar **297 LOC**, diikuti oleh **Kategori** sebesar **320 LOC**, dan **Setting** sebesar **321 LOC**. Nilai ini menunjukkan bahwa fitur tersebut relatif lebih sederhana karena tidak memiliki alur proses bisnis yang panjang seperti transaksi atau POS/Kasir.

Dari sisi komposisi kode, sistem Laravel konvensional didominasi oleh **Blade View** sebesar **6.724 LOC** atau **66,34%** dari total LOC project unik. Hal ini menunjukkan bahwa pendekatan konvensional membutuhkan banyak kode manual pada bagian antarmuka, seperti halaman daftar data, form tambah, form edit, tampilan detail, modal, layout, sidebar, navbar, dan tampilan PDF.

Jika dibandingkan secara konsep dengan Laravel Filament, Laravel konvensional memiliki kebutuhan kode manual yang lebih besar karena banyak komponen administratif seperti form, tabel, action, layout, dan navigasi harus dibuat secara eksplisit. Sebaliknya, pada Laravel Filament, sebagian besar kebutuhan tersebut dibantu oleh Resource, Page, Widget, dan konfigurasi framework.

## 13. Kesimpulan

1. Total LOC pada 13 fitur utama Laravel konvensional adalah **8.814 LOC**.
2. Total file pada 13 fitur utama adalah **89 file/entri**.
3. Total LOC Shared/Common adalah **1.598 LOC**.
4. Total LOC project unik setelah diseimbangkan dengan metode Filament adalah **10.136 LOC** dari **100 file unik**.
5. Fitur dengan LOC terbesar adalah **Transaksi** sebesar **1.401 LOC**.
6. Fitur dengan LOC terkecil adalah **Dashboard** sebesar **297 LOC**.
7. Komponen terbesar pada Laravel konvensional adalah **Blade View**, yaitu **6.724 LOC** atau **66,34%** dari total LOC project unik.
8. File migration user dimasukkan ke fitur **Login / Authentication** agar klasifikasinya seimbang dengan laporan Laravel Filament.
9. Seeder tidak dimasukkan dalam total utama karena laporan Laravel Filament juga tidak menghitung seeder, factory, dan file testing.
10. Laravel konvensional memiliki tingkat otomatisasi framework yang lebih rendah dibandingkan Laravel Filament karena lebih banyak proses CRUD, form, table, layout, dan navigasi ditulis secara manual.

## 14. Rekomendasi Penulisan dalam Laporan TA

Gunakan kalimat berikut agar penjelasan perbandingan Laravel konvensional dan Laravel Filament lebih konsisten:

> Berdasarkan perhitungan Physical Lines of Code (PLOC) yang telah diseimbangkan dengan metode perhitungan Laravel Filament, sistem POS Laravel 12 Konvensional memiliki total **8.814 LOC** pada 13 fitur utama. Jika file pendukung global atau Shared/Common ikut dihitung sebagai bagian dari project, total LOC unik project menjadi **10.136 LOC** dari **100 file unik**. Perhitungan ini tidak memasukkan seeder, factory, testing, file log, asset hasil build, maupun library bawaan. Hasil perhitungan menunjukkan bahwa fitur dengan LOC terbesar adalah **Transaksi** sebesar **1.401 LOC**, sedangkan fitur dengan LOC terkecil adalah **Dashboard** sebesar **297 LOC**. Komponen terbesar berasal dari **Blade View** sebesar **6.724 LOC**, yang menunjukkan bahwa Laravel konvensional membutuhkan lebih banyak penulisan kode manual pada bagian antarmuka, layout, form, tabel, dan tampilan fitur dibandingkan Laravel Filament.
