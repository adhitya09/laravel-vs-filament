# Laporan Perhitungan LOC (Lines of Code)
## Sistem POS Laravel Filament

> **Basis laporan:** hasil perhitungan LOC Laravel Filament yang dikirimkan. Laporan ini hanya merapikan struktur ke dalam format laporan MD, memperjelas alasan pengelompokan, dan menyusun ulang bagian rekapitulasi tanpa mengubah angka LOC, total file, maupun tingkat kompleksitas yang sudah tersedia.

## 1. Identitas Perhitungan

| Komponen | Keterangan |
|---|---|
| Sistem | POS Laravel Filament |
| Metode | Physical Lines of Code (PLOC) |
| Aturan hitung | Menghitung baris kode fisik aktif, tanpa blank line dan tanpa komentar |
| Basis data | Hasil scan file Laravel Filament yang dikirimkan |
| Cakupan | Model, config, migration, Filament resource, Filament page, widget, Livewire, view, controller, service, JS, observer, policy, helper, dan route manual |
| Pengecualian | File testing, seeder, factory, file log, asset hasil build, dan file bawaan package/library yang tidak termasuk custom production code |
| Catatan route | `routes/web.php` hanya dihitung pada fitur yang benar-benar menggunakan route manual karena sebagian besar route Laravel Filament dihasilkan otomatis oleh panel provider |

## 2. Catatan Metode Perhitungan

Perhitungan LOC pada sistem POS Laravel Filament menggunakan metode **Physical Lines of Code (PLOC)**, yaitu menghitung jumlah baris kode fisik aktif tanpa menghitung baris kosong dan komentar. Perhitungan hanya dilakukan pada production code utama agar hasil lebih representatif terhadap implementasi sistem nyata.

Pada Laravel Filament, sebagian besar fitur dibangun menggunakan **Filament Resource**, **Filament Page**, **Widget**, **Policy**, **Observer**, dan komponen pendukung lain. Oleh karena itu, struktur LOC pada versi Filament berbeda dari Laravel konvensional karena banyak proses CRUD, routing, form, table, dan otorisasi dibantu oleh mekanisme otomatis dari framework Filament.

## 3. Detail Perhitungan LOC per Fitur

### 3.1. Fitur: Login / Authentication

**Alasan pengelompokan:** Fitur Login/Authentication digunakan untuk autentikasi pengguna dan validasi akses panel Filament menggunakan Spatie Permission dan Filament Shield.

| No | File | Jenis File | LOC | Keterangan |
|---:|---|---|---:|---|
| 1 | `app/Models/User.php` | Model | 32 | Mendukung autentikasi pengguna dan relasi akses user |
| 2 | `config/auth.php` | Config | 28 | Konfigurasi autentikasi Laravel |
| 3 | `config/permission.php` | Config | 32 | Konfigurasi permission berbasis Spatie Permission |
| 4 | `config/filament-shield.php` | Config | 76 | Konfigurasi otorisasi panel menggunakan Filament Shield |
| 5 | `database/migrations/0001_01_01_000000_create_users_table.php` | Migration | 38 | Struktur tabel user untuk autentikasi |

**Total LOC:** 206  
**Total File:** 5  
**Jenis File Dominan:** Config  
**Tingkat Kompleksitas:** Rendah

### 3.2. Fitur: Dashboard

**Alasan pengelompokan:** Dashboard digunakan untuk menampilkan statistik transaksi, grafik penjualan, monitoring stok produk, dan informasi sistem secara visual menggunakan widget Filament.

| No | File | Jenis File | LOC | Keterangan |
|---:|---|---|---:|---|
| 1 | `app/Filament/Pages/Dashboard.php` | Page | 45 | Halaman dashboard utama Filament |
| 2 | `app/Filament/Widgets/StatsOverview.php` | Widget | 56 | Widget ringkasan statistik sistem |
| 3 | `app/Filament/Widgets/TotalStatsOverview.php` | Widget | 33 | Widget total statistik utama |
| 4 | `app/Filament/Widgets/ProductAlert.php` | Widget | 59 | Widget peringatan produk |
| 5 | `app/Filament/Widgets/ProductFavorite.php` | Widget | 34 | Widget produk favorit |
| 6 | `app/Filament/Widgets/CashFlowRadarChart.php` | Widget | 56 | Widget grafik cashflow |
| 7 | `app/Filament/Widgets/PaymentMethodPieChart.php` | Widget | 42 | Widget grafik metode pembayaran |

**Total LOC:** 325  
**Total File:** 7  
**Jenis File Dominan:** Widget  
**Tingkat Kompleksitas:** Sedang

### 3.3. Fitur: POS / Kasir

**Alasan pengelompokan:** Fitur POS/Kasir merupakan fitur inti sistem yang mencakup transaksi penjualan, barcode scanner, checkout, cart management, printer thermal, dan pencetakan receipt transaksi.

| No | File | Jenis File | LOC | Keterangan |
|---:|---|---|---:|---|
| 1 | `app/Livewire/Pos.php` | Livewire | 326 | Logika utama transaksi kasir berbasis Livewire |
| 2 | `resources/views/livewire/pos.blade.php` | View | 448 | Tampilan utama halaman POS/Kasir |
| 3 | `app/Filament/Pages/PosPage.php` | Page | 24 | Halaman POS di panel Filament |
| 4 | `resources/views/filament/pages/pos-pages.blade.php` | View | 41 | View halaman POS pada Filament |
| 5 | `public/js/full-screen.js` | JS | 9 | Script pendukung mode layar penuh |
| 6 | `resources/views/receipt.blade.php` | View | 238 | Tampilan receipt transaksi |
| 7 | `app/Http/Controllers/ReceiptController.php` | Controller | 37 | Controller untuk proses receipt |
| 8 | `app/Services/DirectPrintService.php` | Service | 88 | Service untuk proses direct print |
| 9 | `public/js/printer-thermal.js` | JS | 114 | Script printer thermal |
| 10 | `app/Livewire/ScannerModalComponent.php` | Livewire | 19 | Komponen scanner barcode |
| 11 | `resources/views/livewire/scanner-modal-component.blade.php` | View | 40 | Tampilan modal scanner barcode |
| 12 | `resources/views/barcode.blade.php` | View | 56 | Tampilan barcode |
| 13 | `routes/web.php` | Route | 6 | Route manual yang digunakan untuk fitur POS/Kasir |

**Total LOC:** 1446  
**Total File:** 13  
**Jenis File Dominan:** View  
**Tingkat Kompleksitas:** Sangat Tinggi

### 3.4. Fitur: Produk

**Alasan pengelompokan:** Fitur Produk digunakan untuk pengelolaan data produk, upload gambar produk, barcode produk, harga jual, dan status produk aktif.

| No | File | Jenis File | LOC | Keterangan |
|---:|---|---|---:|---|
| 1 | `app/Filament/Resources/ProductResource.php` | Resource | 219 | Resource utama untuk manajemen produk |
| 2 | `app/Filament/Resources/ProductResource/Pages/ListProducts.php` | Page | 50 | Halaman daftar produk |
| 3 | `app/Models/Product.php` | Model | 21 | Model data produk |
| 4 | `app/Observers/ProductObserver.php` | Observer | 58 | Observer untuk proses otomatis terkait produk |

**Total LOC:** 348  
**Total File:** 4  
**Jenis File Dominan:** Resource  
**Tingkat Kompleksitas:** Tinggi

### 3.5. Fitur: Kategori

**Alasan pengelompokan:** Fitur kategori digunakan untuk mengelompokkan produk berdasarkan kategori tertentu sehingga pengelolaan produk menjadi lebih terstruktur.

| No | File | Jenis File | LOC | Keterangan |
|---:|---|---|---:|---|
| 1 | `app/Filament/Resources/CategoryResource.php` | Resource | 109 | Resource utama untuk manajemen kategori |
| 2 | `app/Filament/Resources/CategoryResource/Pages/CreateCategory.php` | Page | 9 | Halaman tambah kategori |
| 3 | `app/Filament/Resources/CategoryResource/Pages/EditCategory.php` | Page | 15 | Halaman edit kategori |
| 4 | `app/Filament/Resources/CategoryResource/Pages/ListCategories.php` | Page | 15 | Halaman daftar kategori |
| 5 | `app/Models/Category.php` | Model | 14 | Model data kategori |
| 6 | `app/Observers/CategoryObserver.php` | Observer | 18 | Observer untuk proses otomatis kategori |
| 7 | `app/Policies/CategoryPolicy.php` | Policy | 57 | Policy akses fitur kategori |

**Total LOC:** 237  
**Total File:** 7  
**Jenis File Dominan:** Resource  
**Tingkat Kompleksitas:** Sedang

### 3.6. Fitur: Inventory

**Alasan pengelompokan:** Inventory digunakan untuk pengelolaan stok masuk, stok keluar, dan sinkronisasi stok otomatis menggunakan observer inventory.

| No | File | Jenis File | LOC | Keterangan |
|---:|---|---|---:|---|
| 1 | `app/Filament/Resources/InventoryResource.php` | Resource | 214 | Resource utama untuk manajemen inventory |
| 2 | `app/Filament/Resources/InventoryResource/Pages/ListInventories.php` | Page | 15 | Halaman daftar inventory |
| 3 | `app/Models/Inventory.php` | Model | 13 | Model inventory |
| 4 | `app/Models/InventoryItem.php` | Model | 22 | Model item inventory |
| 5 | `app/Observers/InventoryObserver.php` | Observer | 52 | Observer untuk proses otomatis inventory |
| 6 | `app/Observers/InventoryItemObserver.php` | Observer | 44 | Observer untuk proses otomatis item inventory |
| 7 | `database/migrations/2025_05_28_052715_create_inventories_table.php` | Migration | 23 | Struktur tabel inventory |
| 8 | `database/migrations/2025_06_01_084553_create_inventoryitems_table.php` | Migration | 21 | Struktur tabel inventory item |
| 9 | `app/Services/InventoryLabelService.php` | Service | 44 | Service label inventory |
| 10 | `app/Policies/InventoryPolicy.php` | Policy | 57 | Policy akses inventory |

**Total LOC:** 505  
**Total File:** 10  
**Jenis File Dominan:** Resource  
**Tingkat Kompleksitas:** Tinggi

### 3.7. Fitur: Transaksi

**Alasan pengelompokan:** Fitur transaksi digunakan untuk menyimpan histori transaksi, relasi item transaksi, sinkronisasi stok otomatis, dan detail transaksi penjualan.

| No | File | Jenis File | LOC | Keterangan |
|---:|---|---|---:|---|
| 1 | `app/Filament/Resources/TransactionResource.php` | Resource | 383 | Resource utama untuk manajemen transaksi |
| 2 | `app/Filament/Resources/TransactionResource/Pages/ListTransactions.php` | Page | 27 | Halaman daftar transaksi |
| 3 | `app/Filament/Resources/TransactionResource/Pages/EditTransaction.php` | Page | 33 | Halaman edit transaksi |
| 4 | `app/Filament/Resources/TransactionResource/Pages/CreateTransaction.php` | Page | 9 | Halaman tambah transaksi |
| 5 | `app/Filament/Resources/TransactionResource/Pages/ViewTransaction.php` | Page | 10 | Halaman detail transaksi |
| 6 | `app/Filament/Resources/TransactionResource/RelationManagers/TransactionItemsRelationManager.php` | Relation Manager | 52 | Relation manager item transaksi |
| 7 | `app/Models/Transaction.php` | Model | 25 | Model transaksi |
| 8 | `app/Models/TransactionItem.php` | Model | 23 | Model item transaksi |
| 9 | `app/Observers/TransactionObserver.php` | Observer | 75 | Observer transaksi |
| 10 | `app/Observers/TransactionItemObserver.php` | Observer | 34 | Observer item transaksi |
| 11 | `database/migrations/2025_05_28_052629_create_transactions_table.php` | Migration | 29 | Struktur tabel transaksi |
| 12 | `database/migrations/2025_05_28_052640_create_transaction_items_table.php` | Migration | 24 | Struktur tabel item transaksi |
| 13 | `app/Helpers/TransactionHelper.php` | Helper | 14 | Helper proses transaksi |
| 14 | `app/Policies/TransactionPolicy.php` | Policy | 57 | Policy akses transaksi |

**Total LOC:** 795  
**Total File:** 14  
**Jenis File Dominan:** Resource  
**Tingkat Kompleksitas:** Sangat Tinggi

### 3.8. Fitur: CashFlow

**Alasan pengelompokan:** CashFlow digunakan untuk pencatatan pemasukan dan pengeluaran sistem serta monitoring statistik cashflow secara visual.

| No | File | Jenis File | LOC | Keterangan |
|---:|---|---|---:|---|
| 1 | `app/Filament/Resources/CashFlowResource.php` | Resource | 174 | Resource utama untuk pencatatan cashflow |
| 2 | `app/Filament/Resources/CashFlowResource/Pages/ListCashFlows.php` | Page | 23 | Halaman daftar cashflow |
| 3 | `app/Filament/Widgets/IncomeOverview.php` | Widget | 32 | Widget ringkasan pemasukan |
| 4 | `app/Models/CashFlow.php` | Model | 9 | Model cashflow |
| 5 | `database/migrations/2025_05_28_052738_create_cash_flows_table.php` | Migration | 23 | Struktur tabel cashflow |
| 6 | `app/Policies/CashFlowPolicy.php` | Policy | 57 | Policy akses cashflow |
| 7 | `app/Services/CashFlowLabelService.php` | Service | 52 | Service label cashflow |

**Total LOC:** 370  
**Total File:** 7  
**Jenis File Dominan:** Resource  
**Tingkat Kompleksitas:** Sedang

### 3.9. Fitur: Payment Method

**Alasan pengelompokan:** Payment Method digunakan untuk mengelola metode pembayaran transaksi seperti cash dan non-cash.

| No | File | Jenis File | LOC | Keterangan |
|---:|---|---|---:|---|
| 1 | `app/Filament/Resources/PaymentMethodResource.php` | Resource | 107 | Resource utama metode pembayaran |
| 2 | `app/Filament/Resources/PaymentMethodResource/Pages/CreatePaymentMethod.php` | Page | 9 | Halaman tambah metode pembayaran |
| 3 | `app/Filament/Resources/PaymentMethodResource/Pages/EditPaymentMethod.php` | Page | 15 | Halaman edit metode pembayaran |
| 4 | `app/Filament/Resources/PaymentMethodResource/Pages/ListPaymentMethods.php` | Page | 15 | Halaman daftar metode pembayaran |
| 5 | `app/Models/PaymentMethod.php` | Model | 10 | Model metode pembayaran |
| 6 | `database/migrations/2025_05_28_052608_create_payment_methods_table.php` | Migration | 22 | Struktur tabel metode pembayaran |
| 7 | `app/Policies/PaymentMethodPolicy.php` | Policy | 57 | Policy akses metode pembayaran |

**Total LOC:** 235  
**Total File:** 7  
**Jenis File Dominan:** Resource  
**Tingkat Kompleksitas:** Rendah

### 3.10. Fitur: Report / Laporan

**Alasan pengelompokan:** Fitur laporan digunakan untuk menampilkan laporan transaksi, laporan pemasukan, laporan pengeluaran, dan export laporan sistem.

| No | File | Jenis File | LOC | Keterangan |
|---:|---|---|---:|---|
| 1 | `app/Filament/Resources/ReportResource.php` | Resource | 131 | Resource utama laporan |
| 2 | `app/Filament/Resources/ReportResource/Pages/CreateReport.php` | Page | 9 | Halaman tambah laporan |
| 3 | `app/Filament/Resources/ReportResource/Pages/EditReport.php` | Page | 15 | Halaman edit laporan |
| 4 | `app/Filament/Resources/ReportResource/Pages/ListReports.php` | Page | 15 | Halaman daftar laporan |
| 5 | `app/Models/Report.php` | Model | 10 | Model laporan |
| 6 | `database/migrations/2025_05_28_052755_create_reports_table.php` | Migration | 23 | Struktur tabel laporan |
| 7 | `app/Policies/ReportPolicy.php` | Policy | 57 | Policy akses laporan |
| 8 | `app/Observers/ReportObserver.php` | Observer | 110 | Observer laporan |
| 9 | `resources/views/reports/penjualan.blade.php` | View | 123 | View laporan penjualan |
| 10 | `resources/views/reports/pemasukan.blade.php` | View | 105 | View laporan pemasukan |
| 11 | `resources/views/reports/pengeluaran.blade.php` | View | 105 | View laporan pengeluaran |

**Total LOC:** 703  
**Total File:** 11  
**Jenis File Dominan:** Resource  
**Tingkat Kompleksitas:** Tinggi

### 3.11. Fitur: User Management

**Alasan pengelompokan:** User Management digunakan untuk pengelolaan data pengguna sistem dan validasi akses pengguna menggunakan policy dan permission management.

| No | File | Jenis File | LOC | Keterangan |
|---:|---|---|---:|---|
| 1 | `app/Filament/Resources/UserResource.php` | Resource | 90 | Resource utama user management |
| 2 | `app/Filament/Resources/UserResource/Pages/ListUsers.php` | Page | 15 | Halaman daftar user |
| 3 | `app/Models/User.php` | Model | 32 | Model user |
| 4 | `app/Policies/UserPolicy.php` | Policy | 56 | Policy akses user |

**Total LOC:** 193  
**Total File:** 4  
**Jenis File Dominan:** Resource  
**Tingkat Kompleksitas:** Rendah

### 3.12. Fitur: Role / Permission

**Alasan pengelompokan:** Role/Permission digunakan untuk pengaturan hak akses pengguna sistem menggunakan Spatie Permission dan Filament Shield.

| No | File | Jenis File | LOC | Keterangan |
|---:|---|---|---:|---|
| 1 | `config/permission.php` | Config | 32 | Konfigurasi permission Spatie |
| 2 | `database/migrations/2024_06_25_092758_create_permission_tables.php` | Migration | 109 | Struktur tabel permission dan role |
| 3 | `config/filament-shield.php` | Config | 76 | Konfigurasi Filament Shield |
| 4 | `app/Policies/RolePolicy.php` | Policy | 57 | Policy akses role |

**Total LOC:** 274  
**Total File:** 4  
**Jenis File Dominan:** Config  
**Tingkat Kompleksitas:** Rendah

### 3.13. Fitur: Setting

**Alasan pengelompokan:** Fitur setting digunakan untuk konfigurasi umum sistem seperti identitas toko, logo toko, printer, dan pengaturan POS lainnya.

| No | File | Jenis File | LOC | Keterangan |
|---:|---|---|---:|---|
| 1 | `app/Filament/Resources/SettingResource.php` | Resource | 128 | Resource utama setting |
| 2 | `app/Filament/Resources/SettingResource/Pages/CreateSetting.php` | Page | 9 | Halaman tambah setting |
| 3 | `app/Filament/Resources/SettingResource/Pages/EditSetting.php` | Page | 15 | Halaman edit setting |
| 4 | `app/Filament/Resources/SettingResource/Pages/ListSettings.php` | Page | 15 | Halaman daftar setting |
| 5 | `app/Models/Setting.php` | Model | 11 | Model setting |
| 6 | `database/migrations/2025_05_28_052809_create_settings_table.php` | Migration | 24 | Struktur tabel setting |
| 7 | `app/Policies/SettingPolicy.php` | Policy | 57 | Policy akses setting |

**Total LOC:** 259  
**Total File:** 7  
**Jenis File Dominan:** Resource  
**Tingkat Kompleksitas:** Rendah

## 4. Rekapitulasi Total Seluruh Fitur

| No | Fitur | Total LOC | Total File | Jenis File Dominan | Tingkat Kompleksitas |
|---:|---|---:|---:|---|---|
| 1 | Login / Authentication | 206 | 5 | Config | Rendah |
| 2 | Dashboard | 325 | 7 | Widget | Sedang |
| 3 | POS / Kasir | 1446 | 13 | View | Sangat Tinggi |
| 4 | Produk | 348 | 4 | Resource | Tinggi |
| 5 | Kategori | 237 | 7 | Resource | Sedang |
| 6 | Inventory | 505 | 10 | Resource | Tinggi |
| 7 | Transaksi | 795 | 14 | Resource | Sangat Tinggi |
| 8 | CashFlow | 370 | 7 | Resource | Sedang |
| 9 | Payment Method | 235 | 7 | Resource | Rendah |
| 10 | Report / Laporan | 703 | 11 | Resource | Tinggi |
| 11 | User Management | 193 | 4 | Resource | Rendah |
| 12 | Role / Permission | 274 | 4 | Config | Rendah |
| 13 | Setting | 259 | 7 | Resource | Rendah |
|  | **Total** | **5896** | **100** |  |  |

## 5. Ringkasan Keseluruhan Project

| Aspek | Hasil |
|---|---:|
| Total LOC Seluruh Fitur | 5.896 LOC |
| Total File Seluruh Fitur | 100 File |
| Rata-rata LOC per Fitur | 453 LOC |
| Fitur dengan LOC Terbesar | POS / Kasir (1446 LOC) |
| Fitur dengan LOC Terkecil | User Management (193 LOC) |
| Dominasi Arsitektur | Filament Resource & Widget |
| Tingkat Otomatisasi Framework | Tinggi |
| Dominasi Business Logic Manual | POS / Kasir |

## 6. Fitur dengan LOC Terbesar dan Terkecil

### 6.1 LOC Terbesar

| Peringkat | Fitur | Total LOC | Keterangan |
|---:|---|---:|---|
| 1 | POS / Kasir | 1446 | Fitur inti dengan proses transaksi, cart, checkout, barcode scanner, thermal printer, dan receipt |
| 2 | Transaksi | 795 | Mengelola histori transaksi, item transaksi, observer, policy, dan relasi data transaksi |
| 3 | Report / Laporan | 703 | Mengelola laporan transaksi, pemasukan, pengeluaran, dan tampilan laporan |
| 4 | Inventory | 505 | Mengelola stok masuk, stok keluar, item inventory, observer, dan service label |
| 5 | CashFlow | 370 | Mengelola pencatatan pemasukan dan pengeluaran serta ringkasan cashflow |

### 6.2 LOC Terkecil

| Peringkat | Fitur | Total LOC | Keterangan |
|---:|---|---:|---|
| 1 | User Management | 193 | Pengelolaan user relatif ringkas karena dibantu resource dan policy Filament |
| 2 | Login / Authentication | 206 | Autentikasi banyak ditangani oleh konfigurasi Laravel, Filament Shield, dan Spatie Permission |
| 3 | Payment Method | 235 | CRUD metode pembayaran cukup sederhana |
| 4 | Kategori | 237 | CRUD kategori relatif sederhana dengan resource, page, model, observer, dan policy |
| 5 | Setting | 259 | Konfigurasi umum sistem dengan resource, model, migration, dan policy |

## 7. Catatan File Shared dan Kontribusinya

Beberapa file digunakan oleh lebih dari satu fitur. Pada laporan ini, angka tetap mengikuti hasil perhitungan yang dikirimkan dan tidak dilakukan perubahan terhadap total LOC maupun total file.

| No | File Shared | Jenis File | LOC | Digunakan pada Fitur |
|---:|---|---|---:|---|
| 1 | `app/Models/User.php` | Model | 32 | Login / Authentication dan User Management |
| 2 | `config/permission.php` | Config | 32 | Login / Authentication dan Role / Permission |
| 3 | `config/filament-shield.php` | Config | 76 | Login / Authentication dan Role / Permission |

## 8. Catatan Khusus Receipt/Invoice dan Barcode Scanner

### 8.1 Receipt / Invoice

Fitur receipt/invoice berada dalam kelompok POS/Kasir karena proses pencetakan receipt merupakan bagian langsung dari transaksi kasir.

| File | Lokasi Fitur | LOC | Keterangan |
|---|---|---:|---|
| `resources/views/receipt.blade.php` | POS / Kasir | 238 | Tampilan receipt transaksi |
| `app/Http/Controllers/ReceiptController.php` | POS / Kasir | 37 | Controller untuk proses receipt |
| `app/Services/DirectPrintService.php` | POS / Kasir | 88 | Service untuk direct print |
| `public/js/printer-thermal.js` | POS / Kasir | 114 | Script printer thermal |

### 8.2 Barcode Scanner

Fitur barcode scanner berada dalam kelompok POS/Kasir karena digunakan pada proses transaksi kasir dan pemindaian produk.

| File | Lokasi Fitur | LOC | Keterangan |
|---|---|---:|---|
| `app/Livewire/ScannerModalComponent.php` | POS / Kasir | 19 | Komponen Livewire scanner barcode |
| `resources/views/livewire/scanner-modal-component.blade.php` | POS / Kasir | 40 | Tampilan modal scanner barcode |
| `resources/views/barcode.blade.php` | POS / Kasir | 56 | Tampilan barcode |
| `app/Livewire/Pos.php` | POS / Kasir | 326 | Logika utama POS yang terhubung dengan proses barcode dan transaksi |

## 9. Analisis Hasil

Berdasarkan hasil perhitungan LOC, sistem POS Laravel Filament memiliki total **5.896 LOC** dari **100 file**. Angka ini menunjukkan bahwa implementasi sistem menggunakan Filament cenderung lebih ringkas dibandingkan pendekatan konvensional karena banyak kebutuhan administratif seperti CRUD, form, tabel, action, policy, dan layout panel telah difasilitasi oleh ekosistem Filament.

Fitur dengan LOC terbesar adalah **POS / Kasir** sebesar **1446 LOC**. Hal ini wajar karena fitur POS/Kasir merupakan fitur inti yang tidak sepenuhnya dapat diotomatisasi oleh Filament. Fitur ini masih membutuhkan logika manual untuk cart management, checkout, barcode scanner, receipt, direct print, dan integrasi printer thermal.

Fitur dengan LOC terbesar berikutnya adalah **Transaksi** sebesar **795 LOC** dan **Report / Laporan** sebesar **703 LOC**. Kedua fitur ini memiliki kebutuhan proses yang lebih kompleks karena berkaitan dengan relasi data, observer, policy, tampilan laporan, dan pemrosesan data transaksi.

Sebaliknya, fitur dengan LOC terkecil adalah **User Management** sebesar **193 LOC**, diikuti oleh **Login / Authentication** sebesar **206 LOC** dan **Payment Method** sebesar **235 LOC**. Rendahnya LOC pada fitur tersebut menunjukkan bahwa Filament Resource, Spatie Permission, dan Filament Shield membantu mengurangi kebutuhan penulisan kode manual.

Secara umum, dominasi arsitektur pada sistem ini berada pada **Filament Resource & Widget**. Hal ini menunjukkan bahwa pendekatan Filament lebih banyak mengandalkan komponen framework untuk membangun fitur administratif, sehingga jumlah kode manual dapat ditekan tanpa menghilangkan fungsi utama sistem.

## 10. Kesimpulan

1. Total LOC seluruh fitur pada sistem POS Laravel Filament adalah **5.896 LOC**.
2. Total file seluruh fitur adalah **100 file**.
3. Rata-rata LOC per fitur adalah **453 LOC**.
4. Fitur dengan LOC terbesar adalah **POS / Kasir** dengan **1446 LOC**.
5. Fitur dengan LOC terkecil adalah **User Management** dengan **193 LOC**.
6. Dominasi arsitektur sistem berada pada **Filament Resource & Widget**.
7. Tingkat otomatisasi framework tergolong **tinggi** karena banyak proses CRUD, form, table, policy, dan halaman administratif dibantu oleh Filament.
8. Business logic manual paling dominan berada pada fitur **POS / Kasir** karena fitur ini mencakup transaksi langsung, cart, checkout, receipt, barcode scanner, dan printer thermal.

## 11. Rekomendasi Penulisan dalam Laporan TA

Untuk menjaga konsistensi akademik, gunakan kalimat berikut saat menjelaskan hasil perhitungan LOC Laravel Filament:

> Berdasarkan perhitungan Physical Lines of Code (PLOC), sistem POS Laravel Filament memiliki total **5.896 LOC** dari **100 file**. Perhitungan dilakukan dengan mengabaikan blank line dan komentar, serta hanya menghitung production code utama. Hasil perhitungan menunjukkan bahwa fitur dengan LOC terbesar adalah **POS / Kasir** sebesar **1446 LOC**, sedangkan fitur dengan LOC terkecil adalah **User Management** sebesar **193 LOC**. Dominasi arsitektur sistem berada pada **Filament Resource & Widget**, yang menunjukkan bahwa penggunaan Laravel Filament mampu mengurangi kebutuhan penulisan kode manual pada fitur administratif melalui mekanisme resource, page, widget, policy, dan konfigurasi otomatis.