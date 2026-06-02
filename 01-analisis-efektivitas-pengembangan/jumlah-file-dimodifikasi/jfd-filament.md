# Analisis Jumlah File yang Dimodifikasi
## Sistem POS Laravel Filament

## 1. Metode Analisis

Analisis ini dilakukan dengan melakukan scan langsung terhadap folder project dan mengidentifikasi file source code yang berkontribusi pada implementasi fitur sistem POS Laravel Filament.

Analisis hanya menggunakan **13 fitur utama** dan tidak membuat kategori **Shared/Common** sebagai fitur terpisah. File yang digunakan oleh lebih dari satu fitur tetap dicatat sebagai **Shared File**, tetapi dalam total file unik project file tersebut hanya dihitung satu kali.

File yang dihitung adalah file yang:
1. Dibuat khusus untuk kebutuhan sistem POS.
2. Diubah dari struktur default Laravel/Filament.
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
- file bawaan Laravel/Filament yang tidak dimodifikasi

## 2. Catatan Validasi Angka

Pada hasil awal terdapat ketidaksesuaian aritmetika antara tabel detail dan tabel rekap. Karena itu, laporan ini menggunakan **tabel detail per fitur** sebagai sumber utama.

| Bagian | Angka pada hasil awal | Hasil validasi dari tabel detail | Keterangan |
|---|---:|---:|---|
| Total file berbasis kontribusi fitur | 113 file | 122 file | Hasil penjumlahan 13 fitur: 5 + 7 + 27 + 8 + 9 + 10 + 14 + 7 + 8 + 11 + 5 + 4 + 7 = 122 |
| Total shared file yang dihitung lebih dari sekali | 26 file | 23 file | Berdasarkan file path yang muncul pada lebih dari satu fitur |
| Total file unik project | 87 file | 99 file | Total kontribusi 122 file dikurangi 23 duplikasi shared file |
| Total fitur dianalisis | 13 fitur | 13 fitur | Tidak ada kategori Shared/Common terpisah |

Dengan demikian, angka final yang digunakan adalah:

| Metrik | Nilai Final |
|---|---:|
| Total file berbasis kontribusi fitur | 122 file |
| Total shared file unik | 23 file |
| Total duplikasi shared file | 23 file |
| Total file unik project | 99 file |
| Total fitur dianalisis | 13 fitur |

## 3. Detail Jumlah File yang Dimodifikasi per Fitur

### 3.1 Fitur: Login / Authentication

| No | File | Jenis File | Status | Keterangan |
|---:|---|---|---|---|
| 1 | `app/Models/User.php` | Model | Shared File | Model User untuk autentikasi Filament dan access control |
| 2 | `app/Policies/UserPolicy.php` | Policy | Shared File | Policy untuk mengontrol akses user |
| 3 | `app/Filament/Resources/UserResource.php` | Resource | Shared File | Resource untuk manajemen user di Filament panel |
| 4 | `app/Filament/Resources/UserResource/Pages/ListUsers.php` | Page | Shared File | Page untuk menampilkan daftar user |
| 5 | `config/auth.php` | Config | Shared File | Konfigurasi guard dan provider autentikasi |

| Ringkasan | Nilai |
|---|---:|
| Total File Fitur | 5 |
| Total Shared File | 5 |
| Total File Spesifik Fitur | 0 |

#### Penjelasan

Fitur Login / Authentication menggunakan model user, policy user, resource user, halaman list user, dan konfigurasi autentikasi. File-file tersebut juga digunakan pada fitur User Management, sehingga seluruh file pada fitur ini dikategorikan sebagai **Shared File**.

---

### 3.2 Fitur: Dashboard

| No | File | Jenis File | Status | Keterangan |
|---:|---|---|---|---|
| 1 | `app/Filament/Pages/Dashboard.php` | Page | File Spesifik Fitur | Halaman dashboard utama dengan overview statistik |
| 2 | `app/Filament/Widgets/StatsOverview.php` | Widget | File Spesifik Fitur | Widget untuk menampilkan statistik overview |
| 3 | `app/Filament/Widgets/TotalStatsOverview.php` | Widget | File Spesifik Fitur | Widget untuk total statistik dashboard |
| 4 | `app/Filament/Widgets/CashFlowRadarChart.php` | Widget | Shared File | Widget radar chart untuk visualisasi cash flow |
| 5 | `app/Filament/Widgets/PaymentMethodPieChart.php` | Widget | Shared File | Widget pie chart untuk visualisasi payment method |
| 6 | `app/Filament/Widgets/ProductAlert.php` | Widget | Shared File | Widget alert untuk produk dengan stok rendah |
| 7 | `app/Filament/Widgets/ProductFavorite.php` | Widget | Shared File | Widget untuk menampilkan produk favorit |

| Ringkasan | Nilai |
|---|---:|
| Total File Fitur | 7 |
| Total Shared File | 4 |
| Total File Spesifik Fitur | 3 |

#### Penjelasan

Dashboard memiliki file spesifik berupa halaman utama dan widget statistik. Beberapa widget bersifat shared karena juga berhubungan dengan fitur lain, seperti CashFlow, Payment Method, dan Produk.

---

### 3.3 Fitur: POS / Kasir

| No | File | Jenis File | Status | Keterangan |
|---:|---|---|---|---|
| 1 | `app/Filament/Pages/PosPage.php` | Page | File Spesifik Fitur | Halaman POS/Kasir utama |
| 2 | `app/Livewire/Pos.php` | Livewire | File Spesifik Fitur | Komponen Livewire untuk interface POS |
| 3 | `app/Livewire/ScannerModalComponent.php` | Livewire | File Spesifik Fitur | Komponen Livewire untuk barcode scanner modal |
| 4 | `app/Http/Controllers/ReceiptController.php` | Controller | File Spesifik Fitur | Controller untuk generate dan download receipt |
| 5 | `app/Services/DirectPrintService.php` | Service | File Spesifik Fitur | Service untuk direct print ke printer thermal |
| 6 | `app/Models/Transaction.php` | Model | Shared File | Model untuk data transaksi |
| 7 | `app/Models/TransactionItem.php` | Model | Shared File | Model untuk item transaksi |
| 8 | `app/Observers/TransactionObserver.php` | Observer | Shared File | Observer untuk lifecycle transaksi |
| 9 | `app/Observers/TransactionItemObserver.php` | Observer | Shared File | Observer untuk lifecycle item transaksi |
| 10 | `app/Policies/TransactionPolicy.php` | Policy | Shared File | Policy untuk kontrol akses transaksi |
| 11 | `app/Filament/Resources/TransactionResource.php` | Resource | Shared File | Resource Filament untuk transaksi |
| 12 | `app/Filament/Resources/TransactionResource/Pages/CreateTransaction.php` | Page | Shared File | Page untuk create transaksi |
| 13 | `app/Filament/Resources/TransactionResource/Pages/EditTransaction.php` | Page | Shared File | Page untuk edit transaksi |
| 14 | `app/Filament/Resources/TransactionResource/Pages/ListTransactions.php` | Page | Shared File | Page untuk list transaksi |
| 15 | `app/Filament/Resources/TransactionResource/Pages/ViewTransaction.php` | Page | Shared File | Page untuk view detail transaksi |
| 16 | `app/Filament/Resources/TransactionResource/RelationManagers/TransactionItemsRelationManager.php` | RelationManager | Shared File | Relation manager untuk transaction items |
| 17 | `app/Helpers/TransactionHelper.php` | Helper | Shared File | Helper untuk kalkulasi dan proses transaksi |
| 18 | `resources/views/livewire/pos.blade.php` | Blade View | File Spesifik Fitur | Template Blade untuk interface POS Livewire |
| 19 | `resources/views/livewire/scanner-modal-component.blade.php` | Blade View | File Spesifik Fitur | Template Blade untuk scanner modal |
| 20 | `resources/views/filament/pages/pos-pages.blade.php` | Blade View | File Spesifik Fitur | Template Blade custom untuk POS page |
| 21 | `resources/views/filament/layouts/layout.blade.php` | Blade View | File Spesifik Fitur | Layout custom untuk POS Filament |
| 22 | `resources/views/pdf/receipt/receipt.blade.php` | Blade View | File Spesifik Fitur | Template PDF untuk receipt |
| 23 | `public/js/printer-thermal.js` | JavaScript | File Spesifik Fitur | Script untuk kontrol printer thermal Bluetooth |
| 24 | `public/js/full-screen.js` | JavaScript | File Spesifik Fitur | Script untuk toggle fullscreen mode di POS |
| 25 | `routes/web.php` | Route | File Spesifik Fitur | Route untuk receipt download dan view |
| 26 | `database/migrations/2025_05_28_052629_create_transactions_table.php` | Migration | Shared File | Tabel untuk menyimpan data transaksi |
| 27 | `database/migrations/2025_05_28_052640_create_transaction_items_table.php` | Migration | Shared File | Tabel untuk item transaksi |

| Ringkasan | Nilai |
|---|---:|
| Total File Fitur | 27 |
| Total Shared File | 14 |
| Total File Spesifik Fitur | 13 |

#### Penjelasan

POS/Kasir adalah fitur dengan jumlah file terbanyak karena mencakup halaman POS, Livewire, scanner barcode, receipt, printer thermal, view khusus, JavaScript, route, serta file transaksi yang juga digunakan oleh fitur Transaksi.

Barcode Scanner dan Receipt/Invoice tidak dipisahkan sebagai fitur mandiri karena keduanya menjadi bagian dari proses POS/Kasir.

---

### 3.4 Fitur: Produk

| No | File | Jenis File | Status | Keterangan |
|---:|---|---|---|---|
| 1 | `app/Models/Product.php` | Model | File Spesifik Fitur | Model untuk data produk |
| 2 | `app/Observers/ProductObserver.php` | Observer | File Spesifik Fitur | Observer untuk lifecycle produk |
| 3 | `app/Policies/ProductPolicy.php` | Policy | File Spesifik Fitur | Policy untuk kontrol akses produk |
| 4 | `app/Filament/Resources/ProductResource.php` | Resource | File Spesifik Fitur | Resource Filament untuk manajemen produk |
| 5 | `app/Filament/Resources/ProductResource/Pages/ListProducts.php` | Page | File Spesifik Fitur | Page untuk list produk |
| 6 | `app/Filament/Widgets/ProductAlert.php` | Widget | Shared File | Widget alert produk yang juga digunakan Dashboard |
| 7 | `app/Filament/Widgets/ProductFavorite.php` | Widget | Shared File | Widget produk favorit yang juga digunakan Dashboard |
| 8 | `database/migrations/2025_05_28_052554_create_products_table.php` | Migration | File Spesifik Fitur | Tabel untuk data produk |

| Ringkasan | Nilai |
|---|---:|
| Total File Fitur | 8 |
| Total Shared File | 2 |
| Total File Spesifik Fitur | 6 |

#### Penjelasan

Fitur Produk mencakup model, observer, policy, resource, page, widget, dan migration. File widget produk juga digunakan pada Dashboard, sehingga dikategorikan sebagai shared file.

---

### 3.5 Fitur: Kategori

| No | File | Jenis File | Status | Keterangan |
|---:|---|---|---|---|
| 1 | `app/Models/Category.php` | Model | File Spesifik Fitur | Model untuk data kategori produk |
| 2 | `app/Observers/CategoryObserver.php` | Observer | File Spesifik Fitur | Observer untuk lifecycle kategori |
| 3 | `app/Policies/CategoryPolicy.php` | Policy | File Spesifik Fitur | Policy untuk kontrol akses kategori |
| 4 | `app/Filament/Resources/CategoryResource.php` | Resource | File Spesifik Fitur | Resource Filament untuk manajemen kategori |
| 5 | `app/Filament/Resources/CategoryResource/Pages/CreateCategory.php` | Page | File Spesifik Fitur | Page untuk create kategori |
| 6 | `app/Filament/Resources/CategoryResource/Pages/EditCategory.php` | Page | File Spesifik Fitur | Page untuk edit kategori |
| 7 | `app/Filament/Resources/CategoryResource/Pages/ListCategories.php` | Page | File Spesifik Fitur | Page untuk list kategori |
| 8 | `app/Filament/Resources/CategoryResource/RelationManagers/ProductsRelationManager.php` | RelationManager | File Spesifik Fitur | Relation manager untuk produk dalam kategori |
| 9 | `database/migrations/2025_05_28_052536_create_categories_table.php` | Migration | File Spesifik Fitur | Tabel untuk data kategori |

| Ringkasan | Nilai |
|---|---:|
| Total File Fitur | 9 |
| Total Shared File | 0 |
| Total File Spesifik Fitur | 9 |

#### Penjelasan

Fitur Kategori merupakan fitur yang berdiri sendiri. Seluruh file pada fitur ini berkontribusi langsung pada pengelolaan kategori produk dan tidak digunakan ulang oleh fitur lain dalam tabel detail.

---

### 3.6 Fitur: Inventory

| No | File | Jenis File | Status | Keterangan |
|---:|---|---|---|---|
| 1 | `app/Models/Inventory.php` | Model | File Spesifik Fitur | Model untuk data inventory |
| 2 | `app/Models/Inventoryitem.php` | Model | File Spesifik Fitur | Model untuk item inventory |
| 3 | `app/Observers/InventoryObserver.php` | Observer | File Spesifik Fitur | Observer untuk lifecycle inventory |
| 4 | `app/Observers/InventoryItemObserver.php` | Observer | File Spesifik Fitur | Observer untuk lifecycle inventory item |
| 5 | `app/Policies/InventoryPolicy.php` | Policy | File Spesifik Fitur | Policy untuk kontrol akses inventory |
| 6 | `app/Filament/Resources/InventoryResource.php` | Resource | File Spesifik Fitur | Resource Filament untuk manajemen inventory |
| 7 | `app/Filament/Resources/InventoryResource/Pages/ListInventories.php` | Page | File Spesifik Fitur | Page untuk list inventory |
| 8 | `app/Services/InventoryLabelService.php` | Service | File Spesifik Fitur | Service untuk generate label inventory |
| 9 | `database/migrations/2025_05_28_052715_create_inventories_table.php` | Migration | File Spesifik Fitur | Tabel untuk data inventory |
| 10 | `database/migrations/2025_06_01_084553_create_inventoryitems_table.php` | Migration | File Spesifik Fitur | Tabel untuk item inventory |

| Ringkasan | Nilai |
|---|---:|
| Total File Fitur | 10 |
| Total Shared File | 0 |
| Total File Spesifik Fitur | 10 |

#### Penjelasan

Inventory mencakup pengelolaan stok dan item inventory. File yang dihitung meliputi model, observer, policy, resource, page, service, dan migration. Seluruh file pada fitur ini bersifat spesifik fitur.

---

### 3.7 Fitur: Transaksi

| No | File | Jenis File | Status | Keterangan |
|---:|---|---|---|---|
| 1 | `app/Models/Transaction.php` | Model | Shared File | Model transaksi yang juga digunakan POS/Kasir |
| 2 | `app/Models/TransactionItem.php` | Model | Shared File | Model item transaksi yang juga digunakan POS/Kasir |
| 3 | `app/Observers/TransactionObserver.php` | Observer | Shared File | Observer transaksi yang juga digunakan POS/Kasir |
| 4 | `app/Observers/TransactionItemObserver.php` | Observer | Shared File | Observer item transaksi yang juga digunakan POS/Kasir |
| 5 | `app/Policies/TransactionPolicy.php` | Policy | Shared File | Policy transaksi yang juga digunakan POS/Kasir |
| 6 | `app/Filament/Resources/TransactionResource.php` | Resource | Shared File | Resource transaksi yang juga digunakan POS/Kasir |
| 7 | `app/Filament/Resources/TransactionResource/Pages/CreateTransaction.php` | Page | Shared File | Page create transaksi yang juga digunakan POS/Kasir |
| 8 | `app/Filament/Resources/TransactionResource/Pages/EditTransaction.php` | Page | Shared File | Page edit transaksi yang juga digunakan POS/Kasir |
| 9 | `app/Filament/Resources/TransactionResource/Pages/ListTransactions.php` | Page | Shared File | Page list transaksi yang juga digunakan POS/Kasir |
| 10 | `app/Filament/Resources/TransactionResource/Pages/ViewTransaction.php` | Page | Shared File | Page view transaksi yang juga digunakan POS/Kasir |
| 11 | `app/Filament/Resources/TransactionResource/RelationManagers/TransactionItemsRelationManager.php` | RelationManager | Shared File | Relation manager transaction items yang juga digunakan POS/Kasir |
| 12 | `app/Helpers/TransactionHelper.php` | Helper | Shared File | Helper transaksi yang juga digunakan POS/Kasir |
| 13 | `database/migrations/2025_05_28_052629_create_transactions_table.php` | Migration | Shared File | Tabel transaksi yang juga digunakan POS/Kasir |
| 14 | `database/migrations/2025_05_28_052640_create_transaction_items_table.php` | Migration | Shared File | Tabel item transaksi yang juga digunakan POS/Kasir |

| Ringkasan | Nilai |
|---|---:|
| Total File Fitur | 14 |
| Total Shared File | 14 |
| Total File Spesifik Fitur | 0 |

#### Penjelasan

Fitur Transaksi berbagi seluruh file dengan POS/Kasir karena data transaksi, item transaksi, resource transaksi, observer, helper, relation manager, dan migration digunakan pada konteks transaksi maupun proses kasir.

---

### 3.8 Fitur: CashFlow

| No | File | Jenis File | Status | Keterangan |
|---:|---|---|---|---|
| 1 | `app/Models/CashFlow.php` | Model | File Spesifik Fitur | Model untuk data cash flow |
| 2 | `app/Policies/CashFlowPolicy.php` | Policy | File Spesifik Fitur | Policy untuk kontrol akses cash flow |
| 3 | `app/Filament/Resources/CashFlowResource.php` | Resource | File Spesifik Fitur | Resource Filament untuk manajemen cash flow |
| 4 | `app/Filament/Resources/CashFlowResource/Pages/ListCashFlows.php` | Page | File Spesifik Fitur | Page untuk list cash flow |
| 5 | `app/Filament/Widgets/CashFlowRadarChart.php` | Widget | Shared File | Widget radar chart cash flow yang juga digunakan Dashboard |
| 6 | `app/Services/CashFlowLabelService.php` | Service | File Spesifik Fitur | Service untuk generate label cash flow |
| 7 | `database/migrations/2025_05_28_052738_create_cash_flows_table.php` | Migration | File Spesifik Fitur | Tabel untuk data cash flow |

| Ringkasan | Nilai |
|---|---:|
| Total File Fitur | 7 |
| Total Shared File | 1 |
| Total File Spesifik Fitur | 6 |

#### Penjelasan

Fitur CashFlow menangani pencatatan arus kas masuk dan keluar. File yang dihitung meliputi model, policy, resource, page, widget, service, dan migration. Widget CashFlow bersifat shared karena juga digunakan pada Dashboard.

---

### 3.9 Fitur: Payment Method

| No | File | Jenis File | Status | Keterangan |
|---:|---|---|---|---|
| 1 | `app/Models/PaymentMethod.php` | Model | File Spesifik Fitur | Model untuk data metode pembayaran |
| 2 | `app/Policies/PaymentMethodPolicy.php` | Policy | File Spesifik Fitur | Policy untuk kontrol akses payment method |
| 3 | `app/Filament/Resources/PaymentMethodResource.php` | Resource | File Spesifik Fitur | Resource Filament untuk manajemen payment method |
| 4 | `app/Filament/Resources/PaymentMethodResource/Pages/CreatePaymentMethod.php` | Page | File Spesifik Fitur | Page untuk create payment method |
| 5 | `app/Filament/Resources/PaymentMethodResource/Pages/EditPaymentMethod.php` | Page | File Spesifik Fitur | Page untuk edit payment method |
| 6 | `app/Filament/Resources/PaymentMethodResource/Pages/ListPaymentMethods.php` | Page | File Spesifik Fitur | Page untuk list payment method |
| 7 | `app/Filament/Widgets/PaymentMethodPieChart.php` | Widget | Shared File | Widget pie chart payment method yang juga digunakan Dashboard |
| 8 | `database/migrations/2025_05_28_052608_create_payment_methods_table.php` | Migration | File Spesifik Fitur | Tabel untuk metode pembayaran |

| Ringkasan | Nilai |
|---|---:|
| Total File Fitur | 8 |
| Total Shared File | 1 |
| Total File Spesifik Fitur | 7 |

#### Penjelasan

Fitur Payment Method menangani manajemen metode pembayaran. File yang dihitung meliputi model, policy, resource, page, widget, dan migration. Widget Payment Method bersifat shared karena juga digunakan pada Dashboard.

---

### 3.10 Fitur: Report / Laporan

| No | File | Jenis File | Status | Keterangan |
|---:|---|---|---|---|
| 1 | `app/Models/Report.php` | Model | File Spesifik Fitur | Model untuk data report |
| 2 | `app/Observers/ReportObserver.php` | Observer | File Spesifik Fitur | Observer untuk lifecycle report |
| 3 | `app/Policies/ReportPolicy.php` | Policy | File Spesifik Fitur | Policy untuk kontrol akses report |
| 4 | `app/Filament/Resources/ReportResource.php` | Resource | File Spesifik Fitur | Resource Filament untuk manajemen report |
| 5 | `app/Filament/Resources/ReportResource/Pages/CreateReport.php` | Page | File Spesifik Fitur | Page untuk create report |
| 6 | `app/Filament/Resources/ReportResource/Pages/EditReport.php` | Page | File Spesifik Fitur | Page untuk edit report |
| 7 | `app/Filament/Resources/ReportResource/Pages/ListReports.php` | Page | File Spesifik Fitur | Page untuk list report |
| 8 | `resources/views/pdf/reports/pemasukan.blade.php` | Blade View | File Spesifik Fitur | Template PDF untuk laporan pemasukan |
| 9 | `resources/views/pdf/reports/pengeluaran.blade.php` | Blade View | File Spesifik Fitur | Template PDF untuk laporan pengeluaran |
| 10 | `resources/views/pdf/reports/penjualan.blade.php` | Blade View | File Spesifik Fitur | Template PDF untuk laporan penjualan |
| 11 | `database/migrations/2025_05_28_052755_create_reports_table.php` | Migration | File Spesifik Fitur | Tabel untuk data report |

| Ringkasan | Nilai |
|---|---:|
| Total File Fitur | 11 |
| Total Shared File | 0 |
| Total File Spesifik Fitur | 11 |

#### Penjelasan

Fitur Report / Laporan mencakup pembuatan dan pengelolaan laporan bisnis. File yang dihitung meliputi model, observer, policy, resource, pages, template PDF, dan migration.

---

### 3.11 Fitur: User Management

| No | File | Jenis File | Status | Keterangan |
|---:|---|---|---|---|
| 1 | `app/Models/User.php` | Model | Shared File | Model User yang juga digunakan Login / Authentication |
| 2 | `app/Policies/UserPolicy.php` | Policy | Shared File | Policy User yang juga digunakan Login / Authentication |
| 3 | `app/Filament/Resources/UserResource.php` | Resource | Shared File | Resource User yang juga digunakan Login / Authentication |
| 4 | `app/Filament/Resources/UserResource/Pages/ListUsers.php` | Page | Shared File | Page list User yang juga digunakan Login / Authentication |
| 5 | `config/auth.php` | Config | Shared File | Config auth yang juga digunakan Login / Authentication |

| Ringkasan | Nilai |
|---|---:|
| Total File Fitur | 5 |
| Total Shared File | 5 |
| Total File Spesifik Fitur | 0 |

#### Penjelasan

User Management menggunakan file yang sama dengan Login / Authentication karena pengelolaan user, autentikasi, dan akses panel berkaitan langsung. Karena itu, seluruh file pada fitur ini dikategorikan sebagai shared file.

---

### 3.12 Fitur: Role / Permission

| No | File | Jenis File | Status | Keterangan |
|---:|---|---|---|---|
| 1 | `app/Policies/RolePolicy.php` | Policy | File Spesifik Fitur | Policy untuk kontrol akses role |
| 2 | `config/permission.php` | Config | File Spesifik Fitur | Konfigurasi Spatie Permission |
| 3 | `config/filament-shield.php` | Config | File Spesifik Fitur | Konfigurasi Filament Shield untuk role dan permission |
| 4 | `database/migrations/2024_06_25_092758_create_permission_tables.php` | Migration | File Spesifik Fitur | Tabel untuk role dan permission |

| Ringkasan | Nilai |
|---|---:|
| Total File Fitur | 4 |
| Total Shared File | 0 |
| Total File Spesifik Fitur | 4 |

#### Penjelasan

Role / Permission menangani akses kontrol berbasis role. File yang dihitung meliputi policy, konfigurasi Spatie Permission, konfigurasi Filament Shield, dan migration permission table.

---

### 3.13 Fitur: Setting

| No | File | Jenis File | Status | Keterangan |
|---:|---|---|---|---|
| 1 | `app/Models/Setting.php` | Model | File Spesifik Fitur | Model untuk setting sistem |
| 2 | `app/Policies/SettingPolicy.php` | Policy | File Spesifik Fitur | Policy untuk kontrol akses setting |
| 3 | `app/Filament/Resources/SettingResource.php` | Resource | File Spesifik Fitur | Resource Filament untuk manajemen setting |
| 4 | `app/Filament/Resources/SettingResource/Pages/CreateSetting.php` | Page | File Spesifik Fitur | Page untuk create setting |
| 5 | `app/Filament/Resources/SettingResource/Pages/EditSetting.php` | Page | File Spesifik Fitur | Page untuk edit setting |
| 6 | `app/Filament/Resources/SettingResource/Pages/ListSettings.php` | Page | File Spesifik Fitur | Page untuk list setting |
| 7 | `database/migrations/2025_05_28_052809_create_settings_table.php` | Migration | File Spesifik Fitur | Tabel untuk data setting |

| Ringkasan | Nilai |
|---|---:|
| Total File Fitur | 7 |
| Total Shared File | 0 |
| Total File Spesifik Fitur | 7 |

#### Penjelasan

Setting menangani konfigurasi sistem POS. File yang dihitung meliputi model, policy, resource, pages, dan migration. Seluruh file pada fitur ini bersifat spesifik fitur.

## 4. Rekapitulasi Jumlah File per Fitur

| No | Fitur | Total File | File Spesifik Fitur | Shared File | Jenis File Dominan | Keterangan |
|---:|---|---:|---:|---:|---|---|
| 1 | Login / Authentication | 5 | 0 | 5 | Model / Policy / Resource | Shared dengan User Management |
| 2 | Dashboard | 7 | 3 | 4 | Widget / Page | Halaman dashboard dan widget statistik |
| 3 | POS / Kasir | 27 | 13 | 14 | Page / View / Model | Fitur paling kompleks dengan POS, barcode, receipt, dan direct print |
| 4 | Produk | 8 | 6 | 2 | Resource / Widget / Model | Produk dan widget produk |
| 5 | Kategori | 9 | 9 | 0 | Page / Model / Resource | Fitur kategori produk |
| 6 | Inventory | 10 | 10 | 0 | Model / Observer / Migration | Fitur manajemen stok |
| 7 | Transaksi | 14 | 0 | 14 | Page / Model / Resource | Fully shared dengan POS/Kasir |
| 8 | CashFlow | 7 | 6 | 1 | Resource / Model / Widget | Shared widget dengan Dashboard |
| 9 | Payment Method | 8 | 7 | 1 | Page / Resource / Model | Shared widget dengan Dashboard |
| 10 | Report / Laporan | 11 | 11 | 0 | Page / View / Resource | Fitur laporan bisnis |
| 11 | User Management | 5 | 0 | 5 | Model / Policy / Resource | Fully shared dengan Login/Auth |
| 12 | Role / Permission | 4 | 4 | 0 | Config / Policy / Migration | Sistem akses kontrol |
| 13 | Setting | 7 | 7 | 0 | Page / Resource / Model | Pengaturan sistem |
|  | **Total** | **122** | **76** | **46** |  |  |

> Catatan: total shared file pada tabel rekap adalah **46 kemunculan shared file**, bukan file shared unik. File shared unik berjumlah **23 file**.

## 5. Rekapitulasi File Unik Project

| Metrik | Nilai |
|---|---:|
| Total file berbasis kontribusi fitur | 122 file |
| Total file spesifik fitur | 76 file |
| Total kemunculan shared file pada tabel fitur | 46 file |
| Total shared file unik | 23 file |
| Total duplikasi shared file | 23 file |
| Total file unik project | 99 file |
| Total fitur dianalisis | 13 fitur |

### Perhitungan

```text
Total file berbasis kontribusi fitur:
5 + 7 + 27 + 8 + 9 + 10 + 14 + 7 + 8 + 11 + 5 + 4 + 7 = 122 file

Total duplikasi shared file:
46 kemunculan shared file - 23 shared file unik = 23 duplikasi

Total file unik project:
122 total kontribusi - 23 duplikasi = 99 file unik
```

## 6. Persentase Kontribusi File per Fitur

Persentase dihitung berdasarkan total kontribusi fitur sebesar **122 file**.

| Fitur | Total File | Persentase terhadap Total File Kontribusi |
|---|---:|---:|
| POS / Kasir | 27 | 22,13% |
| Transaksi | 14 | 11,48% |
| Report / Laporan | 11 | 9,02% |
| Inventory | 10 | 8,20% |
| Kategori | 9 | 7,38% |
| Produk | 8 | 6,56% |
| Payment Method | 8 | 6,56% |
| Dashboard | 7 | 5,74% |
| CashFlow | 7 | 5,74% |
| Setting | 7 | 5,74% |
| Login / Authentication | 5 | 4,10% |
| User Management | 5 | 4,10% |
| Role / Permission | 4 | 3,28% |
| **Total** | **122** | **100,00%** |

## 7. File Shared

| No | Shared File | Jenis File | Digunakan pada Fitur | Keterangan |
|---:|---|---|---|---|
| 1 | `app/Models/User.php` | Model | Login / Authentication, User Management | Model User untuk autentikasi dan manajemen user |
| 2 | `app/Policies/UserPolicy.php` | Policy | Login / Authentication, User Management | Policy untuk kontrol akses user |
| 3 | `app/Filament/Resources/UserResource.php` | Resource | Login / Authentication, User Management | Resource user untuk kedua fitur |
| 4 | `app/Filament/Resources/UserResource/Pages/ListUsers.php` | Page | Login / Authentication, User Management | Page list user untuk kedua fitur |
| 5 | `config/auth.php` | Config | Login / Authentication, User Management | Konfigurasi autentikasi global |
| 6 | `app/Filament/Widgets/CashFlowRadarChart.php` | Widget | Dashboard, CashFlow | Widget visualisasi cashflow |
| 7 | `app/Filament/Widgets/PaymentMethodPieChart.php` | Widget | Dashboard, Payment Method | Widget visualisasi metode pembayaran |
| 8 | `app/Filament/Widgets/ProductAlert.php` | Widget | Dashboard, Produk | Widget alert stok produk |
| 9 | `app/Filament/Widgets/ProductFavorite.php` | Widget | Dashboard, Produk | Widget produk favorit |
| 10 | `app/Models/Transaction.php` | Model | POS / Kasir, Transaksi | Model transaksi untuk kasir dan histori transaksi |
| 11 | `app/Models/TransactionItem.php` | Model | POS / Kasir, Transaksi | Model item transaksi |
| 12 | `app/Observers/TransactionObserver.php` | Observer | POS / Kasir, Transaksi | Observer transaksi |
| 13 | `app/Observers/TransactionItemObserver.php` | Observer | POS / Kasir, Transaksi | Observer item transaksi |
| 14 | `app/Policies/TransactionPolicy.php` | Policy | POS / Kasir, Transaksi | Policy transaksi |
| 15 | `app/Filament/Resources/TransactionResource.php` | Resource | POS / Kasir, Transaksi | Resource transaksi |
| 16 | `app/Filament/Resources/TransactionResource/Pages/CreateTransaction.php` | Page | POS / Kasir, Transaksi | Page create transaksi |
| 17 | `app/Filament/Resources/TransactionResource/Pages/EditTransaction.php` | Page | POS / Kasir, Transaksi | Page edit transaksi |
| 18 | `app/Filament/Resources/TransactionResource/Pages/ListTransactions.php` | Page | POS / Kasir, Transaksi | Page list transaksi |
| 19 | `app/Filament/Resources/TransactionResource/Pages/ViewTransaction.php` | Page | POS / Kasir, Transaksi | Page view transaksi |
| 20 | `app/Filament/Resources/TransactionResource/RelationManagers/TransactionItemsRelationManager.php` | RelationManager | POS / Kasir, Transaksi | Relation manager transaction items |
| 21 | `app/Helpers/TransactionHelper.php` | Helper | POS / Kasir, Transaksi | Helper kalkulasi transaksi |
| 22 | `database/migrations/2025_05_28_052629_create_transactions_table.php` | Migration | POS / Kasir, Transaksi | Tabel transaksi |
| 23 | `database/migrations/2025_05_28_052640_create_transaction_items_table.php` | Migration | POS / Kasir, Transaksi | Tabel item transaksi |

## 8. Analisis Hasil

### 8.1 Fitur dengan Jumlah File Terbanyak

Fitur dengan jumlah file terbanyak adalah **POS / Kasir** dengan **27 file** atau **22,13%** dari total kontribusi fitur. Jumlah ini tinggi karena POS/Kasir mencakup banyak komponen, seperti halaman POS, Livewire, barcode scanner, receipt, direct print service, JavaScript printer, view POS, route receipt, serta file transaksi yang juga digunakan oleh fitur Transaksi.

Fitur terbesar kedua adalah **Transaksi** dengan **14 file** atau **11,48%**. Seluruh file pada fitur Transaksi bersifat shared dengan POS/Kasir karena transaksi menjadi inti dari proses kasir.

### 8.2 Fitur dengan Jumlah File Tersedikit

Fitur dengan jumlah file tersedikit adalah **Role / Permission** dengan **4 file** atau **3,28%**. Hal ini karena Role / Permission lebih berfungsi sebagai infrastruktur akses, bukan fitur bisnis operasional yang memiliki banyak halaman, service, atau view.

### 8.3 Jenis File yang Dominan

Jenis file yang dominan pada Laravel Filament adalah:
1. **Filament Page**, karena setiap resource umumnya memiliki halaman list, create, edit, atau view.
2. **Filament Resource**, karena resource menjadi pusat konfigurasi fitur administratif.
3. **Model**, karena setiap entitas bisnis tetap direpresentasikan sebagai model.
4. **Policy**, karena akses fitur dikontrol melalui authorization.
5. **Observer**, karena beberapa proses otomatis seperti transaksi, produk, inventory, dan report dijalankan melalui lifecycle model.
6. **Migration**, karena setiap entitas membutuhkan struktur tabel.
7. **Widget**, karena dashboard dan visualisasi data menggunakan komponen widget.
8. **Blade View**, terutama untuk POS, receipt, dan report PDF.

### 8.4 Peran File Shared

File shared memiliki peran penting untuk menghindari duplikasi implementasi. Contohnya:
- File user digunakan oleh Login / Authentication dan User Management.
- File transaksi digunakan oleh POS / Kasir dan Transaksi.
- Widget CashFlow, Payment Method, dan Produk digunakan oleh Dashboard serta fitur asal datanya.
- File migration transaksi digunakan oleh POS / Kasir dan Transaksi karena keduanya mengacu pada tabel transaksi yang sama.

Dengan adanya shared file, total kontribusi fitur mencapai **122 file**, tetapi setelah file shared dihitung satu kali, total file unik project menjadi **99 file**.

### 8.5 Karakteristik Arsitektur Laravel Filament

Laravel Filament cenderung memiliki struktur file yang terdiri dari Resource, Page, Widget, Policy, Observer, Livewire, Service, dan Blade View. Hal ini terjadi karena Filament menyediakan pola pengembangan administratif berbasis resource. Resource menangani form dan table, Page menangani halaman fitur, Widget menangani ringkasan dan visualisasi data, Policy mengatur akses, dan Observer menangani proses otomatis pada lifecycle model.

Meskipun Filament mengurangi penulisan kode manual pada fitur administratif, fitur dengan business logic tinggi seperti POS/Kasir tetap membutuhkan banyak file tambahan seperti Livewire component, service printer, controller receipt, custom view, dan JavaScript.

## 9. Kesimpulan

1. Analisis jumlah file yang dimodifikasi pada sistem POS Laravel Filament dilakukan terhadap **13 fitur utama** tanpa membuat kategori Shared/Common terpisah.
2. Total file berbasis kontribusi fitur adalah **122 file**.
3. Total file spesifik fitur adalah **76 file**.
4. Total kemunculan shared file pada tabel fitur adalah **46 file**.
5. Total shared file unik adalah **23 file**.
6. Total file unik project setelah shared file dihitung satu kali adalah **99 file**.
7. Fitur dengan jumlah file terbanyak adalah **POS / Kasir** dengan **27 file**.
8. Fitur dengan jumlah file tersedikit adalah **Role / Permission** dengan **4 file**.
9. File shared perlu dijelaskan secara eksplisit agar tidak terjadi double-count pada total file unik project.
10. Laravel Filament banyak menggunakan Resource, Page, Widget, Policy, Observer, Livewire, Service, dan Blade View dalam implementasi fitur.
11. Fitur administratif seperti Kategori, Payment Method, User Management, dan Setting cenderung lebih terstruktur melalui Resource dan Page.
12. Fitur operasional inti seperti POS / Kasir membutuhkan lebih banyak file karena mencakup barcode scanner, receipt, printer thermal, Livewire, JavaScript, dan proses transaksi.
13. Angka **113 file** dan **87 file unik** pada rekap awal tidak digunakan sebagai angka final karena tidak konsisten dengan tabel detail fitur.

## 10. Rekomendasi Penulisan dalam Laporan TA

Gunakan kalimat berikut untuk menjelaskan hasil analisis jumlah file yang dimodifikasi pada Laravel Filament:

> Berdasarkan hasil analisis jumlah file yang dimodifikasi pada sistem POS Laravel Filament, diperoleh total **122 file berbasis kontribusi fitur** dari **13 fitur utama**. Setelah file shared dihitung satu kali, total file unik project adalah **99 file**. Fitur dengan jumlah file terbanyak adalah **POS / Kasir** dengan **27 file**, sedangkan fitur dengan jumlah file tersedikit adalah **Role / Permission** dengan **4 file**. Hasil ini menunjukkan bahwa Laravel Filament banyak menggunakan struktur Resource, Page, Widget, Policy, Observer, Livewire, Service, dan Blade View. File shared seperti file user, transaksi, widget dashboard, dan migration transaksi perlu dijelaskan secara eksplisit agar tidak terjadi double-count dalam total file unik project.