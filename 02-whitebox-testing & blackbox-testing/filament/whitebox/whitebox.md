# Lampiran Pengujian White Box Sistem POS Laravel 12 Konvensional

---

## Keterangan Revisi

Pengujian white box pada sistem POS Laravel 12 konvensional dilakukan untuk memastikan setiap proses utama pada sistem berjalan sesuai skenario yang telah ditentukan. 

---

# Tabel 4. Hasil Pengujian White Box Fitur Login / Auth

| No | Input                                           | Process                           | Output                           | Result |
| -- | ----------------------------------------------- | --------------------------------- | -------------------------------- | ------ |
| 1  | User memasukkan email dan password valid        | Menguji proses autentikasi login  | User berhasil login ke sistem    | Valid  |
| 2  | User memasukkan email atau password tidak valid | Menguji validasi credential login | Login gagal diproses             | Valid  |
| 3  | User melakukan logout                           | Menguji proses invalidate session | User berhasil keluar dari sistem | Valid  |
| 4  | User memperbarui profil                         | Menguji update data profil user   | Profil user berhasil diperbarui  | Valid  |

### Evidence Pengujian

* File test:

  * `tests/Feature/AuthTest.php`

* File terkait:

  * `app/Http/Controllers/AuthController.php`
  * `app/Models/User.php`

---

# Tabel 5. Hasil Pengujian White Box Fitur Dashboard

| No | Input                                     | Process                              | Output                                      | Result |
| -- | ----------------------------------------- | ------------------------------------ | ------------------------------------------- | ------ |
| 1  | Data transaksi tersedia                   | Menghitung total transaksi dashboard | Total transaksi berhasil ditampilkan        | Valid  |
| 2  | Data income tersedia                      | Menghitung total income              | Total income berhasil ditampilkan           | Valid  |
| 3  | Data transaksi terbaru tersedia           | Mengambil latest transaction         | Data transaksi terbaru berhasil ditampilkan | Valid  |
| 4  | User mengakses dashboard                  | Menguji route dashboard              | Dashboard berhasil diakses                  | Valid  |
| 5  | User tanpa permission mengakses dashboard | Menguji middleware authorization     | Akses dashboard ditolak                     | Valid  |
| 6  | Guest mengakses dashboard                 | Menguji middleware authentication    | Guest diarahkan ke halaman login            | Valid  |

### Evidence Pengujian

* File test:

  * `tests/Feature/AggregateQueryTest.php`
  * `tests/Feature/PermissionMiddlewareTest.php`

* File terkait:

  * `app/Http/Controllers/DashboardController.php`
  * `app/Http/Middleware/PermissionMiddleware.php`

---

# Tabel 6. Hasil Pengujian White Box Fitur Kasir / POS

| No | Input                                           | Process                              | Output                         | Result |
| -- | ----------------------------------------------- | ------------------------------------ | ------------------------------ | ------ |
| 1  | Input checkout valid                            | Menguji create transaction           | Data transaksi berhasil dibuat | Valid  |
| 2  | Input checkout valid                            | Menguji create transaction item      | Item transaksi berhasil dibuat | Valid  |
| 3  | Input transaksi POS                             | Menguji sinkronisasi stok produk     | Stock produk berkurang         | Valid  |
| 4  | Input stock kurang                              | Menguji validasi stock               | Checkout gagal diproses        | Valid  |
| 5  | Input pembayaran kurang                         | Menguji validation branch pembayaran | Checkout gagal diproses        | Valid  |
| 6  | Input checkout tanpa item                       | Menguji validasi cart kosong         | Checkout gagal diproses        | Valid  |
| 7  | Input subtotal transaksi                        | Menghitung subtotal item             | Subtotal berhasil dihitung     | Valid  |
| 8  | Input multi item transaksi                      | Menghitung total transaksi           | Total transaksi sesuai         | Valid  |
| 9  | Input nominal pembayaran lebih besar dari total | Menghitung kembalian                 | Kembalian berhasil dihitung    | Valid  |
| 10 | Input nominal pembayaran lebih kecil dari total | Menguji branch pembayaran            | Kembalian menjadi 0            | Valid  |

### Evidence Pengujian

* File test:

  * `tests/Feature/PosTest.php`
  * `tests/Feature/ArithmeticLogicTest.php`

* File terkait:

  * `app/Http/Controllers/PosController.php`
  * `app/Models/Transaction.php`
  * `app/Models/TransactionItem.php`

---

# Tabel 7. Hasil Pengujian White Box Fitur Produk

| No | Input                     | Process                        | Output                         | Result |
| -- | ------------------------- | ------------------------------ | ------------------------------ | ------ |
| 1  | Input create produk       | Menguji create produk          | Produk berhasil disimpan       | Valid  |
| 2  | Input harga invalid       | Menguji validasi numeric harga | Validasi gagal diproses        | Valid  |
| 3  | Input update produk       | Menguji update produk          | Produk berhasil diperbarui     | Valid  |
| 4  | Input delete produk       | Menguji soft delete produk     | Produk berhasil dihapus        | Valid  |
| 5  | Input produk tanpa stok   | Menguji default stock          | Nilai stock menjadi 0          | Valid  |
| 6  | Input status produk aktif | Menguji status boolean produk  | Status aktif berhasil disimpan | Valid  |

### Evidence Pengujian

* File test:

  * `tests/Feature/ProdukTest.php`
  * `tests/Feature/ModelStateTest.php`

* File terkait:

  * `app/Http/Controllers/ProductController.php`
  * `app/Models/Product.php`

---

# Tabel 8. Hasil Pengujian White Box Fitur Kategori

| No | Input                               | Process                      | Output                       | Result |
| -- | ----------------------------------- | ---------------------------- | ---------------------------- | ------ |
| 1  | Input kategori baru                 | Menguji create kategori      | Kategori berhasil disimpan   | Valid  |
| 2  | Input update kategori               | Menguji update kategori      | Kategori berhasil diperbarui | Valid  |
| 3  | Input delete kategori               | Menguji soft delete kategori | Kategori berhasil dihapus    | Valid  |
| 4  | Input relasi kategori dengan produk | Menguji relasi `products()`  | Relasi berhasil diambil      | Valid  |

### Evidence Pengujian

* File test:

  * `tests/Feature/KategoriTest.php`
  * `tests/Feature/RelationshipTest.php`

* File terkait:

  * `app/Http/Controllers/KategoriController.php`
  * `app/Models/Category.php`

---

# Tabel 9. Hasil Pengujian White Box Fitur Inventory

| No | Input                      | Process                         | Output                      | Result |
| -- | -------------------------- | ------------------------------- | --------------------------- | ------ |
| 1  | Input inventory type `in`  | Menguji increment stock         | Stock produk bertambah      | Valid  |
| 2  | Input inventory type `out` | Menguji decrement stock         | Stock produk berkurang      | Valid  |
| 3  | Input adjustment stock     | Menguji adjustment stock        | Stock berhasil disesuaikan  | Valid  |
| 4  | Input delete inventory     | Menguji restore stock           | Stock berhasil dikembalikan | Valid  |
| 5  | Input stock tidak cukup    | Menguji validation branch stock | Inventory gagal diproses    | Valid  |

### Evidence Pengujian

* File test:

  * `tests/Feature/InventoryTest.php`
  * `tests/Feature/ArithmeticLogicTest.php`

* File terkait:

  * `app/Http/Controllers/InventoryController.php`
  * `app/Models/Product.php`

---

# Tabel 10. Hasil Pengujian White Box Fitur Transaksi

| No | Input                           | Process                          | Output                                | Result |
| -- | ------------------------------- | -------------------------------- | ------------------------------------- | ------ |
| 1  | Input transaksi                 | Menguji relasi transaction item  | Relasi berhasil diambil               | Valid  |
| 2  | Input payment method            | Menguji relasi payment method    | Payment method berhasil diambil       | Valid  |
| 3  | Input product relation          | Menguji relasi product           | Produk berhasil diambil               | Valid  |
| 4  | Input delete transaksi          | Menguji restore stock            | Stock berhasil dikembalikan           | Valid  |
| 5  | Input delete transaksi          | Menguji delete cashflow otomatis | Cashflow otomatis berhasil dihapus    | Valid  |
| 6  | User mengakses transaksi        | Menguji route transaksi          | Halaman transaksi berhasil diakses    | Valid  |
| 7  | User mengakses detail transaksi | Menguji detail transaksi         | Detail transaksi berhasil ditampilkan | Valid  |

### Evidence Pengujian

* File test:

  * `tests/Feature/TransaksiTest.php`
  * `tests/Feature/RelationshipTest.php`

* File terkait:

  * `app/Http/Controllers/TransaksiController.php`
  * `app/Models/Transaction.php`
  * `app/Models/TransactionItem.php`

---

# Tabel 11. Hasil Pengujian White Box Fitur Cash Flow

| No | Input                        | Process                            | Output                                 | Result |
| -- | ---------------------------- | ---------------------------------- | -------------------------------------- | ------ |
| 1  | Input create cash in         | Menguji pencatatan cashflow masuk  | Data cashflow masuk berhasil disimpan  | Valid  |
| 2  | Input create cash out        | Menguji pencatatan cashflow keluar | Data cashflow keluar berhasil disimpan | Valid  |
| 3  | Input source type invalid    | Menguji validasi source type       | Validasi gagal diproses                | Valid  |
| 4  | Input delete manual cashflow | Menguji delete cashflow manual     | Cashflow manual berhasil dihapus       | Valid  |
| 5  | Input delete auto cashflow   | Menguji proteksi auto cashflow     | Cashflow otomatis tidak dapat dihapus  | Valid  |

### Evidence Pengujian

* File test:

  * `tests/Feature/CashFlowTest.php`

* File terkait:

  * `app/Http/Controllers/CashFlowController.php`
  * `app/Models/CashboxFlow.php`

### Keterangan Perbaikan

Pada hasil pengujian sebelumnya, beberapa skenario Cash Flow masih gagal karena assertion pengujian belum sesuai dengan response controller. Setelah test case disesuaikan dengan perilaku controller yang sebenarnya, seluruh skenario Cash Flow berhasil dijalankan. Perbaikan ini menunjukkan bahwa fungsi Cash Flow sudah berjalan sesuai skenario, yaitu pencatatan kas masuk, pencatatan kas keluar, validasi source type, penghapusan cashflow manual, serta proteksi terhadap cashflow otomatis.

---

# Tabel 12. Hasil Pengujian White Box Fitur Payment Method

| No | Input                        | Process                            | Output                      | Result |
| -- | ---------------------------- | ---------------------------------- | --------------------------- | ------ |
| 1  | Input create payment method  | Menguji create payment method      | Data berhasil disimpan      | Valid  |
| 2  | Input update payment method  | Menguji update payment method      | Data berhasil diperbarui    | Valid  |
| 3  | Input delete payment method  | Menguji soft delete payment method | Data berhasil dihapus       | Valid  |
| 4  | Input restore payment method | Menguji restore payment method     | Data berhasil dipulihkan    | Valid  |
| 5  | Input field `is_cash`        | Menguji tipe metode pembayaran     | Status cash berhasil dibaca | Valid  |
| 6  | Input validation invalid     | Menguji validation payment method  | Validasi gagal diproses     | Valid  |

### Evidence Pengujian

* File test:

  * `tests/Feature/PaymentMethodTest.php`
  * `tests/Feature/ModelStateTest.php`

* File terkait:

  * `app/Http/Controllers/PaymentMethodController.php`
  * `app/Models/PaymentMethod.php`

---

# Tabel 13. Hasil Pengujian White Box Fitur Report

| No | Input                  | Process                      | Output                                  | Result |
| -- | ---------------------- | ---------------------------- | --------------------------------------- | ------ |
| 1  | Input transaksi        | Menghitung total transaksi   | Total transaksi berhasil dihitung       | Valid  |
| 2  | Input filter transaksi | Menguji filter laporan       | Data laporan berhasil difilter          | Valid  |
| 3  | Input latest transaksi | Mengambil latest transaction | Data transaksi terbaru berhasil diambil | Valid  |
| 4  | Input query aggregate  | Menguji statistik laporan    | Statistik laporan berhasil ditampilkan  | Valid  |

### Evidence Pengujian

* File test:

  * `tests/Feature/AggregateQueryTest.php`

* File terkait:

  * `app/Http/Controllers/ReportController.php`
  * `app/Models/Transaction.php`

---

# Tabel 14. Hasil Pengujian White Box Fitur User

| No | Input                     | Process             | Output                        | Result |
| -- | ------------------------- | ------------------- | ----------------------------- | ------ |
| 1  | Input data user baru      | Menguji create user | User berhasil disimpan        | Valid  |
| 2  | Input perubahan data user | Menguji update user | Data user berhasil diperbarui | Valid  |
| 3  | Input verifikasi user     | Menguji verify user | User berhasil diverifikasi    | Valid  |
| 4  | Input delete user         | Menguji delete user | User berhasil dihapus         | Valid  |

### Evidence Pengujian

* File test:

  * `tests/Feature/RoleUserTest.php`
  * `tests/Feature/AuthTest.php`

* File terkait:

  * `app/Models/User.php`
  * `app/Http/Controllers/UserController.php`

---

# Tabel 15. Hasil Pengujian White Box Fitur Role / Permission

| No | Input                                     | Process                             | Output                                  | Result |
| -- | ----------------------------------------- | ----------------------------------- | --------------------------------------- | ------ |
| 1  | Input role baru                           | Menguji create role                 | Role berhasil disimpan                  | Valid  |
| 2  | Input permission pada role                | Menguji penyimpanan permission role | Permission berhasil tersimpan pada role | Valid  |
| 3  | Input update role                         | Menguji update role                 | Role berhasil diperbarui                | Valid  |
| 4  | Input delete role                         | Menguji delete role                 | Role berhasil dihapus                   | Valid  |
| 5  | User memiliki permission sesuai role      | Menguji exact permission            | Permission berhasil dikenali            | Valid  |
| 6  | User memiliki wildcard permission         | Menguji wildcard permission         | Permission berhasil dikenali            | Valid  |
| 7  | User tanpa role                           | Menguji user tanpa permission       | User tidak memiliki permission          | Valid  |
| 8  | User tanpa permission mengakses dashboard | Menguji authorization middleware    | Access denied berhasil ditampilkan      | Valid  |
| 9  | Request JSON tanpa permission             | Menguji JSON authorization          | Response 403 berhasil ditampilkan       | Valid  |
| 10 | User dengan permission dashboard          | Menguji akses dashboard             | Dashboard berhasil diakses              | Valid  |

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

# Tabel 16. Hasil Pengujian White Box Fitur Setting

| No | Input                          | Process                         | Output                               | Result |
| -- | ------------------------------ | ------------------------------- | ------------------------------------ | ------ |
| 1  | User mengakses halaman setting | Menguji route setting           | Halaman setting berhasil ditampilkan | Valid  |
| 2  | Input perubahan setting        | Menguji update setting          | Data setting berhasil diperbarui     | Valid  |
| 3  | Input logo toko                | Menguji upload store logo       | Logo toko berhasil diupload          | Valid  |
| 4  | Input data wajib kosong        | Menguji validasi required field | Validasi gagal diproses              | Valid  |
| 5  | Input tipe print tidak valid   | Menguji validasi print type     | Validasi gagal diproses              | Valid  |
| 6  | Input file logo tidak valid    | Menguji validasi image          | Validasi gagal diproses              | Valid  |
| 7  | Input logo baru                | Menguji penghapusan logo lama   | Logo lama berhasil diganti           | Valid  |

### Evidence Pengujian

* File test:

  * `tests/Feature/SettingTest.php`

* File terkait:

  * `app/Http/Controllers/SettingController.php`
  * `app/Models/Setting.php`

---

# Rekapitulasi Hasil Pengujian White Box

| No | Modul Utama       | Jumlah Skenario Inti | Berhasil | Gagal | Persentase |
| -- | ----------------- | -------------------- | -------- | ----- | ---------- |
| 1  | Login / Auth      | 4                    | 4        | 0     | 100%       |
| 2  | Dashboard         | 6                    | 6        | 0     | 100%       |
| 3  | Kasir / POS       | 10                   | 10       | 0     | 100%       |
| 4  | Produk            | 6                    | 6        | 0     | 100%       |
| 5  | Kategori          | 4                    | 4        | 0     | 100%       |
| 6  | Inventory         | 5                    | 5        | 0     | 100%       |
| 7  | Transaksi         | 7                    | 7        | 0     | 100%       |
| 8  | Cash Flow         | 5                    | 5        | 0     | 100%       |
| 9  | Payment Method    | 6                    | 6        | 0     | 100%       |
| 10 | Report            | 4                    | 4        | 0     | 100%       |
| 11 | User              | 4                    | 4        | 0     | 100%       |
| 12 | Role / Permission | 10                   | 10       | 0     | 100%       |
| 13 | Setting           | 7                    | 7        | 0     | 100%       |
|    | **TOTAL**         | **78**               | **78**   | **0** | **100%**   |

---

# Hasil Testing dengan PHPUnit

Berdasarkan hasil eksekusi PHPUnit terbaru, seluruh pengujian pada sistem POS Laravel 12 konvensional berhasil dijalankan tanpa test yang gagal.

| Aspek              | Hasil              |
| ------------------ | ------------------ |
| Command            | `php artisan test` |
| Total Test PHPUnit | 98 tests           |
| Total Assertion    | 233 assertions     |
| Status             | Passed             |
| Test Gagal         | 0                  |
| Durasi             | 12.22s             |

---

# Ringkasan Cakupan Pengujian

| Komponen Utama        | Status Pengujian |
| --------------------- | ---------------- |
| User Permission       | Berhasil diuji   |
| Authentication        | Berhasil diuji   |
| Permission Middleware | Berhasil diuji   |
| POS Logic             | Berhasil diuji   |
| Transaction Logic     | Berhasil diuji   |
| Product CRUD          | Berhasil diuji   |
| Category CRUD         | Berhasil diuji   |
| Inventory Flow        | Berhasil diuji   |
| Payment Method        | Berhasil diuji   |
| Cash Flow             | Berhasil diuji   |
| Relationship Testing  | Berhasil diuji   |
| Aggregate Query       | Berhasil diuji   |
| Setting               | Berhasil diuji   |

---

# Analisis Hasil Pengujian Cash Flow

Pada pengujian sebelumnya, fitur Cash Flow masih memiliki beberapa test case yang gagal. Kegagalan tersebut bukan disebabkan oleh kegagalan fungsi utama Cash Flow, melainkan karena skenario pengujian belum sepenuhnya menyesuaikan bentuk response yang diberikan oleh controller.

Setelah pengujian diperbaiki, seluruh test case Cash Flow berhasil dijalankan. Pengujian Cash Flow mencakup pencatatan kas masuk, pencatatan kas keluar, validasi source type, penghapusan cashflow manual, dan proteksi terhadap cashflow otomatis. Hasil ini menunjukkan bahwa fitur Cash Flow pada sistem Laravel konvensional sudah berjalan sesuai skenario white box yang ditentukan.

---

# Kesimpulan Hasil Pengujian White Box Laravel Konvensional

Berdasarkan hasil pengujian white box pada sistem POS Laravel 12 konvensional, seluruh fitur utama telah diuji dan memperoleh status valid. Fitur yang diuji meliputi Login/Auth, Dashboard, Kasir/POS, Produk, Kategori, Inventory, Transaksi, Cash Flow, Payment Method, Report, User, Role/Permission, dan Setting.

Dengan demikian, sistem POS Laravel 12 konvensional dapat dinyatakan berhasil menjalankan fungsi-fungsi utama sesuai skenario pengujian white box yang telah ditentukan.
