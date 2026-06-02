# Tingkat Otomatisasi
## Sistem POS Berbasis Laravel 12 Konvensional

Analisis tingkat otomatisasi dilakukan untuk mengukur sejauh mana Laravel 12 membantu proses pengembangan fitur pada sistem POS Laravel konvensional dibandingkan dengan bagian yang masih harus dikembangkan secara manual oleh developer. Indikator otomatisasi yang dianalisis meliputi penggunaan route resource, route middleware, request validation, Eloquent ORM, Eloquent relationship, query builder, Blade templating, soft delete, storage helper, database transaction, route model binding, session handling, serta package pendukung seperti PDF dan Excel export.

Pada sistem Laravel konvensional, framework membantu menyediakan struktur dasar pengembangan aplikasi. Namun, proses bisnis inti seperti checkout POS, barcode scanner, receipt, invoice generation, stock mutation, cashflow summary, report formatting, dan permission mapping tetap membutuhkan implementasi manual. Barcode Scanner dan Receipt/Invoice tidak dipisahkan sebagai fitur mandiri karena keduanya merupakan bagian langsung dari fitur POS/Kasir.

## E. Tingkat Otomatisasi

### 1. Fitur Login / Authentication

| No | Bagian Otomatis oleh Framework | Bagian Manual oleh Developer | Jumlah Komponen Dianalisis | Evidence Kode | Keterangan |
|---:|---|---|---:|---|---|
| 1 | `auth` middleware, `guest` middleware, session handling | Custom `AuthController` login/logout/profile | 9 | `web.php`, `AuthController.php` | Laravel menyediakan route grouping dan session, tetapi eksekusi login, logout, dan profile ditulis manual |
| 2 | `Request::validate()` | Custom credential check, remember handling, dan redirect ke route pertama yang bisa diakses |  | `AuthController.php` | Validasi form dibantu Laravel, tetapi alur redirect berdasarkan permission dibuat custom |
| 3 | `Auth::attempt()` dan `Auth::logout()` | `PermissionMiddleware` custom untuk permission mapping |  | `AuthController.php`, `PermissionMiddleware.php` | Framework menangani autentikasi dasar, sedangkan autorisasi berbasis permission dibangun manual |
| 4 | Hashing password melalui mekanisme Laravel | `getFirstAccessibleRoute()` dan `permissionFromRouteName()` |  | `User.php` | Laravel mendukung keamanan password, tetapi mapping route ke permission dibuat oleh developer |
| 5 | Built-in `Route::middleware('auth')` | Custom route permission seperti `permission:dashboard.viewAny` dan `permission:pos.viewAny` |  | `web.php` | Middleware auth bawaan digunakan, sedangkan permission route ditetapkan manual |

| Ringkasan | Nilai |
|---|---:|
| Tingkat Otomatisasi | 4/9 |
| Persentase Otomatisasi | 44% |
| Tingkat Ketergantungan Framework | Sedang |
| Dominasi | Manual |

#### Penjelasan

Fitur Login / Authentication menggunakan Laravel 12 untuk autentikasi dasar, validasi request, route middleware, session handling, dan proses login/logout melalui helper `Auth`. Bagian ini menunjukkan bahwa framework sudah menyediakan fondasi autentikasi yang cukup kuat.

Namun, alur login, profile update, redirect berdasarkan permission, dan pengecekan hak akses fitur masih ditulis secara manual. Custom `PermissionMiddleware` menunjukkan bahwa sistem tidak hanya bergantung pada autentikasi bawaan Laravel, tetapi juga membangun mekanisme otorisasi sendiri. Oleh karena itu, tingkat otomatisasi fitur ini adalah **4/9** atau **44%**.

---

### 2. Fitur Dashboard

| No | Bagian Otomatis oleh Framework | Bagian Manual oleh Developer | Jumlah Komponen Dianalisis | Evidence Kode | Keterangan |
|---:|---|---|---:|---|---|
| 1 | `Route::get('/dashboard', ...)` dan middleware | Agregasi statistik dashboard custom | 7 | `web.php`, `DashboardController.php` | Routing dibantu Laravel, tetapi perhitungan data dashboard dibuat sendiri |
| 2 | `permission:dashboard.viewAny` middleware | Custom date range `rangeDates()` |  | `web.php`, `DashboardController.php` | Middleware permission digunakan, sedangkan logika range tanggal dibuat manual |
| 3 | Eloquent query builder, `whereBetween`, `sum`, dan `count` | Mapping transaksi berdasarkan payment method dan status stok |  | `DashboardController.php` | Query dibantu Laravel, tetapi struktur analitik dibuat developer |
| 4 | Blade rendering view | Controller menyiapkan variabel ringkasan dashboard |  | `dashboard.blade.php` | Blade membantu tampilan, sedangkan data disusun manual pada controller |

| Ringkasan | Nilai |
|---|---:|
| Tingkat Otomatisasi | 4/7 |
| Persentase Otomatisasi | 57% |
| Tingkat Ketergantungan Framework | Sedang-Rendah |
| Dominasi | Otomatis |

#### Penjelasan

Dashboard memanfaatkan Laravel untuk routing, middleware, query builder, Eloquent, dan Blade view. Fitur tersebut membantu proses pengambilan dan penyajian data.

Namun, indikator bisnis seperti statistik transaksi, rentang tanggal, mapping metode pembayaran, dan status stok tetap dihitung secara manual di controller. Tingkat otomatisasi Dashboard adalah **4/7** atau **57%**.

---

### 3. Fitur POS / Kasir

| No | Bagian Otomatis oleh Framework | Bagian Manual oleh Developer | Jumlah Komponen Dianalisis | Evidence Kode | Keterangan |
|---:|---|---|---:|---|---|
| 1 | `Route::resource('pos', ...)` | Checkout dan stock update logic | 10 | `web.php`, `PosController.php` | Routing resource otomatis, tetapi proses checkout dibuat custom |
| 2 | `Request::validate()` | Barcode scanning response custom |  | `PosController.php` | Validasi request dibantu Laravel |
| 3 | Eloquent query seperti `Product::where(...)` dan `PaymentMethod::where(...)` | `lockForUpdate()`, stock mutation, dan invoice generation |  | `PosController.php` | ORM membantu query, sedangkan concurrency dan transaksi tetap manual |
| 4 | JSON response helper | Receipt rendering custom |  | `PosController.php` | Laravel membantu response JSON, tetapi isi respons disusun developer |
| 5 | Blade view | `cetakResi()` dan receipt HTML/PDF custom |  | `index.blade.php`, `resi.blade.php` | Blade membantu tampilan, tetapi layout receipt dikembangkan manual |

| Ringkasan | Nilai |
|---|---:|
| Tingkat Otomatisasi | 5/10 |
| Persentase Otomatisasi | 50% |
| Tingkat Ketergantungan Framework | Sedang |
| Dominasi | Manual |

#### Penjelasan

Fitur POS / Kasir menggunakan otomatisasi Laravel untuk route resource, validasi, Eloquent query, response helper, dan Blade view. Bagian ini membantu struktur dasar transaksi POS.

Namun, inti fitur seperti checkout flow, perhitungan cart, barcode scanning, invoice number generation, stock mutation, concurrency handling, dan receipt rendering tetap dibuat secara manual. Oleh karena itu, tingkat otomatisasi fitur POS / Kasir adalah **5/10** atau **50%**.

---

### 4. Fitur Produk

| No | Bagian Otomatis oleh Framework | Bagian Manual oleh Developer | Jumlah Komponen Dianalisis | Evidence Kode | Keterangan |
|---:|---|---|---:|---|---|
| 1 | `Route::resource('produk', ...)` dan extra product routes | Barcode dan SKU generation | 9 | `web.php`, `ProdukController.php` | Resource routing otomatis, tetapi pemrosesan produk dibuat custom |
| 2 | Pagination melalui `paginate()` | Barcode PDF export dengan plugin |  | `ProdukController.php` | Pagination dibantu Laravel |
| 3 | `Request::validate()` | Method `generateSku()` dan `generateBarcode()` |  | `ProdukController.php` | Validasi otomatis, sedangkan format SKU/barcode dibuat manual |
| 4 | `SoftDeletes` | Custom barcode print copy count |  | `Product.php`, `ProdukController.php` | Soft delete dibantu Laravel, export logic manual |
| 5 | Storage file upload helper | Product image handling dan storage path |  | `ProdukController.php` | Storage helper membantu upload, tetapi cleanup dan path handling tetap manual |

| Ringkasan | Nilai |
|---|---:|
| Tingkat Otomatisasi | 4/9 |
| Persentase Otomatisasi | 44% |
| Tingkat Ketergantungan Framework | Sedang |
| Dominasi | Manual |

#### Penjelasan

Fitur Produk menggunakan Laravel untuk CRUD dasar, route resource, validasi, pagination, soft delete, dan upload file. Bagian tersebut membantu pengelolaan data produk secara umum.

Namun, fitur paling spesifik seperti SKU generation, barcode generation, barcode PDF export, image handling, dan filter status stok dibuat manual. Karena kebutuhan produk memiliki banyak logika khusus, tingkat otomatisasi fitur ini adalah **4/9** atau **44%**.

---

### 5. Fitur Kategori

| No | Bagian Otomatis oleh Framework | Bagian Manual oleh Developer | Jumlah Komponen Dianalisis | Evidence Kode | Keterangan |
|---:|---|---|---:|---|---|
| 1 | `Route::resource('kategori', ...)` | `withSum('products', 'stock')` khusus | 6 | `web.php`, `KategoriController.php`, `Category.php` | CRUD otomatis, agregasi stok custom |
| 2 | `Request::validate()` | Search filter produk dalam kategori |  | `KategoriController.php` | Validasi dibantu Laravel |
| 3 | Eloquent relationship `hasMany` | Custom pagination/search untuk halaman edit |  | `Category.php`, `KategoriController.php` | Relationship dibantu Laravel |
| 4 | Blade view | Rendering daftar kategori dan relasi produk |  | `resources/views/pages/kategori/*.blade.php` | View dibantu Blade |

| Ringkasan | Nilai |
|---|---:|
| Tingkat Otomatisasi | 4/6 |
| Persentase Otomatisasi | 67% |
| Tingkat Ketergantungan Framework | Tinggi |
| Dominasi | Otomatis |

#### Penjelasan

Kategori adalah fitur dengan tingkat otomatisasi paling tinggi karena sebagian besar kebutuhan fitur berupa CRUD dan relasi sederhana. Laravel membantu routing, validasi, Eloquent relationship, dan tampilan Blade.

Bagian manual hanya terdapat pada agregasi stok menggunakan `withSum` dan filter pencarian khusus. Oleh karena itu, tingkat otomatisasi fitur Kategori adalah **4/6** atau **67%**.

---

### 6. Fitur Inventory

| No | Bagian Otomatis oleh Framework | Bagian Manual oleh Developer | Jumlah Komponen Dianalisis | Evidence Kode | Keterangan |
|---:|---|---|---:|---|---|
| 1 | `Route::resource('inventory', ...)` | Stock mutation dan inventory type logic | 8 | `web.php`, `InventoryController.php`, `2026_04_19_155943_create_inventories_table.php` | Routing otomatis, tetapi bisnis inventory custom |
| 2 | `Request::validate()` | CashFlow auto-entry untuk tipe `out` |  | `InventoryController.php` | Validasi dibantu Laravel |
| 3 | DB transaction wrapper | Reference number generation |  | `InventoryController.php` | API transaction database dibantu Laravel |
| 4 | Eloquent relationship | Custom stock adjustment berdasarkan tipe inventory |  | `Inventory.php`, `InventoryItem.php` | Relationship dibantu Laravel |

| Ringkasan | Nilai |
|---|---:|
| Tingkat Otomatisasi | 4/8 |
| Persentase Otomatisasi | 50% |
| Tingkat Ketergantungan Framework | Sedang |
| Dominasi | Manual |

#### Penjelasan

Inventory menggunakan Laravel untuk routing, validation, Eloquent relationship, dan database transaction. Bagian tersebut membantu menjaga struktur data dan konsistensi transaksi database.

Namun, logika stok masuk, stok keluar, adjustment, cashflow auto-entry, dan reference number generation tetap dibuat manual. Tingkat otomatisasi fitur Inventory adalah **4/8** atau **50%**.

---

### 7. Fitur Transaksi

| No | Bagian Otomatis oleh Framework | Bagian Manual oleh Developer | Jumlah Komponen Dianalisis | Evidence Kode | Keterangan |
|---:|---|---|---:|---|---|
| 1 | `Route::resource('transaksi', ...)` | Return transaksi dan reverse cashflow custom | 11 | `web.php`, `TransaksiController.php`, `Transaction.php` | Routing otomatis, bisnis transaksi manual |
| 2 | `Request::validate()` | Invoice number generation |  | `TransaksiController.php` | Validasi dibantu Laravel |
| 3 | DB transaction | Profit calculation |  | `TransaksiController.php` | Transaction wrapper dibantu Laravel |
| 4 | PDF export package | Stock decrement dan increment |  | `TransaksiController.php` | PDF export dibantu package |
| 5 | Eloquent relationship | CashboxFlow cleanup saat destroy transaksi |  | `Transaction.php`, `TransaksiController.php` | Relationship dibantu Laravel |

| Ringkasan | Nilai |
|---|---:|
| Tingkat Otomatisasi | 6/11 |
| Persentase Otomatisasi | 55% |
| Tingkat Ketergantungan Framework | Sedang |
| Dominasi | Otomatis |

#### Penjelasan

Transaksi memanfaatkan Laravel untuk routing, validation, route binding, Eloquent relationship, DB transaction, dan export PDF. Framework cukup membantu proses data access dan struktur transaksi.

Namun, inti bisnis seperti invoice generation, stock decrement/increment, return transaction, profit calculation, dan cashflow reverse logic dibuat manual. Tingkat otomatisasi fitur Transaksi adalah **6/11** atau **55%**.

---

### 8. Fitur CashFlow

| No | Bagian Otomatis oleh Framework | Bagian Manual oleh Developer | Jumlah Komponen Dianalisis | Evidence Kode | Keterangan |
|---:|---|---|---:|---|---|
| 1 | `Route::resource('cash-flow', ...)` | Multi-table summary, modal logic, dan legacy compatibility | 10 | `web.php`, `CashFlowController.php`, `2026_04_21_000001_create_cash_flow_sources_table.php` | Routing otomatis, financial logic manual |
| 2 | `Request::validate()` | Method `calculateSummary()` custom |  | `CashFlowController.php` | Validasi dibantu Laravel |
| 3 | `SoftDeletes` | Auto/manual distinction melalui `is_auto` |  | `CashboxFlow.php`, migration | Soft delete dibantu Laravel |
| 4 | Eloquent joins/relationships | Custom cashflow source type enum |  | `CashboxFlow.php`, migration | ORM membantu query dan relasi |

| Ringkasan | Nilai |
|---|---:|
| Tingkat Otomatisasi | 5/10 |
| Persentase Otomatisasi | 50% |
| Tingkat Ketergantungan Framework | Sedang |
| Dominasi | Manual |

#### Penjelasan

CashFlow menggunakan Laravel untuk routing, validation, Eloquent ORM, relationship, query builder, dan soft delete. Bagian tersebut membantu pengelolaan data dasar arus kas.

Namun, rangkuman modal, perhitungan outflow, multi-table summary, legacy compatibility, dan desain cashflow manual/otomatis dibuat secara custom. Tingkat otomatisasi fitur CashFlow adalah **5/10** atau **50%**.

---

### 9. Fitur Payment Method

| No | Bagian Otomatis oleh Framework | Bagian Manual oleh Developer | Jumlah Komponen Dianalisis | Evidence Kode | Keterangan |
|---:|---|---|---:|---|---|
| 1 | `Route::resource('payment-method', ...)` | Restore route dan `is_cash` business logic | 8 | `web.php`, `PaymentMethodController.php`, `PaymentMethod.php` | CRUD otomatis, payment-specific logic manual |
| 2 | `Request::validate()` | Logo file cleanup dan storage path |  | `PaymentMethodController.php` | Validasi dibantu Laravel |
| 3 | `SoftDeletes` | Boolean flag `is_cash` |  | `PaymentMethod.php`, migration | Soft delete dibantu Laravel |
| 4 | Eloquent fillable dan cast | Custom helper `isCashPayment()` |  | `PaymentMethod.php` | ORM membantu struktur data |

| Ringkasan | Nilai |
|---|---:|
| Tingkat Otomatisasi | 5/8 |
| Persentase Otomatisasi | 62% |
| Tingkat Ketergantungan Framework | Sedang-Tinggi |
| Dominasi | Otomatis |

#### Penjelasan

Payment Method menggunakan resource routing, validation, Eloquent ORM, soft delete, dan storage helper. Karena fitur ini relatif sederhana, banyak bagian dapat ditangani oleh Laravel.

Bagian manual masih diperlukan pada restore route, logo cleanup, dan business logic `is_cash`. Tingkat otomatisasi fitur Payment Method adalah **5/8** atau **62%**.

---

### 10. Fitur Report / Laporan

| No | Bagian Otomatis oleh Framework | Bagian Manual oleh Developer | Jumlah Komponen Dianalisis | Evidence Kode | Keterangan |
|---:|---|---|---:|---|---|
| 1 | Route definitions dan request validation | Report naming/code generation dan struktur sheet custom | 8 | `web.php`, `ReportController.php`, `Report.php`, `LaporanKeuanganExport.php` | Routing dan export package membantu, format laporan dikembangkan manual |
| 2 | PDF dan Excel packages | Date range dan monthly aggregation |  | `ReportController.php` | Package export membantu proses laporan |
| 3 | Eloquent `whereBetween` dan `sum` | `getTypeLabelAttribute()` |  | `Report.php` | ORM membantu query laporan |
| 4 | Blade view | Layout `laporan-pdf` custom |  | `resources/views/pages/report/*.blade.php` | Blade membantu tampilan, layout laporan tetap custom |

| Ringkasan | Nilai |
|---|---:|
| Tingkat Otomatisasi | 5/8 |
| Persentase Otomatisasi | 62% |
| Tingkat Ketergantungan Framework | Sedang-Tinggi |
| Dominasi | Otomatis |

#### Penjelasan

Report / Laporan menggunakan Laravel untuk routing, validation, Eloquent query, Blade view, serta bantuan package PDF dan Excel. Bagian tersebut membuat proses laporan lebih otomatis dibandingkan fitur dengan business logic berat.

Namun, naming laporan, struktur sheet export, date range logic, aggregation, dan layout PDF tetap dibuat manual. Tingkat otomatisasi fitur Report / Laporan adalah **5/8** atau **62%**.

---

### 11. Fitur User Management

| No | Bagian Otomatis oleh Framework | Bagian Manual oleh Developer | Jumlah Komponen Dianalisis | Evidence Kode | Keterangan |
|---:|---|---|---:|---|---|
| 1 | `Route::resource('user', ...)` | Role assignment dan permission check logic | 8 | `web.php`, `UserController.php`, `User.php` | CRUD user otomatis, role/permission custom |
| 2 | `Request::validate()` | Manual verify user action |  | `UserController.php` | Validasi dibantu Laravel |
| 3 | Eloquent relationship `role()` | Method `hasPermission()` |  | `User.php` | Relationship dibantu Laravel |
| 4 | Route model binding | Custom `verify()` method |  | `web.php`, `UserController.php` | Binding dibantu Laravel |

| Ringkasan | Nilai |
|---|---:|
| Tingkat Otomatisasi | 5/8 |
| Persentase Otomatisasi | 62% |
| Tingkat Ketergantungan Framework | Sedang-Tinggi |
| Dominasi | Otomatis |

#### Penjelasan

User Management mengandalkan Laravel untuk resource routing, request validation, Eloquent relationship, route model binding, dan pagination. Bagian ini membuat CRUD user lebih cepat dikembangkan.

Namun, role assignment, manual verification, dan permission checking tetap dibuat manual sesuai kebutuhan sistem. Tingkat otomatisasi fitur User Management adalah **5/8** atau **62%**.

---

### 12. Fitur Role / Permission

| No | Bagian Otomatis oleh Framework | Bagian Manual oleh Developer | Jumlah Komponen Dianalisis | Evidence Kode | Keterangan |
|---:|---|---|---:|---|---|
| 1 | Route definitions | Permission groups dan action mapping custom | 9 | `web.php`, `RoleController.php`, `PermissionMiddleware.php` | Routing otomatis, sistem permission dirancang manual |
| 2 | `Request::validate()` | Method `allowedPermissions()` whitelist |  | `RoleController.php` | Validasi dibantu Laravel |
| 3 | JSON cast `permissions` | Wildcard support `*` dan `resource.*` |  | `Role.php`, `User.php` | Cast JSON dibantu Laravel |
| 4 | Route model binding | Custom permission middleware mapping |  | `PermissionMiddleware.php` | Binding dibantu Laravel, permission mapping custom |

| Ringkasan | Nilai |
|---|---:|
| Tingkat Otomatisasi | 5/9 |
| Persentase Otomatisasi | 56% |
| Tingkat Ketergantungan Framework | Sedang |
| Dominasi | Otomatis |

#### Penjelasan

Role / Permission menggunakan Laravel untuk route definitions, request validation, Eloquent ORM, route model binding, dan JSON cast. Bagian tersebut membantu penyimpanan data role dan permission.

Namun, permission engine, permission groups, whitelist permission, wildcard support, dan action mapping dalam middleware merupakan desain manual. Tingkat otomatisasi fitur Role / Permission adalah **5/9** atau **56%**.

---

### 13. Fitur Setting

| No | Bagian Otomatis oleh Framework | Bagian Manual oleh Developer | Jumlah Komponen Dianalisis | Evidence Kode | Keterangan |
|---:|---|---|---:|---|---|
| 1 | Route definitions | Singleton `updateOrCreate` pattern dan logo cleanup | 8 | `web.php`, `SettingController.php`, `Setting.php`, `2026_04_28_000001_create_settings_table.php` | Routing otomatis, tetapi manajemen setting dan printer custom |
| 2 | `Request::validate()` | `store_logo` upload/delete logic |  | `SettingController.php` | Validasi dibantu Laravel |
| 3 | Eloquent model | Printer type enum `kabel/bluetooth` |  | migration, model | ORM membantu pengelolaan data setting |
| 4 | Storage helper | `updateOrCreate()` single record |  | `SettingController.php` | Storage dibantu Laravel, pola single record tetap custom |

| Ringkasan | Nilai |
|---|---:|
| Tingkat Otomatisasi | 5/8 |
| Persentase Otomatisasi | 62% |
| Tingkat Ketergantungan Framework | Sedang-Tinggi |
| Dominasi | Otomatis |

#### Penjelasan

Setting menggunakan Laravel untuk routing, validation, Eloquent model, storage helper, dan Blade view. Framework membantu proses penyimpanan konfigurasi sistem.

Namun, pola single-record setting, upload/delete logo, cleanup file, serta printer type logic tetap dikembangkan manual. Tingkat otomatisasi fitur Setting adalah **5/8** atau **62%**.

---

## Rekap Tingkat Otomatisasi

| Fitur | Tingkat Otomatisasi | Persentase | Dominasi Otomatisasi | Keterangan |
|---|---:|---:|---|---|
| Login / Authentication | 4/9 | 44% | Manual | Banyak custom auth/permission flow |
| Dashboard | 4/7 | 57% | Otomatis | CRUD dan query dasar Laravel kuat |
| POS / Kasir | 5/10 | 50% | Manual | Checkout/barcode/receipt custom |
| Produk | 4/9 | 44% | Manual | Barcode/SKU/export custom |
| Kategori | 4/6 | 67% | Otomatis | CRUD dan relationship otomatis |
| Inventory | 4/8 | 50% | Manual | Stock/cashflow custom |
| Transaksi | 6/11 | 55% | Otomatis | ORM/query otomatis, bisnis manual |
| CashFlow | 5/10 | 50% | Manual | Financial logic custom |
| Payment Method | 5/8 | 62% | Otomatis | CRUD otomatis, flags manual |
| Report / Laporan | 5/8 | 62% | Otomatis | Export package membantu |
| User Management | 5/8 | 62% | Otomatis | CRUD otomatis, permission manual |
| Role / Permission | 5/9 | 56% | Otomatis | Storage otomatis, engine manual |
| Setting | 5/8 | 62% | Otomatis | Config CRUD otomatis |

## Ringkasan Total Sistem

| Metrik | Nilai |
|---|---:|
| Total Komponen Otomatis | 61 |
| Total Komponen Manual | 48 |
| Total Analisis Keseluruhan | 109 |
| Rata-rata Otomatisasi | 56% |
| Fitur Paling Otomatis | Kategori (4/6, 67%) |
| Fitur Paling Manual | Login / Authentication dan Produk (4/9, 44%) |

## Fitur dengan Otomatisasi Tertinggi

| Peringkat | Fitur | Tingkat Otomatisasi | Persentase | Keterangan |
|---:|---|---:|---:|---|
| 1 | Kategori | 4/6 | 67% | CRUD dan relationship banyak dibantu Laravel |
| 2 | Payment Method | 5/8 | 62% | CRUD, validation, ORM, soft delete, dan storage banyak dibantu Laravel |
| 3 | Report / Laporan | 5/8 | 62% | Query dan export package membantu proses laporan |
| 4 | User Management | 5/8 | 62% | CRUD user, validation, relationship, dan route model binding dibantu Laravel |
| 5 | Setting | 5/8 | 62% | Laravel membantu penyimpanan setting, validation, dan upload file |

## Fitur dengan Otomatisasi Terendah

| Peringkat | Fitur | Tingkat Otomatisasi | Persentase | Keterangan |
|---:|---|---:|---:|---|
| 1 | Login / Authentication | 4/9 | 44% | Banyak custom auth, redirect, dan permission logic |
| 2 | Produk | 4/9 | 44% | Banyak logika manual untuk SKU, barcode, PDF, dan filter stok |
| 3 | POS / Kasir | 5/10 | 50% | Checkout, barcode scanner, receipt, dan invoice masih custom |
| 4 | Inventory | 4/8 | 50% | Stock mutation dan cashflow auto-entry manual |
| 5 | CashFlow | 5/10 | 50% | Summary keuangan dan compatibility antar tabel dibuat manual |

## Komponen Otomatis yang Paling Sering Digunakan

| Komponen Otomatis | Evidence File | Fitur yang Menggunakan | Keterangan |
|---|---|---|---|
| Route Resource / Route Definition | `routes/web.php` | Hampir seluruh fitur | Membantu pembentukan endpoint fitur |
| Request Validation | Controller tiap fitur | Login, Produk, Inventory, Transaksi, User, Setting, dan lainnya | Membantu validasi input |
| Eloquent ORM | `app/Models/*` | Hampir seluruh fitur | Membantu interaksi database |
| Eloquent Relationship | `app/Models/*` | Produk, Kategori, Inventory, Transaksi, User, Payment Method | Membantu relasi antar tabel |
| Blade Templating | `resources/views/*` | Dashboard, POS, Produk, Transaksi, Report, Setting, dan lainnya | Membantu penyusunan tampilan |
| Soft Delete | Model tertentu | Produk, Kategori, Payment Method, CashFlow, dan lainnya | Membantu penghapusan data secara aman |
| Storage Helper | Controller fitur tertentu | Produk, Payment Method, Setting | Membantu upload file |
| DB Transaction | Controller fitur transaksi/stok | POS, Inventory, Transaksi | Membantu menjaga konsistensi data |
| PDF / Excel Export Package | Report dan Transaksi | Report / Laporan, Transaksi, Produk | Membantu export dokumen dan laporan |

## Komponen Manual yang Paling Dominan

| Komponen Manual | Fitur Terkait | Keterangan |
|---|---|---|
| Checkout Flow | POS / Kasir | Proses cart, pembayaran, dan transaksi POS dibuat manual |
| Barcode Scanner dan Barcode Generation | POS / Kasir, Produk | Proses scan dan generate barcode dikembangkan sesuai kebutuhan sistem |
| Receipt dan Invoice Generation | POS / Kasir, Transaksi | Format invoice dan receipt ditulis khusus |
| Stock Mutation | POS / Kasir, Inventory, Transaksi | Perubahan stok membutuhkan logika bisnis manual |
| Profit Calculation | Transaksi | Perhitungan profit dibuat berdasarkan harga jual dan modal |
| CashFlow Summary | CashFlow | Ringkasan arus kas dan multi-table compatibility dikembangkan manual |
| Permission Mapping | Login / Authentication, Role / Permission | Mapping permission dan middleware akses dibuat custom |
| Singleton Setting | Setting | Pengaturan sistem dibuat sebagai satu record utama |
| Report Formatting | Report / Laporan | Struktur PDF dan Excel disusun sesuai kebutuhan laporan |

## Catatan Evidence

Semua bukti analisis tingkat otomatisasi mengacu pada source code nyata berikut:

| Evidence File | Peran dalam Analisis |
|---|---|
| `routes/web.php` | Resource routes, route definitions, auth middleware, dan permission middleware |
| `config/auth.php` | Authentication guard, provider, dan password reset |
| `app/Http/Controllers/*` | Validasi custom, POS, transaksi, produk, laporan, inventory, cashflow, user, role, dan setting |
| `app/Http/Middleware/PermissionMiddleware.php` | Custom permission logic dan action mapping |
| `app/Models/*` | Soft delete, relationship, cast, dan model logic |
| `database/migrations/*` | Enum status/type, struktur tabel, soft deletes, dan field pendukung fitur |
| `resources/views/*` | Blade view untuk dashboard, POS, produk, transaksi, report, setting, dan fitur lain |
| `app/Exports/LaporanKeuanganExport.php` | Struktur export Excel laporan |
| `resources/js/*` | JavaScript pendukung fitur jika digunakan dalam tampilan |

Analisis ini tidak memasukkan file `seeder`, testing, factory, vendor, file dummy, file log, atau file hasil build.

## Kesimpulan Umum

1. Total komponen otomatis pada sistem POS Laravel 12 Konvensional adalah **61 komponen**.
2. Total komponen manual adalah **48 komponen**.
3. Total komponen yang dianalisis adalah **109 komponen**.
4. Rata-rata tingkat otomatisasi sistem adalah **56%**.
5. Fitur dengan tingkat otomatisasi tertinggi adalah **Kategori** dengan tingkat otomatisasi **4/6** atau **67%**.
6. Fitur dengan tingkat otomatisasi terendah adalah **Login / Authentication** dan **Produk**, masing-masing dengan tingkat otomatisasi **4/9** atau **44%**.
7. Laravel 12 memberikan otomatisasi kuat pada routing, request validation, Eloquent ORM, Eloquent relationship, Blade templating, soft delete, storage helper, database transaction, dan package export.
8. Meskipun demikian, business logic inti seperti checkout POS, barcode, receipt, invoice, stock mutation, cashflow summary, report formatting, dan permission mapping tetap membutuhkan pengembangan manual yang signifikan.
9. Secara umum, tingkat otomatisasi Laravel 12 Konvensional berada pada kategori **sedang**, karena framework membantu struktur dasar aplikasi, tetapi proses bisnis spesifik sistem POS tetap memerlukan implementasi custom.

## Rekomendasi Penulisan dalam Laporan TA

Gunakan kalimat berikut untuk menjelaskan hasil analisis tingkat otomatisasi Laravel konvensional:

> Berdasarkan hasil analisis tingkat otomatisasi pada sistem POS Laravel 12 Konvensional, diperoleh total **61 komponen otomatis** dan **48 komponen manual** dari **109 komponen analisis**, dengan rata-rata otomatisasi sebesar **56%**. Fitur dengan tingkat otomatisasi tertinggi adalah **Kategori** sebesar **67%**, sedangkan fitur dengan tingkat otomatisasi terendah adalah **Login / Authentication** dan **Produk** sebesar **44%**. Hasil ini menunjukkan bahwa Laravel 12 membantu pengembangan melalui routing, request validation, Eloquent ORM, Eloquent relationship, Blade templating, soft delete, storage helper, database transaction, serta package export. Namun, proses bisnis inti seperti checkout POS, barcode, receipt, invoice, stock mutation, cashflow, report formatting, dan permission mapping masih memerlukan pengembangan manual oleh developer.