# Lampiran Pengujian White Box Sistem POS Laravel 12 Konvensional

---

## Keterangan 

Pengujian white box pada sistem POS Laravel 12 konvensional dilakukan untuk memastikan setiap proses utama pada sistem berjalan sesuai skenario yang telah ditentukan. Pada data terbaru, rekapitulasi pengujian disesuaikan dengan output PHPUnit terbaru, yaitu **98 tests**, **233 assertions**, **0 test gagal**, dan status **Passed**.

Pengujian dikelompokkan ke dalam 13 fitur utama agar sejajar dengan tabel pembanding sistem POS Filament. Fitur yang diuji meliputi Dashboard, POS/Kasir, Produk, Kategori, Inventory, Transaksi, Payment Method, Cash Flow, Report, User, Role/Permission, Setting, dan Login/Auth.

---

# Tabel 4. Hasil Pengujian White Box Fitur Dashboard

| No | Input | Process | Output | Result |
| -- | ----- | ------- | ------ | ------ |
| 1 | Data transaksi tersedia | Menghitung jumlah transaksi pada dashboard | Jumlah transaksi berhasil ditampilkan | Valid |
| 2 | Data income tersedia | Menghitung total income pada dashboard | Total income berhasil ditampilkan | Valid |
| 3 | Data transaksi terbaru tersedia | Mengambil latest transaction | Data transaksi terbaru berhasil ditampilkan | Valid |

### Evidence Pengujian

* File test:

  * `tests/Feature/AggregateQueryTest.php`
  * `tests/Feature/PermissionMiddlewareTest.php`

* File terkait:

  * `app/Http/Controllers/DashboardController.php`
  * `app/Http/Middleware/PermissionMiddleware.php`
  * `app/Models/Transaction.php`

---

# Tabel 5. Hasil Pengujian White Box Fitur Kasir / POS

| No | Input | Process | Output | Result |
| -- | ----- | ------- | ------ | ------ |
| 1 | Input harga dan quantity produk | Menghitung total harga | Total harga berhasil dihitung | Valid |
| 2 | Input pembayaran lebih besar dari total | Menghitung kembalian | Kembalian berhasil dihitung | Valid |
| 3 | Input pembayaran lebih kecil dari total | Menguji branch pembayaran kurang | Kembalian menjadi 0 | Valid |
| 4 | Input quantity melebihi stok | Menguji validasi quantity terhadap stok | Quantity tidak dapat melebihi stok | Valid |
| 5 | Input checkout tanpa item | Menguji validasi cart kosong | Checkout gagal diproses | Valid |
| 6 | Input subtotal transaksi | Menghitung subtotal item | Subtotal berhasil dihitung | Valid |
| 7 | Input multi item transaksi | Menghitung total transaksi dari beberapa item | Total transaksi sesuai | Valid |
| 8 | Input transaksi POS valid | Menguji proses transaksi POS | Transaksi berhasil dibuat | Valid |
| 9 | Input stock kurang | Menguji validasi stok tidak cukup | Checkout gagal diproses | Valid |
| 10 | Input pembayaran kurang | Menguji validasi pembayaran tidak cukup | Checkout gagal diproses | Valid |
| 11 | Input item kosong | Menguji validasi item kosong | Checkout gagal diproses | Valid |

### Evidence Pengujian

* File test:

  * `tests/Feature/PosTest.php`
  * `tests/Feature/ArithmeticLogicTest.php`

* File terkait:

  * `app/Http/Controllers/PosController.php`
  * `app/Models/Transaction.php`
  * `app/Models/TransactionItem.php`
  * `app/Models/Product.php`
  * `app/Models/PaymentMethod.php`

---

# Tabel 6. Hasil Pengujian White Box Fitur Produk

| No | Input | Process | Output | Result |
| -- | ----- | ------- | ------ | ------ |
| 1 | Input produk baru | Menguji create product | Produk berhasil disimpan | Valid |
| 2 | Input produk tidak valid | Menguji validasi produk | Validasi gagal diproses | Valid |
| 3 | Input update produk | Menguji update product | Produk berhasil diperbarui | Valid |
| 4 | Input delete produk | Menguji soft delete product | Produk berhasil dihapus secara soft delete | Valid |
| 5 | Input produk tanpa stok | Menguji default stock zero | Nilai stok menjadi 0 | Valid |
| 6 | Input harga produk | Menguji price casted to decimal | Harga berhasil dibaca sebagai decimal | Valid |
| 7 | Data produk dihapus | Menguji product soft delete state | Status soft delete berhasil dikenali | Valid |

### Evidence Pengujian

* File test:

  * `tests/Feature/ProdukTest.php`
  * `tests/Feature/ModelStateTest.php`

* File terkait:

  * `app/Http/Controllers/ProductController.php`
  * `app/Models/Product.php`
  * `app/Models/Category.php`

---

# Tabel 7. Hasil Pengujian White Box Fitur Kategori

| No | Input | Process | Output | Result |
| -- | ----- | ------- | ------ | ------ |
| 1 | User mengakses halaman kategori | Menguji view category index | Halaman kategori berhasil ditampilkan | Valid |
| 2 | Input kategori baru | Menguji create category | Kategori berhasil disimpan | Valid |
| 3 | Input kategori tanpa nama | Menguji validasi nama kategori kosong | Validasi gagal diproses | Valid |
| 4 | Input nama kategori terlalu panjang | Menguji validasi panjang nama kategori | Validasi gagal diproses | Valid |
| 5 | User mengakses halaman edit kategori | Menguji view edit page dengan data produk | Halaman edit kategori berhasil ditampilkan | Valid |
| 6 | Input update kategori | Menguji update category | Kategori berhasil diperbarui | Valid |
| 7 | Input delete kategori | Menguji soft delete category | Kategori berhasil dihapus | Valid |
| 8 | Data kategori banyak | Menguji pagination kategori | Pagination berhasil berjalan | Valid |
| 9 | Kategori memiliki banyak produk | Menguji relasi has many products | Relasi kategori dan produk berhasil dibaca | Valid |
| 10 | Input relasi kategori dengan produk | Menguji products relation | Relasi produk kategori berhasil diambil | Valid |

### Evidence Pengujian

* File test:

  * `tests/Feature/KategoriTest.php`
  * `tests/Feature/RelationshipTest.php`

* File terkait:

  * `app/Http/Controllers/KategoriController.php`
  * `app/Models/Category.php`
  * `app/Models/Product.php`

---

# Tabel 8. Hasil Pengujian White Box Fitur Inventory

| No | Input | Process | Output | Result |
| -- | ----- | ------- | ------ | ------ |
| 1 | User mengakses halaman inventory | Menguji view inventory index | Halaman inventory berhasil ditampilkan | Valid |
| 2 | Input inventory type `in` | Menguji create inventory tipe masuk | Stok produk bertambah | Valid |
| 3 | Input inventory type `out` | Menguji create inventory tipe keluar | Stok produk berkurang | Valid |
| 4 | Input inventory adjustment | Menguji create inventory adjustment | Stok berhasil disesuaikan | Valid |
| 5 | Input field wajib kosong | Menguji validasi required fields | Validasi gagal diproses | Valid |
| 6 | Input item kosong | Menguji validasi empty items | Validasi gagal diproses | Valid |
| 7 | Input produk tidak valid | Menguji validasi invalid product | Validasi gagal diproses | Valid |
| 8 | Input stok keluar melebihi stok tersedia | Menguji validasi stok tidak cukup untuk tipe keluar | Inventory gagal diproses | Valid |
| 9 | User mengakses detail inventory | Menguji view inventory detail | Detail inventory berhasil ditampilkan | Valid |
| 10 | User mengakses halaman edit inventory | Menguji view inventory edit page | Halaman edit inventory berhasil ditampilkan | Valid |
| 11 | Input delete inventory | Menguji reverse stock changes | Stok berhasil dikembalikan | Valid |
| 12 | Input inventory baru | Menguji generate unique reference number | Nomor referensi unik berhasil dibuat | Valid |
| 13 | Input nomor referensi | Menguji search by reference number | Data inventory berhasil ditemukan | Valid |
| 14 | Input inventory dengan beberapa item | Menguji inventory with multiple items | Beberapa item inventory berhasil diproses | Valid |

### Evidence Pengujian

* File test:

  * `tests/Feature/InventoryTest.php`
  * `tests/Feature/ArithmeticLogicTest.php`

* File terkait:

  * `app/Http/Controllers/InventoryController.php`
  * `app/Models/Product.php`
  * `app/Models/Inventory.php`

---

# Tabel 9. Hasil Pengujian White Box Fitur Transaksi

| No | Input | Process | Output | Result |
| -- | ----- | ------- | ------ | ------ |
| 1 | User mengakses halaman transaksi | Menguji view transaction index | Halaman transaksi berhasil ditampilkan | Valid |
| 2 | User mengakses detail transaksi | Menguji view transaction detail | Detail transaksi berhasil ditampilkan | Valid |
| 3 | Input delete transaksi | Menguji restore stock dan delete cashflow | Stok dikembalikan dan cashflow terhapus | Valid |
| 4 | Input transaksi | Menguji relasi transaction items | Item transaksi berhasil diambil | Valid |
| 5 | Input payment method | Menguji relasi payment method | Metode pembayaran berhasil diambil | Valid |
| 6 | Input product relation | Menguji relasi transaction item dengan produk | Produk berhasil diambil | Valid |

### Evidence Pengujian

* File test:

  * `tests/Feature/TransaksiTest.php`
  * `tests/Feature/RelationshipTest.php`

* File terkait:

  * `app/Http/Controllers/TransaksiController.php`
  * `app/Models/Transaction.php`
  * `app/Models/TransactionItem.php`
  * `app/Models/Product.php`
  * `app/Models/PaymentMethod.php`
  * `app/Models/CashboxFlow.php`

---

# Tabel 10. Hasil Pengujian White Box Fitur Payment Method

| No | Input | Process | Output | Result |
| -- | ----- | ------- | ------ | ------ |
| 1 | Input payment method baru | Menguji create payment method | Data berhasil disimpan | Valid |
| 2 | Input payment method tidak valid | Menguji validation fails | Validasi gagal diproses | Valid |
| 3 | Input update payment method | Menguji update payment method | Data berhasil diperbarui | Valid |
| 4 | Input delete payment method | Menguji soft delete payment method | Data berhasil dihapus | Valid |
| 5 | Input restore payment method | Menguji restore payment method | Data berhasil dipulihkan | Valid |
| 6 | Input payment method cash | Menguji cash payment method logic | Metode pembayaran cash berhasil dikenali | Valid |
| 7 | Input status aktif true | Menguji active status true | Status aktif berhasil dibaca | Valid |
| 8 | Input status aktif false | Menguji active status false | Status tidak aktif berhasil dibaca | Valid |
| 9 | Data payment method dihapus | Menguji payment method soft delete state | Status soft delete berhasil dikenali | Valid |
| 10 | Payment method memiliki transaksi | Menguji relasi payment method dengan transactions | Relasi transaksi berhasil dibaca | Valid |

### Evidence Pengujian

* File test:

  * `tests/Feature/PaymentMethodTest.php`
  * `tests/Feature/ModelStateTest.php`

* File terkait:

  * `app/Http/Controllers/PaymentMethodController.php`
  * `app/Models/PaymentMethod.php`
  * `app/Models/Transaction.php`

---

# Tabel 11. Hasil Pengujian White Box Fitur Cash Flow

| No | Input | Process | Output | Result |
| -- | ----- | ------- | ------ | ------ |
| 1 | Input create cash in | Menguji create cash in flow | Data cashflow masuk berhasil disimpan | Valid |
| 2 | Input create cash out | Menguji create cash out flow | Data cashflow keluar berhasil disimpan | Valid |
| 3 | Input source type invalid | Menguji source type mismatch validation | Validasi gagal diproses | Valid |
| 4 | Input delete manual cashflow | Menguji manual cashflow delete | Cashflow manual berhasil dihapus | Valid |
| 5 | Input delete auto cashflow | Menguji auto cashflow delete protection | Cashflow otomatis tidak dapat dihapus | Valid |

### Evidence Pengujian

* File test:

  * `tests/Feature/CashFlowTest.php`

* File terkait:

  * `app/Http/Controllers/CashFlowController.php`
  * `app/Models/CashboxFlow.php`

---

# Tabel 12. Hasil Pengujian White Box Fitur Report

| No | Input | Process | Output | Result |
| -- | ----- | ------- | ------ | ------ |
| 1 | Input transaksi | Menguji transaction total calculation | Total transaksi berhasil dihitung | Valid |
| 2 | Input filter transaksi | Menguji report filter transactions | Data laporan berhasil difilter | Valid |

### Evidence Pengujian

* File test:

  * `tests/Feature/AggregateQueryTest.php`

* File terkait:

  * `app/Http/Controllers/ReportController.php`
  * `app/Models/Transaction.php`

---

# Tabel 13. Hasil Pengujian White Box Fitur User

| No | Input | Process | Output | Result |
| -- | ----- | ------- | ------ | ------ |
| 1 | Input user baru | Menguji create user | User berhasil disimpan | Valid |
| 2 | Input perubahan data user | Menguji update user | User berhasil diperbarui | Valid |
| 3 | Input verifikasi user | Menguji verify user | User berhasil diverifikasi | Valid |
| 4 | Input delete user | Menguji delete user | User berhasil dihapus | Valid |
| 5 | Input update profile | Menguji update profile | Profil berhasil diperbarui | Valid |

### Evidence Pengujian

* File test:

  * `tests/Feature/RoleUserTest.php`
  * `tests/Feature/AuthTest.php`

* File terkait:

  * `app/Http/Controllers/UserController.php`
  * `app/Models/User.php`

---

# Tabel 14. Hasil Pengujian White Box Fitur Role / Permission

| No | Input | Process | Output | Result |
| -- | ----- | ------- | ------ | ------ |
| 1 | Route index diakses | Menguji permission mapping untuk route index | Permission berhasil dipetakan | Valid |
| 2 | Route store diakses | Menguji permission mapping untuk route store | Permission berhasil dipetakan | Valid |
| 3 | User memiliki permission spesifik | Menguji exact permission | Permission berhasil dikenali | Valid |
| 4 | User memiliki wildcard permission | Menguji wildcard permission | Permission berhasil dikenali | Valid |
| 5 | User memiliki permission tidak valid | Menguji invalid permission | Permission ditolak | Valid |
| 6 | User tanpa role | Menguji user without role | User tidak memiliki permission | Valid |
| 7 | User memiliki beberapa route | Menguji first accessible route | Route pertama yang dapat diakses berhasil ditemukan | Valid |
| 8 | Guest mengakses halaman terlindungi | Menguji guest redirect to login | Guest diarahkan ke login | Valid |
| 9 | User tanpa permission | Menguji response 403 | Akses ditolak dengan status 403 | Valid |
| 10 | User dengan permission dashboard | Menguji akses dashboard berdasarkan permission | Dashboard berhasil diakses | Valid |
| 11 | Request JSON tanpa permission | Menguji JSON forbidden response | Response 403 berhasil ditampilkan | Valid |
| 12 | Input role baru | Menguji create role | Role berhasil disimpan | Valid |
| 13 | Input update role | Menguji update role | Role berhasil diperbarui | Valid |
| 14 | Input delete role | Menguji delete role | Role berhasil dihapus | Valid |

### Evidence Pengujian

* File test:

  * `tests/Unit/UserPermissionTest.php`
  * `tests/Feature/PermissionMiddlewareTest.php`
  * `tests/Feature/RoleUserTest.php`

* File terkait:

  * `app/Models/User.php`
  * `app/Models/Role.php`
  * `app/Http/Middleware/PermissionMiddleware.php`

---

# Tabel 15. Hasil Pengujian White Box Fitur Setting

| No | Input | Process | Output | Result |
| -- | ----- | ------- | ------ | ------ |
| 1 | User mengakses halaman setting | Menguji view setting page | Halaman setting berhasil ditampilkan | Valid |
| 2 | Input perubahan setting | Menguji update setting | Data setting berhasil diperbarui | Valid |
| 3 | Input logo toko | Menguji upload store logo | Logo toko berhasil diupload | Valid |
| 4 | Input data wajib kosong | Menguji validation missing required fields | Validasi gagal diproses | Valid |
| 5 | Input tipe print tidak valid | Menguji validation invalid print type | Validasi gagal diproses | Valid |
| 6 | Input file logo tidak valid | Menguji validation invalid image | Validasi gagal diproses | Valid |
| 7 | Input logo baru | Menguji old logo deleted when new logo uploaded | Logo lama berhasil diganti | Valid |

### Evidence Pengujian

* File test:

  * `tests/Feature/SettingTest.php`

* File terkait:

  * `app/Http/Controllers/SettingController.php`
  * `app/Models/Setting.php`

---

# Tabel 16. Hasil Pengujian White Box Fitur Login / Auth

| No | Input | Process | Output | Result |
| -- | ----- | ------- | ------ | ------ |
| 1 | User memasukkan credential valid | Menguji login with valid credentials | Login berhasil | Valid |
| 2 | User memasukkan credential tidak valid | Menguji login with invalid credentials | Login gagal | Valid |
| 3 | User melakukan logout | Menguji logout | User berhasil keluar dari sistem | Valid |
| 4 | Guest mengakses halaman terlindungi | Menguji guest redirect login | Guest diarahkan ke login | Valid |

### Evidence Pengujian

* File test:

  * `tests/Feature/AuthTest.php`

* File terkait:

  * `app/Http/Controllers/AuthController.php`
  * `app/Models/User.php`

---

# Rekapitulasi Hasil Pengujian White Box

| No | Modul Utama | Jumlah Test Case | Berhasil | Gagal | Persentase |
| -- | ----------- | ---------------- | -------- | ----- | ---------- |
| 1 | Dashboard | 3 | 3 | 0 | 100% |
| 2 | POS / Kasir | 11 | 11 | 0 | 100% |
| 3 | Produk | 7 | 7 | 0 | 100% |
| 4 | Kategori | 10 | 10 | 0 | 100% |
| 5 | Inventory | 14 | 14 | 0 | 100% |
| 6 | Transaksi | 6 | 6 | 0 | 100% |
| 7 | Payment Method | 10 | 10 | 0 | 100% |
| 8 | Cash Flow | 5 | 5 | 0 | 100% |
| 9 | Report | 2 | 2 | 0 | 100% |
| 10 | User | 5 | 5 | 0 | 100% |
| 11 | Role / Permission | 14 | 14 | 0 | 100% |
| 12 | Setting | 7 | 7 | 0 | 100% |
| 13 | Login / Auth | 4 | 4 | 0 | 100% |
| | **TOTAL** | **98** | **98** | **0** | **100%** |

---

# Hasil Testing dengan PHPUnit

Berdasarkan hasil eksekusi PHPUnit terbaru, seluruh pengujian pada sistem POS Laravel 12 konvensional berhasil dijalankan tanpa test yang gagal.

| Aspek | Hasil |
| ----- | ----- |
| Command | `php artisan test` |
| Total Test PHPUnit | 98 tests |
| Total Assertion | 233 assertions |
| Status | Passed |
| Test Gagal | 0 |
| Persentase Keberhasilan | 100% |

---

# Ringkasan Cakupan Pengujian

| Komponen Utama | Status Pengujian | Evidence File Testing |
| -------------- | ---------------- | --------------------- |
| Dashboard Testing | Berhasil diuji | `AggregateQueryTest.php`, `PermissionMiddlewareTest.php` |
| POS Logic | Berhasil diuji | `PosTest.php`, `ArithmeticLogicTest.php` |
| Product CRUD | Berhasil diuji | `ProdukTest.php`, `ModelStateTest.php` |
| Category CRUD / Relation | Berhasil diuji | `KategoriTest.php`, `RelationshipTest.php` |
| Inventory Flow | Berhasil diuji | `InventoryTest.php`, `ArithmeticLogicTest.php` |
| Transaction Logic | Berhasil diuji | `TransaksiTest.php`, `RelationshipTest.php` |
| Payment Method | Berhasil diuji | `PaymentMethodTest.php`, `ModelStateTest.php` |
| Cash Flow | Berhasil diuji | `CashFlowTest.php` |
| Report / Aggregate Query | Berhasil diuji | `AggregateQueryTest.php` |
| User Management | Berhasil diuji | `RoleUserTest.php`, `AuthTest.php` |
| Role / Permission | Berhasil diuji | `UserPermissionTest.php`, `PermissionMiddlewareTest.php`, `RoleUserTest.php` |
| Setting | Berhasil diuji | `SettingTest.php` |
| Authentication | Berhasil diuji | `AuthTest.php` |

---

# Daftar File Testing

| No | File Testing |
| -- | ------------ |
| 1 | `AggregateQueryTest.php` |
| 2 | `ArithmeticLogicTest.php` |
| 3 | `AuthTest.php` |
| 4 | `CashFlowTest.php` |
| 5 | `InventoryTest.php` |
| 6 | `KategoriTest.php` |
| 7 | `ModelStateTest.php` |
| 8 | `PaymentMethodTest.php` |
| 9 | `PermissionMiddlewareTest.php` |
| 10 | `PosTest.php` |
| 11 | `ProdukTest.php` |
| 12 | `RelationshipTest.php` |
| 13 | `RoleUserTest.php` |
| 14 | `SettingTest.php` |
| 15 | `TransaksiTest.php` |
| 16 | `tests/Unit/UserPermissionTest.php` |

---

# Analisis Hasil Pengujian White Box Laravel Konvensional

Berdasarkan hasil pengujian white box, sistem POS Laravel 12 konvensional memperoleh tingkat keberhasilan sebesar 100%. Seluruh test case yang dikelompokkan ke dalam 13 fitur utama memperoleh status valid. Modul yang diuji meliputi Dashboard, POS/Kasir, Produk, Kategori, Inventory, Transaksi, Payment Method, Cash Flow, Report, User, Role/Permission, Setting, dan Login/Auth.

Keberhasilan pengujian tersebut menunjukkan bahwa proses utama pada sistem POS Laravel 12 konvensional telah berjalan sesuai skenario yang ditentukan. Fitur dashboard berhasil menghitung jumlah transaksi, total income, dan transaksi terbaru. Fitur POS berhasil menangani perhitungan harga, subtotal, total transaksi, kembalian, checkout, validasi stok, validasi pembayaran, dan validasi cart kosong.

Pada fitur Inventory, pengujian menunjukkan bahwa sistem dapat menangani inventory masuk, inventory keluar, adjustment stock, validasi field, validasi produk, pencarian nomor referensi, detail inventory, edit inventory, serta inventory dengan beberapa item. Pada fitur Transaksi, pengujian menunjukkan bahwa sistem dapat menampilkan daftar transaksi, detail transaksi, mengembalikan stok saat transaksi dihapus, menghapus cashflow otomatis, serta membaca relasi transaction item, payment method, dan produk.

Fitur Payment Method berhasil diuji pada proses create, update, soft delete, restore, validasi, status aktif, status cash, dan relasi transaksi. Fitur Cash Flow berhasil diuji pada pencatatan kas masuk, kas keluar, validasi source type, penghapusan cashflow manual, dan proteksi terhadap cashflow otomatis. Fitur Report, User, Role/Permission, Setting, dan Login/Auth juga memperoleh hasil valid sesuai skenario masing-masing.

---

# Kesimpulan Hasil Pengujian White Box Laravel Konvensional

Berdasarkan hasil pengujian white box pada sistem POS Laravel 12 konvensional, seluruh fitur utama telah diuji dan memperoleh status valid. Total pengujian yang digunakan pada rekapitulasi terbaru berjumlah **98 test case**, dengan **98 test case berhasil**, **0 test case gagal**, dan persentase keberhasilan sebesar **100%**.

Dengan demikian, sistem POS Laravel 12 konvensional dapat dinyatakan berhasil menjalankan fungsi-fungsi utama sesuai skenario white box yang telah ditentukan.

# Hasil Testing dengan PHPUnit

![Hasil Testing PHPUnit 1](test-result-wb-laravel-1.png)
![Hasil Testing PHPUnit 2](test-result-wb-laravel-2.png)
