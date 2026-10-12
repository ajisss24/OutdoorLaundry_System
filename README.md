# OutdoorLaundry System

Aplikasi web manajemen laundry khusus peralatan outdoor (carrier, tenda, sleeping bag, dll) dengan desain premium dan state-of-the-art.

## 🛠️ Teknologi
- **Backend**: PHP (Native dengan PDO)
- **Frontend**: HTML5, JavaScript (ES6+), Tailwind CSS (via CDN)
- **Database**: MySQL
- **Design Aesthetic**: Premium Orange/Peach Theme (Inspirasi: getwashlaundry.id)

## ✨ Fitur Utama

### 🏠 Landing Page
- **Hero Section**: Visual before-after peralatan outdoor yang kotor vs bersih.
- **Layanan Unggulan**: Cuci Carrier, Reproof Gore-Tex, dan Transparansi Harga.
- **Testimoni**: 5 Community Reviews dari pelanggan pendaki.
- **Modal Bantuan**: FAQ, Syarat & Ketentuan, dan Kebijakan Privasi yang interaktif.

### 👤 Customer Dashboard & Otentikasi
- **Autentikasi Aman & Reset Password**: Registrasi, login dengan enkripsi bcrypt, serta fitur pemulihan kata sandi (Lupa Password) berbasis token aman dengan batas waktu kedaluwarsa.
- **Manajemen Gear**: Pendataan perlengkapan outdoor milik pengguna.
- **Smart Booking**: Pemesanan laundry dengan jadwal penjemputan (*Pickup Time Range*).
- **Real-time Tracking**: Melacak status pencucian dari Pending hingga Selesai.
- **Penyederhanaan Pembayaran**: Mendukung Transfer Bank dan Tunai (COD).

### 👨‍💼 Admin Dashboard
- **Manajemen Pesanan**: Validasi pembayaran dan penugasan kurir.
- **Manajemen Layanan**: Fitur edit harga treatment secara langsung.
- **Manajemen User**: Pengaturan status keaktifan kurir (Aktif/Libur).
- **Statistik**: Monitoring pendapatan dan total pesanan.

### 🚚 Kurir Dashboard
- **Task Management**: Daftar tugas penjemputan dan pengantaran.
- **Bukti Kerja**: Upload foto bukti setelah barang dijemput atau diantar.

## 🔄 Alur Penggunaan (Workflow)

Aplikasi ini melibatkan tiga peran utama: **Customer**, **Kurir**, dan **Admin**. Berikut adalah alur kerjanya:

1.  **Registrasi & Login**: Pengguna mendaftar dan masuk sebagai Customer.
2.  **Pendataan Gear**: Customer menambahkan perlengkapan outdoor mereka (tenda, carrier, dll) di menu "My Gears".
3.  **Booking Service**: 
    - Customer melakukan pemesanan dengan memilih gear yang sudah didata.
    - Memilih jenis treatment tambahan jika diperlukan.
    - Menentukan jadwal penjemputan (*Pickup Time*).
4.  **Penjemputan (Pickup)**:
    - Admin menugaskan Kurir (atau Kurir mengambil tugas).
    - Kurir mendatangi lokasi, mengambil barang, dan mengunggah **foto bukti jemput**.
    - Status berubah menjadi "Picked Up".
5.  **Proses Pencucian**:
    - Admin/Sistem memperbarui status ke "Washing" saat barang sedang diproses.
6.  **Pembayaran**:
    - Customer melakukan pembayaran via Transfer Bank atau COD.
    - Jika transfer, customer mengunggah bukti pembayaran di dashboard.
7.  **Validasi & Pengantaran**:
    - Admin memvalidasi pembayaran.
    - Kurir mengantar barang kembali ke lokasi customer dan mengunggah **foto bukti antar**.
    - Status berubah menjadi "Completed".

---

## 🚀 Cara Instalasi & Menjalankan Proyek (Laragon)

Ikuti langkah-langkah berikut untuk menjalankan sistem di lingkungan lokal menggunakan **Laragon**:

### 1. Persiapan Lingkungan
Pastikan Anda sudah menginstal:
- **Laragon** (WAMP/Apache/PHP setup).
- **HeidiSQL** (Sudah termasuk dalam paket instalasi Laragon).

### 2. Setup Database (HeidiSQL)
1.  Buka **Laragon** dan klik tombol **Start All**.
2.  Klik tombol **Database** pada Laragon untuk membuka **HeidiSQL**.
3.  Di HeidiSQL, klik kanan pada koneksi Anda (biasanya `Unnamed`) -> **Create new** -> **Database**.
4.  Beri nama database: `laundry_outdoor`.
5.  Klik database `laundry_outdoor` yang baru dibuat, lalu buka menu **File** -> **Run SQL file...**.
6.  Pilih file `database.sql` yang ada di folder proyek ini dan klik **Open** untuk mengeksekusi script database.

### 3. Konfigurasi Aplikasi
1.  Buka file `config.php` menggunakan editor teks (VS Code, dll).
2.  Pastikan pengaturan database sesuai (Default Laragon adalah `root` tanpa password):
    ```php
    $host = 'localhost';
    $dbname = 'laundry_outdoor';
    $username = 'root';
    $password = ''; 
    ```

### 4. Menjalankan Aplikasi
1.  Pindahkan atau copy folder proyek `outdoor_laundry` ke direktori root web Laragon di:
    `C:\laragon\www\outdoor_laundry`
2.  Akses melalui browser dengan URL:
    - **URL Standar**: `http://localhost/outdoor_laundry/`
    - **Pretty URL (Jika aktif)**: `http://outdoor_laundry.test/`

---

## 👥 Akun Demo untuk Pengujian
Gunakan akun berikut untuk mencoba masing-masing dashboard:

| Role | Email | Password |
| :--- | :--- | :--- |
| **Admin** | `admin@laundry.com` | `123456` |
| **Kurir** | `budi@laundry.com` | `123456` |
| **Customer** | `test@gmail.com` | `123456` |
| **Customer (Personal)** | `azizdhisa18@gmail.com` | `123456` |

> 💡 **Notifikasi Email Real-Time (Lupa Password)**:  
> Untuk mengaktifkan pengiriman email reset password real-time ke akun Gmail Anda:
> 1. Buka file [`mail_config.php`](file:///c:/laragon/www/OutdoorLaundry-main/mail_config.php).
> 2. Masukkan 16 Digit **Google App Password** Anda pada baris `'smtp_pass' => 'xxxx xxxx xxxx xxxx'`.

---

## 🧪 Tabel Pengujian (Daily Project 6)
Pengujian sistem dilakukan berdasarkan Use Case yang telah dirancang untuk memastikan kualitas dan fungsionalitas fitur *OutdoorLaundry*.

| ID | Fitur / Use Case | Langkah Pengujian (Pseudocode) | Input | Output yang Diharapkan | Hasil Uji | Status |
|:---|:---|:---|:---|:---|:---|:---|
| **UC-01** | **Registrasi & Login** | `register(user_data)` -> `login(email, pass)` | Nama, Email, Password | Akses dashboard sesuai role | Dashboard Terbuka | ✅ Pass |
| **UC-02** | **Input Data Gear** | `customer -> add_gear(gear_info)` | Nama Gear, Kategori (Carrier) | Gear tersimpan di database | Tersimpan | ✅ Pass |
| **UC-03** | **Booking Laundry** | `customer -> select_gear -> create_order` | Gear ID, Jadwal Pickup | Pesanan masuk ke daftar tracking | Order Berhasil | ✅ Pass |
| **UC-05** | **Estimasi Harga** | `js_logic -> calculate(gear, conditions)` | Lumpur, Jamur, Gore-Tex | Harga total berubah real-time | Rp 110.000 | ✅ Pass |
| **UC-06** | **Request Pickup** | `booking -> set_pickup_schedule` | Tanggal & Jam Pickup | Jadwal tercatat untuk kurir | Terjadwal | ✅ Pass |
| **UC-07** | **Tracking Status** | `admin -> update_status('Dicuci')` | Status: "Dicuci" | Status di customer berubah | Real-time Update | ✅ Pass |
| **UC-08** | **Pembayaran** | `customer -> upload_proof` | Foto Struk Transfer | Bukti pembayaran tersimpan | Terkirim | ✅ Pass |
| **UC-09** | **Gunakan Promo** | `booking -> apply_promo('OUTDOOR10')` | Kode: OUTDOOR10 | Harga dipotong diskon 10% | Diskon Aktif | ✅ Pass |
| **UC-10** | **Lihat Riwayat** | `customer -> gear_history(id)` | Klik "Lihat Riwayat" | Muncul modal riwayat cuci gear | Muncul Modal | ✅ Pass |
| **UC-14** | **Update Status** | `admin -> set_status('Re-coating')` | Status: "Re-coating" | Log tracking bertambah | Log Terupdate | ✅ Pass |
| **UC-15** | **Upload Foto** | `kurir -> upload_photo(pickup_proof)` | File Gambar (.jpg) | Foto tampil di detail tracking | Foto Tersimpan | ✅ Pass |
| **UC-16** | **Validasi Bayar** | `admin -> validate_payment(order_id)` | Klik Tombol "Validasi" | Status bayar menjadi "Paid" | Status: Paid | ✅ Pass |
| **UC-18** | **Jadwal Pickup** | `kurir -> view_assigned_tasks` | Login Role: Kurir | Muncul list tugas jemputan | List Muncul | ✅ Pass |
| **UC-19** | **Ambil Barang** | `kurir -> update_status('Dijemput')` | Status: "Dijemput" | Status berubah & tercatat | Berhasil | ✅ Pass |
| **UC-20** | **Antar Barang** | `kurir -> update_status('Selesai')` | Status: "Selesai" | Order tertutup & masuk history | Completed | ✅ Pass |

---

## 🛠️ Rancangan Fitur Unggulan (New Product)
Berdasarkan analisis Daily Project 6, sistem ini telah mengimplementasikan:
1.  **Klasifikasi Item Outdoor**: Penanganan khusus untuk Carrier, Tenda, Jaket, dll.
2.  **Smart Recommendation**: Logika otomatis yang menyarankan treatment berdasarkan kondisi barang (Lumpur, Jamur, dll).
3.  **Treatment Spesifik**: Dukungan untuk *Gore-Tex Re-coating* (Waterproofing ulang).
4.  **Tracking Visual**: Timeline progress cucian yang melampaui laundry biasa.
5.  **Edukasi Gear**: Modal tips perawatan khusus bahan teknis seperti Gore-Tex.
6.  **Eco-Friendly**: Tracking penggunaan air (simulasi) untuk mendukung gerakan ramah lingkungan.


