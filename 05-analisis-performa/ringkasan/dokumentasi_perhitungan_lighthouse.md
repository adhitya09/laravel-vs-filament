# Dokumentasi Per Sheet Excel Perhitungan Google Lighthouse

Dokumen ini menjelaskan definisi, fungsi, cara hitung, contoh perhitungan manual/tradisional, dan rumus Excel pada setiap sheet dalam file perhitungan Google Lighthouse.

---

## 00_README

### Definisi

Sheet **00_README** adalah halaman petunjuk penggunaan file Excel.

### Fungsi

Sheet ini berfungsi sebagai panduan awal agar pengguna memahami cara mengisi data dan membaca hasil perhitungan.

### Cara Hitung

Sheet ini tidak memiliki perhitungan statistik. Isinya hanya berupa instruksi penggunaan file.

### Contoh Penggunaan

Pengguna hanya perlu mengisi data mentah pada sheet **01_Raw_Data**, khususnya kolom:

| Kolom yang Diisi |
|---|
| Performance |
| Accessibility |
| Best Practices |
| SEO |
| FCP (s) |
| LCP (s) |
| CLS |
| TTFB (ms) |

---

## 01_Raw_Data

### Definisi

Sheet **01_Raw_Data** adalah tempat memasukkan data hasil pengujian Google Lighthouse secara mentah.

### Fungsi

Sheet ini menjadi sumber utama seluruh perhitungan pada sheet lainnya.

Data yang dimasukkan terdiri dari:

| Komponen | Keterangan |
|---|---|
| Fitur | Halaman atau fitur yang diuji |
| Sistem | Filament atau Laravel |
| Run | Pengujian ke-1, ke-2, atau ke-3 |
| Performance | Skor performa Lighthouse |
| Accessibility | Skor aksesibilitas |
| Best Practices | Skor praktik pengembangan web |
| SEO | Skor optimasi mesin pencari |
| FCP (s) | First Contentful Paint dalam detik |
| LCP (s) | Largest Contentful Paint dalam detik |
| CLS | Cumulative Layout Shift |
| TTFB (ms) | Time To First Byte dalam milidetik |

### Jumlah Data

Jumlah data yang benar adalah:

```text
13 fitur × 2 sistem × 3 pengujian = 78 baris
```

### Cara Hitung

Sheet ini tidak menghitung hasil akhir. Sheet ini hanya menyimpan input data mentah.

### Contoh Input

| Fitur | Sistem | Run | Performance | Accessibility | Best Practices | SEO | FCP (s) | LCP (s) | CLS | TTFB (ms) |
|---|---|---:|---:|---:|---:|---:|---:|---:|---:|---:|
| Login | Filament | 1 | 91 | 87 | 100 | 91 | 0,70 | 0,70 | 0,000 | 240 |
| Login | Filament | 2 | 91 | 87 | 100 | 91 | 0,70 | 0,70 | 0,000 | 120 |
| Login | Filament | 3 | 94 | 87 | 100 | 91 | 0,60 | 0,60 | 0,000 | 190 |

---

## 02_Lighthouse_Overview

### Definisi

Sheet **02_Lighthouse_Overview** adalah tabel ringkasan skor utama Google Lighthouse per fitur dan per sistem.

### Fungsi

Sheet ini menghitung rata-rata dari 3 kali pengujian untuk metrik:

| Metrik |
|---|
| Performance |
| Accessibility |
| Best Practices |
| SEO |

Sheet ini dapat digunakan sebagai tabel **Skor Google Lighthouse per Halaman** pada Bab 4.5.

### Cara Hitung

Setiap nilai dihitung menggunakan rata-rata dari 3 kali pengujian.

```text
Mean = (x1 + x2 + x3) / 3
```

### Contoh Perhitungan Tradisional

Misalnya nilai **Performance Login Filament** adalah:

```text
91, 91, 94
```

Maka:

```text
Mean = (91 + 91 + 94) / 3
Mean = 276 / 3
Mean = 92
```

Jadi rata-rata Performance Login Filament adalah **92,00**.

### Rumus Excel

```excel
=AVERAGE(E5:E7)
```

Rumus aman yang digunakan dalam file:

```excel
=IF(COUNT(E5:E7)=3,AVERAGE(E5:E7),"")
```

Artinya, Excel hanya menghitung jika 3 data pengujian sudah lengkap.

---

## 03_Web_Vitals

### Definisi

Sheet **03_Web_Vitals** adalah tabel ringkasan metrik teknis performa halaman dari hasil Google Lighthouse.

### Fungsi

Sheet ini menghitung rata-rata dari 3 kali pengujian untuk metrik:

| Metrik | Satuan | Interpretasi |
|---|---|---|
| FCP | detik | Semakin rendah semakin baik |
| LCP | detik | Semakin rendah semakin baik |
| CLS | tanpa satuan | Semakin rendah semakin baik |
| TTFB | milidetik | Semakin rendah semakin baik |

Sheet ini dapat digunakan sebagai tabel **Metrik Web Vitals / Detail Teknis** pada Bab 4.5.

### Cara Hitung

```text
Mean = (x1 + x2 + x3) / 3
```

### Contoh Perhitungan Tradisional

Misalnya nilai **FCP Login Filament** adalah:

```text
0,70, 0,70, 0,60
```

Maka:

```text
Mean FCP = (0,70 + 0,70 + 0,60) / 3
Mean FCP = 2,00 / 3
Mean FCP = 0,667
```

Jadi rata-rata FCP Login Filament adalah **0,667 detik**.

### Rumus Excel

```excel
=AVERAGE(I5:I7)
```

Rumus aman yang digunakan dalam file:

```excel
=IF(COUNT(I5:I7)=3,AVERAGE(I5:I7),"")
```

---

## 04_Statistik_Deskriptif

### Definisi

Sheet **04_Statistik_Deskriptif** adalah tabel statistik yang menampilkan nilai rata-rata dan standar deviasi dari hasil pengujian.

### Fungsi

Sheet ini digunakan untuk melihat:

| Statistik | Fungsi |
|---|---|
| Mean | Menunjukkan nilai rata-rata performa |
| SD | Menunjukkan konsistensi hasil pengujian |

Jika nilai **SD kecil**, maka hasil pengujian lebih stabil.  
Jika nilai **SD besar**, maka hasil pengujian lebih bervariasi.

### Cara Hitung Mean

```text
Mean = (x1 + x2 + x3) / 3
```

### Cara Hitung Standar Deviasi

Karena data berasal dari 3 kali pengujian, standar deviasi yang digunakan adalah **sample standard deviation**.

```text
SD = √(Σ(xi - x̄)² / (n - 1))
```

Keterangan:

| Simbol | Keterangan |
|---|---|
| xi | Nilai setiap pengujian |
| x̄ | Nilai rata-rata |
| n | Jumlah data |

### Contoh Perhitungan Tradisional

Misalnya nilai **Performance Login Filament** adalah:

```text
91, 91, 94
```

Mean:

```text
x̄ = (91 + 91 + 94) / 3
x̄ = 92
```

Selisih setiap data terhadap mean:

```text
91 - 92 = -1
91 - 92 = -1
94 - 92 = 2
```

Kuadratkan setiap selisih:

```text
(-1)² = 1
(-1)² = 1
2² = 4
```

Jumlah kuadrat selisih:

```text
1 + 1 + 4 = 6
```

Standar deviasi:

```text
SD = √(6 / (3 - 1))
SD = √3
SD = 1,732
```

Jadi:

| Statistik | Nilai |
|---|---:|
| Mean | 92,00 |
| SD | 1,732 |

### Rumus Excel Mean

```excel
=AVERAGE(E5:E7)
```

### Rumus Excel Standar Deviasi

```excel
=STDEV(E5:E7)
```

Rumus aman yang digunakan dalam file:

```excel
=IF(COUNT(E5:E7)=3,STDEV(E5:E7),"")
```

---

## 05_Uji_Normalitas

### Definisi

Sheet **05_Uji_Normalitas** adalah tabel untuk melihat apakah data hasil pengujian berdistribusi normal atau tidak.

### Fungsi

Sheet ini digunakan untuk mendukung bagian **Teknik Analisis Data** pada TA.

Metrik yang diuji adalah:

| Metrik |
|---|
| Performance |
| FCP (s) |
| LCP (s) |
| CLS |
| TTFB (ms) |

Setiap metrik diuji untuk sistem **Filament** dan **Laravel**.

### Cara Hitung

Uji normalitas menggunakan pendekatan Shapiro-Wilk untuk data kecil, yaitu **n = 3**.

Rumus statistik W:

```text
W = (xmax - xmin)² / (2 × Σ(xi - x̄)²)
```

Keterangan:

| Simbol | Keterangan |
|---|---|
| xmax | Nilai terbesar |
| xmin | Nilai terkecil |
| xi | Nilai setiap pengujian |
| x̄ | Nilai rata-rata |

### Contoh Perhitungan Tradisional

Misalnya data **Performance Login Filament** adalah:

```text
91, 91, 94
```

Mean:

```text
x̄ = 92
```

Nilai terbesar:

```text
xmax = 94
```

Nilai terkecil:

```text
xmin = 91
```

Jumlah kuadrat selisih:

```text
(91 - 92)² + (91 - 92)² + (94 - 92)²
= 1 + 1 + 4
= 6
```

Maka:

```text
W = (94 - 91)² / (2 × 6)
W = 9 / 12
W = 0,75
```

Setelah nilai W diperoleh, p-value dibandingkan dengan batas signifikansi:

```text
α = 0,05
```

### Interpretasi

| Kondisi | Keterangan |
|---|---|
| p-value ≥ 0,05 | Data berdistribusi normal |
| p-value < 0,05 | Data tidak berdistribusi normal |

### Rumus Excel W

```excel
=((MAX(A6:C6)-MIN(A6:C6))^2)/(2*DEVSQ(A6:C6))
```

Rumus aman yang digunakan:

```excel
=IF(COUNT(A6:C6)<3,"",IF(DEVSQ(A6:C6)=0,1,(MAX(A6:C6)-MIN(A6:C6))^2/(2*DEVSQ(A6:C6))))
```

### Rumus Excel Keterangan Normalitas

```excel
=IF(p_value>=0.05,"Normal","Tidak Normal")
```

Contoh rumus dalam file:

```excel
=IF(OR(D4="",F4=""),"Belum lengkap",IF(AND(D4>=0.05,F4>=0.05),"Normal","Tidak Normal"))
```

<!-- ### Catatan Penting

Karena setiap fitur hanya diuji **3 kali**, uji normalitas memiliki kekuatan statistik yang lemah. Hasil ini tetap bisa digunakan sebagai pendukung analisis, tetapi jika dosen meminta validasi statistik formal, hasil sebaiknya diverifikasi ulang menggunakan SPSS, R, atau Python. -->

---

## 06_Contoh_Perhitungan

### Definisi

Sheet **06_Contoh_Perhitungan** adalah sheet khusus untuk menunjukkan contoh cara perhitungan.

### Fungsi

Sheet ini berfungsi sebagai bukti bahwa hasil perhitungan berasal dari rumus statistik yang jelas.

Sheet ini menampilkan contoh:

| Perhitungan |
|---|
| Mean |
| Standar Deviasi |
| W Shapiro-Wilk |
| p-value |
| Keterangan normalitas |

### Contoh Perhitungan Tradisional

Misalnya data yang digunakan adalah:

```text
91, 91, 94
```

Mean:

```text
(91 + 91 + 94) / 3 = 92
```

Standar deviasi:

```text
SD = √(((91 - 92)² + (91 - 92)² + (94 - 92)²) / 2)
SD = 1,732
```

W Shapiro-Wilk:

```text
W = (94 - 91)² / (2 × 6)
W = 0,75
```

### Rumus Excel Mean

```excel
=AVERAGE(A6:C6)
```

### Rumus Excel Standar Deviasi

```excel
=STDEV(A6:C6)
```

### Rumus Excel W Shapiro-Wilk

```excel
=((MAX(A6:C6)-MIN(A6:C6))^2)/(2*DEVSQ(A6:C6))
```

### Rumus Excel Keterangan

```excel
=IF(D12>=0.05,"Normal","Tidak Normal")
```

---

## 07_Dashboard

### Definisi

Sheet **07_Dashboard** adalah dashboard visual untuk membandingkan hasil pengujian antara Laravel Filament dan Laravel konvensional.

### Fungsi

Sheet ini menyajikan hasil dalam bentuk tabel dan grafik agar lebih mudah dibaca.

Isi utama sheet ini adalah:

| Bagian | Fungsi |
|---|---|
| Rekap Skor Lighthouse | Membandingkan Performance, Accessibility, Best Practices, SEO |
| Rekap Web Vitals | Membandingkan FCP, LCP, CLS, TTFB |
| Detail per fitur | Menampilkan perbandingan tiap fitur |
| Chart | Visualisasi Filament vs Laravel |
| Kesimpulan | Ringkasan hasil per kelompok metrik |

### Kelompok Metrik 1: Skor Lighthouse

Untuk metrik berikut, **nilai lebih tinggi lebih baik**:

| Metrik |
|---|
| Performance |
| Accessibility |
| Best Practices |
| SEO |

### Kelompok Metrik 2: Web Vitals dan Teknis

Untuk metrik berikut, **nilai lebih rendah lebih baik**:

| Metrik |
|---|
| FCP (s) |
| LCP (s) |
| CLS |
| TTFB (ms) |

### Cara Hitung Rata-rata Keseluruhan

```text
Rata-rata keseluruhan = jumlah mean seluruh fitur / 13
```

### Contoh Perhitungan Tradisional

Misalnya rata-rata Performance Filament dari 13 fitur adalah:

```text
92 + 89,667 + 62,667 + ... + 93,333
```

Maka:

```text
Rata-rata Performance Filament = jumlah seluruh mean Performance Filament / 13
```

### Rumus Excel

```excel
=AVERAGE(B20:B32)
```

### Cara Menentukan Pemenang Skor Lighthouse

Karena skor Lighthouse lebih tinggi lebih baik:

| Kondisi | Hasil |
|---|---|
| Filament > Laravel | Filament unggul |
| Laravel > Filament | Laravel unggul |
| Filament = Laravel | Sama/Seri |

### Rumus Excel Skor Lighthouse

```excel
=IF(B6=C6,"Sama",IF(B6>C6,"Filament","Laravel"))
```

### Cara Menentukan Pemenang Web Vitals

Karena Web Vitals lebih rendah lebih baik:

| Kondisi | Hasil |
|---|---|
| Filament < Laravel | Filament unggul |
| Laravel < Filament | Laravel unggul |
| Filament = Laravel | Sama/Seri |

### Rumus Excel Web Vitals

```excel
=IF(B70=C70,"Sama",IF(B70<C70,"Filament","Laravel"))
```

### Cara Menghitung Jumlah Kemenangan

Menghitung jumlah kemenangan Filament:

```excel
=COUNTIF(D20:D32,"Filament")
```

Menghitung jumlah kemenangan Laravel:

```excel
=COUNTIF(D20:D32,"Laravel")
```

Menghitung jumlah hasil seri:

```excel
=COUNTIF(D20:D32,"Sama")
```

---

## Helper_Shapiro

### Definisi

Sheet **Helper_Shapiro** adalah sheet bantu untuk estimasi p-value Shapiro-Wilk.

### Fungsi

Sheet ini digunakan agar Excel dapat menghasilkan estimasi p-value berdasarkan nilai W.

Sheet ini tidak perlu ditampilkan dalam laporan utama karena sifatnya hanya sebagai tabel bantu teknis.

### Cara Hitung

Sheet ini menyimpan pasangan nilai:

| Nilai W | Estimasi p-value |
|---|---|

Nilai W dari sheet **05_Uji_Normalitas** dicocokkan dengan tabel bantu ini untuk memperoleh estimasi p-value.

### Rumus Excel

```excel
=VLOOKUP(W,Helper_Shapiro!A:B,2,TRUE)
```

Artinya, Excel mencari nilai W pada tabel bantu, lalu mengambil estimasi p-value yang sesuai.

---

## 08_Rekap_Akhir

### Definisi

Sheet **08_Rekap_Akhir** adalah sheet kesimpulan akhir dari seluruh hasil pengujian.

### Fungsi

Sheet ini digunakan untuk menentukan sistem mana yang lebih unggul secara keseluruhan.

Sheet ini merangkum dua kelompok besar:

| Kelompok | Metrik |
|---|---|
| Skor Lighthouse | Performance, Accessibility, Best Practices, SEO |
| Web Vitals dan Teknis | FCP, LCP, CLS, TTFB |

### Cara Hitung Kesimpulan Per Metrik

Setiap metrik dibandingkan berdasarkan rata-rata keseluruhan.

Untuk skor Lighthouse:

```text
Nilai lebih tinggi lebih unggul
```

Untuk Web Vitals:

```text
Nilai lebih rendah lebih unggul
```

### Contoh Perhitungan Tradisional Skor Lighthouse

Misalnya rata-rata Performance adalah:

| Sistem | Rata-rata Performance |
|---|---:|
| Filament | 86,077 |
| Laravel | 88,769 |

Karena Performance adalah skor Lighthouse, maka nilai lebih tinggi lebih baik.

```text
88,769 > 86,077
```

Maka:

```text
Laravel unggul pada Performance
```

### Contoh Perhitungan Tradisional Web Vitals

Misalnya rata-rata FCP adalah:

| Sistem | Rata-rata FCP |
|---|---:|
| Filament | 1,259 |
| Laravel | 1,338 |

Karena FCP lebih rendah lebih baik:

```text
1,259 < 1,338
```

Maka:

```text
Filament unggul pada FCP
```

### Rumus Excel Pemenang Skor Lighthouse

```excel
=IF(C8=D8,"Sama",IF(C8>D8,"Filament","Laravel"))
```

### Rumus Excel Pemenang Web Vitals

```excel
=IF(C14=D14,"Sama",IF(C14<D14,"Filament","Laravel"))
```

### Cara Menghitung Pemenang Akhir

Pemenang akhir dihitung dari jumlah metrik yang dimenangkan.

```text
Jumlah kemenangan Filament = total metrik yang dimenangkan Filament
Jumlah kemenangan Laravel = total metrik yang dimenangkan Laravel
```

Jika:

```text
Filament menang lebih banyak → Filament lebih unggul
Laravel menang lebih banyak → Laravel lebih unggul
```

Jika jumlah kemenangan sama, maka hasil dinyatakan seimbang atau dilihat lagi dari total kemenangan per fitur.

### Rumus Excel Jumlah Kemenangan Filament

```excel
=COUNTIF(E8:E17,"Filament")
```

### Rumus Excel Jumlah Kemenangan Laravel

```excel
=COUNTIF(E8:E17,"Laravel")
```

### Rumus Excel Kesimpulan Akhir

```excel
=IF(C5>D5,"Filament",IF(D5>C5,"Laravel","Seimbang"))
```

---

## Ringkasan Fungsi Semua Sheet

| Sheet | Fungsi Utama | Digunakan dalam Laporan |
|---|---|---|
| 00_README | Petunjuk penggunaan file | Tidak wajib |
| 01_Raw_Data | Input data mentah Lighthouse | Lampiran/data dasar |
| 02_Lighthouse_Overview | Rata-rata Performance, Accessibility, Best Practices, SEO | Ya |
| 03_Web_Vitals | Rata-rata FCP, LCP, CLS, TTFB | Ya |
| 04_Statistik_Deskriptif | Mean dan standar deviasi | Ya |
| 05_Uji_Normalitas | Uji normalitas Shapiro-Wilk | Ya, dengan catatan n=3 |
| 06_Contoh_Perhitungan | Contoh hitung manual dan Excel | Ya, cocok untuk lampiran |
| 07_Dashboard | Visualisasi dan perbandingan detail | Ya, sebagai pendukung hasil |
| Helper_Shapiro | Tabel bantu p-value | Tidak perlu ditampilkan |
| 08_Rekap_Akhir | Kesimpulan akhir per metrik dan keseluruhan | Ya |

---

## Kalimat Penjelasan untuk Laporan TA

Perhitungan hasil pengujian dilakukan dengan mengolah data mentah dari Google Lighthouse yang diperoleh melalui tiga kali pengujian pada setiap fitur dan setiap sistem. Data mentah dimasukkan ke dalam sheet **01_Raw_Data**, kemudian dihitung secara otomatis untuk memperoleh nilai rata-rata, standar deviasi, hasil uji normalitas, serta rekapitulasi perbandingan antara Laravel Filament dan Laravel konvensional.

Metrik **Performance**, **Accessibility**, **Best Practices**, dan **SEO** dianalisis berdasarkan prinsip bahwa nilai yang lebih tinggi menunjukkan hasil yang lebih baik. Sementara itu, metrik **FCP**, **LCP**, **CLS**, dan **TTFB** dianalisis berdasarkan prinsip bahwa nilai yang lebih rendah menunjukkan performa yang lebih baik.

Hasil akhir kemudian dirangkum pada sheet **07_Dashboard** dan **08_Rekap_Akhir** untuk menentukan sistem yang lebih unggul secara keseluruhan berdasarkan kelompok skor Lighthouse, kelompok Web Vitals, serta total kemenangan per fitur dan per metrik.
