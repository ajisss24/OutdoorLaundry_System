<?php
// Template Konfigurasi SMTP Pengiriman Email (Contoh untuk GitHub)
// Salin file ini menjadi 'mail_config.php' lalu isi dengan kredensial akun Anda.

return [
    'smtp_host'   => 'smtp.gmail.com',
    'smtp_port'   => 587, // 587 untuk TLS, atau 465 untuk SSL
    'smtp_secure' => 'tls', // 'tls' atau 'ssl'
    'smtp_auth'   => true,
    'smtp_user'   => 'email_anda@gmail.com', // Email akun Google pengirim
    'smtp_pass'   => 'xxxx xxxx xxxx xxxx', // 16 Digit Sandi Aplikasi (App Password) Google
    'from_email'  => 'email_anda@gmail.com',
    'from_name'   => 'Outdoor Laundry Service',
];
