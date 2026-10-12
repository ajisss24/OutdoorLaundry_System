<?php
session_start();
require 'config.php';

$token = trim($_GET['token'] ?? $_POST['token'] ?? '');
$token_valid = false;
$reset_record = null;
$error_message = '';

if (empty($token)) {
    $error_message = "Token reset password tidak ditemukan.";
} else {
    // Cek apakah token ada dan belum kadaluwarsa
    $stmt = $pdo->prepare("SELECT * FROM password_resets WHERE token = ? AND expires_at > NOW() ORDER BY id DESC LIMIT 1");
    $stmt->execute([$token]);
    $reset_record = $stmt->fetch();

    if ($reset_record) {
        $token_valid = true;
    } else {
        $error_message = "Tautan reset password sudah tidak berlaku atau sudah kadaluwarsa. Silakan ajukan permintaan baru.";
    }
}

// Proses submit ganti password baru
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $token_valid) {
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if (strlen($new_password) < 6) {
        $error_message = "Password baru minimal terdiri dari 6 karakter.";
    } elseif ($new_password !== $confirm_password) {
        $error_message = "Konfirmasi password baru tidak cocok. Pastikan kedua kolom sama.";
    } else {
        // Hash password baru
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        // Update password di tabel users
        $updateStmt = $pdo->prepare("UPDATE users SET password = ? WHERE email = ?");
        $updateStmt->execute([$hashed_password, $reset_record['email']]);

        // Hapus token yang sudah digunakan
        $delStmt = $pdo->prepare("DELETE FROM password_resets WHERE email = ?");
        $delStmt->execute([$reset_record['email']]);

        // Redirect ke login dengan status success
        header("Location: login.php?reset=success");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Outdoor Laundry</title>
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
            <img src="https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?q=80&w=2070&auto=format&fit=crop" alt="Mountain Peak" class="absolute inset-0 w-full h-full object-cover opacity-35 mix-blend-multiply grayscale">
            <div class="absolute inset-0 bg-gradient-to-t from-brand-900/90 to-transparent"></div>
            <div class="relative z-10 flex flex-col justify-end p-12 w-full h-full text-white">
                <a href="login.php" class="absolute top-8 left-8 flex items-center text-white/80 hover:text-white transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path d="m15 18-6-6 6-6"/></svg>
                    Batal & Kembali
                </a>
                <h2 class="font-display text-4xl font-bold mb-4 leading-tight">Buat Password<br>Baru yang Kuat.</h2>
                <p class="text-brand-100 text-sm max-w-sm">Pastikan kata sandi baru Anda mudah diingat namun sulit ditebak oleh orang lain.</p>
            </div>
        </div>

        <!-- Right: Form & Token Status -->
        <div class="w-full md:w-1/2 p-10 sm:p-14 flex flex-col justify-center bg-white">
            <div class="mb-8">
                <div class="flex items-center mb-6 text-brand-500">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10Z"/><path d="M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12"/></svg>
                    <span class="font-display text-xl font-bold tracking-tight text-slate-900">OutdoorLaundry</span>
                </div>
                <h1 class="font-display text-3xl font-bold text-slate-900">Atur Ulang Password</h1>
                <p class="text-slate-500 mt-2 text-sm">
                    <?php if ($token_valid): ?>
                        Memperbarui password untuk akun: <span class="font-semibold text-slate-800"><?= htmlspecialchars($reset_record['email']) ?></span>
                    <?php else: ?>
                        Verifikasi token pemulihan akun.
                    <?php endif; ?>
                </p>
            </div>

            <?php if (!empty($error_message)): ?>
                <div class="bg-red-50 border border-red-100 text-red-600 p-4 rounded-2xl mb-6 flex items-start text-sm font-medium">
                    <svg class="w-5 h-5 mr-2.5 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span><?= htmlspecialchars($error_message) ?></span>
                </div>
            <?php endif; ?>

            <?php if (!$token_valid): ?>
                <div class="bg-slate-50 border border-slate-200/80 rounded-2xl p-6 text-center space-y-4">
                    <div class="w-12 h-12 bg-amber-100 text-amber-600 rounded-full flex items-center justify-center mx-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    </div>
                    <p class="text-sm text-slate-600">Tautan reset ini mungkin telah kedaluwarsa atau sudah pernah digunakan sebelumnya.</p>
                    <a href="forgot_password.php" class="inline-flex items-center justify-center w-full bg-brand-500 hover:bg-brand-600 text-white font-bold text-sm py-3 px-6 rounded-full transition-all shadow-md shadow-brand-500/20">
                        Minta Tautan Reset Baru
                    </a>
                </div>
            <?php else: ?>
                <form action="reset_password.php" method="POST" id="resetForm" class="space-y-5">
                    <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
                    
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5 ml-1">Password Baru</label>
                        <div class="relative">
                            <input type="password" id="new_password" name="new_password" required minlength="6" placeholder="Minimal 6 karakter" class="w-full px-5 py-3.5 pr-12 bg-slate-50 border border-slate-100 rounded-full focus:ring-2 focus:ring-brand-500 focus:border-brand-500 focus:bg-white transition-all outline-none text-sm">
                            <button type="button" onclick="toggleVisibility('new_password', this)" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 eye-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </button>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5 ml-1">Ulangi Password Baru</label>
                        <div class="relative">
                            <input type="password" id="confirm_password" name="confirm_password" required minlength="6" placeholder="Ulangi password baru" class="w-full px-5 py-3.5 pr-12 bg-slate-50 border border-slate-100 rounded-full focus:ring-2 focus:ring-brand-500 focus:border-brand-500 focus:bg-white transition-all outline-none text-sm">
                            <button type="button" onclick="toggleVisibility('confirm_password', this)" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 eye-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </button>
                        </div>
                        <p id="matchWarning" class="text-xs text-red-500 mt-1 ml-2 hidden">Konfirmasi password tidak cocok!</p>
                    </div>

                    <button type="submit" id="submitBtn" class="w-full bg-brand-500 text-white py-3.5 rounded-full font-bold shadow-lg shadow-brand-500/30 hover:bg-brand-600 hover:shadow-brand-500/40 transform hover:-translate-y-0.5 transition-all duration-200 mt-2">
                        Simpan Password Baru
                    </button>
                </form>

                <script>
                    function toggleVisibility(inputId, btn) {
                        const input = document.getElementById(inputId);
                        if (input.type === 'password') {
                            input.type = 'text';
                            btn.classList.add('text-brand-500');
                        } else {
                            input.type = 'password';
                            btn.classList.remove('text-brand-500');
                        }
                    }

                    const newPass = document.getElementById('new_password');
                    const confPass = document.getElementById('confirm_password');
                    const warning = document.getElementById('matchWarning');
                    const submitBtn = document.getElementById('submitBtn');

                    function validateMatch() {
                        if (confPass.value.length > 0 && newPass.value !== confPass.value) {
                            warning.classList.remove('hidden');
                        } else {
                            warning.classList.add('hidden');
                        }
                    }

                    newPass.addEventListener('input', validateMatch);
                    confPass.addEventListener('input', validateMatch);
                </script>
            <?php endif; ?>
            
            <p class="mt-8 text-center text-sm text-slate-500">
                <a href="login.php" class="text-brand-500 font-bold hover:text-brand-600 transition-colors">Kembali ke Halaman Login</a>
            </p>
        </div>
    </div>

</body>
</html>
