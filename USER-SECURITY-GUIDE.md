# Panduan Keamanan ShopX untuk Pengguna

Dokumen ini memberikan informasi tentang fitur keamanan ShopX dan panduan praktis bagi pengguna untuk memaksimalkan keamanan data saat menggunakan aplikasi.

## Fitur Keamanan Data di ShopX

ShopX mengimplementasikan berbagai fitur keamanan untuk melindungi data pengguna:

### 1. Enkripsi Data Sensitif

Semua data sensitif dalam ShopX dienkripsi menggunakan teknologi canggih:

| Jenis Data | Metode Enkripsi | Tingkat Keamanan |
|------------|-----------------|------------------|
| Data Kartu Kredit | AES-256 | Tinggi |
| CVV Kartu | PBKDF2 + AES-256 | Sangat Tinggi |
| Alamat | AES-256 | Tinggi |
| Detail Akun Bank | AES-256 | Tinggi |

### 2. Opsi Keamanan Tambahan

ShopX menawarkan opsi untuk meningkatkan keamanan Anda:

- **Enkripsi Lanjutan untuk CVV**: Menggunakan PBKDF2 dengan 10,000 iterasi untuk perlindungan ekstra
- **Sesi Aman**: Seluruh sesi pengguna dienkripsi
- **HTTPS**: Semua komunikasi dienkripsi menggunakan HTTPS

## Panduan Keamanan untuk Pengguna

### Mengaktifkan Keamanan Lanjutan untuk Metode Pembayaran

1. Saat menambahkan metode pembayaran baru, centang opsi "Gunakan keamanan tingkat lanjut"
2. Isi CVV kartu seperti biasa
3. Data CVV Anda akan disimpan dengan perlindungan ekstra menggunakan PBKDF2

### Praktik Terbaik untuk Keamanan Akun

1. **Gunakan Password Kuat**: Minimal 12 karakter dengan kombinasi huruf, angka, dan simbol
2. **Aktifkan Semua Fitur Keamanan**: Gunakan semua opsi keamanan yang tersedia
3. **Verifikasi Transaksi**: Selalu periksa notifikasi dan riwayat transaksi
4. **Gunakan Perangkat Pribadi**: Hindari mengakses akun dari komputer publik

## FAQ Keamanan

### Apa itu PBKDF2?

PBKDF2 (Password-Based Key Derivation Function 2) adalah algoritma yang memperkuat kunci enkripsi dengan melakukan ribuan iterasi fungsi hash. Ini membuat upaya pembobolan data melalui serangan brute force menjadi sangat sulit.

### Apakah data kartu kredit saya aman?

Ya. ShopX tidak pernah menyimpan nomor kartu kredit lengkap dalam bentuk yang tidak terenkripsi. Semua data sensitif dienkripsi dengan AES-256, dan untuk data sangat sensitif seperti CVV, enkripsi tambahan dengan PBKDF2 tersedia.

### Bagaimana cara mengetahui enkripsi lanjutan aktif?

Saat melihat detail metode pembayaran Anda, terdapat indikator "Dilindungi PBKDF2" untuk data yang menggunakan enkripsi lanjutan. Anda juga dapat melihat ini di halaman detail metode pembayaran.

### Apa yang terjadi jika ada kebocoran data?

Bahkan jika ada kebocoran data, informasi sensitif Anda tetap terenkripsi dan sangat sulit untuk didekripsi tanpa kunci enkripsi. Untuk data dengan PBKDF2, diperlukan upaya komputasi yang sangat besar untuk mencoba memboboknya.

## Melaporkan Masalah Keamanan

Jika Anda menemukan masalah keamanan di ShopX, segera laporkan ke:

- Email: security@shopx.com
- Formulir: [https://shopx.com/report-security-issue](https://shopx.com/report-security-issue)

Kami berkomitmen untuk menangani laporan keamanan dengan serius dan menyelesaikan masalah secepat mungkin.
