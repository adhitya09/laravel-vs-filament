# Analisis Perbandingan White Box Testing Sistem POS Filament vs Laravel 12 Konvensional

---

## Keterangan

Analisis ini disesuaikan berdasarkan data terbaru pengujian white box pada sistem POS berbasis **Filament** dan **Laravel 12 konvensional**. Pada versi terbaru, jumlah test case pada tabel perbandingan disetarakan menjadi **98 test case pembanding** untuk masing-masing sistem agar analisis dapat dilakukan pada basis yang seimbang.

Perlu dibedakan antara **jumlah test case pembanding** dan **output PHPUnit mentah**. Pada sistem Filament, output PHPUnit mentah menunjukkan jumlah test yang lebih besar karena terdapat test tambahan seperti `ExampleTest.php` dan pengujian receipt/struk melalui `ReceiptControllerTest.php`. Dalam tabel pembanding, receipt/struk tidak dijadikan fitur utama tersendiri, tetapi digabungkan ke modul **Transaksi** karena masih menjadi bagian dari alur transaksi.

Dengan penyesuaian tersebut, kedua sistem memiliki **13 modul utama**, **98 test case pembanding**, **98 test case berhasil**, **0 test case gagal**, dan persentase keberhasilan **100%**.

---

# Tabel Perbandingan White Box Testing Sistem POS Filament vs Laravel 12 Konvensional

| No | Modul | Filament | Laravel 12 Konvensional | Selisih / Analisis |
| -- | ----- | -------- | ----------------------- | ------------------ |
| 1 | Dashboard | 9/9 PASS (100%) | 3/3 PASS (100%) | Filament memiliki skenario akses dashboard lebih detail, termasuk akses admin, guest, user tanpa permission, user dengan permission, route, dan permission dashboard. Laravel berfokus pada perhitungan dashboard utama, yaitu jumlah transaksi, total income, dan latest transaction. |
| 2 | POS / Kasir | 20/20 PASS (100%) | 11/11 PASS (100%) | Filament memiliki pengujian POS lebih rinci karena mencakup interaksi order berbasis Livewire seperti add product, duplicate item, increase/decrease quantity, reset order, checkout, validasi stok, validasi pembayaran, dan penyimpanan payment amount. Laravel menguji logic utama POS seperti subtotal, total, kembalian, checkout, validasi stok, validasi pembayaran, dan cart kosong. |
| 3 | Produk | 9/9 PASS (100%) | 7/7 PASS (100%) | Filament memiliki tambahan pengujian akses halaman produk berdasarkan role/permission. Laravel lebih menekankan CRUD, validasi produk, default stock, price casting, dan soft delete state. |
| 4 | Kategori | 4/4 PASS (100%) | 10/10 PASS (100%) | Laravel memiliki pengujian kategori lebih detail, termasuk view index, validasi nama kosong, validasi nama terlalu panjang, edit page, pagination, dan relasi produk. Filament berfokus pada CRUD kategori dan relasi produk kategori. |
| 5 | Inventory | 5/5 PASS (100%) | 14/14 PASS (100%) | Laravel memiliki pengujian inventory lebih luas, termasuk index, detail, edit page, validasi field, validasi item, validasi produk, nomor referensi, pencarian, dan multiple items. Filament menekankan sinkronisasi stok melalui observer inventory. |
| 6 | Transaksi | 12/12 PASS (100%) | 6/6 PASS (100%) | Filament memiliki skenario transaksi lebih banyak karena mencakup transaction relation, deleted product access, stock synchronization, transaction number, stock validation, dan receipt flow. Laravel menguji index, detail, restore stock, delete cashflow otomatis, serta relasi transaction item, payment method, dan product. |
| 7 | Metode Pembayaran | 4/4 PASS (100%) | 10/10 PASS (100%) | Laravel memiliki pengujian payment method lebih detail, meliputi validation, restore, cash logic, active status, soft delete state, dan relation. Filament berfokus pada CRUD payment method dan penyimpanan field `is_cash`. |
| 8 | Alur Kas / Cash Flow | 4/4 PASS (100%) | 5/5 PASS (100%) | Keduanya valid. Laravel memiliki satu skenario tambahan terkait proteksi cashflow otomatis, sedangkan Filament berfokus pada create, update, delete, dan validasi nominal cashflow. |
| 9 | Laporan / Report | 4/4 PASS (100%) | 2/2 PASS (100%) | Filament memiliki pengujian report lebih banyak, termasuk total transaksi, filter laporan, latest transaction, dan average transaction. Laravel menguji total transaksi dan filter laporan melalui aggregate query. |
| 10 | User / User Management | 8/8 PASS (100%) | 5/5 PASS (100%) | Filament memiliki pengujian user management lebih detail, terutama akses user page, guest redirect, unique email, dan password hashing. Laravel menguji create, update, verify, delete user, dan update profile. |
| 11 | Role / Permission | 12/12 PASS (100%) | 14/14 PASS (100%) | Laravel memiliki pengujian permission lebih detail pada level route, wildcard permission, invalid permission, first accessible route, JSON 403 response, dan middleware authorization. Filament menguji role, permission assignment, access control, dan permission validation. |
| 12 | Setting | 4/4 PASS (100%) | 7/7 PASS (100%) | Laravel memiliki pengujian setting lebih lengkap, termasuk view setting page, upload logo, validasi required field, validasi print type, validasi image, dan penghapusan logo lama. Filament berfokus pada create, update, delete setting, dan penyimpanan phone number. |
| 13 | Login / Auth | 3/3 PASS (100%) | 4/4 PASS (100%) | Laravel memiliki skenario login/logout lebih eksplisit, yaitu login valid, login invalid, logout, dan guest redirect. Filament menekankan validasi akses panel, role access, homepage redirect, dan login panel validation. |

---

# Tabel Rekapitulasi Keseluruhan

| Aspek | Filament | Laravel 12 Konvensional |
| ----- | -------- | ----------------------- |
| Total modul utama yang dibandingkan | 13 modul | 13 modul |
| Total test case pembanding | 98 test case | 98 test case |
| Total berhasil | 98 test case | 98 test case |
| Total gagal | 0 test case | 0 test case |
| Persentase keberhasilan | 100% | 100% |
| Raw PHPUnit tests | 107 tests | 98 tests |
| Total assertion | 123 assertions | 233 assertions |
| Status eksekusi PHPUnit | Passed | Passed |
| Test gagal | 0 | 0 |
| Authentication testing | Ada | Ada |
| Authorization testing | Ada | Ada |
| Access / middleware testing | Ada, melalui `AccessTest.php` dan `RolePermissionTest.php` | Ada, melalui `PermissionMiddlewareTest.php` dan `RoleUserTest.php` |
| CRUD testing | Ada | Ada |
| Relasi model | Tercakup dalam test modul terkait, bukan file khusus `RelationshipTest.php` | Ada, termasuk melalui `RelationshipTest.php` |
| Statistik dashboard/laporan | Tercakup dalam `DashboardTest.php` dan `ReportTest.php` | Ada, termasuk melalui `AggregateQueryTest.php` |
| Arithmetic / POS logic testing | Ada, melalui `PosLogicTest.php`, `PosCheckoutTest.php`, dan `PosAdvancedTest.php` | Ada, termasuk melalui `ArithmeticLogicTest.php` |
| Cash Flow testing | 4/4 PASS | 5/5 PASS |
| Setting testing | 4/4 PASS | 7/7 PASS |
| Kesimpulan hasil uji | Seluruh test case pembanding valid | Seluruh test case pembanding valid |

---

# Tabel Pembacaan File Testing

| Komponen Pengujian | File Testing Filament | File Testing Laravel 12 Konvensional | Catatan Analisis |
| ------------------ | --------------------- | ------------------------------------ | ---------------- |
| Access / Authorization | `AccessTest.php`, `RolePermissionTest.php` | `PermissionMiddlewareTest.php`, `RoleUserTest.php`, `UserPermissionTest.php` | Sama-sama menguji akses dan permission, tetapi Laravel lebih eksplisit pada middleware dan mapping permission route. |
| Authentication | `AuthTest.php`, `AccessTest.php` | `AuthTest.php` | Filament lebih berfokus pada akses panel, sedangkan Laravel lebih eksplisit pada login valid, login invalid, logout, dan guest redirect. |
| Dashboard | `DashboardTest.php`, `AccessTest.php`, `RolePermissionTest.php` | `AggregateQueryTest.php`, `PermissionMiddlewareTest.php` | Filament tidak memakai nama `AggregateQueryTest.php`; statistik dashboard diuji melalui `DashboardTest.php`. |
| POS / Kasir | `PosAdvancedTest.php`, `PosCheckoutTest.php`, `PosLogicTest.php` | `PosTest.php`, `ArithmeticLogicTest.php` | Filament memecah POS ke beberapa file test karena ada interaksi order dan Livewire logic. |
| Product | `ProductAccessTest.php`, `ProductTest.php` | `ProdukTest.php`, `ModelStateTest.php` | Filament memiliki file khusus akses produk. |
| Category | `CategoryTest.php` | `KategoriTest.php`, `RelationshipTest.php` | Laravel lebih detail pada validasi dan pagination kategori. |
| Inventory | `InventoryObserverTest.php` | `InventoryTest.php`, `ArithmeticLogicTest.php` | Filament menonjolkan observer inventory, sedangkan Laravel menguji alur inventory lebih luas. |
| Transaction | `TransactionFlowTest.php`, `TransactionTest.php`, `ReceiptControllerTest.php` | `TransaksiTest.php`, `RelationshipTest.php` | Receipt pada Filament digabung ke Transaksi karena masih bagian dari transaction flow. |
| Payment Method | `PaymentMethodTest.php` | `PaymentMethodTest.php`, `ModelStateTest.php` | Laravel memiliki cakupan payment method lebih rinci, termasuk restore, state, active status, dan relation. |
| Cash Flow | `CashflowTest.php` | `CashFlowTest.php` | Keduanya menguji modul alur kas, tetapi skenario Laravel mencakup proteksi cashflow otomatis. |
| Report | `ReportTest.php` | `AggregateQueryTest.php` | Filament tidak memakai nama `AggregateQueryTest.php`; pengujian laporan dilakukan melalui `ReportTest.php`. |
| User | `UserTest.php`, `AuthTest.php` | `RoleUserTest.php`, `AuthTest.php` | Keduanya menguji user management, tetapi cakupan Filament lebih menekankan akses user page dan hashing. |
| Setting | `SettingTest.php` | `SettingTest.php` | Laravel memiliki pengujian setting lebih banyak pada upload dan validasi file. |
| Relationship testing khusus | Tidak ada file khusus `RelationshipTest.php` | `RelationshipTest.php` | Pada Filament, relasi diuji dalam test modul terkait. |
| Aggregate query testing khusus | Tidak ada file khusus `AggregateQueryTest.php` | `AggregateQueryTest.php` | Pada Filament, statistik diuji melalui `DashboardTest.php` dan `ReportTest.php`. |
| Receipt / Invoice | `ReceiptControllerTest.php` | Tidak ditampilkan sebagai fitur utama terpisah | Receipt pada Filament digabung ke modul Transaksi dalam rekapitulasi 13 fitur. |

---

# Tabel Analisis Stabilitas Pengujian

| Aspek | Filament | Laravel 12 Konvensional | Analisis |
| ----- | -------- | ----------------------- | -------- |
| Hasil akhir pengujian | 100% PASS | 100% PASS | Kedua sistem berhasil memenuhi seluruh test case pembanding. |
| Total test case pembanding | 98 | 98 | Jumlah test case disetarakan untuk kebutuhan analisis komparatif. |
| Raw PHPUnit tests | 107 | 98 | Filament memiliki test mentah lebih banyak karena terdapat test tambahan seperti `ExampleTest.php` dan `ReceiptControllerTest.php`. |
| Cash Flow | 4/4 PASS | 5/5 PASS | Keduanya stabil. Laravel memiliki proteksi cashflow otomatis sebagai skenario tambahan. |
| Setting | 4/4 PASS | 7/7 PASS | Laravel memiliki pengujian setting lebih detail, terutama upload logo dan validasi file. |
| Authentication | Valid | Valid | Keduanya berhasil menguji akses awal sistem dan mekanisme autentikasi. |
| Authorization / Access Control | Valid | Valid | Keduanya berhasil menguji akses berdasarkan role dan permission. |
| Relasi model | Tercakup dalam test modul transaksi, kategori, dan produk | Diuji melalui test modul serta `RelationshipTest.php` | Filament tidak memiliki file khusus `RelationshipTest.php`. |
| Statistik dashboard/laporan | Diuji melalui `DashboardTest.php` dan `ReportTest.php` | Diuji melalui `AggregateQueryTest.php` | Istilah aggregate query khusus lebih tepat untuk Laravel karena nama file test tersebut memang tersedia. |
| Risiko mismatch response | Lebih rendah | Lebih tinggi jika controller tidak konsisten | Filament memiliki flow lebih terstandarisasi, sedangkan Laravel bergantung pada implementasi manual controller. |
| Ketergantungan pada developer | Lebih rendah | Lebih tinggi | Laravel membutuhkan konsistensi manual pada controller, validation, redirect, response, dan middleware. |

---

# Tabel Perbandingan Tingkat Otomatisasi Framework

| Aspek | Filament | Laravel 12 Konvensional | Dampak terhadap Pengujian |
| ----- | -------- | ----------------------- | ------------------------- |
| Struktur pengembangan | Resource-driven | Controller-driven | Filament lebih terstandarisasi, sedangkan Laravel lebih bergantung pada konsistensi controller yang ditulis manual. |
| CRUD Resource | Otomatis melalui Resource, Form, dan Table | Manual melalui controller, route, request, dan Blade | Filament mengurangi boilerplate, sedangkan Laravel memberi kontrol lebih luas tetapi membutuhkan penulisan lebih banyak. |
| Form Rendering | Otomatis melalui form schema | Manual melalui Blade form | Laravel lebih fleksibel tetapi memerlukan konsistensi implementasi. |
| Table Rendering | Otomatis melalui table schema | Manual melalui Blade dan query controller | Filament lebih cepat untuk membangun tabel administratif. |
| Redirect Handling | Umumnya distandarkan oleh lifecycle Filament | Ditentukan manual oleh controller | Laravel perlu konsistensi response agar assertion testing tidak mismatch. |
| Validation Error | Terintegrasi dengan form handling Filament | Manual melalui request/controller validation | Keduanya dapat valid, tetapi Laravel membutuhkan penyesuaian assertion sesuai flow validasi aktual. |
| Permission Handling | Terintegrasi pada panel/resource dan access control | Manual melalui middleware dan role permission | Keduanya valid, tetapi Laravel memerlukan pengelolaan middleware dan rule permission yang lebih eksplisit. |
| Notification Handling | Umumnya tersedia melalui mekanisme Filament | Manual melalui session flash/response | Filament lebih terstandarisasi dalam feedback antarmuka. |
| Upload Handling | Semi otomatis melalui komponen upload | Manual melalui validasi file dan storage | Laravel lebih banyak setup ketika fitur upload diuji. |
| Dashboard Widget | Dibantu widget dan komponen Filament | Manual melalui query controller dan Blade | Filament lebih efisien untuk tampilan admin, Laravel lebih bebas dalam desain. |
| Route Management | Banyak dibantu oleh resource/page Filament | Manual pada route web dan controller | Laravel lebih eksplisit, tetapi jumlah konfigurasi lebih banyak. |
| Testing Stability | Stabil karena banyak lifecycle terstandarisasi | Stabil jika controller dan response konsisten | Pada data terbaru, keduanya stabil dengan hasil 100%. |

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

Berdasarkan data terbaru, hasil white box testing menunjukkan bahwa sistem POS berbasis Filament dan sistem POS Laravel 12 konvensional sama-sama memperoleh hasil **100% PASS** pada **98 test case pembanding**. Seluruh modul utama yang diuji, yaitu Dashboard, POS/Kasir, Produk, Kategori, Inventory, Transaksi, Cash Flow, Payment Method, Report, User/User Management, Role/Permission, Setting, dan Login/Auth berhasil dijalankan sesuai skenario pengujian.

Perbedaan utama tidak terletak pada keberhasilan pengujian, karena kedua sistem sama-sama memperoleh hasil valid. Perbedaan utama terletak pada distribusi test case dan karakteristik implementasi. Filament memiliki jumlah test case lebih banyak pada modul Dashboard, POS/Kasir, Produk, Transaksi, Report, dan User Management. Hal ini dipengaruhi oleh struktur Filament yang menggunakan panel, resource, komponen Livewire, access control, observer, serta alur transaksi yang mencakup receipt/struk.

Sebaliknya, Laravel 12 konvensional memiliki jumlah test case lebih banyak pada modul Kategori, Inventory, Payment Method, Cash Flow, Role/Permission, Setting, dan Login/Auth. Hal ini menunjukkan bahwa Laravel konvensional lebih banyak menguji bagian controller, middleware, relationship, aggregate query, state model, validation, dan flow manual yang ditulis secara eksplisit oleh developer.

Dari sisi struktur testing, Filament tidak menggunakan file khusus `RelationshipTest.php` dan `AggregateQueryTest.php`. Relasi data diuji melalui file test modul terkait seperti `TransactionTest.php`, `TransactionFlowTest.php`, `CategoryTest.php`, dan `ProductTest.php`, sedangkan statistik dashboard dan laporan diuji melalui `DashboardTest.php` dan `ReportTest.php`. Pada Laravel 12 konvensional, file `RelationshipTest.php` dan `AggregateQueryTest.php` memang digunakan secara khusus, sehingga istilah relationship testing dan aggregate query testing lebih tepat digunakan pada sisi Laravel.

Filament lebih unggul pada otomatisasi karena banyak proses administratif seperti CRUD, form, table, resource, access control, observer, dan lifecycle komponen dibantu oleh framework. Laravel 12 konvensional lebih unggul pada fleksibilitas karena controller, route, validation, middleware, view, response, dan business logic dapat dikendalikan secara manual oleh developer. Namun, fleksibilitas tersebut membutuhkan konsistensi implementasi agar hasil testing tetap stabil.

---

# Kesimpulan Perbandingan

Berdasarkan hasil pengujian white box terbaru, sistem POS berbasis Filament dan Laravel 12 konvensional sama-sama memperoleh tingkat keberhasilan sebesar **100%** pada **98 test case pembanding**. Kedua sistem memiliki **13 modul utama**, seluruh test case berhasil dijalankan, dan tidak terdapat test case yang gagal.

Hasil ini menunjukkan bahwa kedua sistem telah memenuhi skenario fungsional utama yang diuji melalui pendekatan white box testing. Perbedaan utama bukan pada tingkat keberhasilan pengujian, melainkan pada struktur implementasi, distribusi test case, dan karakteristik framework.

Filament lebih efisien untuk membangun sistem admin/POS dengan kebutuhan CRUD, manajemen data, access control, observer, dan komponen antarmuka yang dominan karena memiliki otomatisasi dan standardisasi yang lebih tinggi. Laravel 12 konvensional lebih kuat ketika sistem membutuhkan logika bisnis khusus, kontrol response yang detail, struktur route/controller yang eksplisit, dan rancangan antarmuka yang lebih bebas. Namun, pada Laravel konvensional, developer harus menjaga konsistensi controller, validasi, redirect, response, dan middleware agar pengujian tetap stabil.
