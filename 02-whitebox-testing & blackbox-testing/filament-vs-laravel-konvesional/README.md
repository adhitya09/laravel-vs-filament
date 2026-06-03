# Analisis Perbandingan White Box Testing Sistem POS Filament vs Laravel 12 Konvensional

---

# Tabel Perbandingan White Box Testing Sistem POS Filament vs Laravel 12 Konvensional

| No | Modul | Filament | Laravel 12 Konvensional | Selisih / Analisis |
| -- | ----- | -------- | ----------------------- | ------------------ |
| 1 | Login / Auth | 4/4 PASS (100%) | 4/4 PASS (100%) | Setara. Keduanya berhasil menguji login valid, login tidak valid, logout, dan update profil. |
| 2 | Dashboard | 6/6 PASS (100%) | 6/6 PASS (100%) | Setara. Pada Filament diuji melalui `DashboardTest.php`, sedangkan pada Laravel diuji melalui pengujian dashboard dan query agregasi. |
| 3 | Kasir / POS | 10/10 PASS (100%) | 10/10 PASS (100%) | Setara. Keduanya menguji checkout, item transaksi, sinkronisasi stok, validasi stok, validasi pembayaran, subtotal, total, dan kembalian. |
| 4 | Produk | 6/6 PASS (100%) | 6/6 PASS (100%) | Setara. Keduanya menguji create, update, delete/soft delete, validasi harga, default stock, dan status produk. |
| 5 | Kategori | 4/4 PASS (100%) | 4/4 PASS (100%) | Setara. Keduanya menguji create, update, delete/soft delete, dan keterkaitan kategori dengan produk. |
| 6 | Inventory | 5/5 PASS (100%) | 5/5 PASS (100%) | Setara. Keduanya menguji stock in, stock out, adjustment stock, restore stock, dan validasi stok tidak cukup. |
| 7 | Transaksi | 7/7 PASS (100%) | 7/7 PASS (100%) | Setara. Keduanya menguji data transaksi, item transaksi, metode pembayaran, produk, pengembalian stok, cashflow otomatis, akses halaman, dan detail transaksi. |
| 8 | Cash Flow | 5/5 PASS (100%) | 5/5 PASS (100%) | Setara pada data terbaru. Laravel sebelumnya sempat mengalami mismatch assertion, tetapi sudah diperbaiki sehingga seluruh skenario Cash Flow valid. |
| 9 | Payment Method | 6/6 PASS (100%) | 6/6 PASS (100%) | Setara. Keduanya menguji create, update, delete/soft delete, restore, field `is_cash`, dan validasi payment method. |
| 10 | Report | 4/4 PASS (100%) | 4/4 PASS (100%) | Setara. Pada Filament diuji melalui `ReportTest.php`, sedangkan pada Laravel diuji melalui pengujian report dan aggregate query. |
| 11 | User | 4/4 PASS (100%) | 4/4 PASS (100%) | Setara. Keduanya menguji create user, update user, verifikasi user, dan delete user. |
| 12 | Role / Permission | 10/10 PASS (100%) | 10/10 PASS (100%) | Setara. Keduanya menguji role, permission, permission berdasarkan role, middleware authorization, dan akses dashboard berdasarkan permission. |
| 13 | Setting | 7/7 PASS (100%) | 7/7 PASS (100%) | Setara. Keduanya menguji halaman setting, update setting, upload logo, validasi field wajib, validasi print type, validasi image, dan penggantian logo lama. |

---

# Tabel Rekapitulasi Keseluruhan

| Aspek | Filament | Laravel 12 Konvensional |
| ----- | -------- | ----------------------- |
| Total modul utama yang dibandingkan | 13 modul | 13 modul |
| Total skenario inti white box | 78 skenario | 78 skenario |
| Total berhasil | 78 skenario | 78 skenario |
| Total gagal | 0 skenario | 0 skenario |
| Persentase keberhasilan | 100% | 100% |
| Total PHPUnit tests | 98 tests | 98 tests |
| Total assertion | 233 assertions | 233 assertions |
| Status eksekusi PHPUnit | Passed | Passed |
| Test gagal | 0 | 0 |
| Authentication testing | Ada | Ada |
| Authorization testing | Ada | Ada |
| Middleware / access testing | Ada, melalui `AccessTest.php` dan `RolePermissionTest.php` | Ada, melalui middleware dan permission testing |
| CRUD testing | Ada | Ada |
| Relasi model | Tercakup dalam test modul terkait, bukan file khusus `RelationshipTest.php` | Ada, termasuk melalui `RelationshipTest.php` |
| Statistik dashboard/laporan | Tercakup dalam `DashboardTest.php` dan `ReportTest.php` | Ada, termasuk melalui `AggregateQueryTest.php` |
| Arithmetic / POS logic testing | Ada, melalui test POS terkait | Ada, termasuk melalui `ArithmeticLogicTest.php` |
| Cash Flow testing | 5/5 PASS | 5/5 PASS |
| Setting testing | 7/7 PASS | 7/7 PASS |
| Kesimpulan hasil uji | Seluruh skenario valid | Seluruh skenario valid |

---

# Tabel Pembacaan File Testing

| Komponen Pengujian | File Testing Filament | File Testing Laravel 12 Konvensional | Catatan Analisis |
| ------------------ | --------------------- | ------------------------------------ | ---------------- |
| Access / authorization | `AccessTest.php`, `RolePermissionTest.php` | `PermissionMiddlewareTest.php`, `RoleUserTest.php` | Sama-sama menguji akses dan permission, tetapi struktur file berbeda. |
| Authentication | `AuthTest.php` | `AuthTest.php` | Setara. |
| Cash Flow | `CashflowTest.php` | `CashFlowTest.php` | Setara secara cakupan modul. |
| Category | `CategoryTest.php` | `KategoriTest.php` | Setara secara cakupan fitur, berbeda penamaan file. |
| Dashboard | `DashboardTest.php` | `AggregateQueryTest.php`, `PermissionMiddlewareTest.php` | Filament tidak memakai nama `AggregateQueryTest.php`, tetapi pengujian dashboard tercakup pada `DashboardTest.php`. |
| Inventory | `InventoryObserverTest.php` | `InventoryTest.php`, `ArithmeticLogicTest.php` | Filament menonjolkan observer inventory, sedangkan Laravel memisahkan logic inventory dan arithmetic. |
| Payment Method | `PaymentMethodTest.php` | `PaymentMethodTest.php` | Setara. |
| POS / Kasir | `PosAdvancedTest.php`, `PosCheckoutTest.php`, `PosLogicTest.php` | `PosTest.php`, `ArithmeticLogicTest.php` | Keduanya menguji POS, tetapi Filament memecah POS ke beberapa file test. |
| Product | `ProductAccessTest.php`, `ProductTest.php` | `ProdukTest.php`, `ModelStateTest.php` | Filament memiliki file khusus akses produk. |
| Receipt | `ReceiptControllerTest.php` | Tidak ditampilkan sebagai modul utama pada rekap Laravel terbaru | Receipt ada pada daftar testing Filament, tetapi tidak dimasukkan sebagai modul pembanding utama karena rekap perbandingan mengikuti 13 modul utama. |
| Report | `ReportTest.php` | `AggregateQueryTest.php` | Filament tidak memakai nama `AggregateQueryTest.php`, tetapi pengujian laporan tercakup pada `ReportTest.php`. |
| Setting | `SettingTest.php` | `SettingTest.php` | Setara. |
| Transaction | `TransactionFlowTest.php`, `TransactionTest.php` | `TransaksiTest.php`, `RelationshipTest.php` | Filament menguji transaksi melalui file transaction, sedangkan Laravel juga memiliki file relationship khusus. |
| User | `UserTest.php` | `RoleUserTest.php`, `AuthTest.php` | Setara secara cakupan user management. |
| Relationship testing khusus | Tidak ada file khusus `RelationshipTest.php` | `RelationshipTest.php` | relasi diuji di dalam test modul terkait. |
| Aggregate query testing khusus | Tidak ada file khusus `AggregateQueryTest.php` | `AggregateQueryTest.php` | statistik diuji melalui `DashboardTest.php` dan `ReportTest.php`. |

---

# Tabel Analisis Stabilitas Pengujian

| Aspek | Filament | Laravel 12 Konvensional | Analisis |
| ----- | -------- | ----------------------- | -------- |
| Hasil akhir pengujian | 100% PASS | 100% PASS | Kedua sistem berhasil memenuhi seluruh skenario white box. |
| Cash Flow | Stabil | Stabil setelah perbaikan test case | Perbedaan sebelumnya ada pada assertion, bukan kegagalan fungsi utama. |
| Setting | 7/7 PASS | 7/7 PASS | Fitur Setting sudah teruji pada kedua sistem. |
| Authentication | Valid | Valid | Login, credential validation, logout, dan update profil berhasil diuji. |
| Authorization / access control | Valid | Valid | Akses berdasarkan permission berhasil diuji pada kedua sistem. |
| Relasi model | Tercakup dalam test modul transaksi, kategori, dan produk | Diuji melalui test modul serta `RelationshipTest.php` | Filament tidak memiliki file khusus `RelationshipTest.php`, sehingga jangan ditulis sebagai komponen testing terpisah. |
| Statistik dashboard/laporan | Diuji melalui `DashboardTest.php` dan `ReportTest.php` | Diuji melalui `AggregateQueryTest.php` | Filament tidak memiliki file khusus `AggregateQueryTest.php`, sehingga istilah aggregate query khusus hanya tepat untuk Laravel. |
| Risiko mismatch response | Lebih rendah | Lebih tinggi jika controller tidak konsisten | Filament memiliki flow lebih terstandarisasi, sedangkan Laravel bergantung pada implementasi manual. |
| Ketergantungan pada developer | Lebih rendah | Lebih tinggi | Laravel membutuhkan konsistensi manual pada controller, validation, redirect, dan response. |

---

# Tabel Perbandingan Tingkat Otomatisasi Framework

| Aspek | Filament | Laravel 12 Konvensional | Dampak terhadap Pengujian |
| ----- | -------- | ----------------------- | ------------------------- |
| Struktur pengembangan | Resource-driven | Controller-driven | Filament lebih terstandarisasi, sedangkan Laravel lebih bergantung pada konsistensi controller yang ditulis manual. |
| CRUD Resource | Otomatis melalui Resource, Form, dan Table | Manual melalui controller, route, request, dan Blade | Filament mengurangi boilerplate, sedangkan Laravel memberi kontrol lebih luas tetapi membutuhkan penulisan lebih banyak. |
| Form Rendering | Otomatis melalui form schema | Manual melalui Blade form | Risiko inkonsistensi form lebih tinggi pada Laravel jika struktur form tidak distandarkan. |
| Table Rendering | Otomatis melalui table schema | Manual melalui Blade dan query controller | Filament lebih cepat untuk membangun tabel administratif. |
| Redirect Handling | Umumnya distandarkan oleh lifecycle Filament | Ditentukan manual oleh controller | Laravel lebih fleksibel, tetapi perlu konsistensi response agar assertion testing tidak mismatch. |
| Validation Error | Terintegrasi dengan form handling Filament | Manual melalui request/controller validation | Keduanya dapat valid, tetapi Laravel membutuhkan penyesuaian assertion sesuai flow validasi aktual. |
| Permission Handling | Dapat dibantu package/admin panel permission | Manual melalui middleware dan role permission | Keduanya valid, tetapi Laravel memerlukan pengelolaan middleware dan rule permission yang lebih eksplisit. |
| Notification Handling | Umumnya tersedia melalui mekanisme Filament | Manual melalui session flash/response | Filament lebih terstandarisasi dalam feedback antarmuka. |
| Upload Handling | Semi otomatis melalui komponen upload | Manual melalui validasi file dan storage | Laravel lebih fleksibel, tetapi membutuhkan pengaturan validasi dan penyimpanan lebih detail. |
| Dashboard Widget | Dibantu widget dan komponen Filament | Manual melalui query controller dan Blade | Filament lebih efisien untuk tampilan admin, Laravel lebih bebas dalam desain. |
| Route Management | Banyak dibantu oleh resource/page Filament | Manual pada route web dan controller | Laravel lebih eksplisit, tetapi jumlah konfigurasi lebih banyak. |
| Testing Stability | Stabil karena banyak lifecycle terstandarisasi | Stabil setelah assertion disesuaikan dengan response controller | Pada data terbaru, keduanya stabil; risiko mismatch Laravel tetap lebih tinggi jika response tidak konsisten. |

---

# Tabel Analisis Arsitektur

| Aspek | Filament | Laravel 12 Konvensional |
| ----- | -------- | ----------------------- |
| Arsitektur | Resource-driven | Controller-driven |
| Fokus framework | Rapid admin development | Full custom development |
| Kompleksitas coding | Lebih rendah untuk fitur administratif | Lebih tinggi karena banyak proses ditulis manual |
| Boilerplate code | Lebih sedikit | Lebih banyak |
| Maintainability | Tinggi jika mengikuti pola resource Filament | Tinggi jika controller, service, request, dan middleware ditulis konsisten |
| Development speed | Lebih cepat untuk CRUD/admin panel | Lebih lambat, tetapi lebih fleksibel |
| Fleksibilitas logic | Sedang sampai tinggi | Sangat tinggi |
| Konsistensi response | Lebih terstandarisasi | Bergantung pada implementasi developer |
| Risiko human error | Lebih rendah | Lebih tinggi |
| Kontrol detail antarmuka | Cukup, tetapi mengikuti pola Filament | Lebih bebas karena menggunakan Blade/custom UI |
| Kesesuaian untuk POS custom | Baik untuk admin panel dan operasional cepat | Baik untuk kebutuhan custom yang membutuhkan kontrol penuh |
| Tingkat otomatisasi | Tinggi | Rendah–sedang |
| Dominasi manual logic | Lebih rendah | Lebih tinggi |

---

# Analisis Perbandingan

Berdasarkan data terbaru, hasil white box testing menunjukkan bahwa sistem POS berbasis Filament dan sistem POS Laravel 12 konvensional sama-sama memperoleh hasil **100% PASS**. Seluruh modul utama yang diuji, yaitu Login/Auth, Dashboard, Kasir/POS, Produk, Kategori, Inventory, Transaksi, Cash Flow, Payment Method, Report, User, Role/Permission, dan Setting, berhasil dijalankan sesuai skenario pengujian.

Filament lebih unggul pada otomatisasi karena banyak proses administratif seperti CRUD, form, table, resource, permission integration, dan response lifecycle dibantu oleh framework. Laravel 12 konvensional lebih unggul pada fleksibilitas karena controller, route, validation, middleware, view, dan response dapat dikendalikan secara manual oleh developer. Namun, fleksibilitas tersebut membutuhkan konsistensi implementasi agar hasil testing tetap stabil.

---

# Kesimpulan Perbandingan

Berdasarkan hasil pengujian white box terbaru, sistem POS berbasis Filament dan Laravel 12 konvensional sama-sama memperoleh tingkat keberhasilan sebesar **100%**. Kedua sistem memiliki **78 skenario inti**, seluruhnya berhasil dijalankan, dengan **0 skenario gagal**.

Hasil ini menunjukkan bahwa kedua sistem telah memenuhi skenario fungsional utama yang diuji melalui pendekatan white box testing. Perbedaan utama bukan pada keberhasilan pengujian, melainkan pada karakteristik pengembangan dan struktur file pengujian.

Filament lebih efisien untuk membangun sistem admin/POS dengan kebutuhan CRUD dan manajemen data yang dominan karena memiliki otomatisasi dan standardisasi yang lebih tinggi. Laravel 12 konvensional lebih kuat ketika sistem membutuhkan logika bisnis khusus, kontrol response yang detail, dan rancangan antarmuka yang lebih bebas. Namun, pada Laravel konvensional, developer harus menjaga konsistensi controller, validasi, redirect, dan response agar pengujian tetap stabil.

