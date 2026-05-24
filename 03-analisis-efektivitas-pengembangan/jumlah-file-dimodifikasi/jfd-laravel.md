# Analisis Jumlah File yang Dimodifikasi
## Sistem POS Laravel 12 Konvensional

## 1. Metode Analisis

Analisis ini dilakukan dengan melakukan scan langsung terhadap folder project dan mengidentifikasi file source code yang berkontribusi pada implementasi fitur sistem POS Laravel 12 Konvensional.

Analisis hanya menggunakan **13 fitur utama** dan tidak membuat kategori **Shared/Common** sebagai fitur terpisah. File yang digunakan oleh lebih dari satu fitur tetap dicatat sebagai **Shared File**, tetapi dalam total file unik project file tersebut hanya dihitung satu kali.

File yang dihitung adalah file yang:
1. Dibuat khusus untuk kebutuhan sistem POS.
2. Diubah dari struktur default Laravel.
3. Digunakan langsung oleh fitur sistem.
4. Berkontribusi terhadap proses bisnis, tampilan, konfigurasi, akses, laporan, transaksi, stok, pembayaran, atau setting sistem.

File yang dikecualikan:
- `vendor/*`
- `node_modules/*`
- `storage/*`
- `bootstrap/cache/*`
- `public/build/*`
- `database/seeders/*`
- `database/factories/*`
- `tests/*`
- file testing
- file log
- file cache
- file temporary
- file dummy
- file hasil build
- file Tailadmin yang tidak relevan
- file bawaan Laravel yang tidak dimodifikasi

## 2. Catatan Validasi Angka

Pada hasil awal terdapat ketidaksesuaian kecil pada jumlah file spesifik fitur dan shared file. Karena itu, laporan ini menggunakan **tabel detail per fitur** sebagai sumber utama.

| Bagian | Angka pada hasil awal | Hasil validasi dari tabel detail | Keterangan |
|---|---:|---:|---|
| Total file berbasis kontribusi fitur | 219 file | 219 file | Hasil penjumlahan 13 fitur tetap konsisten |
| Total file spesifik fitur | 74 file | 71 file | Dihitung ulang dari ringkasan tiap fitur |
| Total kemunculan shared file | 145 file | 148 file | Dihitung ulang dari ringkasan tiap fitur |
| Total shared file unik | 31 file | 31 file | Mengikuti daftar shared file unik hasil scan |
| Total file unik project | 92 file | 92 file | Mengikuti hasil scan file unik project |
| Total fitur dianalisis | 13 fitur | 13 fitur | Tidak ada kategori Shared/Common terpisah |

Dengan demikian, angka final yang digunakan adalah:

| Metrik | Nilai Final |
|---|---:|
| Total file berbasis kontribusi fitur | 219 file |
| Total file spesifik fitur | 71 file |
| Total kemunculan shared file | 148 file |
| Total shared file unik | 31 file |
| Total file unik project | 92 file |
| Total fitur dianalisis | 13 fitur |

## 3. Detail Jumlah File yang Dimodifikasi per Fitur

### 3.1 Fitur: Login / Authentication

| No | File | Jenis File | Status | Keterangan |
|---:|---|---|---|---|
| 1 | `AuthController.php` | Controller | File Spesifik Fitur | Mengelola login, logout, dan profil |
| 2 | `User.php` | Model | Shared File | Digunakan pada Login / Authentication dan User Management |
| 3 | `PermissionMiddleware.php` | Middleware | Shared File | Pembatasan akses berbasis permission |
| 4 | `AppServiceProvider.php` | Provider | Shared File | Custom `@perm` dan Gate permission global |
| 5 | `web.php` | Route | Shared File | Mendefinisikan route login, logout, profile, dan route fitur lain |
| 6 | `login.blade.php` | Blade View | File Spesifik Fitur | Halaman login khusus POS |
| 7 | `profile.blade.php` | Blade View | File Spesifik Fitur | Halaman edit profil pengguna |
| 8 | `app.css` | CSS | Shared File | Styling global |
| 9 | `app.js` | JavaScript | Shared File | Asset JavaScript global |
| 10 | `app.blade.php` | Blade Layout | Shared File | Layout utama halaman authenticated |
| 11 | `navbar.blade.php` | Blade Partial | Shared File | Navbar global |
| 12 | `sidebar.blade.php` | Blade Partial | Shared File | Sidebar global |
| 13 | `confirm-modal.blade.php` | Blade Component | Shared File | Modal konfirmasi global |
| 14 | `2026_05_05_000001_add_role_id_to_users_table.php` | Migration | Shared File | Menambah relasi `role_id` pada tabel users |

| Ringkasan | Nilai |
|---|---:|
| Total File Fitur | 14 |
| Total Shared File | 10 |
| Total File Spesifik Fitur | 4 |

#### Penjelasan

Fitur Login / Authentication menggunakan controller khusus, halaman login, halaman profil, model user, middleware permission, route, dan file pendukung layout. File seperti `User.php`, `PermissionMiddleware.php`, `AppServiceProvider.php`, dan `web.php` bersifat shared karena digunakan juga oleh fitur lain.

---

### 3.2 Fitur: Dashboard

| No | File | Jenis File | Status | Keterangan |
|---:|---|---|---|---|
| 1 | `DashboardController.php` | Controller | File Spesifik Fitur | Menyajikan data ringkasan toko |
| 2 | `Transaction.php` | Model | Shared File | Data penjualan dan ringkasan transaksi |
| 3 | `CashFlow.php` | Model | Shared File | Data arus kas untuk dashboard |
| 4 | `PaymentMethod.php` | Model | Shared File | Data ringkasan transaksi berdasarkan metode pembayaran |
| 5 | `web.php` | Route | Shared File | Route dashboard dan permission |
| 6 | `dashboard.blade.php` | Blade View | File Spesifik Fitur | Halaman dashboard |
| 7 | `chart-donut.js` | JavaScript | File Spesifik Fitur | Grafik donut dashboard |
| 8 | `app.css` | CSS | Shared File | Styling global |
| 9 | `app.js` | JavaScript | Shared File | Asset global dan chart loader |
| 10 | `app.blade.php` | Blade Layout | Shared File | Layout utama |
| 11 | `navbar.blade.php` | Blade Partial | Shared File | Navbar global |
| 12 | `sidebar.blade.php` | Blade Partial | Shared File | Sidebar global |
| 13 | `confirm-modal.blade.php` | Blade Component | Shared File | Modal global |
| 14 | `2026_04_19_155812_create_products_table.php` | Migration | Shared File | Data produk untuk ringkasan dashboard |
| 15 | `2026_04_19_155931_create_transactions_table.php` | Migration | Shared File | Data transaksi |
| 16 | `2026_04_19_155918_create_payment_methods_table.php` | Migration | Shared File | Data metode pembayaran |
| 17 | `2026_04_19_155953_create_cash_flows_table.php` | Migration | Shared File | Data cashflow |
| 18 | `2026_04_21_000002_create_cashbox_flows_table.php` | Migration | Shared File | Data kas masuk dan keluar |

| Ringkasan | Nilai |
|---|---:|
| Total File Fitur | 18 |
| Total Shared File | 13 |
| Total File Spesifik Fitur | 5 |

#### Penjelasan

Dashboard menggunakan controller dan view khusus untuk menampilkan ringkasan data. Data yang ditampilkan berasal dari model transaksi, cashflow, payment method, dan produk, sehingga beberapa file yang digunakan dashboard berstatus shared.

---

### 3.3 Fitur: POS / Kasir

| No | File | Jenis File | Status | Keterangan |
|---:|---|---|---|---|
| 1 | `PosController.php` | Controller | File Spesifik Fitur | Logika transaksi kasir, scan barcode, dan cetak resi |
| 2 | `Transaction.php` | Model | Shared File | Menyimpan transaksi kasir |
| 3 | `TransactionItem.php` | Model | Shared File | Menyimpan detail item transaksi |
| 4 | `Product.php` | Model | Shared File | Produk yang dijual pada POS |
| 5 | `PaymentMethod.php` | Model | Shared File | Pilihan metode pembayaran kasir |
| 6 | `web.php` | Route | Shared File | Route POS dan permission |
| 7 | `index.blade.php` | Blade View | File Spesifik Fitur | Halaman kasir |
| 8 | `resi.blade.php` | Blade View | File Spesifik Fitur | Tampilan cetak resi transaksi |
| 9 | `app.css` | CSS | Shared File | Styling global |
| 10 | `app.js` | JavaScript | Shared File | Asset global dan helper konfirmasi |
| 11 | `app.blade.php` | Blade Layout | Shared File | Layout utama |
| 12 | `navbar.blade.php` | Blade Partial | Shared File | Navbar |
| 13 | `sidebar.blade.php` | Blade Partial | Shared File | Sidebar |
| 14 | `confirm-modal.blade.php` | Blade Component | Shared File | Modal global |
| 15 | `2026_04_19_155931_create_transactions_table.php` | Migration | Shared File | Struktur tabel transaksi |
| 16 | `2026_04_19_155938_create_transaction_items_table.php` | Migration | Shared File | Struktur tabel item transaksi |
| 17 | `2026_04_19_155812_create_products_table.php` | Migration | Shared File | Struktur tabel produk |
| 18 | `2026_04_19_155918_create_payment_methods_table.php` | Migration | Shared File | Struktur tabel metode pembayaran |

| Ringkasan | Nilai |
|---|---:|
| Total File Fitur | 18 |
| Total Shared File | 13 |
| Total File Spesifik Fitur | 5 |

#### Penjelasan

POS / Kasir menggunakan controller dan view khusus untuk menangani proses kasir. File shared seperti model transaksi, produk, payment method, route, layout, dan migration digunakan karena fitur POS berhubungan langsung dengan data transaksi, produk, stok, dan pembayaran.

---

### 3.4 Fitur: Produk

| No | File | Jenis File | Status | Keterangan |
|---:|---|---|---|---|
| 1 | `ProdukController.php` | Controller | File Spesifik Fitur | CRUD produk dan cetak barcode |
| 2 | `Product.php` | Model | Shared File | Model data produk |
| 3 | `Category.php` | Model | Shared File | Model kategori produk |
| 4 | `web.php` | Route | Shared File | Route produk dan permission |
| 5 | `index.blade.php` | Blade View | File Spesifik Fitur | Daftar produk |
| 6 | `create.blade.php` | Blade View | File Spesifik Fitur | Form tambah produk |
| 7 | `edit.blade.php` | Blade View | File Spesifik Fitur | Form edit produk |
| 8 | `show.blade.php` | Blade View | File Spesifik Fitur | Detail produk |
| 9 | `barcode-pdf.blade.php` | Blade View | File Spesifik Fitur | Cetak barcode produk |
| 10 | `table-footer.blade.php` | Blade Component | Shared File | Paginasi produk |
| 11 | `app.css` | CSS | Shared File | Styling global |
| 12 | `app.js` | JavaScript | Shared File | Asset global |
| 13 | `app.blade.php` | Blade Layout | Shared File | Layout utama |
| 14 | `navbar.blade.php` | Blade Partial | Shared File | Navbar |
| 15 | `sidebar.blade.php` | Blade Partial | Shared File | Sidebar |
| 16 | `confirm-modal.blade.php` | Blade Component | Shared File | Modal global |
| 17 | `2026_04_19_155812_create_products_table.php` | Migration | Shared File | Struktur tabel produk |
| 18 | `2026_04_20_100000_add_cost_price_barcode_is_active_to_products_table.php` | Migration | Shared File | Field tambahan produk seperti cost price, barcode, dan status aktif |
| 19 | `2026_04_19_155753_create_categories_table.php` | Migration | Shared File | Struktur tabel kategori produk |

| Ringkasan | Nilai |
|---|---:|
| Total File Fitur | 19 |
| Total Shared File | 13 |
| Total File Spesifik Fitur | 6 |

#### Penjelasan

Produk merupakan fitur yang membutuhkan banyak file karena mencakup CRUD produk, relasi kategori, upload atau pengelolaan data produk, barcode, dan tampilan detail. File seperti model, layout, route, dan migration bersifat shared karena juga digunakan oleh fitur lain.

---

### 3.5 Fitur: Kategori

| No | File | Jenis File | Status | Keterangan |
|---:|---|---|---|---|
| 1 | `KategoriController.php` | Controller | File Spesifik Fitur | CRUD kategori |
| 2 | `Category.php` | Model | Shared File | Model kategori produk |
| 3 | `Product.php` | Model | Shared File | Model produk yang berelasi dengan kategori |
| 4 | `web.php` | Route | Shared File | Route kategori dan permission |
| 5 | `index.blade.php` | Blade View | File Spesifik Fitur | Daftar kategori |
| 6 | `create.blade.php` | Blade View | File Spesifik Fitur | Form tambah kategori |
| 7 | `edit.blade.php` | Blade View | File Spesifik Fitur | Form edit kategori |
| 8 | `table-footer.blade.php` | Blade Component | Shared File | Paginasi kategori |
| 9 | `app.css` | CSS | Shared File | Styling global |
| 10 | `app.js` | JavaScript | Shared File | Asset global |
| 11 | `app.blade.php` | Blade Layout | Shared File | Layout utama |
| 12 | `navbar.blade.php` | Blade Partial | Shared File | Navbar |
| 13 | `sidebar.blade.php` | Blade Partial | Shared File | Sidebar |
| 14 | `confirm-modal.blade.php` | Blade Component | Shared File | Modal global |
| 15 | `2026_04_19_155753_create_categories_table.php` | Migration | Shared File | Struktur tabel kategori |

| Ringkasan | Nilai |
|---|---:|
| Total File Fitur | 15 |
| Total Shared File | 12 |
| Total File Spesifik Fitur | 3 |

#### Penjelasan

Kategori menggunakan controller dan view khusus untuk CRUD kategori. Model `Category` dan `Product` digunakan bersama karena fitur kategori berhubungan langsung dengan pengelompokan produk.

---

### 3.6 Fitur: Inventory

| No | File | Jenis File | Status | Keterangan |
|---:|---|---|---|---|
| 1 | `InventoryController.php` | Controller | File Spesifik Fitur | CRUD inventory |
| 2 | `Inventory.php` | Model | File Spesifik Fitur | Model inventory |
| 3 | `InventoryItem.php` | Model | File Spesifik Fitur | Model item inventory |
| 4 | `Product.php` | Model | Shared File | Produk terkait stok |
| 5 | `web.php` | Route | Shared File | Route inventory |
| 6 | `index.blade.php` | Blade View | File Spesifik Fitur | Daftar inventory |
| 7 | `create.blade.php` | Blade View | File Spesifik Fitur | Form create inventory |
| 8 | `edit.blade.php` | Blade View | File Spesifik Fitur | Form edit inventory |
| 9 | `show.blade.php` | Blade View | File Spesifik Fitur | Detail inventory |
| 10 | `table-footer.blade.php` | Blade Component | Shared File | Paginasi inventory |
| 11 | `app.css` | CSS | Shared File | Styling global |
| 12 | `app.js` | JavaScript | Shared File | Asset global |
| 13 | `app.blade.php` | Blade Layout | Shared File | Layout utama |
| 14 | `navbar.blade.php` | Blade Partial | Shared File | Navbar |
| 15 | `sidebar.blade.php` | Blade Partial | Shared File | Sidebar |
| 16 | `confirm-modal.blade.php` | Blade Component | Shared File | Modal global |
| 17 | `2026_04_19_155943_create_inventories_table.php` | Migration | File Spesifik Fitur | Struktur tabel inventory |
| 18 | `2026_04_19_155947_create_inventory_items_table.php` | Migration | File Spesifik Fitur | Struktur tabel item inventory |
| 19 | `2026_04_20_120000_add_source_and_total_modal_to_inventories_table.php` | Migration | File Spesifik Fitur | Penambahan field inventory |
| 20 | `2026_04_19_155812_create_products_table.php` | Migration | Shared File | Produk sebagai basis stok |

| Ringkasan | Nilai |
|---|---:|
| Total File Fitur | 20 |
| Total Shared File | 8 |
| Total File Spesifik Fitur | 12 |

#### Penjelasan

Inventory memiliki banyak file karena fitur ini mengatur stok, item inventory, perubahan stok, dan relasi dengan produk. Model dan migration inventory bersifat spesifik, sedangkan produk, route, layout, dan komponen tampilan digunakan secara shared.

---

### 3.7 Fitur: Transaksi

| No | File | Jenis File | Status | Keterangan |
|---:|---|---|---|---|
| 1 | `TransaksiController.php` | Controller | File Spesifik Fitur | Manajemen transaksi |
| 2 | `Transaction.php` | Model | Shared File | Model transaksi |
| 3 | `TransactionItem.php` | Model | Shared File | Model item transaksi |
| 4 | `Product.php` | Model | Shared File | Produk transaksi |
| 5 | `PaymentMethod.php` | Model | Shared File | Metode pembayaran transaksi |
| 6 | `web.php` | Route | Shared File | Route transaksi dan PDF |
| 7 | `index.blade.php` | Blade View | File Spesifik Fitur | Daftar transaksi |
| 8 | `create.blade.php` | Blade View | File Spesifik Fitur | Form tambah transaksi |
| 9 | `edit.blade.php` | Blade View | File Spesifik Fitur | Form edit transaksi |
| 10 | `show.blade.php` | Blade View | File Spesifik Fitur | Detail transaksi |
| 11 | `pdf.blade.php` | Blade View | File Spesifik Fitur | Cetak PDF transaksi |
| 12 | `table-footer.blade.php` | Blade Component | Shared File | Paginasi transaksi |
| 13 | `app.css` | CSS | Shared File | Styling global |
| 14 | `app.js` | JavaScript | Shared File | Asset global |
| 15 | `app.blade.php` | Blade Layout | Shared File | Layout utama |
| 16 | `navbar.blade.php` | Blade Partial | Shared File | Navbar |
| 17 | `sidebar.blade.php` | Blade Partial | Shared File | Sidebar |
| 18 | `confirm-modal.blade.php` | Blade Component | Shared File | Modal global |
| 19 | `2026_04_19_155931_create_transactions_table.php` | Migration | Shared File | Struktur tabel transaksi |
| 20 | `2026_04_19_155938_create_transaction_items_table.php` | Migration | Shared File | Struktur tabel item transaksi |
| 21 | `2026_04_19_155918_create_payment_methods_table.php` | Migration | Shared File | Struktur metode pembayaran transaksi |

| Ringkasan | Nilai |
|---|---:|
| Total File Fitur | 21 |
| Total Shared File | 14 |
| Total File Spesifik Fitur | 7 |

#### Penjelasan

Transaksi menjadi fitur dengan jumlah file terbanyak karena mencakup controller, model transaksi, item transaksi, metode pembayaran, view daftar, view form, detail, PDF, route, layout, dan migration. Banyak file pada fitur ini bersifat shared karena transaksi digunakan juga oleh POS/Kasir, dashboard, dan laporan.

---

### 3.8 Fitur: CashFlow

| No | File | Jenis File | Status | Keterangan |
|---:|---|---|---|---|
| 1 | `CashFlowController.php` | Controller | File Spesifik Fitur | Manajemen arus kas |
| 2 | `CashFlow.php` | Model | File Spesifik Fitur | Model arus kas |
| 3 | `CashFlowSource.php` | Model | File Spesifik Fitur | Model sumber kas |
| 4 | `CashboxFlow.php` | Model | Shared File | Model kas masuk dan keluar detail |
| 5 | `web.php` | Route | Shared File | Route cashflow |
| 6 | `index.blade.php` | Blade View | File Spesifik Fitur | Daftar cashflow |
| 7 | `table-footer.blade.php` | Blade Component | Shared File | Paginasi cashflow |
| 8 | `app.css` | CSS | Shared File | Styling global |
| 9 | `app.js` | JavaScript | Shared File | Asset global |
| 10 | `app.blade.php` | Blade Layout | Shared File | Layout utama |
| 11 | `navbar.blade.php` | Blade Partial | Shared File | Navbar |
| 12 | `sidebar.blade.php` | Blade Partial | Shared File | Sidebar |
| 13 | `confirm-modal.blade.php` | Blade Component | Shared File | Modal global |
| 14 | `2026_04_19_155953_create_cash_flows_table.php` | Migration | File Spesifik Fitur | Struktur tabel cashflow |
| 15 | `2026_04_21_000001_create_cash_flow_sources_table.php` | Migration | File Spesifik Fitur | Struktur sumber cashflow |
| 16 | `2026_04_21_000002_create_cashbox_flows_table.php` | Migration | Shared File | Struktur kas masuk dan keluar |
| 17 | `2026_04_22_000000_add_fields_to_cashbox_flows.php` | Migration | File Spesifik Fitur | Field tambahan cashbox |

| Ringkasan | Nilai |
|---|---:|
| Total File Fitur | 17 |
| Total Shared File | 9 |
| Total File Spesifik Fitur | 8 |

#### Penjelasan

CashFlow memiliki controller, model, view, dan migration khusus untuk arus kas. File `CashboxFlow.php` dan migration cashbox bersifat shared karena digunakan juga pada laporan dan dashboard.

---

### 3.9 Fitur: Payment Method

| No | File | Jenis File | Status | Keterangan |
|---:|---|---|---|---|
| 1 | `PaymentMethodController.php` | Controller | File Spesifik Fitur | CRUD payment method |
| 2 | `PaymentMethod.php` | Model | File Spesifik Fitur | Model metode pembayaran |
| 3 | `web.php` | Route | Shared File | Route payment method |
| 4 | `index.blade.php` | Blade View | File Spesifik Fitur | Daftar metode pembayaran |
| 5 | `create.blade.php` | Blade View | File Spesifik Fitur | Form tambah metode pembayaran |
| 6 | `edit.blade.php` | Blade View | File Spesifik Fitur | Form edit metode pembayaran |
| 7 | `table-footer.blade.php` | Blade Component | Shared File | Paginasi payment method |
| 8 | `app.css` | CSS | Shared File | Styling global |
| 9 | `app.js` | JavaScript | Shared File | Asset global |
| 10 | `app.blade.php` | Blade Layout | Shared File | Layout utama |
| 11 | `navbar.blade.php` | Blade Partial | Shared File | Navbar |
| 12 | `sidebar.blade.php` | Blade Partial | Shared File | Sidebar |
| 13 | `confirm-modal.blade.php` | Blade Component | Shared File | Modal global |
| 14 | `2026_04_19_155918_create_payment_methods_table.php` | Migration | File Spesifik Fitur | Struktur tabel payment method |
| 15 | `2026_04_20_000000_add_logo_and_is_cash_to_payment_methods_table.php` | Migration | File Spesifik Fitur | Field tambahan payment method |

| Ringkasan | Nilai |
|---|---:|
| Total File Fitur | 15 |
| Total Shared File | 9 |
| Total File Spesifik Fitur | 6 |

#### Penjelasan

Payment Method memiliki controller, model, view CRUD, dan migration khusus. File layout, route, asset, dan komponen tabel bersifat shared karena digunakan lintas fitur.

---

### 3.10 Fitur: Report / Laporan

| No | File | Jenis File | Status | Keterangan |
|---:|---|---|---|---|
| 1 | `ReportController.php` | Controller | File Spesifik Fitur | Menangani tampilan report dan export |
| 2 | `Report.php` | Model | File Spesifik Fitur | Model data laporan |
| 3 | `Transaction.php` | Model | Shared File | Basis data laporan transaksi |
| 4 | `CashboxFlow.php` | Model | Shared File | Basis data laporan cashflow |
| 5 | `LaporanKeuanganExport.php` | Export | File Spesifik Fitur | Export Excel laporan |
| 6 | `web.php` | Route | Shared File | Route report dan export |
| 7 | `index.blade.php` | Blade View | File Spesifik Fitur | Halaman report |
| 8 | `laporan-pdf.blade.php` | Blade View | File Spesifik Fitur | Export PDF laporan |
| 9 | `app.css` | CSS | Shared File | Styling global |
| 10 | `app.js` | JavaScript | Shared File | Asset global |
| 11 | `app.blade.php` | Blade Layout | Shared File | Layout utama |
| 12 | `navbar.blade.php` | Blade Partial | Shared File | Navbar |
| 13 | `sidebar.blade.php` | Blade Partial | Shared File | Sidebar |
| 14 | `confirm-modal.blade.php` | Blade Component | Shared File | Modal global |
| 15 | `2026_05_20_000001_create_reports_table.php` | Migration | File Spesifik Fitur | Struktur tabel report |
| 16 | `2026_04_19_155931_create_transactions_table.php` | Migration | Shared File | Data transaksi untuk laporan |
| 17 | `2026_04_21_000002_create_cashbox_flows_table.php` | Migration | Shared File | Data cashbox untuk laporan |

| Ringkasan | Nilai |
|---|---:|
| Total File Fitur | 17 |
| Total Shared File | 12 |
| Total File Spesifik Fitur | 5 |

#### Penjelasan

Report / Laporan menggunakan controller, model, export Excel, view report, dan view PDF. Fitur ini juga menggunakan data transaksi dan cashbox flow sebagai sumber laporan, sehingga beberapa file bersifat shared.

---

### 3.11 Fitur: User Management

| No | File | Jenis File | Status | Keterangan |
|---:|---|---|---|---|
| 1 | `UserController.php` | Controller | File Spesifik Fitur | CRUD user |
| 2 | `User.php` | Model | Shared File | User untuk manajemen dan autentikasi |
| 3 | `Role.php` | Model | Shared File | Role assignment user |
| 4 | `web.php` | Route | Shared File | Route user management |
| 5 | `index.blade.php` | Blade View | File Spesifik Fitur | Daftar user |
| 6 | `create.blade.php` | Blade View | File Spesifik Fitur | Form tambah user |
| 7 | `edit.blade.php` | Blade View | File Spesifik Fitur | Form edit user |
| 8 | `table-footer.blade.php` | Blade Component | Shared File | Paginasi user |
| 9 | `app.css` | CSS | Shared File | Styling global |
| 10 | `app.js` | JavaScript | Shared File | Asset global |
| 11 | `app.blade.php` | Blade Layout | Shared File | Layout utama |
| 12 | `navbar.blade.php` | Blade Partial | Shared File | Navbar |
| 13 | `sidebar.blade.php` | Blade Partial | Shared File | Sidebar |
| 14 | `confirm-modal.blade.php` | Blade Component | Shared File | Modal global |
| 15 | `2026_04_19_160000_create_roles_table.php` | Migration | Shared File | Struktur role untuk user |
| 16 | `2026_05_05_000001_add_role_id_to_users_table.php` | Migration | Shared File | Relasi role-user |

| Ringkasan | Nilai |
|---|---:|
| Total File Fitur | 16 |
| Total Shared File | 13 |
| Total File Spesifik Fitur | 3 |

#### Penjelasan

User Management menggunakan controller dan view khusus untuk CRUD user. Model `User`, model `Role`, migration role, route, layout, dan komponen tampilan bersifat shared karena digunakan juga oleh fitur autentikasi dan role/permission.

---

### 3.12 Fitur: Role / Permission

| No | File | Jenis File | Status | Keterangan |
|---:|---|---|---|---|
| 1 | `RoleController.php` | Controller | File Spesifik Fitur | CRUD role |
| 2 | `Role.php` | Model | Shared File | Role dan permissions |
| 3 | `PermissionMiddleware.php` | Middleware | Shared File | Middleware permission global |
| 4 | `AppServiceProvider.php` | Provider | Shared File | Custom Blade `@perm` dan Gate |
| 5 | `web.php` | Route | Shared File | Route role dan permission |
| 6 | `index.blade.php` | Blade View | File Spesifik Fitur | Daftar role |
| 7 | `create.blade.php` | Blade View | File Spesifik Fitur | Form buat role |
| 8 | `edit.blade.php` | Blade View | File Spesifik Fitur | Form edit role |
| 9 | `table-footer.blade.php` | Blade Component | Shared File | Paginasi role |
| 10 | `app.css` | CSS | Shared File | Styling global |
| 11 | `app.js` | JavaScript | Shared File | Asset global |
| 12 | `app.blade.php` | Blade Layout | Shared File | Layout utama |
| 13 | `navbar.blade.php` | Blade Partial | Shared File | Navbar |
| 14 | `sidebar.blade.php` | Blade Partial | Shared File | Sidebar |
| 15 | `confirm-modal.blade.php` | Blade Component | Shared File | Modal global |
| 16 | `2026_04_19_160000_create_roles_table.php` | Migration | Shared File | Struktur tabel role |
| 17 | `2026_05_05_000001_add_role_id_to_users_table.php` | Migration | Shared File | Relasi role-user |

| Ringkasan | Nilai |
|---|---:|
| Total File Fitur | 17 |
| Total Shared File | 14 |
| Total File Spesifik Fitur | 3 |

#### Penjelasan

Role / Permission menjadi fitur otorisasi utama pada sistem. Middleware, provider, role model, route, layout, dan migration role digunakan lintas fitur, sehingga sebagian besar file pada fitur ini berstatus shared.

---

### 3.13 Fitur: Setting

| No | File | Jenis File | Status | Keterangan |
|---:|---|---|---|---|
| 1 | `SettingController.php` | Controller | File Spesifik Fitur | Pengaturan sistem |
| 2 | `Setting.php` | Model | File Spesifik Fitur | Model data setting |
| 3 | `web.php` | Route | Shared File | Route setting |
| 4 | `index.blade.php` | Blade View | File Spesifik Fitur | Halaman setting |
| 5 | `table-footer.blade.php` | Blade Component | Shared File | Paginasi setting |
| 6 | `app.css` | CSS | Shared File | Styling global |
| 7 | `app.js` | JavaScript | Shared File | Asset global |
| 8 | `app.blade.php` | Blade Layout | Shared File | Layout utama |
| 9 | `navbar.blade.php` | Blade Partial | Shared File | Navbar |
| 10 | `sidebar.blade.php` | Blade Partial | Shared File | Sidebar |
| 11 | `confirm-modal.blade.php` | Blade Component | Shared File | Modal global |
| 12 | `2026_04_28_000001_create_settings_table.php` | Migration | File Spesifik Fitur | Struktur tabel setting |

| Ringkasan | Nilai |
|---|---:|
| Total File Fitur | 12 |
| Total Shared File | 8 |
| Total File Spesifik Fitur | 4 |

#### Penjelasan

Setting merupakan fitur pengaturan sistem yang relatif ringan. File spesifik terdiri atas controller, model, view, dan migration, sedangkan route, layout, asset, dan komponen tampilan bersifat shared.

## 4. Rekapitulasi Jumlah File per Fitur

| No | Fitur | Total File | File Spesifik Fitur | Shared File | Jenis File Dominan | Keterangan |
|---:|---|---:|---:|---:|---|---|
| 1 | Login / Authentication | 14 | 4 | 10 | Controller / Blade View | Login, profil, auth-permission |
| 2 | Dashboard | 18 | 5 | 13 | Controller / Blade View | Ringkasan toko dan grafik |
| 3 | POS / Kasir | 18 | 5 | 13 | Controller / Blade View | Kasir, barcode, dan resi |
| 4 | Produk | 19 | 6 | 13 | Controller / Blade View | CRUD produk dan barcode |
| 5 | Kategori | 15 | 3 | 12 | Controller / Blade View | CRUD kategori |
| 6 | Inventory | 20 | 12 | 8 | Controller / Blade View | Stok dan inventory item |
| 7 | Transaksi | 21 | 7 | 14 | Controller / Blade View | Transaksi dan PDF |
| 8 | CashFlow | 17 | 8 | 9 | Controller / Blade View | Arus kas |
| 9 | Payment Method | 15 | 6 | 9 | Controller / Blade View | Metode pembayaran |
| 10 | Report / Laporan | 17 | 5 | 12 | Controller / Export | Laporan dan export |
| 11 | User Management | 16 | 3 | 13 | Controller / Blade View | CRUD user |
| 12 | Role / Permission | 17 | 3 | 14 | Controller / Middleware | Role dan permission |
| 13 | Setting | 12 | 4 | 8 | Controller / Blade View | Setting sistem |
|  | **Total** | **219** | **71** | **148** |  |  |

> Catatan: total shared file pada tabel rekap adalah **148 kemunculan shared file**, bukan file shared unik. File shared unik berjumlah **31 file** berdasarkan daftar shared file.

## 5. Rekapitulasi File Unik Project

| Metrik | Nilai |
|---|---:|
| Total file berbasis kontribusi fitur | 219 file |
| Total file spesifik fitur | 71 file |
| Total kemunculan shared file pada tabel fitur | 148 file |
| Total shared file unik | 31 file |
| Total file unik project | 92 file |
| Total fitur dianalisis | 13 fitur |

### Perhitungan

```text
Total file berbasis kontribusi fitur:
14 + 18 + 18 + 19 + 15 + 20 + 21 + 17 + 15 + 17 + 16 + 17 + 12 = 219 file

Total file spesifik fitur:
4 + 5 + 5 + 6 + 3 + 12 + 7 + 8 + 6 + 5 + 3 + 3 + 4 = 71 file

Total kemunculan shared file:
10 + 13 + 13 + 13 + 12 + 8 + 14 + 9 + 9 + 12 + 13 + 14 + 8 = 148 file

Total file unik project berdasarkan hasil scan:
92 file unik
```

## 6. Persentase Kontribusi File per Fitur

Persentase dihitung berdasarkan total kontribusi fitur sebesar **219 file**.

| Fitur | Total File | Persentase terhadap Total File Kontribusi |
|---|---:|---:|
| Transaksi | 21 | 9,59% |
| Inventory | 20 | 9,13% |
| Produk | 19 | 8,68% |
| Dashboard | 18 | 8,22% |
| POS / Kasir | 18 | 8,22% |
| CashFlow | 17 | 7,76% |
| Report / Laporan | 17 | 7,76% |
| Role / Permission | 17 | 7,76% |
| User Management | 16 | 7,31% |
| Kategori | 15 | 6,85% |
| Payment Method | 15 | 6,85% |
| Login / Authentication | 14 | 6,39% |
| Setting | 12 | 5,48% |
| **Total** | **219** | **100,00%** |

## 7. File Shared

| No | Shared File | Jenis File | Digunakan pada Fitur | Keterangan |
|---:|---|---|---|---|
| 1 | `web.php` | Route | Lintas semua fitur | Semua route fitur POS didefinisikan di sini |
| 2 | `app.css` | CSS | Lintas semua fitur | Styling utama aplikasi |
| 3 | `app.js` | JavaScript | Lintas semua fitur | Asset global, tema, dan confirm helper |
| 4 | `app.blade.php` | Blade Layout | Lintas fitur authenticated | Layout utama halaman dashboard/admin |
| 5 | `navbar.blade.php` | Blade Partial | Lintas fitur authenticated | Navbar global |
| 6 | `sidebar.blade.php` | Blade Partial | Lintas fitur authenticated | Sidebar global |
| 7 | `confirm-modal.blade.php` | Blade Component | Lintas fitur authenticated | Modal konfirmasi global |
| 8 | `table-footer.blade.php` | Blade Component | Produk, Kategori, Inventory, Transaksi, CashFlow, Payment Method, User Management, Role, Setting | Komponen pagination tabel |
| 9 | `User.php` | Model | Authentication, User Management | Model user dan permission |
| 10 | `Product.php` | Model | Produk, POS, Inventory, Transaksi, Dashboard | Produk digunakan di banyak workflow |
| 11 | `Category.php` | Model | Kategori, Produk | Kategori produk |
| 12 | `Transaction.php` | Model | POS, Transaksi, Report, Dashboard | Transaksi core POS |
| 13 | `TransactionItem.php` | Model | POS, Transaksi | Detail item transaksi |
| 14 | `PaymentMethod.php` | Model | Payment Method, POS, Transaksi, Dashboard, Report | Metode pembayaran |
| 15 | `CashFlow.php` | Model | CashFlow, Dashboard | Ringkasan arus kas |
| 16 | `CashboxFlow.php` | Model | CashFlow, Report, Dashboard | Kas masuk/keluar untuk laporan |
| 17 | `Role.php` | Model | User Management, Role / Permission | Role dan permissions |
| 18 | `PermissionMiddleware.php` | Middleware | Login / Authentication, Role / Permission, dan fitur permission-based lainnya | Middleware akses |
| 19 | `AppServiceProvider.php` | Provider | Login / Authentication, Role / Permission | Permission Blade/Gate helper |
| 20 | `2026_04_19_155812_create_products_table.php` | Migration | Produk, Inventory, POS, Transaksi, Dashboard | Data produk |
| 21 | `2026_04_19_155918_create_payment_methods_table.php` | Migration | Payment Method, POS, Transaksi, Dashboard | Data payment method |
| 22 | `2026_04_19_155931_create_transactions_table.php` | Migration | POS, Transaksi, Report, Dashboard | Data transaksi |
| 23 | `2026_04_19_155938_create_transaction_items_table.php` | Migration | POS, Transaksi | Item transaksi |
| 24 | `2026_04_19_160000_create_roles_table.php` | Migration | User Management, Role / Permission | Struktur role |
| 25 | `2026_04_19_155953_create_cash_flows_table.php` | Migration | CashFlow, Dashboard | Struktur cashflow |
| 26 | `2026_04_19_155753_create_categories_table.php` | Migration | Kategori, Produk | Struktur kategori |
| 27 | `2026_04_20_000000_add_logo_and_is_cash_to_payment_methods_table.php` | Migration | Payment Method | Field custom payment method |
| 28 | `2026_04_20_100000_add_cost_price_barcode_is_active_to_products_table.php` | Migration | Produk, POS | Field custom produk |
| 29 | `2026_04_20_120000_add_source_and_total_modal_to_inventories_table.php` | Migration | Inventory | Field inventory khusus |
| 30 | `2026_04_21_000002_create_cashbox_flows_table.php` | Migration | CashFlow, Report, Dashboard | Struktur cashbox |
| 31 | `2026_05_05_000001_add_role_id_to_users_table.php` | Migration | Login / Authentication, User Management, Role / Permission | Relasi role-user |

## 8. Analisis Hasil

### 8.1 Fitur dengan Jumlah File Terbanyak

Fitur dengan jumlah file terbanyak adalah **Transaksi** dengan **21 file** atau **9,59%** dari total kontribusi fitur. Jumlah ini tinggi karena transaksi membutuhkan controller, model transaksi, model item transaksi, model produk, model payment method, route, beberapa Blade View, PDF transaksi, layout, komponen tabel, serta migration yang berkaitan langsung dengan transaksi.

Fitur terbesar berikutnya adalah **Inventory** dengan **20 file** dan **Produk** dengan **19 file**. Inventory membutuhkan banyak file karena mengelola stok, item inventory, model produk, form inventory, detail inventory, serta migration khusus. Produk juga memiliki banyak file karena mencakup CRUD produk, kategori, barcode, detail produk, dan field tambahan produk.

### 8.2 Fitur dengan Jumlah File Tersedikit

Fitur dengan jumlah file tersedikit adalah **Setting** dengan **12 file** atau **5,48%**. Fitur ini relatif lebih sederhana karena hanya membutuhkan controller, model, satu halaman utama, route, layout, asset, komponen tabel, dan migration setting.

### 8.3 Jenis File yang Dominan

Jenis file yang dominan pada Laravel 12 Konvensional adalah:
1. **Controller**, karena setiap fitur utama memiliki controller tersendiri.
2. **Blade View**, karena tampilan daftar, form tambah, form edit, detail, PDF, dan layout dibuat manual.
3. **Model**, karena setiap entitas bisnis direpresentasikan melalui model.
4. **Migration**, karena setiap entitas dan field tambahan membutuhkan struktur tabel.
5. **Route**, karena endpoint setiap fitur ditulis pada `web.php`.
6. **Blade Component dan Partial**, karena layout, sidebar, navbar, modal, dan tabel digunakan lintas fitur.
7. **JavaScript dan CSS**, karena asset global dan chart/tampilan digunakan pada beberapa halaman.
8. **Middleware dan Provider**, karena sistem permission dan akses fitur dibuat secara custom.

### 8.4 Peran File Shared

File shared memiliki peran penting dalam menghubungkan beberapa fitur sekaligus. Contohnya:
- `web.php` digunakan oleh seluruh fitur karena semua route manual berada di file tersebut.
- `app.blade.php`, `navbar.blade.php`, dan `sidebar.blade.php` digunakan oleh hampir semua halaman authenticated.
- `Product.php` digunakan pada Produk, POS/Kasir, Inventory, Transaksi, dan Dashboard.
- `Transaction.php` digunakan pada POS/Kasir, Transaksi, Report, dan Dashboard.
- `PaymentMethod.php` digunakan pada Payment Method, POS/Kasir, Transaksi, Dashboard, dan Report.
- `PermissionMiddleware.php` dan `AppServiceProvider.php` digunakan untuk pembatasan akses berbasis permission.

Dengan adanya shared file, total kontribusi fitur menjadi **219 file**, tetapi total file unik project tetap **92 file** karena file shared hanya dihitung satu kali pada rekap project unik.

### 8.5 Karakteristik Arsitektur Laravel 12 Konvensional

Laravel 12 Konvensional cenderung memiliki struktur file yang eksplisit. Setiap fitur dikembangkan melalui controller, model, route, migration, dan Blade View manual. Berbeda dengan Filament yang banyak menggunakan Resource dan Page Builder, Laravel konvensional mengharuskan developer menulis struktur tampilan, action button, form input, validasi, route, layout, dan query secara lebih langsung.

Struktur ini memberikan kontrol lebih besar kepada developer, tetapi berdampak pada jumlah file kontribusi yang lebih besar karena banyak komponen fitur harus dibuat secara manual.

## 9. Kesimpulan

1. Analisis jumlah file yang dimodifikasi pada sistem POS Laravel 12 Konvensional dilakukan terhadap **13 fitur utama** tanpa membuat kategori Shared/Common terpisah.
2. Total file berbasis kontribusi fitur adalah **219 file**.
3. Total file spesifik fitur adalah **71 file**.
4. Total kemunculan shared file pada tabel fitur adalah **148 file**.
5. Total shared file unik adalah **31 file**.
6. Total file unik project setelah shared file dihitung satu kali adalah **92 file**.
7. Fitur dengan jumlah file terbanyak adalah **Transaksi** dengan **21 file**.
8. Fitur dengan jumlah file tersedikit adalah **Setting** dengan **12 file**.
9. File shared perlu dijelaskan secara eksplisit agar tidak terjadi double-count pada total file unik project.
10. Laravel 12 Konvensional banyak menggunakan Controller, Blade View, Model, Migration, Route manual, Middleware, Provider, Layout, Partial, Component, JavaScript, dan CSS dalam implementasi fitur.
11. Fitur inti seperti Transaksi, Inventory, Produk, dan POS/Kasir memiliki jumlah file lebih tinggi karena proses bisnisnya mencakup transaksi, stok, produk, barcode, pembayaran, PDF, dan tampilan manual.
12. Fitur pendukung seperti Setting memiliki jumlah file lebih rendah karena cakupan proses bisnisnya lebih sederhana.
13. Analisis ini tidak memasukkan seeder, factory, testing, vendor, cache, log, build file, atau file Tailadmin yang tidak relevan.

## 10. Rekomendasi Penulisan dalam Laporan TA

Gunakan kalimat berikut untuk menjelaskan hasil analisis jumlah file yang dimodifikasi pada Laravel 12 Konvensional:

> Berdasarkan hasil analisis jumlah file yang dimodifikasi pada sistem POS Laravel 12 Konvensional, diperoleh total **219 file berbasis kontribusi fitur** dari **13 fitur utama**. Setelah file shared dihitung satu kali, total file unik project adalah **92 file**. Fitur dengan jumlah file terbanyak adalah **Transaksi** dengan **21 file**, sedangkan fitur dengan jumlah file tersedikit adalah **Setting** dengan **12 file**. Hasil ini menunjukkan bahwa Laravel 12 Konvensional membutuhkan struktur file yang lebih eksplisit, seperti controller, Blade View, model, migration, route manual, middleware, provider, layout, partial, component, JavaScript, dan CSS. File shared seperti route, layout, asset global, model, middleware, provider, dan migration perlu dijelaskan secara eksplisit agar tidak terjadi double-count dalam total file unik project.