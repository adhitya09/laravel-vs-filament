# Lampiran Pengujian White Box Sistem POS Filament

---

# Tabel 4. Hasil Pengujian White Box Fitur Login / Auth

| No | Input | Process | Output | Result |
| -- | ----- | ------- | ------ | ------ |
| 1 | User memasukkan email dan password valid | Menguji proses autentikasi login pada panel Filament | User berhasil login ke sistem | Valid |
| 2 | User memasukkan email atau password tidak valid | Menguji validasi credential login | Login gagal diproses | Valid |
| 3 | User melakukan logout | Menguji proses invalidate session | User berhasil keluar dari sistem | Valid |
| 4 | User memperbarui profil | Menguji update data profil user | Profil user berhasil diperbarui | Valid |

### Evidence Pengujian

* File test:

  * `tests/Feature/AuthTest.php`

* File terkait:

  * `app/Models/User.php`
  * `app/Providers/Filament/AdminPanelProvider.php`
  * File konfigurasi autentikasi panel Filament

---

# Tabel 5. Hasil Pengujian White Box Fitur Dashboard

| No | Input | Process | Output | Result |
| -- | ----- | ------- | ------ | ------ |
| 1 | Data transaksi tersedia | Menguji perhitungan total transaksi pada dashboard | Total transaksi berhasil ditampilkan | Valid |
| 2 | Data income tersedia | Menguji perhitungan total income pada dashboard | Total income berhasil ditampilkan | Valid |
| 3 | Data transaksi terbaru tersedia | Menguji pengambilan data transaksi terbaru | Data transaksi terbaru berhasil ditampilkan | Valid |
| 4 | User mengakses dashboard Filament | Menguji akses halaman dashboard | Dashboard berhasil diakses | Valid |
| 5 | User tanpa permission mengakses dashboard | Menguji pembatasan akses berdasarkan permission | Akses dashboard ditolak | Valid |
| 6 | Guest mengakses dashboard | Menguji proteksi authentication pada panel | Guest diarahkan ke halaman login | Valid |

### Evidence Pengujian

* File test:

  * `tests/Feature/DashboardTest.php`
  * `tests/Feature/AccessTest.php`
  * `tests/Feature/RolePermissionTest.php`

* File terkait:

  * File dashboard/page Filament
  * File widget dashboard Filament
  * `app/Models/Transaction.php`
  * `app/Models/User.php`

### Catatan

Pada sistem Filament, pengujian statistik dashboard tidak menggunakan file `AggregateQueryTest.php`. Pengujian statistik dashboard dicakup melalui `DashboardTest.php` karena proses perhitungan dan penampilan data dashboard berada pada modul dashboard Filament.

---

# Tabel 6. Hasil Pengujian White Box Fitur Kasir / POS

| No | Input | Process | Output | Result |
| -- | ----- | ------- | ------ | ------ |
| 1 | Input checkout valid | Menguji proses create transaction | Data transaksi berhasil dibuat | Valid |
| 2 | Input checkout valid | Menguji proses create transaction item | Item transaksi berhasil dibuat | Valid |
| 3 | Input transaksi POS | Menguji sinkronisasi stok produk | Stock produk berkurang | Valid |
| 4 | Input stock kurang | Menguji validasi stock sebelum checkout | Checkout gagal diproses | Valid |
| 5 | Input pembayaran kurang | Menguji validasi pembayaran | Checkout gagal diproses | Valid |
| 6 | Input checkout tanpa item | Menguji validasi cart kosong | Checkout gagal diproses | Valid |
| 7 | Input subtotal transaksi | Menguji perhitungan subtotal item | Subtotal berhasil dihitung | Valid |
| 8 | Input multi item transaksi | Menguji perhitungan total transaksi | Total transaksi sesuai | Valid |
| 9 | Input nominal pembayaran lebih besar dari total | Menguji perhitungan kembalian | Kembalian berhasil dihitung | Valid |
| 10 | Input nominal pembayaran lebih kecil dari total | Menguji branch pembayaran kurang | Kembalian menjadi 0 dan transaksi tidak diproses | Valid |

### Evidence Pengujian

* File test:

  * `tests/Feature/PosCheckoutTest.php`
  * `tests/Feature/PosLogicTest.php`
  * `tests/Feature/PosAdvancedTest.php`

* File terkait:

  * File page POS/Kasir Filament
  * `app/Models/Transaction.php`
  * `app/Models/TransactionItem.php`
  * `app/Models/Product.php`
  * `app/Models/PaymentMethod.php`

---

# Tabel 7. Hasil Pengujian White Box Fitur Produk

| No | Input | Process | Output | Result |
| -- | ----- | ------- | ------ | ------ |
| 1 | Input create produk | Menguji create produk melalui resource Filament | Produk berhasil disimpan | Valid |
| 2 | Input harga invalid | Menguji validasi numeric harga | Validasi gagal diproses | Valid |
| 3 | Input update produk | Menguji update produk | Produk berhasil diperbarui | Valid |
| 4 | Input delete produk | Menguji delete/soft delete produk | Produk berhasil dihapus | Valid |
| 5 | Input produk tanpa stok | Menguji default stock | Nilai stock menjadi 0 | Valid |
| 6 | Input status produk aktif | Menguji status boolean produk | Status aktif berhasil disimpan | Valid |

### Evidence Pengujian

* File test:

  * `tests/Feature/ProductTest.php`
  * `tests/Feature/ProductAccessTest.php`

* File terkait:

  * File resource produk Filament
  * `app/Models/Product.php`
  * `app/Models/Category.php`

---

# Tabel 8. Hasil Pengujian White Box Fitur Kategori

| No | Input | Process | Output | Result |
| -- | ----- | ------- | ------ | ------ |
| 1 | Input kategori baru | Menguji create kategori melalui resource Filament | Kategori berhasil disimpan | Valid |
| 2 | Input update kategori | Menguji update kategori | Kategori berhasil diperbarui | Valid |
| 3 | Input delete kategori | Menguji delete/soft delete kategori | Kategori berhasil dihapus | Valid |
| 4 | Input relasi kategori dengan produk | Menguji keterkaitan kategori dengan produk pada modul terkait | Relasi data kategori dan produk berhasil digunakan | Valid |

### Evidence Pengujian

* File test:

  * `tests/Feature/CategoryTest.php`
  * `tests/Feature/ProductTest.php`

* File terkait:

  * File resource kategori Filament
  * `app/Models/Category.php`
  * `app/Models/Product.php`

### Catatan

Pada sistem Filament, pengujian relasi kategori dan produk tidak menggunakan file khusus `RelationshipTest.php`. Relasi data dibaca dari pengujian modul kategori dan produk karena pengujian dilakukan melalui resource dan model yang saling berkaitan.

---

# Tabel 9. Hasil Pengujian White Box Fitur Inventory

| No | Input | Process | Output | Result |
| -- | ----- | ------- | ------ | ------ |
| 1 | Input inventory type `in` | Menguji penambahan stock produk | Stock produk bertambah | Valid |
| 2 | Input inventory type `out` | Menguji pengurangan stock produk | Stock produk berkurang | Valid |
| 3 | Input adjustment stock | Menguji penyesuaian stock | Stock berhasil disesuaikan | Valid |
| 4 | Input delete inventory | Menguji pengembalian stock setelah data inventory dihapus | Stock berhasil dikembalikan | Valid |
| 5 | Input stock tidak cukup | Menguji validasi stock tidak cukup | Inventory gagal diproses | Valid |

### Evidence Pengujian

* File test:

  * `tests/Feature/InventoryObserverTest.php`

* File terkait:

  * File resource inventory Filament
  * File observer inventory
  * `app/Models/Product.php`
  * `app/Models/Inventory.php`

### Catatan

Pada sistem Filament, pengujian inventory menekankan penggunaan observer untuk menjaga konsistensi perubahan stock. Oleh karena itu, evidence utama pada fitur ini adalah `InventoryObserverTest.php`.

---

# Tabel 10. Hasil Pengujian White Box Fitur Transaksi

| No | Input | Process | Output | Result |
| -- | ----- | ------- | ------ | ------ |
| 1 | Input transaksi | Menguji penyimpanan data transaksi | Data transaksi berhasil disimpan | Valid |
| 2 | Input item transaksi | Menguji pembentukan transaction item | Item transaksi berhasil tersimpan | Valid |
| 3 | Input product relation | Menguji penggunaan data produk pada transaksi | Produk berhasil digunakan pada transaksi | Valid |
| 4 | Input payment method | Menguji penggunaan metode pembayaran pada transaksi | Payment method berhasil digunakan | Valid |
| 5 | Input delete transaksi | Menguji pengembalian stock setelah transaksi dihapus | Stock berhasil dikembalikan | Valid |
| 6 | Input transaksi dengan cashflow otomatis | Menguji pembentukan atau penghapusan cashflow otomatis dari transaksi | Cashflow otomatis berhasil tersinkronisasi | Valid |
| 7 | User mengakses detail transaksi | Menguji detail transaksi dan alur transaksi | Detail transaksi berhasil ditampilkan | Valid |

### Evidence Pengujian

* File test:

  * `tests/Feature/TransactionTest.php`
  * `tests/Feature/TransactionFlowTest.php`
  * `tests/Feature/ReceiptControllerTest.php`

* File terkait:

  * File resource transaksi Filament
  * File controller receipt/struk
  * `app/Models/Transaction.php`
  * `app/Models/TransactionItem.php`
  * `app/Models/Product.php`
  * `app/Models/PaymentMethod.php`
  * `app/Models/CashboxFlow.php`

### Catatan

Pada sistem Filament, pengujian relasi transaksi tidak menggunakan file khusus `RelationshipTest.php`. Relasi transaction item, produk, payment method, dan cashflow diuji melalui `TransactionTest.php` dan `TransactionFlowTest.php`.

---

# Tabel 11. Hasil Pengujian White Box Fitur Cash Flow

| No | Input | Process | Output | Result |
| -- | ----- | ------- | ------ | ------ |
| 1 | Input create cash in | Menguji pencatatan cashflow masuk | Data cashflow masuk berhasil disimpan | Valid |
| 2 | Input create cash out | Menguji pencatatan cashflow keluar | Data cashflow keluar berhasil disimpan | Valid |
| 3 | Input source type invalid | Menguji validasi source type | Validasi gagal diproses | Valid |
| 4 | Input delete manual cashflow | Menguji delete cashflow manual | Cashflow manual berhasil dihapus | Valid |
| 5 | Input delete auto cashflow | Menguji proteksi cashflow otomatis | Cashflow otomatis tidak dapat dihapus sembarangan | Valid |

### Evidence Pengujian

* File test:

  * `tests/Feature/CashflowTest.php`

* File terkait:

  * File resource cash flow Filament
  * `app/Models/CashboxFlow.php`
  * `app/Models/Transaction.php`

---

# Tabel 12. Hasil Pengujian White Box Fitur Payment Method

| No | Input | Process | Output | Result |
| -- | ----- | ------- | ------ | ------ |
| 1 | Input create payment method | Menguji create payment method melalui resource Filament | Data berhasil disimpan | Valid |
| 2 | Input update payment method | Menguji update payment method | Data berhasil diperbarui | Valid |
| 3 | Input delete payment method | Menguji delete/soft delete payment method | Data berhasil dihapus | Valid |
| 4 | Input restore payment method | Menguji restore payment method | Data berhasil dipulihkan | Valid |
| 5 | Input field `is_cash` | Menguji tipe metode pembayaran | Status cash berhasil dibaca | Valid |
| 6 | Input validation invalid | Menguji validasi payment method | Validasi gagal diproses | Valid |

### Evidence Pengujian

* File test:

  * `tests/Feature/PaymentMethodTest.php`

* File terkait:

  * File resource payment method Filament
  * `app/Models/PaymentMethod.php`
  * `app/Models/Transaction.php`

---

# Tabel 13. Hasil Pengujian White Box Fitur Report

| No | Input | Process | Output | Result |
| -- | ----- | ------- | ------ | ------ |
| 1 | Input transaksi | Menguji perhitungan total transaksi pada laporan | Total transaksi berhasil dihitung | Valid |
| 2 | Input filter transaksi | Menguji filter laporan berdasarkan parameter tertentu | Data laporan berhasil difilter | Valid |
| 3 | Input latest transaksi | Menguji pengambilan transaksi terbaru untuk kebutuhan laporan | Data transaksi terbaru berhasil diambil | Valid |
| 4 | Input data ringkasan laporan | Menguji statistik/ringkasan laporan | Statistik laporan berhasil ditampilkan | Valid |

### Evidence Pengujian

* File test:

  * `tests/Feature/ReportTest.php`

* File terkait:

  * File page/report Filament
  * `app/Models/Transaction.php`
  * `app/Models/TransactionItem.php`
  * `app/Models/CashboxFlow.php`

### Catatan

Pada sistem Filament, pengujian laporan tidak menggunakan file `AggregateQueryTest.php`. Pengujian statistik dan ringkasan laporan dicakup melalui `ReportTest.php`.

---

# Tabel 14. Hasil Pengujian White Box Fitur User

| No | Input | Process | Output | Result |
| -- | ----- | ------- | ------ | ------ |
| 1 | Input data user baru | Menguji create user | User berhasil disimpan | Valid |
| 2 | Input perubahan data user | Menguji update user | Data user berhasil diperbarui | Valid |
| 3 | Input verifikasi user | Menguji verify user | User berhasil diverifikasi | Valid |
| 4 | Input delete user | Menguji delete user | User berhasil dihapus | Valid |

### Evidence Pengujian

* File test:

  * `tests/Feature/UserTest.php`
  * `tests/Feature/AuthTest.php`

* File terkait:

  * File resource user Filament
  * `app/Models/User.php`

---

# Tabel 15. Hasil Pengujian White Box Fitur Role / Permission

| No | Input | Process | Output | Result |
| -- | ----- | ------- | ------ | ------ |
| 1 | Input role baru | Menguji create role | Role berhasil disimpan | Valid |
| 2 | Input permission pada role | Menguji penyimpanan permission role | Permission berhasil tersimpan pada role | Valid |
| 3 | Input update role | Menguji update role | Role berhasil diperbarui | Valid |
| 4 | Input delete role | Menguji delete role | Role berhasil dihapus | Valid |
| 5 | User memiliki permission sesuai role | Menguji exact permission | Permission berhasil dikenali | Valid |
| 6 | User memiliki wildcard permission | Menguji wildcard permission | Permission berhasil dikenali | Valid |
| 7 | User tanpa role | Menguji user tanpa permission | User tidak memiliki permission | Valid |
| 8 | User tanpa permission mengakses dashboard | Menguji pembatasan akses dashboard | Access denied berhasil ditampilkan | Valid |
| 9 | Request tanpa permission | Menguji authorization pada request | Response akses ditolak berhasil ditampilkan | Valid |
| 10 | User dengan permission dashboard | Menguji akses dashboard berdasarkan permission | Dashboard berhasil diakses | Valid |

### Evidence Pengujian

* File test:

  * `tests/Feature/RolePermissionTest.php`
  * `tests/Feature/AccessTest.php`

* File terkait:

  * File resource role/permission Filament
  * `app/Models/User.php`
  * Model/konfigurasi role dan permission yang digunakan pada sistem

---

# Tabel 16. Hasil Pengujian White Box Fitur Setting

| No | Input | Process | Output | Result |
| -- | ----- | ------- | ------ | ------ |
| 1 | User mengakses halaman setting | Menguji route/page setting Filament | Halaman setting berhasil ditampilkan | Valid |
| 2 | Input perubahan setting | Menguji update setting | Data setting berhasil diperbarui | Valid |
| 3 | Input logo toko | Menguji upload store logo | Logo toko berhasil diupload | Valid |
| 4 | Input data wajib kosong | Menguji validasi required field | Validasi gagal diproses | Valid |
| 5 | Input tipe print tidak valid | Menguji validasi print type | Validasi gagal diproses | Valid |
| 6 | Input file logo tidak valid | Menguji validasi image | Validasi gagal diproses | Valid |
| 7 | Input logo baru | Menguji penghapusan logo lama ketika logo baru diupload | Logo lama berhasil diganti | Valid |

### Evidence Pengujian

* File test:

  * `tests/Feature/SettingTest.php`

* File terkait:

  * File page/resource setting Filament
  * `app/Models/Setting.php`

---

# Rekapitulasi Hasil Pengujian White Box

| No | Modul Utama | Jumlah Skenario Inti | Berhasil | Gagal | Persentase |
| -- | ----------- | -------------------- | -------- | ----- | ---------- |
| 1 | Login / Auth | 4 | 4 | 0 | 100% |
| 2 | Dashboard | 6 | 6 | 0 | 100% |
| 3 | Kasir / POS | 10 | 10 | 0 | 100% |
| 4 | Produk | 6 | 6 | 0 | 100% |
| 5 | Kategori | 4 | 4 | 0 | 100% |
| 6 | Inventory | 5 | 5 | 0 | 100% |
| 7 | Transaksi | 7 | 7 | 0 | 100% |
| 8 | Cash Flow | 5 | 5 | 0 | 100% |
| 9 | Payment Method | 6 | 6 | 0 | 100% |
| 10 | Report | 4 | 4 | 0 | 100% |
| 11 | User | 4 | 4 | 0 | 100% |
| 12 | Role / Permission | 10 | 10 | 0 | 100% |
| 13 | Setting | 7 | 7 | 0 | 100% |
| | **TOTAL** | **78** | **78** | **0** | **100%** |

---

# Hasil Testing dengan PHPUnit

Berdasarkan hasil eksekusi PHPUnit terbaru, seluruh pengujian pada sistem POS Filament berhasil dijalankan tanpa test yang gagal.

| Aspek | Hasil |
| ----- | ----- |
| Command | `php artisan test` |
| Total Test PHPUnit | 98 tests |
| Total Assertion | 233 assertions |
| Status | Passed |
| Test Gagal | 0 |
| Durasi | 12.22s |

---

# Ringkasan Cakupan Pengujian

| Komponen Utama | Status Pengujian | Evidence File Testing |
| -------------- | ---------------- | --------------------- |
| User Permission | Berhasil diuji | `RolePermissionTest.php`, `AccessTest.php` |
| Authentication | Berhasil diuji | `AuthTest.php` |
| Access Control | Berhasil diuji | `AccessTest.php`, `RolePermissionTest.php` |
| POS Logic | Berhasil diuji | `PosLogicTest.php`, `PosCheckoutTest.php`, `PosAdvancedTest.php` |
| Transaction Logic | Berhasil diuji | `TransactionTest.php`, `TransactionFlowTest.php` |
| Product CRUD | Berhasil diuji | `ProductTest.php`, `ProductAccessTest.php` |
| Category CRUD | Berhasil diuji | `CategoryTest.php` |
| Inventory Flow / Observer | Berhasil diuji | `InventoryObserverTest.php` |
| Payment Method | Berhasil diuji | `PaymentMethodTest.php` |
| Cash Flow | Berhasil diuji | `CashflowTest.php` |
| Relasi Data Modul | Berhasil diuji | `TransactionTest.php`, `TransactionFlowTest.php`, `CategoryTest.php`, `ProductTest.php` |
| Dashboard dan Statistik | Berhasil diuji | `DashboardTest.php` |
| Report | Berhasil diuji | `ReportTest.php` |
| Setting | Berhasil diuji | `SettingTest.php` |
| Receipt / Struk | Berhasil diuji | `ReceiptControllerTest.php` |

---

# Daftar File Testing

| No | File Testing |
| -- | ------------ |
| 1 | `AccessTest.php` |
| 2 | `AuthTest.php` |
| 3 | `CashflowTest.php` |
| 4 | `CategoryTest.php` |
| 5 | `DashboardTest.php` |
| 6 | `ExampleTest.php` |
| 7 | `InventoryObserverTest.php` |
| 8 | `PaymentMethodTest.php` |
| 9 | `PosAdvancedTest.php` |
| 10 | `PosCheckoutTest.php` |
| 11 | `PosLogicTest.php` |
| 12 | `ProductAccessTest.php` |
| 13 | `ProductTest.php` |
| 14 | `ReceiptControllerTest.php` |
| 15 | `ReportTest.php` |
| 16 | `RolePermissionTest.php` |
| 17 | `SettingTest.php` |
| 18 | `TransactionFlowTest.php` |
| 19 | `TransactionTest.php` |
| 20 | `UserTest.php` |

---

# Catatan Penggantian Istilah Pengujian

Pada laporan Filament, istilah **Relationship Testing** tidak digunakan sebagai komponen file test khusus karena tidak terdapat file `RelationshipTest.php` pada daftar file testing Filament. Cakupan relasi data tetap diuji, tetapi berada di dalam pengujian modul yang berkaitan langsung dengan relasi data, seperti transaksi, alur transaksi, kategori, produk, dan metode pembayaran.

Selain itu, istilah **Aggregate Query** juga tidak digunakan sebagai file test khusus karena tidak terdapat file `AggregateQueryTest.php` pada daftar file testing Filament. Pengujian statistik dashboard dan laporan dicakup melalui `DashboardTest.php` dan `ReportTest.php`.

Dengan demikian, penulisan cakupan pengujian Filament yang lebih tepat adalah **Relasi Data Modul**, **Dashboard dan Statistik**, serta **Report**, bukan `RelationshipTest.php` dan `AggregateQueryTest.php`.

---

# Analisis Hasil Pengujian White Box Filament

Berdasarkan hasil pengujian white box, sistem POS berbasis Filament memperoleh tingkat keberhasilan sebesar 100%. Seluruh skenario inti yang diuji pada 13 modul utama memperoleh status valid. Modul yang diuji meliputi Login/Auth, Dashboard, Kasir/POS, Produk, Kategori, Inventory, Transaksi, Cash Flow, Payment Method, Report, User, Role/Permission, dan Setting.

Keberhasilan pengujian tersebut menunjukkan bahwa proses utama pada sistem POS Filament telah berjalan sesuai skenario yang ditentukan. Fitur autentikasi berhasil menangani login, validasi credential, logout, dan update profil. Fitur dashboard berhasil menampilkan statistik utama seperti total transaksi, total income, dan transaksi terbaru. Fitur POS berhasil menangani checkout, validasi stok, validasi pembayaran, perhitungan subtotal, total, dan kembalian.

Pada fitur inventory, pengujian menunjukkan bahwa proses perubahan stok dapat dikendalikan melalui observer. Hal ini membantu menjaga konsistensi stok ketika terjadi penambahan, pengurangan, penyesuaian, maupun penghapusan data inventory. Pada fitur transaksi, pengujian menunjukkan bahwa data transaksi, item transaksi, produk, metode pembayaran, stok, dan cashflow otomatis dapat berjalan secara terintegrasi.

Fitur Cash Flow juga berhasil diuji untuk pencatatan kas masuk, pencatatan kas keluar, validasi source type, penghapusan cashflow manual, serta proteksi terhadap cashflow otomatis. Fitur Payment Method, Report, User, Role/Permission, dan Setting juga memperoleh hasil valid sesuai skenario masing-masing.

---

# Kesimpulan Hasil Pengujian White Box Filament

Berdasarkan hasil pengujian white box pada sistem POS Filament, seluruh fitur utama telah diuji dan memperoleh status valid. Total skenario inti yang diuji berjumlah 78 skenario, dengan 78 skenario berhasil, 0 skenario gagal, dan persentase keberhasilan sebesar 100%.

Dengan demikian, sistem POS Filament dapat dinyatakan berhasil menjalankan fungsi-fungsi utama sesuai skenario white box yang telah ditentukan. Penggunaan Filament memberikan dukungan struktur pengembangan yang terstandarisasi melalui resource, page, form, table, access control, dan observer sehingga proses pengujian dapat dilakukan secara konsisten pada modul-modul utama sistem.

# Hasil Testing dengan PHPUnit

![Hasil Testing PHPUnit 1](test-result-wb-filament-1.png)
![Hasil Testing PHPUnit 1](test-result-wb-filament-2.png)
![Hasil Testing PHPUnit 1](test-result-wb-filament-3.png)

