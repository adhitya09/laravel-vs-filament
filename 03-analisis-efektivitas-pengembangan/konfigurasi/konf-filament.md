# 4.5.1.4 Kebutuhan Konfigurasi
## Sistem POS Berbasis Laravel Filament

Analisis kebutuhan konfigurasi dilakukan untuk mengukur jumlah konfigurasi tambahan yang diperlukan pada setiap fitur dalam sistem POS berbasis Laravel Filament. Konfigurasi yang dihitung meliputi authentication setup, panel provider, middleware, resource configuration, widget discovery, Livewire component, observer, policy, filesystem, PDF generator, printer setup, permission setup, dan konfigurasi runtime yang berkontribusi langsung terhadap fitur.

Analisis ini tidak memasukkan file testing, factory, seeder, vendor, file dummy, file hasil build, atau file yang tidak digunakan langsung oleh fitur. Fitur Barcode Scanner dan Receipt/Invoice tidak dipisahkan sebagai fitur mandiri, tetapi digabungkan ke dalam fitur POS/Kasir karena keduanya merupakan bagian dari proses transaksi kasir.

## D. Kebutuhan Konfigurasi

### 1. Fitur Login / Authentication

| No | Konfigurasi Tambahan | File Konfigurasi | Evidence Kode / Setting | Keterangan |
|---:|---|---|---|---|
| 1 | Authentication Guard | `config/auth.php` | `guards.web` | Konfigurasi guard autentikasi berbasis session |
| 2 | User Provider | `config/auth.php` | `providers.users` | Provider user untuk proses autentikasi |
| 3 | Password Reset | `config/auth.php` | `passwords.users` | Konfigurasi reset password user |
| 4 | Filament Login Panel | `AdminPanelProvider.php` | `->login()` | Mengaktifkan halaman login otomatis pada panel Filament |
| 5 | Middleware Authenticate | `AdminPanelProvider.php` | `Authenticate::class` | Proteksi panel agar hanya user terautentikasi yang dapat mengakses |
| 6 | FilamentUser Interface | `User.php` | `implements FilamentUser` | Menentukan akses user terhadap panel Filament |
| 7 | Role Permission | `User.php` | `use HasRoles` | Integrasi role dan permission pada model user |

| Ringkasan | Nilai |
|---|---:|
| Total Konfigurasi | 7 |
| Total File Konfigurasi | 3 |
| Tingkat Kompleksitas | Sedang |

#### Penjelasan

Fitur Login / Authentication pada Laravel Filament membutuhkan konfigurasi autentikasi dasar Laravel dan konfigurasi akses panel Filament. File `config/auth.php` digunakan untuk mengatur guard, user provider, dan reset password.

Selain konfigurasi bawaan Laravel, sistem juga menggunakan `AdminPanelProvider.php` untuk mengaktifkan login panel serta middleware autentikasi. Model `User.php` juga dikonfigurasi agar mendukung akses ke panel Filament dan integrasi role permission melalui trait `HasRoles`.

---

### 2. Fitur Dashboard

| No | Konfigurasi Tambahan | File Konfigurasi | Evidence Kode / Setting | Keterangan |
|---:|---|---|---|---|
| 1 | Page Discovery | `AdminPanelProvider.php` | `discoverPages()` | Auto register halaman Filament |
| 2 | Widget Discovery | `AdminPanelProvider.php` | `discoverWidgets()` | Auto register widget Filament |
| 3 | Dashboard Filter | `Dashboard.php` | `filtersForm()` | Konfigurasi filter data pada dashboard |
| 4 | Dashboard Permission | `Dashboard.php` | `HasPageShield` | Proteksi akses dashboard menggunakan permission |

| Ringkasan | Nilai |
|---|---:|
| Total Konfigurasi | 4 |
| Total File Konfigurasi | 2 |
| Tingkat Kompleksitas | Rendah |

#### Penjelasan

Dashboard pada Laravel Filament menggunakan konfigurasi otomatis melalui page discovery dan widget discovery. Dengan konfigurasi ini, halaman dan widget dashboard dapat dikenali secara otomatis oleh panel Filament.

Konfigurasi tambahan terdapat pada filter dashboard dan permission halaman melalui `HasPageShield`. Kebutuhan konfigurasi dashboard tergolong rendah karena sebagian besar mekanisme halaman dan widget sudah disediakan oleh Filament.

---

### 3. Fitur POS / Kasir

| No | Konfigurasi Tambahan | File Konfigurasi | Evidence Kode / Setting | Keterangan |
|---:|---|---|---|---|
| 1 | POS Page | `PosPage.php` | `custom filament page` | Halaman khusus POS pada panel Filament |
| 2 | Page Shield | `PosPage.php` | `HasPageShield` | Proteksi akses halaman POS |
| 3 | Livewire POS | `Pos.php` | `cart & checkout` | Logika transaksi POS, cart, dan checkout |
| 4 | Barcode Scanner | `ScannerModalComponent.php` | `scanResult` | Komponen scanner barcode |
| 5 | Thermal Printer | `filesystems.php` | `public_direct` | Konfigurasi penyimpanan/akses file untuk printer thermal |
| 6 | PDF Receipt | `dompdf.php` | `DomPDF` | Konfigurasi pembuatan receipt dalam bentuk PDF |
| 7 | Receipt Route | `web.php` | `/receipt/{id}` | Route manual untuk akses receipt transaksi |
| 8 | Printer Asset | `AppServiceProvider.php` | `FilamentAsset::register` | Registrasi asset JavaScript printer |
| 9 | Runtime Printer Setting | `Setting.php` | `bluetooth/local printer` | Konfigurasi runtime untuk printer bluetooth atau lokal |

| Ringkasan | Nilai |
|---|---:|
| Total Konfigurasi | 9 |
| Total File Konfigurasi | 6 |
| Tingkat Kompleksitas | Tinggi |

#### Penjelasan

Fitur POS / Kasir memiliki kebutuhan konfigurasi tinggi karena fitur ini tidak hanya menampilkan halaman transaksi, tetapi juga mengelola cart, checkout, barcode scanner, printer thermal, dan receipt. Walaupun menggunakan Filament, proses bisnis POS tetap membutuhkan konfigurasi manual tambahan karena alurnya lebih kompleks dibandingkan fitur CRUD biasa.

Barcode Scanner dan Receipt/Invoice digabungkan ke fitur POS/Kasir karena keduanya digunakan langsung dalam proses transaksi kasir. Konfigurasi printer, receipt route, asset printer, dan PDF receipt menjadi bagian penting dari fitur ini.

---

### 4. Fitur Produk

| No | Konfigurasi Tambahan | File Konfigurasi | Evidence Kode / Setting | Keterangan |
|---:|---|---|---|---|
| 1 | Product Resource | `ProductResource.php` | `HasShieldPermissions` | Konfigurasi CRUD produk berbasis Filament Resource |
| 2 | Product Observer | `AppServiceProvider.php` | `Product::observe()` | Registrasi observer untuk proses otomatis produk |
| 3 | Soft Delete | `Product.php` | `SoftDeletes` | Konfigurasi restore dan penghapusan lunak produk |
| 4 | Upload Storage | `filesystems.php` | `public_direct` | Konfigurasi penyimpanan gambar produk |
| 5 | Barcode Generator | `ProductObserver.php` | `barcode generation` | Generate barcode produk otomatis |
| 6 | PDF Export | `dompdf.php` | `barcode PDF` | Konfigurasi export barcode ke PDF |
| 7 | Navigation Badge | `ProductResource.php` | `getNavigationBadge()` | Menampilkan badge jumlah produk pada navigasi |

| Ringkasan | Nilai |
|---|---:|
| Total Konfigurasi | 7 |
| Total File Konfigurasi | 5 |
| Tingkat Kompleksitas | Sedang |

#### Penjelasan

Fitur Produk membutuhkan konfigurasi pada resource, observer, soft delete, storage, barcode, PDF export, dan navigation badge. Filament Resource membantu mengurangi konfigurasi CRUD manual, tetapi kebutuhan khusus seperti barcode dan upload gambar tetap memerlukan konfigurasi tambahan.

Observer digunakan untuk mendukung proses otomatis seperti generate barcode atau SKU, sedangkan `filesystems.php` dan `dompdf.php` digunakan untuk mendukung upload gambar serta export barcode dalam bentuk PDF.

---

### 5. Fitur Kategori

| No | Konfigurasi Tambahan | File Konfigurasi | Evidence Kode / Setting | Keterangan |
|---:|---|---|---|---|
| 1 | Category Resource | `CategoryResource.php` | `HasShieldPermissions` | Konfigurasi CRUD kategori berbasis Filament Resource |
| 2 | Category Observer | `AppServiceProvider.php` | `Category::observe()` | Registrasi observer kategori |
| 3 | Soft Delete | `Category.php` | `SoftDeletes` | Konfigurasi restore dan penghapusan lunak kategori |
| 4 | Relation Manager | `CategoryResource.php` | `ProductsRelationManager` | Konfigurasi relasi kategori dengan produk |

| Ringkasan | Nilai |
|---|---:|
| Total Konfigurasi | 4 |
| Total File Konfigurasi | 3 |
| Tingkat Kompleksitas | Rendah |

#### Penjelasan

Fitur Kategori memiliki kebutuhan konfigurasi rendah karena sebagian besar fungsi CRUD dikelola melalui Filament Resource. Konfigurasi tambahan yang dibutuhkan hanya berkaitan dengan permission resource, observer, soft delete, dan relation manager.

Relation manager digunakan untuk menampilkan atau mengelola relasi antara kategori dan produk, sehingga pengelolaan data kategori tetap terhubung dengan data produk.

---

### 6. Fitur Inventory

| No | Konfigurasi Tambahan | File Konfigurasi | Evidence Kode / Setting | Keterangan |
|---:|---|---|---|---|
| 1 | Inventory Resource | `InventoryResource.php` | `HasShieldPermissions` | Konfigurasi CRUD inventory berbasis Filament Resource |
| 2 | Inventory Observer | `InventoryObserver.php` | `generate INV` | Generate nomor referensi inventory |
| 3 | InventoryItem Observer | `InventoryItemObserver.php` | `stock mutation` | Sinkronisasi perubahan stok |
| 4 | Inventory Label Service | `InventoryLabelService.php` | `dynamic source` | Service label sumber inventory |
| 5 | Dynamic Select Option | `InventoryResource.php` | `source by type` | Opsi pilihan dinamis berdasarkan tipe inventory |
| 6 | Inventory Repeater | `InventoryResource.php` | `repeater items` | Konfigurasi input multiple item inventory |

| Ringkasan | Nilai |
|---|---:|
| Total Konfigurasi | 6 |
| Total File Konfigurasi | 4 |
| Tingkat Kompleksitas | Sedang |

#### Penjelasan

Fitur Inventory membutuhkan konfigurasi untuk resource, observer, service label, dynamic select option, dan repeater item. Konfigurasi ini diperlukan karena fitur inventory tidak hanya menyimpan data utama, tetapi juga mengelola banyak item serta perubahan stok.

Observer berperan dalam menghasilkan nomor inventory dan melakukan sinkronisasi stok. Repeater digunakan untuk memungkinkan input beberapa item inventory dalam satu proses.

---

### 7. Fitur Transaksi

| No | Konfigurasi Tambahan | File Konfigurasi | Evidence Kode / Setting | Keterangan |
|---:|---|---|---|---|
| 1 | Transaction Resource | `TransactionResource.php` | `HasShieldPermissions` | Konfigurasi CRUD transaksi berbasis Filament Resource |
| 2 | Transaction Observer | `TransactionObserver.php` | `generate TRX ID` | Generate ID transaksi |
| 3 | TransactionItem Observer | `TransactionItemObserver.php` | `stock decrement` | Sinkronisasi pengurangan stok |
| 4 | Soft Delete | `Transaction.php` | `SoftDeletes` | Konfigurasi restore dan penghapusan lunak transaksi |
| 5 | Transaction Helper | `TransactionHelper.php` | `generateUniqueTrxId()` | Helper untuk generate ID transaksi unik |
| 6 | Relation Manager | `TransactionItemsRelationManager.php` | `nested item` | Konfigurasi detail item transaksi |
| 7 | Receipt Integration | `ReceiptController.php` | `receipt transaction` | Integrasi transaksi dengan receipt |

| Ringkasan | Nilai |
|---|---:|
| Total Konfigurasi | 7 |
| Total File Konfigurasi | 5 |
| Tingkat Kompleksitas | Tinggi |

#### Penjelasan

Fitur Transaksi memiliki konfigurasi tinggi karena berhubungan dengan proses bisnis utama, yaitu penyimpanan transaksi, detail transaksi, pengurangan stok, soft delete, dan integrasi receipt. Konfigurasi resource dan relation manager digunakan untuk mengelola data transaksi dan item transaksi pada panel Filament.

Observer dan helper digunakan untuk mengatur proses otomatis seperti generate ID transaksi serta sinkronisasi stok. Receipt integration juga menjadi konfigurasi tambahan karena transaksi perlu terhubung dengan bukti transaksi.

---

### 8. Fitur CashFlow

| No | Konfigurasi Tambahan | File Konfigurasi | Evidence Kode / Setting | Keterangan |
|---:|---|---|---|---|
| 1 | CashFlow Resource | `CashFlowResource.php` | `HasShieldPermissions` | Konfigurasi CRUD cashflow berbasis Filament Resource |
| 2 | Dynamic Filter | `CashFlowResource.php` | `date filter` | Filter data cashflow berdasarkan tanggal |
| 3 | CashFlow Service | `CashFlowLabelService.php` | `label formatting` | Format label cashflow |
| 4 | Widget Statistic | `IncomeOverview.php` | `stats overview` | Statistik ringkasan cashflow |
| 5 | Chart Widget | `CashFlowRadarChart.php` | `radar chart` | Grafik cashflow |

| Ringkasan | Nilai |
|---|---:|
| Total Konfigurasi | 5 |
| Total File Konfigurasi | 3 |
| Tingkat Kompleksitas | Sedang |

#### Penjelasan

Fitur CashFlow membutuhkan konfigurasi untuk resource, dynamic filter, service label, widget statistik, dan chart widget. Konfigurasi ini diperlukan agar data cashflow dapat dikelola, difilter, diringkas, dan divisualisasikan.

Penggunaan widget dan chart menunjukkan bahwa fitur CashFlow tidak hanya bersifat CRUD, tetapi juga memiliki kebutuhan visualisasi data.

---

### 9. Fitur Payment Method

| No | Konfigurasi Tambahan | File Konfigurasi | Evidence Kode / Setting | Keterangan |
|---:|---|---|---|---|
| 1 | Payment Resource | `PaymentMethodResource.php` | `HasShieldPermissions` | Konfigurasi CRUD metode pembayaran berbasis Filament Resource |
| 2 | Soft Delete | `PaymentMethod.php` | `SoftDeletes` | Konfigurasi restore dan penghapusan lunak metode pembayaran |
| 3 | Toggle is_cash | `PaymentMethodResource.php` | `toggle form` | Konfigurasi pilihan metode pembayaran cash atau non-cash |
| 4 | Upload Image | `filesystems.php` | `upload icon` | Konfigurasi upload ikon metode pembayaran |

| Ringkasan | Nilai |
|---|---:|
| Total Konfigurasi | 4 |
| Total File Konfigurasi | 3 |
| Tingkat Kompleksitas | Rendah |

#### Penjelasan

Fitur Payment Method memiliki konfigurasi rendah karena sebagian besar proses CRUD dibantu oleh Filament Resource. Konfigurasi tambahan yang dibutuhkan meliputi soft delete, toggle `is_cash`, dan upload image untuk ikon metode pembayaran.

Konfigurasi `is_cash` penting karena membedakan metode pembayaran tunai dan non-tunai yang dapat berpengaruh pada proses transaksi dan cashflow.

---

### 10. Fitur Report / Laporan

| No | Konfigurasi Tambahan | File Konfigurasi | Evidence Kode / Setting | Keterangan |
|---:|---|---|---|---|
| 1 | Report Resource | `ReportResource.php` | `HasShieldPermissions` | Konfigurasi CRUD laporan berbasis Filament Resource |
| 2 | Report Observer | `ReportObserver.php` | `report generation` | Generate laporan otomatis |
| 3 | PDF Generator | `dompdf.php` | `export PDF` | Konfigurasi export laporan ke PDF |
| 4 | Filesystem Storage | `filesystems.php` | `report storage` | Penyimpanan file laporan |
| 5 | Report Template | `penjualan.blade.php` | `export template` | Template tampilan laporan |

| Ringkasan | Nilai |
|---|---:|
| Total Konfigurasi | 5 |
| Total File Konfigurasi | 4 |
| Tingkat Kompleksitas | Sedang |

#### Penjelasan

Fitur Report / Laporan membutuhkan konfigurasi untuk resource, observer, export PDF, penyimpanan file, dan template laporan. Walaupun Filament membantu pengelolaan resource, kebutuhan laporan tetap membutuhkan konfigurasi tambahan karena berkaitan dengan format output.

Report observer digunakan untuk mendukung proses generate laporan, sedangkan `dompdf.php` dan template Blade digunakan untuk menghasilkan laporan dalam bentuk PDF.

---

### 11. Fitur User Management

| No | Konfigurasi Tambahan | File Konfigurasi | Evidence Kode / Setting | Keterangan |
|---:|---|---|---|---|
| 1 | User Resource | `UserResource.php` | `HasShieldPermissions` | Konfigurasi CRUD user berbasis Filament Resource |
| 2 | Password Hashing | `User.php` | `password => hashed` | Konfigurasi hashing password |
| 3 | Role Assignment | `User.php` | `assignRole()` | Konfigurasi pemberian role kepada user |
| 4 | HasRoles Trait | `User.php` | `use HasRoles` | Integrasi user dengan role dan permission |

| Ringkasan | Nilai |
|---|---:|
| Total Konfigurasi | 4 |
| Total File Konfigurasi | 2 |
| Tingkat Kompleksitas | Rendah |

#### Penjelasan

User Management memiliki konfigurasi rendah karena pengelolaan user dibantu oleh Filament Resource. Konfigurasi tambahan berfokus pada hashing password, role assignment, dan integrasi role permission.

Model `User.php` menjadi file penting karena tidak hanya digunakan untuk data user, tetapi juga untuk autentikasi dan pengaturan hak akses.

---

### 12. Fitur Role / Permission

| No | Konfigurasi Tambahan | File Konfigurasi | Evidence Kode / Setting | Keterangan |
|---:|---|---|---|---|
| 1 | Shield Plugin | `filament-shield.php` | `FilamentShieldPlugin` | Konfigurasi UI permission menggunakan Filament Shield |
| 2 | Permission Config | `permission.php` | `Spatie Permission` | Konfigurasi role dan permission |
| 3 | Policy Generation | `shield:generate` | `generated policies` | Generate policy otomatis |
| 4 | Role Policy | `RolePolicy.php` | `authorization` | Pengaturan otorisasi role |
| 5 | HasPageShield | `Dashboard.php` | `permission page` | Proteksi halaman dengan permission |
| 6 | Super Admin | `filament-shield.php` | `super_admin` | Konfigurasi akses penuh super admin |
| 7 | Permission Discovery | `Shield` | `auto scan resource` | Scan otomatis permission dari resource |

| Ringkasan | Nilai |
|---|---:|
| Total Konfigurasi | 7 |
| Total File Konfigurasi | 4 |
| Tingkat Kompleksitas | Tinggi |

#### Penjelasan

Role / Permission memiliki konfigurasi tinggi karena berkaitan langsung dengan keamanan dan pembatasan akses sistem. Sistem menggunakan Spatie Permission dan Filament Shield untuk mengelola role, permission, policy, serta akses halaman/resource.

Konfigurasi seperti super admin, permission discovery, dan policy generation membantu otomatisasi hak akses, tetapi tetap membutuhkan setup khusus agar setiap fitur memiliki permission yang sesuai.

---

### 13. Fitur Setting

| No | Konfigurasi Tambahan | File Konfigurasi | Evidence Kode / Setting | Keterangan |
|---:|---|---|---|---|
| 1 | Setting Resource | `SettingResource.php` | `HasShieldPermissions` | Konfigurasi CRUD setting berbasis Filament Resource |
| 2 | Printer Setting | `Setting.php` | `printer configuration` | Konfigurasi printer sistem |
| 3 | Logo Upload | `filesystems.php` | `upload logo` | Konfigurasi upload logo toko |
| 4 | Storage Disk | `filesystems.php` | `public storage` | Konfigurasi storage untuk file setting |
| 5 | Setting Model | `Setting.php` | `singleton setting` | Konfigurasi satu data setting aktif |
| 6 | POS Runtime Config | `Pos.php` | `load setting` | Pengambilan konfigurasi setting pada fitur POS |

| Ringkasan | Nilai |
|---|---:|
| Total Konfigurasi | 6 |
| Total File Konfigurasi | 3 |
| Tingkat Kompleksitas | Sedang |

#### Penjelasan

Fitur Setting membutuhkan konfigurasi untuk resource, printer, logo upload, storage, singleton setting, dan runtime configuration pada POS. Konfigurasi ini digunakan sebagai pengaturan umum sistem dan dapat berpengaruh pada fitur lain, terutama POS/Kasir.

Setting menjadi fitur pendukung penting karena menyimpan konfigurasi operasional seperti printer dan identitas toko.

---

## Rekap Kebutuhan Konfigurasi

| Fitur | Total Konfigurasi | Total File Konfigurasi | Konfigurasi Dominan | Tingkat Kompleksitas |
|---|---:|---:|---|---|
| Login / Authentication | 7 | 3 | Auth guard, Filament login, role permission | Sedang |
| Dashboard | 4 | 2 | Page discovery, widget discovery, page shield | Rendah |
| POS / Kasir | 9 | 6 | Barcode scanner, printer thermal, receipt PDF | Tinggi |
| Produk | 7 | 5 | Product resource, observer, barcode, upload storage | Sedang |
| Kategori | 4 | 3 | Category resource, observer, relation manager | Rendah |
| Inventory | 6 | 4 | Observer, stock mutation, repeater item | Sedang |
| Transaksi | 7 | 5 | Transaction observer, helper, relation manager, receipt | Tinggi |
| CashFlow | 5 | 3 | Dynamic filter, service label, widget/chart | Sedang |
| Payment Method | 4 | 3 | Resource, soft delete, upload image | Rendah |
| Report / Laporan | 5 | 4 | Report observer, PDF generator, report template | Sedang |
| User Management | 4 | 2 | User resource, password hashing, role assignment | Rendah |
| Role / Permission | 7 | 4 | Filament Shield, Spatie Permission, policy generation | Tinggi |
| Setting | 6 | 3 | Printer setting, logo upload, runtime config | Sedang |
| **Total** | **75** | **47** |  |  |

## Ringkasan Total Keseluruhan Sistem

### Statistik Umum

| Metrik | Nilai |
|---|---:|
| Total Konfigurasi Keseluruhan | 75 |
| Total File Konfigurasi Keseluruhan | 47 |
| Rata-rata Konfigurasi per Fitur | 5,77 |
| Rata-rata File Konfigurasi per Fitur | 3,62 |

### Fitur dengan Konfigurasi Terbanyak

| Peringkat | Fitur | Total Konfigurasi | Keterangan |
|---:|---|---:|---|
| 1 | POS / Kasir | 9 | Memiliki konfigurasi barcode scanner, thermal printer, receipt PDF, route receipt, dan runtime printer setting |
| 2 | Login / Authentication | 7 | Memiliki konfigurasi auth guard, user provider, panel login, middleware, dan role permission |
| 3 | Produk | 7 | Memiliki konfigurasi resource, observer, soft delete, storage, barcode, PDF, dan navigation badge |
| 4 | Transaksi | 7 | Memiliki konfigurasi observer, helper, soft delete, relation manager, dan receipt integration |
| 5 | Role / Permission | 7 | Memiliki konfigurasi Shield, Spatie Permission, policy, super admin, dan permission discovery |

### Fitur dengan Konfigurasi Tersedikit

| Peringkat | Fitur | Total Konfigurasi | Keterangan |
|---:|---|---:|---|
| 1 | Dashboard | 4 | Konfigurasi berfokus pada page discovery, widget discovery, filter, dan permission halaman |
| 2 | Kategori | 4 | Konfigurasi berfokus pada resource, observer, soft delete, dan relation manager |
| 3 | Payment Method | 4 | Konfigurasi berfokus pada resource, soft delete, toggle is_cash, dan upload image |
| 4 | User Management | 4 | Konfigurasi berfokus pada user resource, hashing password, role assignment, dan HasRoles trait |

### Shared Configuration Utama

| Konfigurasi Shared | File | Fitur yang Menggunakan | Penjelasan |
|---|---|---|---|
| Authentication Guard & Provider | `config/auth.php` | Login / Authentication dan fitur yang membutuhkan autentikasi user | Konfigurasi global autentikasi Laravel |
| Filament Panel Provider | `AdminPanelProvider.php` | Login, Dashboard, Resource, Widget, dan panel admin | Mengatur login panel, middleware, discovery page, dan widget |
| Spatie Permission | `permission.php` | Login, Role / Permission, User Management | Konfigurasi role dan permission |
| Filament Shield | `filament-shield.php` | Login, Role / Permission, Dashboard, Resource/Page | Konfigurasi permission otomatis pada resource dan page |
| Filesystem Storage | `filesystems.php` | POS, Produk, Payment Method, Report, Setting | Konfigurasi penyimpanan file, gambar, icon, dan laporan |
| DomPDF | `dompdf.php` | POS, Produk, Report | Konfigurasi pembuatan PDF untuk receipt, barcode, dan laporan |
| App Service Provider | `AppServiceProvider.php` | POS, Produk, Kategori, dan fitur yang menggunakan observer/asset | Registrasi observer dan asset pendukung |
| User Model | `User.php` | Login, User Management, Role / Permission | Model user untuk autentikasi, role, dan permission |

### Kompleksitas Konfigurasi per Level

| Level Kompleksitas | Fitur | Jumlah Konfigurasi |
|---|---|---:|
| Tinggi | POS / Kasir, Transaksi, Role / Permission | 23 |
| Sedang | Login / Authentication, Produk, Inventory, CashFlow, Report / Laporan, Setting | 36 |
| Rendah | Dashboard, Kategori, Payment Method, User Management | 16 |
| **Total** |  | **75** |

## Kesimpulan Umum

1. Total kebutuhan konfigurasi pada sistem POS Laravel Filament adalah **75 konfigurasi** yang tersebar pada **47 file konfigurasi**.
2. Fitur dengan kebutuhan konfigurasi terbanyak adalah **POS / Kasir** dengan **9 konfigurasi**.
3. Fitur dengan kebutuhan konfigurasi tersedikit adalah **Dashboard**, **Kategori**, **Payment Method**, dan **User Management**, masing-masing dengan **4 konfigurasi**.
4. Fitur dengan tingkat kompleksitas konfigurasi tinggi adalah **POS / Kasir**, **Transaksi**, dan **Role / Permission**.
5. Konfigurasi shared utama dalam sistem meliputi `config/auth.php`, `AdminPanelProvider.php`, `permission.php`, `filament-shield.php`, `filesystems.php`, `dompdf.php`, `AppServiceProvider.php`, dan `User.php`.
6. Laravel Filament membantu mengurangi konfigurasi CRUD dasar karena banyak proses administratif ditangani oleh resource, page, widget, discovery, dan plugin.
7. Walaupun Filament mengurangi konfigurasi dasar, fitur dengan business logic tinggi seperti POS/Kasir, Transaksi, dan Role/Permission tetap membutuhkan konfigurasi manual tambahan.
8. Secara umum, kebutuhan konfigurasi sistem POS Laravel Filament tergolong lebih ringkas karena banyak setup administratif sudah disediakan oleh ekosistem Filament.

## Rekomendasi Penulisan dalam Laporan TA

Gunakan kalimat berikut untuk menjelaskan hasil analisis kebutuhan konfigurasi Laravel Filament:

> Berdasarkan hasil analisis kebutuhan konfigurasi pada sistem POS Laravel Filament, diperoleh total **75 konfigurasi** yang tersebar pada **47 file konfigurasi**. Konfigurasi tersebut meliputi authentication guard, Filament panel provider, middleware, resource permission, widget discovery, observer, policy, filesystem storage, PDF generator, printer setup, dan runtime configuration. Fitur dengan kebutuhan konfigurasi terbanyak adalah **POS / Kasir** dengan **9 konfigurasi**, sedangkan fitur dengan kebutuhan konfigurasi tersedikit adalah **Dashboard**, **Kategori**, **Payment Method**, dan **User Management** dengan masing-masing **4 konfigurasi**. Hasil ini menunjukkan bahwa Laravel Filament mampu mengurangi kebutuhan konfigurasi dasar pada fitur administratif melalui resource, page, widget, dan plugin, tetapi fitur dengan business logic tinggi tetap memerlukan konfigurasi manual tambahan.