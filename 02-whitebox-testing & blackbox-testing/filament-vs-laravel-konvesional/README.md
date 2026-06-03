# Analisis Perbandingan White Box Testing Sistem POS Filament vs Laravel 12 Konvensional

---

# Tabel Perbandingan White Box Testing Sistem POS Filament vs Laravel 12 Konvensional

| No | Modul | Filament | Laravel 12 Konvensional | Selisih / Analisis |
| -- | ----- | -------- | ----------------------- | ------------------ |
| 1 | Login / Auth | 4/4 PASS (100%) | 4/4 PASS (100%) | Setara. Keduanya berhasil menguji login valid, login tidak valid, logout, dan update profil. |
| 2 | Dashboard | 6/6 PASS (100%) | 6/6 PASS (100%) | Setara. Keduanya menguji total transaksi, total income, latest transaction, akses dashboard, authorization, dan authentication. |
| 3 | Kasir / POS | 10/10 PASS (100%) | 10/10 PASS (100%) | Setara. Keduanya menguji checkout, item transaksi, sinkronisasi stok, validasi stok, validasi pembayaran, subtotal, total, dan kembalian. |
| 4 | Produk | 6/6 PASS (100%) | 6/6 PASS (100%) | Setara. Keduanya menguji create, update, soft delete, validasi harga, default stock, dan status produk. |
| 5 | Kategori | 4/4 PASS (100%) | 4/4 PASS (100%) | Setara. Keduanya menguji create, update, soft delete, dan relasi kategori dengan produk. |
| 6 | Inventory | 5/5 PASS (100%) | 5/5 PASS (100%) | Setara. Keduanya menguji stock in, stock out, adjustment stock, restore stock, dan validasi stok tidak cukup. |
| 7 | Transaksi | 7/7 PASS (100%) | 7/7 PASS (100%) | Setara. Keduanya menguji relasi transaction item, payment method, product relation, restore stock, delete cashflow otomatis, route transaksi, dan detail transaksi. |
| 8 | Cash Flow | 5/5 PASS (100%) | 5/5 PASS (100%) | Setara. |
| 9 | Payment Method | 6/6 PASS (100%) | 6/6 PASS (100%) | Setara. Keduanya menguji create, update, soft delete, restore, field `is_cash`, dan validasi payment method. |
| 10 | Report | 4/4 PASS (100%) | 4/4 PASS (100%) | Setara. Keduanya menguji total transaksi, filter laporan, latest transaction, dan aggregate query. |
| 11 | User | 4/4 PASS (100%) | 4/4 PASS (100%) | Setara. Keduanya menguji create user, update user, verifikasi user, dan delete user. |
| 12 | Role / Permission | 10/10 PASS (100%) | 10/10 PASS (100%) | Setara. Keduanya menguji role, permission, exact permission, wildcard permission, user tanpa role, middleware authorization, JSON authorization, dan akses dashboard berdasarkan permission. |
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
| Middleware testing | Ada | Ada |
| CRUD testing | Ada | Ada |
| Relationship testing | Ada | Ada |
| Aggregate query testing | Ada | Ada |
| Arithmetic / POS logic testing | Ada | Ada |
| Cash Flow testing | 5/5 PASS | 5/5 PASS |
| Setting testing | 7/7 PASS | 7/7 PASS |
| Kesimpulan hasil uji | Seluruh skenario valid | Seluruh skenario valid |

---

# Tabel Pembacaan Total yang Benar

| Kelompok Pengujian | Filament | Laravel 12 Konvensional | Analisis |
| ------------------ | -------- | ----------------------- | -------- |
| Modul identik yang dibandingkan | 13 modul | 13 modul | Kedua sistem memiliki cakupan modul yang sama, sehingga perbandingan dilakukan pada ruang lingkup yang seimbang. |
| Total skenario inti | 78 skenario | 78 skenario | Jumlah skenario inti pada kedua sistem sudah setara. |
| Total skenario berhasil | 78 skenario | 78 skenario | Seluruh skenario berhasil dijalankan. |
| Total skenario gagal | 0 skenario | 0 skenario | Tidak ada modul yang gagal pada data terbaru. |
| Persentase keberhasilan | 100% | 100% | Secara hasil pengujian white box, kedua sistem sama-sama valid. |
| Modul Cash Flow | 5/5 PASS | 5/5 PASS | Laravel sudah diperbaiki, sehingga tidak lagi menggunakan angka 2/5 atau 40%. |
| Modul Setting | 7/7 PASS | 7/7 PASS | Setting sudah masuk dalam rekap Laravel, sehingga total bukan lagi 67 skenario. |

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

# Tabel Analisis Stabilitas Pengujian

| Aspek | Filament | Laravel 12 Konvensional | Analisis |
| ----- | -------- | ----------------------- | -------- |
| Hasil akhir pengujian | 100% PASS | 100% PASS | Kedua sistem berhasil memenuhi seluruh skenario white box. |
| Cash Flow | Stabil | Stabil setelah perbaikan test case | Perbedaan sebelumnya ada pada assertion, bukan kegagalan fungsi utama. |
| Setting | 7/7 PASS | 7/7 PASS | Fitur Setting sudah teruji pada kedua sistem. |
| Authentication | Valid | Valid | Login, credential validation, logout, dan update profil berhasil diuji. |
| Authorization | Valid | Valid | Akses berdasarkan permission berhasil diuji. |
| Relationship testing | Valid | Valid | Relasi antar model berhasil diuji. |
| Aggregate query | Valid | Valid | Statistik dashboard dan laporan berhasil diuji. |
| Risiko mismatch response | Lebih rendah | Lebih tinggi jika controller tidak konsisten | Filament memiliki flow lebih terstandarisasi, sedangkan Laravel bergantung pada implementasi manual. |
| Ketergantungan pada developer | Lebih rendah | Lebih tinggi | Laravel membutuhkan konsistensi manual pada controller, validation, redirect, dan response. |

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

Perbedaan utama tidak lagi berada pada persentase keberhasilan pengujian, karena kedua sistem sudah sama-sama valid. Perbedaan utama berada pada pendekatan implementasi. Filament memiliki keunggulan pada otomatisasi karena banyak proses administratif seperti CRUD, form, table, resource, permission integration, dan response lifecycle dibantu oleh framework. Hal ini membuat struktur pengembangan lebih ringkas dan konsisten.

Laravel 12 konvensional memiliki karakteristik berbeda. Sistem ini memberikan fleksibilitas lebih tinggi karena controller, route, validation, middleware, view, dan response dapat dikendalikan secara manual oleh developer. Namun, fleksibilitas tersebut meningkatkan kebutuhan konsistensi implementasi. Kasus Cash Flow sebelumnya menunjukkan bahwa pengujian dapat mengalami mismatch jika expected response pada test tidak disesuaikan dengan response controller yang sebenarnya. Setelah assertion diperbaiki, seluruh skenario Cash Flow berhasil dijalankan.

Dengan demikian, dari sisi hasil white box testing, kedua sistem dapat dinyatakan sama-sama valid. Filament lebih unggul pada konsistensi dan otomatisasi pengembangan, sedangkan Laravel 12 konvensional lebih unggul pada fleksibilitas dan kontrol detail implementasi. Untuk konteks sistem POS, Filament lebih efisien untuk pengembangan fitur administratif yang cepat dan terstandarisasi, sedangkan Laravel konvensional lebih sesuai ketika sistem membutuhkan penyesuaian logic, tampilan, dan alur proses yang sangat spesifik.

---

# Kesimpulan Perbandingan

Berdasarkan hasil pengujian white box terbaru, sistem POS berbasis Filament dan Laravel 12 konvensional sama-sama memperoleh tingkat keberhasilan sebesar **100%**. Kedua sistem memiliki **78 skenario inti**, seluruhnya berhasil dijalankan, dengan **0 skenario gagal**.

Hasil ini menunjukkan bahwa kedua sistem telah memenuhi skenario fungsional utama yang diuji melalui pendekatan white box testing. Perbedaan utama bukan pada keberhasilan pengujian, melainkan pada karakteristik pengembangan. Filament menawarkan otomatisasi dan standardisasi yang lebih tinggi, sedangkan Laravel 12 konvensional menawarkan fleksibilitas dan kontrol implementasi yang lebih luas.

Secara objektif, Filament lebih efisien untuk membangun sistem admin/POS dengan kebutuhan CRUD dan manajemen data yang dominan. Laravel 12 konvensional lebih kuat ketika sistem membutuhkan logika bisnis khusus, kontrol response yang detail, dan rancangan antarmuka yang lebih bebas. Namun, pada Laravel konvensional, developer harus menjaga konsistensi controller, validasi, redirect, dan response agar pengujian tetap stabil.

