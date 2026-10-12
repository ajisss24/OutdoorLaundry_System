<?php
session_start();
require 'config.php';

$message = '';
$message_type = '';
$reset_link = '';
$submitted_email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $submitted_email = $email;

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Format email tidak valid. Masukkan alamat email yang benar.";
        $message_type = "error";
    } else {
        // Cek apakah user dengan email tersebut terdaftar
        $stmt = $pdo->prepare("SELECT id, name, email FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user) {
            // Generate token acak yang aman
            $token = bin2hex(random_bytes(32));
            $expires_at = date('Y-m-d H:i:s', strtotime('+1 hour'));

            // Hapus token reset lama untuk email ini
            $delStmt = $pdo->prepare("DELETE FROM password_resets WHERE email = ?");
            $delStmt->execute([$email]);

            // Simpan token baru (berlaku 1 jam)
            $insStmt = $pdo->prepare("INSERT INTO password_resets (email, token, expires_at) VALUES (?, ?, DATE_ADD(NOW(), INTERVAL 1 HOUR))");
            $insStmt->execute([$email, $token]);

            // Tentukan URL reset
            $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
            $host = $_SERVER['HTTP_HOST'];
            $dir = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
            $reset_link = "{$protocol}{$host}{$dir}/reset_password.php?token={$token}";

            // Kirim email real-time via PHPMailer / Gmail SMTP
            require_once 'mailer.php';
            $mail_status = sendResetPasswordEmail($email, $user['name'], $reset_link);

            if (!empty($mail_status['success'])) {
                $message = "Tautan reset password telah berhasil dikirim ke alamat Gmail Anda (" . htmlspecialchars($submitted_email) . "). Silakan periksa Kotak Masuk (Inbox) atau folder Spam!";
                $message_type = "success";
            } elseif (isset($mail_status['configured']) && $mail_status['configured'] === false) {
                $message = "Permintaan reset dibuat. Untuk mengirimkan email langsung ke Gmail secara real-time, silakan lengkapi Sandi Aplikasi (App Password) di file mail_config.php.";
                $message_type = "warning";
            } else {
                $message = "Gagal mengirim email real-time: " . ($mail_status['message'] ?? 'Kesalahan SMTP.') . " Tautan reset darurat dapat dilihat di bawah.";
                $message_type = "warning";
            }
        } else {
            $message = "Email tidak terdaftar dalam sistem kami. Silakan periksa kembali atau daftar akun baru.";
            $message_type = "error";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - Outdoor Laundry</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Poppins:wght@500;700;800&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        display: ['Poppins', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#FFF8F5',
                            100: '#FDF4F0',
                            500: '#F05023',
                            600: '#D9451D',
                            700: '#B83512',
                            900: '#7A2209',
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-brand-50 min-h-screen font-sans flex items-center justify-center p-4">
    
    <div class="w-full max-w-[1000px] bg-white rounded-[2rem] shadow-xl overflow-hidden flex flex-col md:flex-row">
        <!-- Left: Branding -->
        <div class="w-full md:w-1/2 relative bg-brand-500 overflow-hidden hidden md:block">
            <img src="https://images.unsplash.com/photo-1510312305653-8ed496efae75?q=80&w=1974&auto=format&fit=crop" alt="Camping Outdoor" class="absolute inset-0 w-full h-full object-cover opacity-35 mix-blend-multiply grayscale">
            <div class="absolute inset-0 bg-gradient-to-t from-brand-900/90 to-transparent"></div>
            <div class="relative z-10 flex flex-col justify-end p-12 w-full h-full text-white">
                <a href="login.php" class="absolute top-8 left-8 flex items-center text-white/80 hover:text-white transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path d="m15 18-6-6 6-6"/></svg>
                    Kembali ke Login
                </a>
                <h2 class="font-display text-4xl font-bold mb-4 leading-tight">Keamanan Akun<br>Terjamin & Mudah.</h2>
                <p class="text-brand-100 text-sm max-w-sm">Pulihkan akses akun Anda dengan cepat agar perlengkapan outdoor Anda tetap terawat dan siap pendakian berikutnya.</p>
            </div>
        </div>

        <!-- Right: Form & Content -->
        <div class="w-full md:w-1/2 p-10 sm:p-14 flex flex-col justify-center bg-white">
            <div class="mb-8">
                <div class="flex items-center mb-6 text-brand-500">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10Z"/><path d="M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12"/></svg>
                    <span class="font-display text-xl font-bold tracking-tight text-slate-900">OutdoorLaundry</span>
                </div>
                <h1 class="font-display text-3xl font-bold text-slate-900">Lupa Password?</h1>
                <p class="text-slate-500 mt-2 text-sm">Masukkan email yang terdaftar untuk menerima tautan pemulihan kata sandi Anda.</p>
            </div>

            <?php if ($message_type === 'error'): ?>
                <div class="bg-red-50 border border-red-100 text-red-600 p-4 rounded-2xl mb-6 flex items-start text-sm font-medium">
                    <svg class="w-5 h-5 mr-2.5 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span><?= htmlspecialchars($message) ?></span>
                </div>
            <?php endif; ?>

            <?php if ($message_type === 'warning'): ?>
                <div class="bg-amber-50 border border-amber-200 text-amber-900 p-5 rounded-2xl mb-6">
                    <div class="flex items-start">
                        <svg class="w-6 h-6 mr-3 mt-0.5 shrink-0 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        <div>
                            <h3 class="font-bold text-amber-900 text-sm">Token Reset Dibuat (Perhatian Pengiriman Email)</h3>
                            <p class="text-xs text-amber-800 mt-1"><?= $message ?></p>
                        </div>
                    </div>

                    <!-- Direct Link Fallback -->
                    <div class="mt-4 pt-4 border-t border-amber-200 bg-white/80 p-3 rounded-xl">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-semibold uppercase tracking-wider text-amber-900">Tautan Akses Langsung:</span>
                            <span class="text-[11px] bg-amber-100 text-amber-800 px-2 py-0.5 rounded-full font-medium">Bypass SMTP</span>
                        </div>
                        <div class="bg-slate-50 border border-slate-200 rounded-lg p-2.5 text-xs font-mono text-slate-700 break-all select-all mb-3">
                            <?= htmlspecialchars($reset_link) ?>
                        </div>
                        <a href="<?= htmlspecialchars($reset_link) ?>" class="inline-flex items-center justify-center w-full bg-brand-500 hover:bg-brand-600 text-white font-bold text-xs py-2.5 px-4 rounded-full transition-all shadow shadow-brand-500/20">
                            <span>Buka Halaman Reset Password Sekarang</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 ml-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </a>
                    </div>
                </div>
            <?php endif; ?>

            <?php if ($message_type === 'success'): ?>
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 p-5 rounded-2xl mb-6">
                    <div class="flex items-start">
                        <svg class="w-6 h-6 mr-3 mt-0.5 shrink-0 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <div>
                            <h3 class="font-bold text-emerald-900 text-sm">Notifikasi Terkirim ke Gmail Secara Real-Time!</h3>
                            <p class="text-xs text-emerald-700 mt-1"><?= $message ?></p>
                        </div>
                    </div>

                    <!-- Link Info Box -->
                    <div class="mt-4 pt-4 border-t border-emerald-200/60 bg-white/70 p-3 rounded-xl">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-semibold uppercase tracking-wider text-emerald-800">Tautan Pemulihan Kata Sandi:</span>
                            <span class="text-[11px] bg-emerald-100 text-emerald-800 px-2 py-0.5 rounded-full font-medium">Aktif 1 Jam</span>
                        </div>
                        <div class="bg-slate-50 border border-slate-200 rounded-lg p-2.5 text-xs font-mono text-slate-700 break-all select-all mb-3">
                            <?= htmlspecialchars($reset_link) ?>
                        </div>
                        <a href="<?= htmlspecialchars($reset_link) ?>" class="inline-flex items-center justify-center w-full bg-brand-500 hover:bg-brand-600 text-white font-bold text-xs py-2.5 px-4 rounded-full transition-all shadow shadow-brand-500/20">
                            <span>Buka Halaman Reset Password Sekarang</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 ml-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </a>
                    </div>
                </div>
            <?php endif; ?>

            <form action="forgot_password.php" method="POST" class="space-y-5">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5 ml-1">Email Terdaftar</label>
                    <input type="email" name="email" required value="<?= htmlspecialchars($submitted_email) ?>" placeholder="pendaki@example.com" class="w-full px-5 py-3.5 bg-slate-50 border border-slate-100 rounded-full focus:ring-2 focus:ring-brand-500 focus:border-brand-500 focus:bg-white transition-all outline-none text-sm">
                </div>
                <button type="submit" class="w-full bg-brand-500 text-white py-3.5 rounded-full font-bold shadow-lg shadow-brand-500/30 hover:bg-brand-600 hover:shadow-brand-500/40 transform hover:-translate-y-0.5 transition-all duration-200 mt-2">
                    Kirim Link Reset Password
                </button>
            </form>
            
            <p class="mt-8 text-center text-sm text-slate-500">
                Ingat password Anda? 
                <a href="login.php" class="text-brand-500 font-bold hover:text-brand-600 transition-colors">Kembali ke Login</a>
            </p>
        </div>
    </div>

</body>
</html>
