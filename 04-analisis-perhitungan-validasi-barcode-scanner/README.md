### Validasi Respons Barcode Scanner

Validasi respons fitur **barcode scanner** pada sistem Point of Sale. Validasi dilakukan untuk memastikan sistem dapat menerima input barcode, mencari data produk, dan menambahkan produk ke keranjang transaksi. Bagian ini tidak termasuk pengujian Google Lighthouse, tetapi digunakan sebagai validasi pendukung untuk melihat respons sistem saat fitur barcode digunakan pada proses transaksi.

Pengukuran respons barcode scanner dilakukan menggunakan **Chrome DevTools Network Timing** pada sistem yang telah dideploy. Pengukuran dilakukan dengan mencatat durasi request yang muncul setelah barcode dipindai hingga sistem memberikan respons terhadap proses pencarian atau penambahan produk ke keranjang transaksi. Setiap skenario diuji sebanyak tiga kali pada sistem Laravel Filament dan Laravel konvensional. Nilai akhir pada setiap skenario diperoleh dari rata-rata tiga kali pengujian.

#### Tabel 4.8 Raw Data Validasi Respons Barcode Scanner

##### A. Raw Data Pemindaian Satu Barcode Produk

| Sistem | Run 1 | Run 2 | Run 3 | Rata-rata |
|---|---:|---:|---:|---:|
| Laravel Filament | 305 ms | 132 ms | 147 ms | 194,67 ms |
| Laravel Konvensional | 292 ms | 75 ms | 73 ms | 146,67 ms |

Pada skenario ini, pengujian dilakukan dengan memindai satu barcode produk yang telah terdaftar pada database. Waktu yang dicatat adalah durasi request setelah barcode dipindai hingga produk berhasil diproses oleh sistem.

##### B. Raw Data Pemindaian 5 Barcode Berurutan

| Sistem | Run | Produk 1 | Produk 2 | Produk 3 | Produk 4 | Produk 5 | Total Waktu |
|---|---:|---:|---:|---:|---:|---:|---:|
| Laravel Filament | 1 | 128 ms | 138 ms | 143 ms | 160 ms | 136 ms | 705 ms |
| Laravel Filament | 2 | 155 ms | 133 ms | 130 ms | 168 ms | 171 ms | 757 ms |
| Laravel Filament | 3 | 182 ms | 119 ms | 163 ms | 143 ms | 191 ms | 798 ms |
| Laravel Konvensional | 1 | 257 ms | 79 ms | 73 ms | 85 ms | 75 ms | 569 ms |
| Laravel Konvensional | 2 | 167 ms | 80 ms | 66 ms | 93 ms | 70 ms | 476 ms |
| Laravel Konvensional | 3 | 440 ms | 73 ms | 77 ms | 78 ms | 73 ms | 741 ms |

Pada skenario ini, pengujian dilakukan dengan memindai lima barcode produk secara berurutan dalam satu proses transaksi. Setiap run dihitung dari total waktu lima produk yang dipindai, kemudian hasil akhir diperoleh dari rata-rata total waktu pada tiga kali pengujian.

##### C. Rekapitulasi Pemindaian 5 Barcode Berurutan

| Sistem | Total Run 1 | Total Run 2 | Total Run 3 | Rata-rata Total |
|---|---:|---:|---:|---:|
| Laravel Filament | 705 ms | 757 ms | 798 ms | 753,33 ms |
| Laravel Konvensional | 569 ms | 476 ms | 741 ms | 595,33 ms |

##### D. Raw Data Pemindaian pada Data Produk Besar

| Sistem | Run 1 | Run 2 | Run 3 | Rata-rata |
|---|---:|---:|---:|---:|
| Laravel Filament | 171 ms | 174 ms | 153 ms | 166,00 ms |
| Laravel Konvensional | 206 ms | 73 ms | 67 ms | 115,33 ms |

Pada skenario ini, pengujian dilakukan dengan memindai satu barcode produk pada kondisi database berisi data produk dalam jumlah lebih besar. Skenario ini digunakan untuk melihat respons sistem dalam mencari data produk ketika jumlah data yang dikelola lebih banyak.

##### E. Raw Data Pemindaian Saat Keranjang Sudah Terisi

| Sistem | Run 1 | Run 2 | Run 3 | Rata-rata |
|---|---:|---:|---:|---:|
| Laravel Filament | 178 ms | 146 ms | 151 ms | 158,33 ms |
| Laravel Konvensional | 170 ms | 68 ms | 67 ms | 101,67 ms |

Pada skenario ini, pengujian dilakukan dengan memindai barcode tambahan saat keranjang transaksi sudah berisi produk. Skenario ini digunakan untuk melihat respons sistem ketika transaksi sedang berjalan dan sistem perlu memperbarui isi keranjang.

---

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
Rata-rata Total = (Total Run 1 + Total Run 2 + Total Run 3) / 3
```

Rumus selisih yang digunakan adalah sebagai berikut.

```text
Selisih = nilai yang lebih besar - nilai yang lebih kecil
```

Konversi milidetik ke detik dilakukan dengan rumus berikut.

```text
Detik = milidetik / 1000
```

---

#### Detail Perhitungan Per Skenario

##### A. Perhitungan Pemindaian Satu Barcode Produk

**Laravel Filament**

```text
Rata-rata = (305 + 132 + 147) / 3
Rata-rata = 584 / 3
Rata-rata = 194,67 ms
Rata-rata = 194,67 / 1000
Rata-rata = 0,195 detik
```

**Laravel Konvensional**

```text
Rata-rata = (292 + 75 + 73) / 3
Rata-rata = 440 / 3
Rata-rata = 146,67 ms
Rata-rata = 146,67 / 1000
Rata-rata = 0,147 detik
```

**Selisih**

```text
Selisih = 194,67 - 146,67
Selisih = 48,00 ms
Selisih = 48,00 / 1000
Selisih = 0,048 detik
```

Jadi, pada skenario pemindaian satu barcode produk, Laravel konvensional lebih cepat sebesar **48,00 ms** atau **0,048 detik**.

---

##### B. Perhitungan Pemindaian 5 Barcode Berurutan

**Laravel Filament Run 1**

```text
Total Run 1 = 128 + 138 + 143 + 160 + 136
Total Run 1 = 705 ms
```

**Laravel Filament Run 2**

```text
Total Run 2 = 155 + 133 + 130 + 168 + 171
Total Run 2 = 757 ms
```

**Laravel Filament Run 3**

```text
Total Run 3 = 182 + 119 + 163 + 143 + 191
Total Run 3 = 798 ms
```

**Rata-rata Laravel Filament**

```text
Rata-rata = (705 + 757 + 798) / 3
Rata-rata = 2260 / 3
Rata-rata = 753,33 ms
Rata-rata = 753,33 / 1000
Rata-rata = 0,753 detik
```

**Laravel Konvensional Run 1**

```text
Total Run 1 = 257 + 79 + 73 + 85 + 75
Total Run 1 = 569 ms
```

**Laravel Konvensional Run 2**

```text
Total Run 2 = 167 + 80 + 66 + 93 + 70
Total Run 2 = 476 ms
```

**Laravel Konvensional Run 3**

```text
Total Run 3 = 440 + 73 + 77 + 78 + 73
Total Run 3 = 741 ms
```

**Rata-rata Laravel Konvensional**

```text
Rata-rata = (569 + 476 + 741) / 3
Rata-rata = 1786 / 3
Rata-rata = 595,33 ms
Rata-rata = 595,33 / 1000
Rata-rata = 0,595 detik
```

**Selisih**

```text
Selisih = 753,33 - 595,33
Selisih = 158,00 ms
Selisih = 158,00 / 1000
Selisih = 0,158 detik
```

Jadi, pada skenario pemindaian 5 barcode berurutan, Laravel konvensional lebih cepat sebesar **158,00 ms** atau **0,158 detik**.

---

##### C. Perhitungan Pemindaian pada Data Produk Besar

**Laravel Filament**

```text
Rata-rata = (171 + 174 + 153) / 3
Rata-rata = 498 / 3
Rata-rata = 166,00 ms
Rata-rata = 166,00 / 1000
Rata-rata = 0,166 detik
```

**Laravel Konvensional**

```text
Rata-rata = (206 + 73 + 67) / 3
Rata-rata = 346 / 3
Rata-rata = 115,33 ms
Rata-rata = 115,33 / 1000
Rata-rata = 0,115 detik
```

**Selisih**

```text
Selisih = 166,00 - 115,33
Selisih = 50,67 ms
Selisih = 50,67 / 1000
Selisih = 0,051 detik
```

Jadi, pada skenario pemindaian pada data produk besar, Laravel konvensional lebih cepat sebesar **50,67 ms** atau **0,051 detik**.

---

##### D. Perhitungan Pemindaian Saat Keranjang Sudah Terisi

**Laravel Filament**

```text
Rata-rata = (178 + 146 + 151) / 3
Rata-rata = 475 / 3
Rata-rata = 158,33 ms
Rata-rata = 158,33 / 1000
Rata-rata = 0,158 detik
```

**Laravel Konvensional**

```text
Rata-rata = (170 + 68 + 67) / 3
Rata-rata = 305 / 3
Rata-rata = 101,67 ms
Rata-rata = 101,67 / 1000
Rata-rata = 0,102 detik
```

**Selisih**

```text
Selisih = 158,33 - 101,67
Selisih = 56,66 ms
Selisih = 56,66 / 1000
Selisih = 0,057 detik
```

Jadi, pada skenario pemindaian saat keranjang sudah terisi, Laravel konvensional lebih cepat sebesar **56,66 ms** atau **0,057 detik**.

---

#### Tabel 4.9 Validasi Respons Barcode Scanner

| Skenario | Metode Pengukuran | Laravel Filament | Laravel Konvensional | Selisih | Keterangan |
|---|---|---:|---:|---:|---|
| Pemindaian satu barcode produk | Chrome DevTools Network Timing | 0,195 detik | 0,147 detik | 0,048 detik | Laravel konvensional lebih cepat |
| Pemindaian 5 barcode berurutan | Chrome DevTools Network Timing | 0,753 detik | 0,595 detik | 0,158 detik | Laravel konvensional lebih cepat |
| Pemindaian pada data produk besar | Chrome DevTools Network Timing | 0,166 detik | 0,115 detik | 0,051 detik | Laravel konvensional lebih cepat |
| Pemindaian saat keranjang sudah terisi | Chrome DevTools Network Timing | 0,158 detik | 0,102 detik | 0,057 detik | Laravel konvensional lebih cepat |

Berdasarkan hasil perhitungan, Laravel konvensional menunjukkan waktu respons yang lebih cepat dibandingkan Laravel Filament pada seluruh skenario pengujian. Pada skenario pemindaian satu barcode produk, Laravel konvensional memperoleh rata-rata **0,147 detik**, sedangkan Filament memperoleh **0,195 detik**. Pada skenario pemindaian 5 barcode berurutan, Laravel konvensional juga lebih cepat dengan rata-rata **0,595 detik**, sedangkan Filament memperoleh **0,753 detik**. Pada skenario pemindaian pada data produk besar, Laravel konvensional memperoleh **0,115 detik**, sedangkan Filament memperoleh **0,166 detik**. Sementara itu, pada skenario pemindaian saat keranjang sudah terisi, Laravel konvensional memperoleh **0,102 detik**, sedangkan Filament memperoleh **0,158 detik**.

Perbedaan ini menunjukkan bahwa Laravel konvensional memiliki waktu request yang lebih rendah dalam memproses input barcode dan memperbarui keranjang transaksi. Selisih terbesar terjadi pada skenario **pemindaian 5 barcode berurutan**, yaitu **0,158 detik**, sedangkan selisih terkecil terjadi pada skenario **pemindaian satu barcode produk**, yaitu **0,048 detik**. Hal ini menunjukkan bahwa Laravel konvensional tetap lebih cepat pada seluruh skenario, tetapi perbedaan waktunya masih berada pada rentang milidetik.

Kesimpulannya, berdasarkan hasil validasi respons barcode scanner, Laravel konvensional lebih unggul pada seluruh skenario pengujian. Hal ini dapat terjadi karena Laravel konvensional memiliki alur request yang lebih langsung melalui route dan controller, sehingga proses pencarian produk dan pembaruan keranjang dapat dilakukan dengan lebih ringan. Sementara itu, Laravel Filament menggunakan komponen berbasis Livewire yang dapat menambah lapisan proses ketika terjadi perubahan state pada halaman transaksi. Namun, hasil ini hanya menunjukkan respons request pada fitur barcode scanner, bukan keseluruhan performa sistem. Keunggulan Laravel konvensional pada validasi barcode berarti sistem tersebut lebih cepat dalam memproses input scan produk, sedangkan Filament tetap memiliki keunggulan dari sisi kemudahan implementasi dan otomatisasi pengembangan fitur.