# Tabel Black Box Testing Sistem POS Laravel 12 Konvensional

| No | Nama Fitur                           | Input                                  | Process                                     | Hasil yang Diharapkan                    | Result |
| -- | ------------------------------------ | -------------------------------------- | ------------------------------------------- | ---------------------------------------- | ------ |
| 1  | Login Berhasil                       | Email dan password benar diisi lengkap | Sistem memvalidasi credential login         | User berhasil masuk ke dashboard         | Valid  |
| 2  | Login Gagal Password Salah           | Email benar dan password salah         | Sistem memvalidasi credential               | Muncul pesan email atau password salah   | Valid  |
| 3  | Login Gagal Email Kosong             | Password diisi, email kosong           | Sistem memvalidasi form login               | Login gagal dan validasi email muncul    | Valid  |
| 4  | Login Gagal Password Kosong          | Email diisi, password kosong           | Sistem memvalidasi form login               | Login gagal dan validasi password muncul | Valid  |
| 5  | Login Gagal Semua Kosong             | Email dan password kosong              | Sistem memvalidasi seluruh field            | Login gagal dan validasi muncul          | Valid  |
| 6  | Logout Sistem                        | User menekan tombol logout             | Sistem menghapus session login              | User berhasil logout                     | Valid  |
| 7  | Dashboard Ditampilkan                | User berhasil login                    | Sistem memuat dashboard                     | Dashboard tampil normal                  | Valid  |
| 8  | Dashboard Ditolak untuk Guest        | Guest mengakses dashboard              | Middleware authentication dijalankan        | Guest diarahkan ke halaman login         | Valid  |
| 9  | Tambah Produk                        | Seluruh data produk diisi valid        | Sistem menyimpan produk                     | Produk berhasil ditambahkan              | Valid  |
| 10 | Tambah Produk Gagal                  | Nama/harga produk kosong               | Sistem memvalidasi form produk              | Produk gagal disimpan                    | Valid  |
| 11 | Update Produk                        | Data produk diubah                     | Sistem memperbarui data produk              | Produk berhasil diperbarui               | Valid  |
| 12 | Hapus Produk                         | Tombol delete produk ditekan           | Sistem melakukan soft delete                | Produk berhasil dihapus                  | Valid  |
| 13 | Tambah Kategori                      | Nama kategori diisi                    | Sistem menyimpan kategori                   | Kategori berhasil ditambahkan            | Valid  |
| 14 | Update Kategori                      | Data kategori diubah                   | Sistem memperbarui kategori                 | Kategori berhasil diperbarui             | Valid  |
| 15 | Hapus Kategori                       | Tombol delete kategori ditekan         | Sistem menghapus kategori                   | Kategori berhasil dihapus                | Valid  |
| 16 | Tambah Inventory Masuk               | Quantity inventory masuk diisi         | Sistem menambah stok produk                 | Stok produk bertambah                    | Valid  |
| 17 | Tambah Inventory Keluar              | Quantity inventory keluar diisi        | Sistem mengurangi stok produk               | Stok produk berkurang                    | Valid  |
| 18 | Adjustment Inventory                 | Quantity adjustment diisi              | Sistem menyesuaikan stok                    | Stok berhasil disesuaikan                | Valid  |
| 19 | Inventory Gagal Karena Stok Kurang   | Quantity melebihi stok                 | Sistem memvalidasi stok produk              | Inventory gagal diproses                 | Valid  |
| 20 | Tambah Produk ke Cart POS            | Produk dipilih                         | Sistem menambahkan item ke cart             | Produk masuk ke cart POS                 | Valid  |
| 21 | Tambah Quantity POS                  | Quantity ditambah                      | Sistem menghitung subtotal                  | Quantity dan subtotal bertambah          | Valid  |
| 22 | Kurangi Quantity POS                 | Quantity dikurangi                     | Sistem menghitung subtotal                  | Quantity dan subtotal berkurang          | Valid  |
| 23 | Hapus Item Cart POS                  | Tombol remove item ditekan             | Sistem menghapus item dari cart             | Item berhasil dihapus                    | Valid  |
| 24 | Checkout POS Berhasil                | Cart dan pembayaran valid              | Sistem membuat transaksi                    | Checkout berhasil diproses               | Valid  |
| 25 | Checkout POS Gagal Pembayaran Kurang | Nominal bayar kurang dari total        | Sistem memvalidasi pembayaran               | Checkout gagal diproses                  | Valid  |
| 26 | Checkout POS Gagal Cart Kosong       | Tidak ada item dalam cart              | Sistem memvalidasi cart                     | Checkout gagal diproses                  | Valid  |
| 27 | Hitung Kembalian POS                 | Bayar lebih besar dari total           | Sistem menghitung kembalian                 | Kembalian tampil sesuai                  | Valid  |
| 28 | Detail Transaksi                     | User membuka detail transaksi          | Sistem mengambil data transaksi             | Detail transaksi tampil                  | Valid  |
| 29 | Hapus Transaksi                      | Tombol delete transaksi ditekan        | Sistem menghapus transaksi dan restore stok | Transaksi berhasil dihapus               | Valid  |
| 30 | Restore Stock Transaksi              | Transaksi dihapus                      | Sistem mengembalikan stok produk            | Stock kembali seperti semula             | Valid  |
| 31 | Tambah Payment Method                | Data payment method diisi valid        | Sistem menyimpan payment method             | Payment method berhasil ditambahkan      | Valid  |
| 32 | Update Payment Method                | Data payment method diubah             | Sistem memperbarui payment method           | Payment method berhasil diperbarui       | Valid  |
| 33 | Delete Payment Method                | Tombol delete ditekan                  | Sistem melakukan soft delete                | Payment method berhasil dihapus          | Valid  |
| 34 | Restore Payment Method               | Tombol restore ditekan                 | Sistem memulihkan data payment method       | Payment method berhasil dipulihkan       | Valid  |
| 35 | Tambah Cash In                       | Data cashflow masuk diisi              | Sistem menyimpan cashflow masuk             | Cashflow masuk berhasil dibuat           | Valid  |
| 36 | Tambah Cash Out                      | Data cashflow keluar diisi             | Sistem menyimpan cashflow keluar            | Cashflow keluar berhasil dibuat          | Valid  |
| 37 | Validasi Source Cashflow             | Source type tidak sesuai               | Sistem memvalidasi source type              | Muncul validasi error                    | Valid  |
| 38 | Hapus Manual Cashflow                | Cashflow manual dihapus                | Sistem menghapus cashflow                   | Cashflow berhasil dihapus                | Valid  |
| 39 | Hapus Auto Cashflow                  | Auto cashflow dihapus                  | Sistem memblokir penghapusan                | Auto cashflow tidak dapat dihapus        | Valid  |
| 40 | Generate Report                      | User membuka laporan                   | Sistem mengambil data transaksi             | Laporan berhasil ditampilkan             | Valid  |
| 41 | Filter Report                        | Filter tanggal digunakan               | Sistem memfilter data transaksi             | Data laporan berhasil difilter           | Valid  |
| 42 | Dashboard Statistik                  | Dashboard dibuka                       | Sistem menghitung statistik                 | Statistik dashboard tampil               | Valid  |
| 43 | Create Role                          | Data role diisi                        | Sistem menyimpan role                       | Role berhasil dibuat                     | Valid  |
| 44 | Update Role                          | Data role diubah                       | Sistem memperbarui role                     | Role berhasil diperbarui                 | Valid  |
| 45 | Delete Role                          | Tombol delete role ditekan             | Sistem menghapus role                       | Role berhasil dihapus                    | Valid  |
| 46 | Create User                          | Data user diisi                        | Sistem menyimpan user                       | User berhasil dibuat                     | Valid  |
| 47 | Update User                          | Data user diubah                       | Sistem memperbarui user                     | User berhasil diperbarui                 | Valid  |
| 48 | Verify User                          | Tombol verify ditekan                  | Sistem memverifikasi user                   | User berhasil diverifikasi               | Valid  |
| 49 | Delete User                          | Tombol delete ditekan                  | Sistem menghapus user                       | User berhasil dihapus                    | Valid  |
| 50 | Permission Middleware                | User tanpa permission akses route      | Middleware memvalidasi permission           | Access denied ditampilkan                | Valid  |
| 51 | JSON Unauthorized Access             | Request JSON tanpa permission          | Middleware mengembalikan forbidden response | Response 403 tampil                      | Valid  |
| 52 | Update Profile                       | Data profile diubah                    | Sistem memperbarui profile                  | Profile berhasil diperbarui              | Valid  |

---

# Rekapitulasi Black Box Testing

| Aspek                   | Hasil |
| ----------------------- | ----- |
| Total Test Case         | 52    |
| Valid                   | 52    |
| Fail                    | 0     |
| Persentase Keberhasilan | 100%  |

---

# Kesimpulan

Berdasarkan hasil black box testing, seluruh fitur utama pada sistem POS Laravel 12 konvensional berhasil berjalan sesuai kebutuhan fungsional pengguna. Pengujian dilakukan dari sisi pengguna dengan memvalidasi input, proses sistem, dan output yang dihasilkan melalui antarmuka aplikasi. Seluruh skenario pengujian memperoleh hasil valid sehingga tingkat keberhasilan black box testing mencapai 100%.
