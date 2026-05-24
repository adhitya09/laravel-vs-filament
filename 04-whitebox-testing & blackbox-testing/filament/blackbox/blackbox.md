# Tabel Black Box Testing Sistem POS Filament Laravel 12

| No | Nama Fitur | Input | Process | Hasil yang Diharapkan | Result |
|---|---|---|---|---|---|
| 1 | Login Berhasil | Email dan password benar diisi lengkap | Sistem memvalidasi credential login Filament | User berhasil masuk ke dashboard | Valid |
| 2 | Login Gagal Password Salah | Email benar dan password salah | Sistem memvalidasi credential login | Muncul pesan login gagal | Valid |
| 3 | Login Gagal Email Kosong | Password diisi, email kosong | Sistem memvalidasi field email | Validasi email muncul | Valid |
| 4 | Login Gagal Password Kosong | Email diisi, password kosong | Sistem memvalidasi field password | Validasi password muncul | Valid |
| 5 | Login Gagal Semua Kosong | Email dan password kosong | Sistem memvalidasi seluruh field login | Login gagal diproses | Valid |
| 6 | Logout Sistem | User menekan tombol logout | Sistem menghapus session login Filament | User berhasil logout | Valid |
| 7 | Dashboard Ditampilkan | User berhasil login | Sistem memuat dashboard dan widget statistik | Dashboard tampil normal | Valid |
| 8 | Dashboard Ditolak untuk Guest | Guest mengakses dashboard | Middleware authentication dijalankan | Guest diarahkan ke halaman login | Valid |
| 9 | Dashboard Ditolak Tanpa Permission | User tanpa permission dashboard | Middleware authorization dijalankan | Access denied ditampilkan | Valid |
| 10 | Tambah Produk | Seluruh data produk diisi valid | Sistem menyimpan data produk | Produk berhasil ditambahkan | Valid |
| 11 | Tambah Produk Gagal | Nama/harga produk kosong | Sistem memvalidasi form produk | Produk gagal disimpan | Valid |
| 12 | Update Produk | Data produk diubah | Sistem memperbarui data produk | Produk berhasil diperbarui | Valid |
| 13 | Hapus Produk | Tombol delete produk ditekan | Sistem melakukan soft delete | Produk berhasil dihapus | Valid |
| 14 | Guest Mengakses Produk | Guest membuka halaman produk | Middleware authentication dijalankan | Guest diarahkan ke login | Valid |
| 15 | Unauthorized Produk Access | User tanpa permission produk | Middleware permission dijalankan | Akses ditolak | Valid |
| 16 | Tambah Kategori | Nama kategori diisi | Sistem menyimpan kategori | Kategori berhasil ditambahkan | Valid |
| 17 | Update Kategori | Data kategori diubah | Sistem memperbarui kategori | Kategori berhasil diperbarui | Valid |
| 18 | Hapus Kategori | Tombol delete kategori ditekan | Sistem melakukan soft delete | Kategori berhasil dihapus | Valid |
| 19 | Tambah Inventory Masuk | Quantity inventory masuk diisi | Observer inventory menambah stok produk | Stok produk bertambah | Valid |
| 20 | Tambah Inventory Keluar | Quantity inventory keluar diisi | Observer inventory mengurangi stok produk | Stok produk berkurang | Valid |
| 21 | Adjustment Inventory | Quantity adjustment diisi | Observer inventory menyesuaikan stok | Stok berhasil disesuaikan | Valid |
| 22 | Inventory Gagal Karena Stok Kurang | Quantity melebihi stok | Sistem memvalidasi stok produk | Inventory gagal diproses | Valid |
| 23 | Tambah Produk ke Cart POS | Produk dipilih | Sistem menjalankan fungsi `addToOrder()` | Produk masuk ke cart POS | Valid |
| 24 | Tambah Quantity POS | Quantity ditambah | Sistem menjalankan `increaseQuantity()` | Quantity dan subtotal bertambah | Valid |
| 25 | Kurangi Quantity POS | Quantity dikurangi | Sistem menjalankan `decreaseQuantity()` | Quantity dan subtotal berkurang | Valid |
| 26 | Hapus Item Cart POS | Quantity menjadi 0 | Sistem otomatis remove item cart | Item berhasil dihapus | Valid |
| 27 | Hitung Total POS | Item transaksi ditambahkan | Sistem menjalankan `calculateTotal()` | Total transaksi tampil sesuai | Valid |
| 28 | Hitung Kembalian POS | Nominal bayar lebih besar dari total | Sistem menjalankan `calculateChange()` | Kembalian tampil sesuai | Valid |
| 29 | Checkout POS Berhasil | Cart dan pembayaran valid | Sistem membuat transaksi dan transaction item | Checkout berhasil diproses | Valid |
| 30 | Checkout POS Gagal Pembayaran Kurang | Nominal bayar kurang dari total | Sistem memvalidasi pembayaran | Checkout gagal diproses | Valid |
| 31 | Checkout POS Gagal Cart Kosong | Tidak ada item dalam cart | Sistem memvalidasi order_items | Checkout gagal diproses | Valid |
| 32 | Reset Order POS | Tombol reset ditekan | Sistem menjalankan `resetOrder()` | Cart berhasil dikosongkan | Valid |
| 33 | Detail Transaksi | User membuka detail transaksi | Sistem mengambil relasi transaksi | Detail transaksi tampil | Valid |
| 34 | Relasi Payment Method | Payment method dipilih | Sistem mengambil relasi payment method | Payment method tampil sesuai | Valid |
| 35 | Produk Soft Delete pada Transaksi | Produk telah dihapus | Sistem menjalankan `productWithTrashed()` | Produk tetap dapat diakses | Valid |
| 36 | Restore Stock Transaksi | Transaction item dihapus | Observer transaction item dijalankan | Stock kembali seperti semula | Valid |
| 37 | Tambah Payment Method | Data payment method diisi valid | Sistem menyimpan payment method | Payment method berhasil ditambahkan | Valid |
| 38 | Update Payment Method | Data payment method diubah | Sistem memperbarui payment method | Payment method berhasil diperbarui | Valid |
| 39 | Delete Payment Method | Tombol delete ditekan | Sistem melakukan soft delete | Payment method berhasil dihapus | Valid |
| 40 | Validasi Field is_cash | Field is_cash dipilih | Sistem membaca tipe payment method | Status cash berhasil disimpan | Valid |
| 41 | Tambah Cash In | Data cashflow masuk diisi | Sistem menyimpan cashflow masuk | Cashflow masuk berhasil dibuat | Valid |
| 42 | Tambah Cash Out | Data cashflow keluar diisi | Sistem menyimpan cashflow keluar | Cashflow keluar berhasil dibuat | Valid |
| 43 | Validasi Amount Cashflow | Amount non numeric diinput | Sistem memvalidasi amount | Validasi error muncul | Valid |
| 44 | Delete Cashflow | Tombol delete ditekan | Sistem menghapus cashflow | Cashflow berhasil dihapus | Valid |
| 45 | Generate Report | User membuka laporan | Sistem mengambil data transaksi | Laporan berhasil ditampilkan | Valid |
| 46 | Filter Report | Filter tanggal digunakan | Sistem memfilter transaksi | Data laporan berhasil difilter | Valid |
| 47 | Statistik Dashboard | Dashboard dibuka | Sistem menghitung statistik | Statistik dashboard tampil | Valid |
| 48 | Create User | Data user diisi | Sistem menyimpan user | User berhasil dibuat | Valid |
| 49 | Update User | Data user diubah | Sistem memperbarui user | User berhasil diperbarui | Valid |
| 50 | Role Permission User | Role dipilih pada user | Sistem menghubungkan role user | Role berhasil tersimpan | Valid |
| 51 | Unauthorized Panel Access | User tanpa role admin | Sistem menjalankan `canAccessPanel()` | Akses panel ditolak | Valid |
| 52 | Permission Middleware | User tanpa permission akses route | Middleware memvalidasi permission | Access denied ditampilkan | Valid |
| 53 | Receipt Ditampilkan | User membuka receipt transaksi | Sistem mengambil data receipt | Receipt berhasil ditampilkan | Valid |
| 54 | Download Receipt | User download receipt | Sistem generate invoice receipt | Receipt berhasil diunduh | Valid |
| 55 | Invalid Receipt Access | ID transaksi tidak valid | Sistem memvalidasi transaksi | Response 404 tampil | Valid |
| 56 | Scanner Barcode POS | Barcode produk dipindai | Sistem membaca barcode scanner | Produk berhasil ditambahkan | Valid |
| 57 | Upload Logo Setting | File logo dipilih | Sistem upload file logo | Logo berhasil diupload | Valid |
| 58 | Update Setting Toko | Nama toko dan phone diubah | Sistem menyimpan setting | Setting berhasil diperbarui | Valid |

---

# Rekapitulasi Black Box Testing

| Aspek | Hasil |
|---|---|
| Total Test Case | 58 |
| Valid | 58 |
| Fail | 0 |
| Persentase Keberhasilan | 100% |

---

# Kesimpulan

Berdasarkan hasil black box testing pada sistem POS berbasis Filament Laravel 12, seluruh fitur utama sistem berhasil berjalan sesuai kebutuhan fungsional pengguna. Pengujian dilakukan melalui validasi input, proses bisnis sistem, middleware autentikasi, authorization permission, observer stok, Livewire POS, serta relasi transaksi dan inventory. Seluruh skenario pengujian memperoleh hasil valid sehingga tingkat keberhasilan black box testing mencapai 100%.

Pengujian juga menunjukkan bahwa integrasi Filament, Livewire, Laravel Observer, dan Filament Shield mampu mendukung proses bisnis Point of Sales secara stabil, khususnya pada proses transaksi kasir, sinkronisasi stok otomatis, middleware permission, dan pengelolaan data master sistem.