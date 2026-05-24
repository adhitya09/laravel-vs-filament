### 4.2.4.4 Validasi Respons Barcode Scanner

Subbab ini membahas validasi respons fitur **barcode scanner** pada sistem Point of Sale. Validasi dilakukan untuk memastikan sistem dapat menerima input barcode, mencari data produk, dan menambahkan produk ke keranjang transaksi. Bagian ini tidak termasuk pengujian Google Lighthouse, tetapi digunakan sebagai validasi pendukung untuk melihat respons sistem saat fitur barcode digunakan pada proses transaksi.

Pengukuran respons barcode scanner dilakukan menggunakan **Chrome DevTools Network Timing** pada sistem yang telah dideploy. Pengukuran dilakukan dengan mencatat durasi request yang muncul setelah barcode dipindai hingga sistem memberikan respons terhadap proses pencarian atau penambahan produk ke keranjang transaksi. Setiap skenario diuji sebanyak tiga kali pada sistem Laravel Filament dan Laravel konvensional. Nilai akhir pada setiap skenario diperoleh dari rata-rata tiga kali pengujian.

#### Tabel 4.8 Raw Data Validasi Respons Barcode Scanner

##### A. Raw Data Pemindaian Satu Barcode Produk

| Sistem | Run 1 | Run 2 | Run 3 | Rata-rata |
|---|---:|---:|---:|---:|
| Laravel Filament | 256,98 ms | 166,01 ms | 538,10 ms | 320,36 ms |
| Laravel Konvensional | 131,24 ms | 116,10 ms | 203,08 ms | 150,14 ms |

Pada skenario ini, pengujian dilakukan dengan memindai satu barcode produk yang telah terdaftar pada database. Waktu yang dicatat adalah durasi request setelah barcode dipindai hingga produk berhasil diproses oleh sistem.

##### B. Raw Data Pemindaian 5 Barcode Berurutan

| Sistem | Run | Produk 1 | Produk 2 | Produk 3 | Produk 4 | Produk 5 | Total Waktu |
|---|---:|---:|---:|---:|---:|---:|---:|
| Laravel Filament | 1 | 446,58 ms | 165,22 ms | 188,07 ms | 233,39 ms | 178,32 ms | 1.211,58 ms |
| Laravel Filament | 2 | 405,12 ms | 160,82 ms | 315,61 ms | 394,30 ms | 230,78 ms | 1.506,63 ms |
| Laravel Filament | 3 | 349,96 ms | 165,59 ms | 1.000,00 ms | 190,24 ms | 196,40 ms | 1.902,19 ms |
| Laravel Konvensional | 1 | 231,47 ms | 92,11 ms | 108,37 ms | 116,91 ms | 351,45 ms | 900,31 ms |
| Laravel Konvensional | 2 | 145,39 ms | 76,33 ms | 78,82 ms | 82,41 ms | 76,72 ms | 459,67 ms |
| Laravel Konvensional | 3 | 127,22 ms | 84,64 ms | 95,40 ms | 75,19 ms | 102,14 ms | 484,59 ms |

Pada skenario ini, pengujian dilakukan dengan memindai lima barcode produk secara berurutan dalam satu proses transaksi. Setiap run dihitung dari total waktu lima produk yang dipindai, kemudian hasil akhir diperoleh dari rata-rata total waktu pada tiga kali pengujian.

##### C. Rekapitulasi Pemindaian 5 Barcode Berurutan

| Sistem | Total Run 1 | Total Run 2 | Total Run 3 | Rata-rata Total |
|---|---:|---:|---:|---:|
| Laravel Filament | 1.211,58 ms | 1.506,63 ms | 1.902,19 ms | 1.540,13 ms |
| Laravel Konvensional | 900,31 ms | 459,67 ms | 484,59 ms | 614,86 ms |

##### D. Raw Data Pemindaian pada Data Produk Besar

| Sistem | Run 1 | Run 2 | Run 3 | Rata-rata |
|---|---:|---:|---:|---:|
| Laravel Filament | 620,16 ms | 244,76 ms | 327,32 ms | 397,41 ms |
| Laravel Konvensional | 88,73 ms | 79,19 ms | 79,43 ms | 82,45 ms |

Pada skenario ini, pengujian dilakukan dengan memindai satu barcode produk pada kondisi database berisi data produk dalam jumlah lebih besar. Skenario ini digunakan untuk melihat respons sistem dalam mencari data produk ketika jumlah data yang dikelola lebih banyak.

##### E. Raw Data Pemindaian Saat Keranjang Sudah Terisi

| Sistem | Run 1 | Run 2 | Run 3 | Rata-rata |
|---|---:|---:|---:|---:|
| Laravel Filament | 251,49 ms | 540,61 ms | 251,56 ms | 347,89 ms |
| Laravel Konvensional | 91,09 ms | 73,37 ms | 75,03 ms | 79,83 ms |

Pada skenario ini, pengujian dilakukan dengan memindai barcode tambahan saat keranjang transaksi sudah berisi produk. Skenario ini digunakan untuk melihat respons sistem ketika transaksi sedang berjalan dan sistem perlu memperbarui isi keranjang.

#### Rumus Perhitungan

Rumus rata-rata yang digunakan adalah sebagai berikut.

```text
Rata-rata = (Run 1 + Run 2 + Run 3) / 3
```

Pada skenario **pemindaian 5 barcode berurutan**, setiap run dihitung dari total waktu lima produk yang dipindai secara berurutan.

```text
Total Run = Produk 1 + Produk 2 + Produk 3 + Produk 4 + Produk 5
```

```text
Rata-rata = (Total Run 1 + Total Run 2 + Total Run 3) / 3
```

Rumus selisih yang digunakan adalah sebagai berikut.

```text
Selisih = nilai yang lebih besar - nilai yang lebih kecil
```

Konversi milidetik ke detik dilakukan dengan rumus berikut.

```text
Detik = milidetik / 1000
```

#### Contoh Perhitungan

Contoh perhitungan rata-rata pada skenario **pemindaian satu barcode produk** untuk Laravel Filament adalah sebagai berikut.

```text
Rata-rata = (256,98 + 166,01 + 538,10) / 3
Rata-rata = 961,09 / 3
Rata-rata = 320,36 ms
Rata-rata = 0,320 detik
```

Contoh perhitungan rata-rata pada skenario **pemindaian satu barcode produk** untuk Laravel konvensional adalah sebagai berikut.

```text
Rata-rata = (131,24 + 116,10 + 203,08) / 3
Rata-rata = 450,42 / 3
Rata-rata = 150,14 ms
Rata-rata = 0,150 detik
```

Contoh perhitungan total run pada skenario **pemindaian 5 barcode berurutan** untuk Laravel Filament Run 1 adalah sebagai berikut.

```text
Total Run 1 = 446,58 + 165,22 + 188,07 + 233,39 + 178,32
Total Run 1 = 1.211,58 ms
```

Contoh perhitungan rata-rata pada skenario **pemindaian 5 barcode berurutan** untuk Laravel Filament adalah sebagai berikut.

```text
Rata-rata = (1.211,58 + 1.506,63 + 1.902,19) / 3
Rata-rata = 4.620,40 / 3
Rata-rata = 1.540,13 ms
Rata-rata = 1,540 detik
```

Contoh perhitungan selisih pada skenario **pemindaian satu barcode produk** adalah sebagai berikut.

```text
Selisih = 0,320 - 0,150
Selisih = 0,170 detik
```

#### Tabel 4.9 Validasi Respons Barcode Scanner

| Skenario | Metode Pengukuran | Laravel Filament | Laravel Konvensional | Selisih | Keterangan |
|---|---|---:|---:|---:|---|
| Pemindaian satu barcode produk | Chrome DevTools Network Timing | 0,320 detik | 0,150 detik | 0,170 detik | Laravel konvensional lebih cepat |
| Pemindaian 5 barcode berurutan | Chrome DevTools Network Timing | 1,540 detik | 0,615 detik | 0,925 detik | Laravel konvensional lebih cepat |
| Pemindaian pada data produk besar | Chrome DevTools Network Timing | 0,397 detik | 0,082 detik | 0,315 detik | Laravel konvensional lebih cepat |
| Pemindaian saat keranjang sudah terisi | Chrome DevTools Network Timing | 0,348 detik | 0,080 detik | 0,268 detik | Laravel konvensional lebih cepat |

Berdasarkan **Tabel 4.9 Validasi Respons Barcode Scanner**, Laravel konvensional menunjukkan waktu respons yang lebih cepat dibandingkan Laravel Filament pada seluruh skenario pengujian. Pada skenario pemindaian satu barcode produk, Laravel konvensional memperoleh rata-rata **0,150 detik**, sedangkan Filament memperoleh **0,320 detik**. Pada skenario pemindaian 5 barcode berurutan, Laravel konvensional juga lebih cepat dengan rata-rata **0,615 detik**, sedangkan Filament memperoleh **1,540 detik**. Pada skenario pemindaian pada data produk besar, Laravel konvensional memperoleh **0,082 detik**, sedangkan Filament memperoleh **0,397 detik**. Sementara itu, pada skenario pemindaian saat keranjang sudah terisi, Laravel konvensional memperoleh **0,080 detik**, sedangkan Filament memperoleh **0,348 detik**. Perbedaan ini menunjukkan bahwa Laravel konvensional memiliki waktu request yang lebih rendah dalam memproses input barcode dan memperbarui keranjang transaksi.

Kesimpulannya, berdasarkan **Tabel 4.9**, Laravel konvensional lebih unggul pada validasi respons barcode scanner karena memperoleh waktu respons lebih cepat pada seluruh skenario pengujian. Hal ini dapat terjadi karena Laravel konvensional memiliki alur request yang lebih langsung melalui route dan controller, sehingga proses pencarian produk dan pembaruan keranjang dapat dilakukan dengan lebih ringan. Sementara itu, Laravel Filament menggunakan komponen berbasis Livewire yang dapat menambah lapisan proses ketika terjadi perubahan state pada halaman transaksi. Namun, hasil ini hanya menunjukkan respons request pada fitur barcode scanner, bukan keseluruhan performa sistem. Keunggulan Laravel konvensional pada validasi barcode berarti sistem tersebut lebih cepat dalam memproses input scan produk, sedangkan Filament tetap memiliki keunggulan dari sisi kemudahan implementasi dan otomatisasi pengembangan fitur.