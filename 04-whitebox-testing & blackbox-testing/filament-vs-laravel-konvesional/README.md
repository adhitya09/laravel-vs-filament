# Tabel Perbandingan White Box Testing Sistem POS Filament vs Laravel 12 Konvensional

| No | Modul             | Filament          | Laravel 12 Konvensional | Selisih / Analisis                               |
| -- | ----------------- | ----------------- | ----------------------- | ------------------------------------------------ |
| 1  | Dashboard         | 6/6 PASS (100%)   | 6/6 PASS (100%)         | Sama-sama stabil                                 |
| 2  | Kasir / POS       | 14/14 PASS (100%) | 10/10 PASS (100%)       | Filament memiliki pengujian POS lebih detail     |
| 3  | Produk            | 7/7 PASS (100%)   | 6/6 PASS (100%)         | Filament memiliki coverage akses produk          |
| 4  | Kategori          | 4/4 PASS (100%)   | 4/4 PASS (100%)         | Sama                                             |
| 5  | Inventory         | 5/5 PASS (100%)   | 5/5 PASS (100%)         | Logic inventory berhasil di kedua sistem         |
| 6  | Transaksi         | 8/8 PASS (100%)   | 7/7 PASS (100%)         | Filament memiliki observer testing tambahan      |
| 7  | Payment Method    | 4/4 PASS (100%)   | 6/6 PASS (100%)         | Laravel memiliki restore testing tambahan        |
| 8  | Cash Flow         | 4/4 PASS (100%)   | 2/5 PASS (40%)          | Laravel mengalami mismatch response              |
| 9  | Report            | 4/4 PASS (100%)   | 4/4 PASS (100%)         | Sama                                             |
| 10 | User & Permission | 8/8 PASS (100%)   | 14/14 PASS (100%)       | Laravel memiliki testing permission lebih detail |
| 11 | Setting           | 4/4 PASS (100%)   | Tidak diuji             | Fitur belum dibuat/diuji di Laravel              |
| 12 | Receipt / Invoice | 5/5 PASS (100%)   | Tidak diuji             | Receipt hanya ada di Filament                    |

---

# Tabel Rekapitulasi Keseluruhan

| Aspek                    | Filament | Laravel 12 Konvensional |
| ------------------------ | -------- | ----------------------- |
| Total Test Case          | 73       | 67                      |
| Total Berhasil           | 73       | 64                      |
| Total Gagal              | 0        | 3                       |
| Persentase Keberhasilan  | 100%     | 95.5%                   |
| Total Assertion          | 80       | 107                     |
| Observer Testing         | Ada      | Tidak Ada               |
| Middleware Testing       | Ada      | Ada                     |
| Authorization Testing    | Ada      | Ada                     |
| Relationship Testing     | Ada      | Ada                     |
| Arithmetic Logic Testing | Ada      | Ada                     |
| CRUD Testing             | Ada      | Ada                     |
| Aggregate Query Testing  | Ada      | Ada                     |
| Receipt Testing          | Ada      | Tidak Ada               |
| Setting Testing          | Ada      | Tidak Ada               |
| Cash Flow Stability      | Stabil   | Ada mismatch response   |
| Tingkat Otomatisasi      | Tinggi   | Rendah–Sedang           |
| Dominasi Manual Logic    | Rendah   | Tinggi                  |

---

# Tabel Perbandingan Tingkat Otomatisasi Framework

| Aspek                 | Filament        | Laravel Konvensional   | Dampak                           |
| --------------------- | --------------- | ---------------------- | -------------------------------- |
| CRUD Resource         | Otomatis        | Manual Controller      | Laravel lebih banyak coding      |
| Redirect Handling     | Otomatis        | Manual                 | Risiko mismatch lebih tinggi     |
| Validation Error      | Otomatis        | Manual                 | Potensi assertion fail           |
| Form Rendering        | Otomatis        | Blade manual           | Filament lebih cepat             |
| Permission Handling   | Shield otomatis | Middleware manual      | Laravel lebih kompleks           |
| Table Rendering       | Otomatis        | Blade manual           | Filament lebih efisien           |
| Notification Handling | Otomatis        | Manual session flash   | Laravel lebih verbose            |
| Modal/Form State      | Otomatis        | Manual                 | Potensi bug lebih tinggi         |
| Upload Handling       | Semi otomatis   | Manual                 | Laravel lebih banyak setup       |
| Relationship Manager  | Otomatis        | Manual query           | Laravel lebih panjang            |
| Dashboard Widget      | Otomatis        | Manual query dan blade | Filament lebih cepat             |
| Observer Integration  | Native support  | Tidak digunakan        | Logic inventory lebih manual     |
| Route Resource        | Otomatis        | Manual route           | Laravel lebih banyak konfigurasi |

---

# Tabel Analisis Penyebab Cash Flow FAIL pada Laravel

| No | Permasalahan         | Filament                             | Laravel Konvensional              | Dampak                           |
| -- | -------------------- | ------------------------------------ | --------------------------------- | -------------------------------- |
| 1  | Redirect Response    | Ditangani otomatis resource Filament | Ditulis manual di controller      | Assertion redirect gagal         |
| 2  | Validation Error     | Session/form otomatis                | Bisa JSON/API/manual              | `assertSessionHasErrors()` gagal |
| 3  | Response Consistency | Konsisten                            | Bergantung implementasi           | Testing tidak stabil             |
| 4  | Form Handling        | Otomatis                             | Manual                            | Risiko human error               |
| 5  | CRUD Standardization | Terstandarisasi                      | Tidak standar                     | Perilaku tiap controller berbeda |
| 6  | Error Handling       | Konsisten                            | Manual                            | Potensi mismatch response        |
| 7  | Flow Controller      | Resource-driven                      | Controller-driven                 | Logic lebih kompleks             |
| 8  | Testing Stability    | Stabil                               | Bergantung implementasi developer | CashFlow gagal                   |

---

# Tabel Detail Cash Flow FAIL Laravel

| No | Test Case                                        | Expected                 | Actual                  | Penyebab                  |
| -- | ------------------------------------------------ | ------------------------ | ----------------------- | ------------------------- |
| 1  | `test_user_can_create_cash_in_flow`              | Redirect 302             | Response 201            | Controller return berbeda |
| 2  | `test_user_can_create_cash_out_flow`             | Redirect 302             | Response 201            | Controller return berbeda |
| 3  | `test_cash_flow_fails_when_source_type_mismatch` | Session validation error | Tidak ada session error | Validation flow berbeda   |

---

# Tabel Analisis Arsitektur

| Aspek                | Filament                | Laravel Konvensional    |
| -------------------- | ----------------------- | ----------------------- |
| Arsitektur           | Resource-driven         | Controller-driven       |
| Fokus Framework      | Rapid Admin Development | Full Custom Development |
| Kompleksitas Coding  | Lebih rendah            | Lebih tinggi            |
| Boilerplate Code     | Sedikit                 | Banyak                  |
| Maintainability      | Tinggi                  | Sedang                  |
| Development Speed    | Cepat                   | Lebih lambat            |
| Fleksibilitas Logic  | Sedang                  | Sangat tinggi           |
| Risiko Human Error   | Rendah                  | Lebih tinggi            |
| Konsistensi Response | Tinggi                  | Bergantung developer    |
| Tingkat Otomatisasi  | Tinggi                  | Rendah–Sedang           |

---

# Kesimpulan Perbandingan

Berdasarkan hasil white box testing, sistem POS berbasis Filament memperoleh tingkat keberhasilan pengujian sebesar 100% dengan seluruh test case berhasil dijalankan secara konsisten. Hal ini dipengaruhi oleh tingginya otomatisasi framework Filament dalam menangani CRUD, validation, redirect response, form handling, dan permission management.

Sementara itu, sistem POS berbasis Laravel 12 konvensional memperoleh tingkat keberhasilan sebesar 95.5% dengan 64 test berhasil dan 3 test gagal pada modul Cash Flow. Kegagalan terjadi bukan karena fitur tidak berjalan, tetapi karena adanya mismatch antara expected response pada test dan implementasi manual controller.

Laravel konvensional memberikan fleksibilitas logic yang lebih tinggi, namun memerlukan penulisan controller, validation flow, redirect response, dan authorization secara manual sehingga meningkatkan kompleksitas development serta risiko inkonsistensi behavior aplikasi.

Sebaliknya, Filament menyediakan struktur CRUD dan form lifecycle yang lebih terstandarisasi sehingga pengujian menjadi lebih stabil dan konsisten. 
