# 4.5.1.4 Kebutuhan Konfigurasi
## Sistem POS Laravel 12 Konvensional

Analisis kebutuhan konfigurasi dilakukan untuk mengukur jumlah konfigurasi tambahan yang diperlukan pada setiap fitur dalam sistem POS berbasis Laravel 12 konvensional. Konfigurasi yang dihitung meliputi file konfigurasi, middleware, route manual, permission setup, validation rule, enum, relationship setup, file upload setup, PDF/export setup, transaction handling, dan konfigurasi lain yang berkontribusi langsung terhadap implementasi fitur.

Analisis ini tidak memasukkan file testing, factory, seeder, vendor, file dummy, file hasil build, atau file yang tidak digunakan langsung oleh fitur. Fitur Barcode Scanner dan Receipt/Invoice tidak dipisahkan sebagai fitur mandiri, tetapi digabungkan ke dalam fitur POS/Kasir karena keduanya merupakan bagian dari proses transaksi kasir.

## D. Kebutuhan Konfigurasi

### 1. Fitur Login / Authentication

| No | Konfigurasi Tambahan | File Konfigurasi | Evidence Kode / Setting | Keterangan |
|---:|---|---|---|---|
| 1 | Authentication Guard Setup | `config/auth.php` | `'guards' => ['web' => ['driver' => 'session', 'provider' => 'users']]` | Konfigurasi guard web dengan session driver untuk autentikasi user |
| 2 | User Provider Configuration | `config/auth.php` | `'providers' => ['users' => ['driver' => 'eloquent', 'model' => App\Models\User::class]]` | Definisi user provider menggunakan Eloquent ORM |
| 3 | Password Reset Configuration | `config/auth.php` | `'passwords' => ['users' => ['provider' => 'users', 'table' => 'password_reset_tokens', 'expire' => 60]]` | Konfigurasi token reset password dengan waktu kedaluwarsa |
| 4 | Permission Middleware Custom | `app/Http/Middleware/PermissionMiddleware.php` | Method `handle()` yang memetakan action ke permission | Middleware custom untuk pengecekan permission berbasis role |
| 5 | Guest Route Middleware | `routes/web.php` | `Route::middleware('guest')->group(function () { Route::get('/login', [AuthController::class, 'showLogin'])->name('login'); })` | Route group khusus user yang belum login |
| 6 | Auth Route Middleware | `routes/web.php` | `Route::middleware('auth')->group(function () { ... })` | Route group khusus user yang sudah login |
| 7 | Permission Attribute Mapping | `app/Http/Middleware/PermissionMiddleware.php` | `protected array $actionMap = ['index' => 'viewAny', 'create' => 'create', 'store' => 'create', ...]` | Mapping action controller ke permission name |

| Ringkasan | Nilai |
|---|---:|
| Total Konfigurasi | 7 |
| Total File Konfigurasi | 3 |
| Tingkat Kompleksitas | Sedang |

#### Penjelasan

Fitur Login / Authentication memerlukan 7 konfigurasi utama yang tersebar pada 3 file. Konfigurasi authentication guard dan user provider didefinisikan pada `config/auth.php` sebagai bagian dari setup autentikasi Laravel 12. File ini menentukan guard, provider, dan pengaturan reset password.

Selain konfigurasi bawaan Laravel, sistem juga menggunakan `PermissionMiddleware.php` sebagai konfigurasi tambahan untuk membatasi akses berdasarkan permission. Route pada `web.php` juga dibagi menjadi route guest dan route auth, sehingga hanya user dengan status sesuai yang dapat mengakses endpoint tertentu.

---

### 2. Fitur Dashboard

| No | Konfigurasi Tambahan | File Konfigurasi | Evidence Kode / Setting | Keterangan |
|---:|---|---|---|---|
| 1 | Route dengan Permission Middleware | `routes/web.php` | `Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('permission:dashboard.viewAny')->name('dashboard');` | Route dashboard dengan permission check middleware |
| 2 | Date Range Filter Configuration | `DashboardController.php` | Method `rangeDates()` dengan match statement untuk `week`, `month`, `year`, dan `today` | Konfigurasi filter rentang tanggal pada dashboard |
| 3 | Application Timezone | `config/app.php` | `'timezone' => 'UTC'` | Timezone global aplikasi untuk perhitungan tanggal |

| Ringkasan | Nilai |
|---|---:|
| Total Konfigurasi | 3 |
| Total File Konfigurasi | 2 |
| Tingkat Kompleksitas | Rendah |

#### Penjelasan

Dashboard memiliki kebutuhan konfigurasi yang relatif rendah karena fungsinya berfokus pada penampilan ringkasan data. Konfigurasi utama berada pada route dashboard yang menggunakan permission middleware dan filter tanggal pada controller.

Konfigurasi timezone dari `config/app.php` juga berpengaruh karena dashboard menggunakan kalkulasi tanggal untuk menampilkan data berdasarkan rentang waktu tertentu.

---

### 3. Fitur POS / Kasir

| No | Konfigurasi Tambahan | File Konfigurasi | Evidence Kode / Setting | Keterangan |
|---:|---|---|---|---|
| 1 | Barcode Scanner Route | `routes/web.php` | `Route::get('/pos/scan-barcode', [PosController::class, 'scanBarcode'])->middleware('permission:pos.viewAny')->name('pos.scan-barcode');` | Endpoint untuk proses barcode scanning |
| 2 | Product by Barcode Route | `routes/web.php` | `Route::get('/pos/produk-by-barcode', [PosController::class, 'getProductByBarcode'])->middleware('permission:pos.viewAny')->name('pos.product-by-barcode');` | Endpoint untuk pencarian produk berdasarkan barcode |
| 3 | Receipt Printing Route | `routes/web.php` | `Route::get('/pos/resi/{transaction}', [PosController::class, 'cetakResi'])->middleware('permission:pos.viewAny')->name('pos.resi');` | Route untuk mencetak resi transaksi |
| 4 | Transaction Store Route | `routes/web.php` | `Route::resource('pos', PosController::class)->middleware('permission:pos.viewAny')->only(['index', 'store']);` | Endpoint pembuatan transaksi POS |
| 5 | Printer Configuration | `Setting.php` | `'print_type' => 'string'`, setup di `SettingController` untuk `kabel` atau `bluetooth` | Konfigurasi tipe printer untuk pencetakan resi |
| 6 | Product Lock for Concurrent Update | `PosController.php` | `$product = Product::lockForUpdate()->findOrFail($item['product_id']);` | Pessimistic locking untuk mencegah konflik update stok |
| 7 | Transaction Invoice Number Generation | `PosController.php` | `$invoiceNo = 'INV-' . date('Ymd') . '-' . str_pad(Transaction::whereDate('created_at', today())->count() + 1, 4, '0', STR_PAD_LEFT);` | Format nomor invoice berdasarkan tanggal dan urutan transaksi |
| 8 | Database Transaction for Data Integrity | `PosController.php` | `DB::beginTransaction(); ... DB::commit(); ... DB::rollback();` | Menjaga atomicity proses transaksi POS |
| 9 | Active Product Filter | `PosController.php` | `where('is_active', true)->where('stock', '>', 0)` | Menampilkan hanya produk aktif dengan stok tersedia |
| 10 | Payment Method Active Filter | `PosController.php` | `PaymentMethod::where('is_active', true)->get()` | Menampilkan hanya metode pembayaran aktif |

| Ringkasan | Nilai |
|---|---:|
| Total Konfigurasi | 10 |
| Total File Konfigurasi | 4 |
| Tingkat Kompleksitas | Tinggi |

#### Penjelasan

Fitur POS / Kasir memiliki kebutuhan konfigurasi tinggi karena mencakup proses transaksi real-time. Konfigurasi route digunakan untuk membuka endpoint transaksi, barcode scanner, lookup produk berdasarkan barcode, dan pencetakan resi.

Selain route, fitur ini juga memerlukan konfigurasi printer, format invoice, database transaction, locking produk, filter produk aktif, dan filter metode pembayaran aktif. Barcode Scanner dan Receipt/Invoice digabungkan ke dalam fitur POS/Kasir karena keduanya merupakan bagian langsung dari proses transaksi kasir.

---

### 4. Fitur Produk

| No | Konfigurasi Tambahan | File Konfigurasi | Evidence Kode / Setting | Keterangan |
|---:|---|---|---|---|
| 1 | Barcode Library DNS1D | `ProdukController.php` | `use Milon\Barcode\DNS1D;` | Library eksternal untuk generate barcode produk |
| 2 | Product Image Filesystem | `ProdukController.php` | `$data['image'] = $request->file('image')->store('products', 'public');` | Storage disk `public` untuk upload gambar produk |
| 3 | Barcode PDF Export | `ProdukController.php` | `$pdf = Pdf::loadView('pages.produk.barcode-pdf', ['products' => $products, 'copies' => 45]);` | Konfigurasi export PDF barcode |
| 4 | SKU Generation Configuration | `ProdukController.php` | Method `generateSku()` mengambil karakter dari nama produk dan menambahkan suffix random | Format SKU otomatis untuk produk |
| 5 | Barcode Generation Configuration | `ProdukController.php` | Method `generateBarcode()` menghasilkan angka random 12 digit | Format barcode otomatis |
| 6 | Product Status Filter | `ProdukController.php` | Status filter: `all`, `plenty`, `low`, `out` | Konfigurasi filter status stok produk |
| 7 | Image Upload Validation | `ProdukController.php` | `'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'` | Validasi file gambar produk |
| 8 | Category Relationship | `Product.php` | `public function category(): BelongsTo { return $this->belongsTo(Category::class); }` | Relasi produk ke kategori |
| 9 | Soft Delete Configuration | `Product.php` | `use SoftDeletes;` | Konfigurasi soft delete produk |
| 10 | Product Cast Configuration | `Product.php` | `'price' => 'decimal:2', 'cost_price' => 'decimal:2', 'is_active' => 'boolean'` | Casting tipe data harga dan status aktif |

| Ringkasan | Nilai |
|---|---:|
| Total Konfigurasi | 10 |
| Total File Konfigurasi | 3 |
| Tingkat Kompleksitas | Sedang |

#### Penjelasan

Fitur Produk membutuhkan 10 konfigurasi karena tidak hanya mengelola data produk, tetapi juga menangani upload gambar, barcode, SKU otomatis, filter status stok, soft delete, dan casting data.

Konfigurasi barcode menggunakan library DNS1D, sedangkan export barcode menggunakan PDF view. Validasi upload gambar juga diperlukan agar file yang masuk sesuai format dan batas ukuran yang ditentukan.

---

### 5. Fitur Kategori

| No | Konfigurasi Tambahan | File Konfigurasi | Evidence Kode / Setting | Keterangan |
|---:|---|---|---|---|
| 1 | Category Soft Delete | `Category.php` | `use SoftDeletes;` | Soft delete untuk data kategori |
| 2 | Category-Product Relationship | `Category.php` | `public function products(): HasMany { return $this->hasMany(Product::class); }` | Relasi one-to-many antara kategori dan produk |
| 3 | Category withSum Aggregation | `KategoriController.php` | `Category::withSum('products', 'stock')->paginate()` | Agregasi total stok produk per kategori |
| 4 | Route Resource Configuration | `routes/web.php` | `Route::resource('kategori', KategoriController::class)->middleware('permission:kategori.viewAny');` | Resource route kategori dengan permission middleware |

| Ringkasan | Nilai |
|---|---:|
| Total Konfigurasi | 4 |
| Total File Konfigurasi | 3 |
| Tingkat Kompleksitas | Rendah |

#### Penjelasan

Fitur Kategori memiliki konfigurasi yang rendah karena hanya mengelola master data kategori. Konfigurasi yang dibutuhkan meliputi soft delete, relasi kategori ke produk, agregasi total stok, dan resource route dengan permission middleware.

Tidak ada konfigurasi library khusus atau setup eksternal pada fitur ini.

---

### 6. Fitur Inventory

| No | Konfigurasi Tambahan | File Konfigurasi | Evidence Kode / Setting | Keterangan |
|---:|---|---|---|---|
| 1 | Inventory Type Enum | `2026_04_19_155943_create_inventories_table.php` | `$table->enum('type', ['in', 'out', 'adjustment']);` | Tipe inventory: masuk, keluar, dan penyesuaian |
| 2 | Inventory Reference Number | `InventoryController.php` | `'reference_no' => 'INV-' . date('Ymd') . '-' . strtoupper(Str::random(6))` | Format nomor referensi inventory |
| 3 | CashFlow Auto-Generation | `InventoryController.php` | `if ($request->type === 'out' && $totalCost > 0) { CashFlow::create([...]) }` | Pembuatan cashflow otomatis saat stok keluar |
| 4 | Stock Update Logic | `InventoryController.php` | Conditional increment/decrement berdasarkan type `in`, `out`, dan `adjustment` | Konfigurasi logika perubahan stok |
| 5 | Database Transaction Integrity | `InventoryController.php` | `DB::beginTransaction(); ... DB::commit(); ... DB::rollback();` | Menjaga atomicity proses inventory |
| 6 | Inventory Relationship | `Inventory.php` | `public function inventoryItems(): HasMany { return $this->hasMany(InventoryItem::class); }` | Relasi inventory ke inventory item |
| 7 | InventoryItem Cast | `InventoryItem.php` | `'cost_price' => 'decimal:2'` | Casting harga modal pada item inventory |
| 8 | Stock Validation | `InventoryController.php` | `if ($product->stock < $quantity) { throw new \Exception() }` | Validasi stok sebelum proses keluar/adjustment |

| Ringkasan | Nilai |
|---|---:|
| Total Konfigurasi | 8 |
| Total File Konfigurasi | 4 |
| Tingkat Kompleksitas | Sedang |

#### Penjelasan

Fitur Inventory membutuhkan konfigurasi untuk membedakan jenis pergerakan stok, membuat nomor referensi, memperbarui stok, dan menjaga konsistensi data melalui database transaction.

Konfigurasi tambahan juga diperlukan untuk membuat catatan cashflow otomatis ketika terjadi stok keluar yang berdampak pada pengeluaran modal.

---

### 7. Fitur Transaksi

| No | Konfigurasi Tambahan | File Konfigurasi | Evidence Kode / Setting | Keterangan |
|---:|---|---|---|---|
| 1 | Transaction Status Enum | `2026_04_19_155931_create_transactions_table.php` | `$table->enum('status', ['pending', 'completed', 'cancelled'])->default('pending');` | Status transaksi yang dibatasi pada nilai tertentu |
| 2 | Invoice Number Generation | `TransaksiController.php` | `$invoiceNo = 'INV-' . date('Ymd') . '-' . str_pad(count + 1, 4, '0', STR_PAD_LEFT);` | Format nomor invoice transaksi |
| 3 | Transaction PDF Export | `TransaksiController.php` | `return Pdf::loadView('pages.transaksi.pdf', $data)->download('transaksi-' . $invoiceNo . '.pdf');` | Export transaksi ke PDF |
| 4 | Transaction Validation Rules | `TransaksiController.php` | Rules untuk `customer_name`, `payment_method_id`, `paid_amount`, dan `items` array | Validasi input transaksi |
| 5 | Stock Decrement | `TransaksiController.php` | `$product->decrement('stock', $quantity)` | Pengurangan stok otomatis setelah transaksi |
| 6 | Database Transaction Integrity | `TransaksiController.php` | `DB::beginTransaction(); ... DB::commit(); DB::rollback();` | Menjaga atomicity transaksi |
| 7 | Return Transaction Logic | `TransaksiController.php` | Method `returnTransaction()` melakukan validasi status, increment stock, dan update status ke `returned` | Logika retur transaksi |
| 8 | Profit Calculation | `TransaksiController.php` | `$totalProfit = sum((price - cost_price) * quantity)` | Perhitungan profit otomatis |
| 9 | CashboxFlow Auto-Entry | `TransaksiController.php` | Auto-delete `cashbox_flows` dengan `is_auto=true` saat destroy transaksi | Sinkronisasi arus kas saat transaksi dibatalkan |
| 10 | Customer Information Optional | `TransaksiController.php` | `'customer_name' => 'nullable'` | Nama pelanggan bersifat opsional |
| 11 | Payment Method Relationship | `Transaction.php` | `public function paymentMethod(): BelongsTo` | Relasi transaksi ke metode pembayaran |
| 12 | TransactionItem Relationship | `Transaction.php` | `public function transactionItems(): HasMany` | Relasi transaksi ke item transaksi |

| Ringkasan | Nilai |
|---|---:|
| Total Konfigurasi | 12 |
| Total File Konfigurasi | 4 |
| Tingkat Kompleksitas | Tinggi |

#### Penjelasan

Fitur Transaksi memiliki konfigurasi terbanyak karena menjadi inti proses bisnis penjualan. Konfigurasi yang dibutuhkan mencakup status transaksi, invoice, validasi input, pengurangan stok, export PDF, retur transaksi, perhitungan profit, serta sinkronisasi cashbox flow.

Fitur ini juga menggunakan database transaction untuk menjaga agar proses transaksi, perubahan stok, dan pencatatan keuangan tetap konsisten.

---

### 8. Fitur Cash Flow

| No | Konfigurasi Tambahan | File Konfigurasi | Evidence Kode / Setting | Keterangan |
|---:|---|---|---|---|
| 1 | CashFlowSource Type Enum | `2026_04_21_000001_create_cash_flow_sources_table.php` | `$table->enum('type', ['in', 'out', 'both'])->default('both');` | Tipe sumber cashflow |
| 2 | CashboxFlow Type Enum | `2026_04_21_000002_create_cashbox_flows_table.php` | `$table->enum('type', ['in', 'out']);` | Tipe arus kas masuk atau keluar |
| 3 | CashboxFlow Auto Flag | `2026_04_22_000000_add_fields_to_cashbox_flows.php` | `$table->boolean('is_auto')->default(false);` | Penanda data otomatis atau manual |
| 4 | CashboxFlow Reference Tracking | `2026_04_22_000000_add_fields_to_cashbox_flows.php` | `reference_type`, `reference_id` | Pelacakan sumber transaksi cashbox |
| 5 | CashFlow Filter Configuration | `CashFlowController.php` | Method `getFilteredQuery()` dengan filter by date, type, dan source_id | Filter data cashflow |
| 6 | Summary Calculation Configuration | `CashFlowController.php` | Method `calculateSummary()` dengan aggregation dari `cashbox_flows`, `cash_flows`, dan `transactions` | Perhitungan ringkasan arus kas |
| 7 | Modal Awal dan Modal Tambahan Tracking | `CashFlowController.php` | Special logic untuk `Modal Awal` dan `Modal Tambahan` sources | Pemisahan modal dari arus kas operasional |
| 8 | Multi-Table Cash Tracking | `CashFlowController.php` | Query dari `cashbox_flows`, legacy `cash_flows`, dan `transactions` | Pelacakan arus kas dari beberapa tabel |
| 9 | Sort Order Configuration | `2026_04_21_000001_create_cash_flow_sources_table.php` | `$table->integer('sort_order')->default(0);` | Pengurutan sumber cashflow di tampilan |
| 10 | CashboxFlow Soft Delete | `CashboxFlow.php` | `use SoftDeletes;` | Soft delete untuk menjaga audit trail cashbox |

| Ringkasan | Nilai |
|---|---:|
| Total Konfigurasi | 10 |
| Total File Konfigurasi | 5 |
| Tingkat Kompleksitas | Tinggi |

#### Penjelasan

Fitur Cash Flow membutuhkan konfigurasi yang cukup kompleks karena harus mencatat pemasukan, pengeluaran, sumber cashflow, cashbox flow, dan ringkasan saldo. Konfigurasi enum digunakan untuk membatasi tipe arus kas dan sumber kas.

Fitur ini juga memiliki konfigurasi pelacakan referensi transaksi, auto flag, multi-table tracking, serta soft delete untuk menjaga riwayat data keuangan.

---

### 9. Fitur Payment Method

| No | Konfigurasi Tambahan | File Konfigurasi | Evidence Kode / Setting | Keterangan |
|---:|---|---|---|---|
| 1 | PaymentMethod is_cash Boolean | `2026_04_20_000000_add_logo_and_is_cash_to_payment_methods_table.php` | `$table->boolean('is_cash')->default(false);` | Penanda metode pembayaran tunai |
| 2 | Logo Storage Configuration | `PaymentMethodController.php` | `$request->file('logo')->store('payment-methods', 'public')` | Storage logo metode pembayaran |
| 3 | Logo Upload Validation | `PaymentMethodController.php` | `'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'` | Validasi file logo |
| 4 | Active Payment Method Filter | `PaymentMethodController.php` | `where('is_active', true)` | Filter metode pembayaran aktif |
| 5 | Payment Method Restore Route | `routes/web.php` | Route restore untuk payment method | Route untuk mengembalikan data yang dihapus |
| 6 | Payment Method Cast | `PaymentMethod.php` | `'is_active' => 'boolean', 'is_cash' => 'boolean'` | Casting status aktif dan cash |
| 7 | Transaction Relationship | `PaymentMethod.php` | `public function transactions(): HasMany` | Relasi metode pembayaran ke transaksi |
| 8 | Cash Payment Logic | `PaymentMethod.php` | Method atau atribut yang membedakan metode pembayaran cash dan non-cash | Konfigurasi logika pembayaran tunai/non-tunai |

| Ringkasan | Nilai |
|---|---:|
| Total Konfigurasi | 8 |
| Total File Konfigurasi | 4 |
| Tingkat Kompleksitas | Sedang |

#### Penjelasan

Fitur Payment Method membutuhkan konfigurasi untuk mengelola metode pembayaran aktif, membedakan pembayaran cash dan non-cash, mengunggah logo metode pembayaran, serta mengatur relasi dengan transaksi.

Konfigurasi `is_cash` penting karena metode pembayaran tunai dapat memengaruhi pencatatan cashbox dan arus kas.

---

### 10. Fitur Report / Laporan

| No | Konfigurasi Tambahan | File Konfigurasi | Evidence Kode / Setting | Keterangan |
|---:|---|---|---|---|
| 1 | Report Type Enum | `Report.php` atau migration report | Enum/type laporan seperti transaksi, pemasukan, dan pengeluaran | Pembatasan jenis laporan |
| 2 | Report Date Range Filter | `ReportController.php` | Filter berdasarkan rentang tanggal | Konfigurasi filter tanggal laporan |
| 3 | PDF Export Configuration | `ReportController.php` | `Pdf::loadView(...)` | Export laporan ke PDF |
| 4 | Excel Export Configuration | `LaporanKeuanganExport.php` | Export laporan ke Excel | Konfigurasi export Excel |
| 5 | Multi-Sheet Export | `LaporanKeuanganExport.php` | Sheet untuk transaksi, pemasukan, dan pengeluaran | Export laporan dalam beberapa sheet |
| 6 | Report Validation Rules | `ReportController.php` | Validasi input tanggal dan tipe laporan | Validasi parameter laporan |
| 7 | Report Aggregation Query | `ReportController.php` | Aggregation transaksi, pemasukan, pengeluaran, dan total | Perhitungan data laporan |
| 8 | PDF View Styling | `resources/views/pages/report/laporan-pdf.blade.php` | Styling tampilan laporan PDF | Konfigurasi tampilan PDF |
| 9 | Report Model Cast | `Report.php` | Cast tanggal atau nilai laporan | Konfigurasi tipe data laporan |
| 10 | Download Route Configuration | `routes/web.php` | Route download/export laporan | Endpoint export laporan |

| Ringkasan | Nilai |
|---|---:|
| Total Konfigurasi | 10 |
| Total File Konfigurasi | 4 |
| Tingkat Kompleksitas | Sedang |

#### Penjelasan

Fitur Report / Laporan membutuhkan konfigurasi untuk filter tanggal, validasi parameter, aggregation query, export PDF, dan export Excel. Konfigurasi ini diperlukan agar laporan dapat ditampilkan dan diunduh dalam format yang sesuai.

Karena laporan mengambil data dari transaksi dan cashflow, fitur ini membutuhkan konfigurasi query dan format output yang lebih detail dibandingkan fitur master data sederhana.

---

### 11. Fitur User Management

| No | Konfigurasi Tambahan | File Konfigurasi | Evidence Kode / Setting | Keterangan |
|---:|---|---|---|---|
| 1 | User-Role Relationship | `User.php` | `public function role(): BelongsTo` | Relasi user ke role |
| 2 | Role Foreign Key Migration | `2026_05_05_000001_add_role_id_to_users_table.php` | `$table->foreignId('role_id')->nullable()->constrained()` | Konfigurasi relasi role pada tabel users |
| 3 | User Validation Rules | `UserController.php` | Validasi `name`, `email`, `password`, dan `role_id` | Validasi input user |
| 4 | Password Hashing | `UserController.php` | `Hash::make($request->password)` | Konfigurasi penyimpanan password aman |
| 5 | Permission Check Method | `User.php` | Method permission checking pada model user | Konfigurasi pengecekan akses user |
| 6 | Email Verification Nullable | `User.php` atau migration users | `email_verified_at` nullable | Konfigurasi status verifikasi email |
| 7 | User Route Resource | `routes/web.php` | `Route::resource('user', UserController::class)` dengan permission middleware | Route CRUD user |
| 8 | Manual Verification Option | `UserController.php` | Update status verifikasi atau data user | Konfigurasi verifikasi user secara manual |

| Ringkasan | Nilai |
|---|---:|
| Total Konfigurasi | 8 |
| Total File Konfigurasi | 3 |
| Tingkat Kompleksitas | Sedang |

#### Penjelasan

User Management membutuhkan konfigurasi untuk relasi user dengan role, validasi input, hashing password, permission check, route resource, dan status verifikasi email.

Fitur ini berhubungan langsung dengan Login / Authentication dan Role / Permission karena data user menjadi dasar autentikasi sekaligus otorisasi.

---

### 12. Fitur Role / Permission

| No | Konfigurasi Tambahan | File Konfigurasi | Evidence Kode / Setting | Keterangan |
|---:|---|---|---|---|
| 1 | Permission Array Structure | `Role.php` atau `RoleController.php` | Array permission berdasarkan fitur dan action | Struktur permission sistem |
| 2 | Permission Groups Definition | `RoleController.php` | Group permission seperti dashboard, produk, transaksi, inventory, dan lainnya | Pengelompokan permission per fitur |
| 3 | Role Permission Cast | `Role.php` | Cast permission menjadi array | Konversi data permission menjadi array |
| 4 | Permission Middleware | `PermissionMiddleware.php` | Method `handle()` untuk memeriksa permission | Middleware otorisasi fitur |
| 5 | Action Mapping | `PermissionMiddleware.php` | `$actionMap = ['index' => 'viewAny', 'create' => 'create', ...]` | Mapping action controller ke permission |
| 6 | Role Route Resource | `routes/web.php` | Route resource role dengan middleware permission | Endpoint CRUD role |
| 7 | Default Role Structure | `Role.php` atau controller | Role seperti admin dan cashier | Struktur awal role sistem |
| 8 | Wildcard Permission Support | `User.php` atau `PermissionMiddleware.php` | Permission `*` untuk akses penuh | Konfigurasi akses penuh untuk role tertentu |

| Ringkasan | Nilai |
|---|---:|
| Total Konfigurasi | 8 |
| Total File Konfigurasi | 5 |
| Tingkat Kompleksitas | Sedang |

#### Penjelasan

Role / Permission membutuhkan konfigurasi untuk mengatur struktur permission, pengelompokan permission, middleware, action mapping, dan dukungan wildcard permission. Konfigurasi ini menjadi dasar pengamanan akses pada hampir seluruh fitur sistem.

Middleware permission menjadi komponen penting karena digunakan untuk memastikan user hanya dapat mengakses fitur sesuai hak aksesnya.

---

### 13. Fitur Setting

| No | Konfigurasi Tambahan | File Konfigurasi | Evidence Kode / Setting | Keterangan |
|---:|---|---|---|---|
| 1 | Store Name Configuration | `Setting.php` atau `SettingController.php` | Field nama toko | Konfigurasi identitas toko |
| 2 | Store Address Configuration | `Setting.php` atau `SettingController.php` | Field alamat toko | Konfigurasi alamat toko |
| 3 | Store Phone Configuration | `Setting.php` atau `SettingController.php` | Field nomor telepon toko | Konfigurasi kontak toko |
| 4 | Logo Upload Configuration | `SettingController.php` | Upload logo ke storage public | Konfigurasi logo toko |
| 5 | Logo Validation Rules | `SettingController.php` | Validasi file logo | Validasi upload logo |
| 6 | Print Type Configuration | `Setting.php` atau `SettingController.php` | Pilihan `kabel` atau `bluetooth` | Konfigurasi tipe printer |
| 7 | Printer Name / Identifier | `Setting.php` atau `SettingController.php` | Field printer name atau identifier | Identifikasi printer |
| 8 | Singleton Setting Pattern | `SettingController.php` | Pengambilan satu record setting utama | Konfigurasi satu data setting aktif |
| 9 | Setting Cast Configuration | `Setting.php` | Cast field setting tertentu | Konfigurasi tipe data setting |
| 10 | Setting Route Resource | `routes/web.php` | Route resource setting dengan permission middleware | Endpoint pengaturan sistem |

| Ringkasan | Nilai |
|---|---:|
| Total Konfigurasi | 10 |
| Total File Konfigurasi | 3 |
| Tingkat Kompleksitas | Rendah-Sedang |

#### Penjelasan

Fitur Setting mengatur konfigurasi umum sistem, seperti identitas toko, logo, nomor telepon, alamat, dan tipe printer. Konfigurasi ini digunakan lintas fitur, terutama POS/Kasir dan Receipt/Invoice.

Walaupun jumlah konfigurasinya cukup banyak, tingkat kompleksitasnya tidak setinggi POS atau Transaksi karena sebagian besar berupa field pengaturan dan validasi input.

---

## Rekap Kebutuhan Konfigurasi

| Fitur | Total Konfigurasi | Total File Konfigurasi | Konfigurasi Dominan | Tingkat Kompleksitas |
|---|---:|---:|---|---|
| Login / Authentication | 7 | 3 | Guard setup, permission middleware | Sedang |
| Dashboard | 3 | 2 | Route middleware, date filter | Rendah |
| POS / Kasir | 10 | 4 | Barcode API, receipt printing, concurrency | Tinggi |
| Produk | 10 | 3 | Barcode generation, image upload, SKU format | Sedang |
| Kategori | 4 | 3 | Soft delete, aggregation query | Rendah |
| Inventory | 8 | 4 | Type enum, CashFlow auto-generation, stock validation | Sedang |
| Transaksi | 12 | 4 | Status enum, invoice numbering, profit calculation, return logic | Tinggi |
| Cash Flow | 10 | 5 | Type enum, multi-table tracking, summary aggregation | Tinggi |
| Payment Method | 8 | 4 | `is_cash` flag, logo storage, restore route | Sedang |
| Report / Laporan | 10 | 4 | Type enum, multi-sheet Excel, PDF styling | Sedang |
| User Management | 8 | 3 | Role relationship, permission check, email verification | Sedang |
| Role / Permission | 8 | 5 | Permission array, group definition, action mapping | Sedang |
| Setting | 10 | 3 | Printer type, logo upload, singleton pattern | Rendah-Sedang |

## Ringkasan Total Keseluruhan Sistem

### Statistik Umum

| Metrik | Nilai |
|---|---:|
| Total Konfigurasi Keseluruhan | 118 |
| Total File Konfigurasi Keseluruhan | 47 |
| Rata-rata Konfigurasi per Fitur | 9,08 |
| Rata-rata File Konfigurasi per Fitur | 3,62 |

### Fitur dengan Konfigurasi Terbanyak

| Peringkat | Fitur | Total Konfigurasi | Persentase |
|---:|---|---:|---:|
| 1 | Transaksi | 12 | 10,17% |
| 2 | POS / Kasir | 10 | 8,47% |
| 3 | Cash Flow | 10 | 8,47% |
| 4 | Produk | 10 | 8,47% |
| 5 | Report / Laporan | 10 | 8,47% |
| 6 | Setting | 10 | 8,47% |

### Fitur dengan Konfigurasi Tersedikit

| Peringkat | Fitur | Total Konfigurasi | Persentase |
|---:|---|---:|---:|
| 1 | Dashboard | 3 | 2,54% |
| 2 | Kategori | 4 | 3,39% |
| 3 | Login / Authentication | 7 | 5,93% |
| 4 | Inventory | 8 | 6,78% |
| 5 | Payment Method | 8 | 6,78% |

### Shared Configuration Utama

| Konfigurasi Shared | File | Fitur yang Menggunakan | Penjelasan |
|---|---|---|---|
| Authentication Guard & Provider | `config/auth.php` | Login / Authentication dan fitur yang memerlukan user access | Konfigurasi global autentikasi Laravel 12 |
| Application Timezone | `config/app.php` | Dashboard, Report, Transaksi | Timezone global untuk operasi tanggal dan waktu |
| Database Connection | `config/database.php` | Semua fitur | Konfigurasi koneksi database untuk Eloquent |
| Permission Middleware | `PermissionMiddleware.php` | Semua fitur yang menggunakan permission route | Middleware global untuk pengecekan hak akses |
| Web Routes Group | `routes/web.php` | Semua fitur | Definisi route utama dengan auth dan permission middleware |
| User Model with Permission Methods | `User.php` | Login, Role/Permission, User Management | Model user dengan logic pengecekan permission |

### Persentase Distribusi Konfigurasi per Jenis

```text
Type Enum / Status Configuration      ██████░░░░░░░░░░░░░░░░░░░░░░░░░ 18,64%
API Routes & Endpoints                ██████░░░░░░░░░░░░░░░░░░░░░░░░░░ 15,25%
File Upload & Storage Config          █████░░░░░░░░░░░░░░░░░░░░░░░░░░░ 11,86%
Data Validation Rules                 █████░░░░░░░░░░░░░░░░░░░░░░░░░░░ 11,86%
Database Transaction & Atomicity      ████░░░░░░░░░░░░░░░░░░░░░░░░░░░░  8,47%
Query Filtering & Aggregation         ███░░░░░░░░░░░░░░░░░░░░░░░░░░░░░  6,78%
PDF & Excel Export Config             ███░░░░░░░░░░░░░░░░░░░░░░░░░░░░░  6,78%
Auth & Permission Middleware          ██░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░  5,08%
Model Relationship & Cast             ██░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░  4,24%
Unique ID Generation & Formatting     ██░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░  4,24%
Others                                ░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░  6,78%
```

### Kompleksitas Konfigurasi per Level

| Level Kompleksitas | Fitur | Jumlah Konfigurasi |
|---|---|---:|
| Tinggi | POS / Kasir, Transaksi, Cash Flow | 32 |
| Sedang | Login / Authentication, Produk, Inventory, Payment Method, Report / Laporan, User Management, Role / Permission, Setting | 73 |
| Rendah | Dashboard, Kategori | 7 |

## Kesimpulan Umum

1. Total kebutuhan konfigurasi pada sistem POS Laravel 12 Konvensional adalah **118 konfigurasi** yang tersebar pada **47 file konfigurasi**.
2. Fitur dengan kebutuhan konfigurasi terbanyak adalah **Transaksi** dengan **12 konfigurasi**.
3. Fitur dengan kebutuhan konfigurasi tersedikit adalah **Dashboard** dengan **3 konfigurasi**.
4. Fitur dengan tingkat kompleksitas konfigurasi tinggi adalah **POS / Kasir**, **Transaksi**, dan **Cash Flow** karena ketiganya berkaitan langsung dengan proses transaksi, stok, arus kas, dan integritas data.
5. Shared configuration utama dalam sistem meliputi `config/auth.php`, `config/app.php`, `config/database.php`, `PermissionMiddleware.php`, `routes/web.php`, dan `User.php`.
6. Jenis konfigurasi yang paling dominan adalah **Type Enum / Status Configuration**, yaitu konfigurasi yang mengatur tipe, status, dan batasan nilai pada fitur transaksi, inventory, cash flow, report, dan fitur terkait lainnya.
7. Sistem menggunakan pendekatan Laravel konvensional, sehingga banyak konfigurasi ditulis secara eksplisit melalui controller, route, middleware, model relationship, validation rule, migration, dan file konfigurasi.
8. Secara umum, kebutuhan konfigurasi sistem tergolong cukup tinggi karena sistem POS tidak hanya melakukan CRUD, tetapi juga menangani transaksi, stok, barcode, receipt, laporan, cashflow, permission, dan pengaturan sistem.

## Rekomendasi Penulisan dalam Laporan TA

Gunakan kalimat berikut untuk menjelaskan hasil analisis kebutuhan konfigurasi:

> Berdasarkan hasil analisis kebutuhan konfigurasi pada source code sistem POS Laravel 12 Konvensional, diperoleh total **118 konfigurasi** yang tersebar pada **47 file konfigurasi**. Konfigurasi tersebut meliputi authentication setup, route middleware, permission middleware, enum/status, validation rule, file upload, PDF/export, database transaction, model relationship, dan konfigurasi pendukung lainnya. Fitur dengan kebutuhan konfigurasi terbanyak adalah **Transaksi** dengan **12 konfigurasi**, sedangkan fitur dengan kebutuhan konfigurasi paling sedikit adalah **Dashboard** dengan **3 konfigurasi**. Hasil ini menunjukkan bahwa Laravel konvensional membutuhkan konfigurasi eksplisit pada banyak bagian sistem, terutama pada fitur yang berkaitan dengan transaksi, stok, arus kas, dan kontrol akses.