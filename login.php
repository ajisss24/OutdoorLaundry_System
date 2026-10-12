<?php
session_start();
if (isset($_SESSION['user_id'])) {
    if ($_SESSION['role'] == 'admin') header("Location: dashboard_admin.php");
    else if ($_SESSION['role'] == 'kurir') header("Location: dashboard_kurir.php");
    else header("Location: dashboard_customer.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Outdoor Laundry</title>
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
            <img src="https://images.unsplash.com/photo-1551632811-561732d1e306?q=80&w=2070&auto=format&fit=crop" alt="Hiking Mountain" class="absolute inset-0 w-full h-full object-cover opacity-30 mix-blend-multiply grayscale">
            <div class="absolute inset-0 bg-gradient-to-t from-brand-900/90 to-transparent"></div>
            <div class="relative z-10 flex flex-col justify-end p-12 w-full h-full text-white">
                <a href="index.php" class="absolute top-8 left-8 flex items-center text-white/80 hover:text-white transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path d="m15 18-6-6 6-6"/></svg>
                    Kembali
                </a>
                <h2 class="font-display text-4xl font-bold mb-4 leading-tight">Bersihkan Gearmu,<br>Siap Bertualang Lagi.</h2>
                <p class="text-brand-100 text-sm max-w-sm">Layanan laundry profesional khusus peralatan outdoor. Menggunakan treatment aman untuk material teknis.</p>
            </div>
        </div>

        <!-- Right: Form -->
        <div class="w-full md:w-1/2 p-10 sm:p-14 flex flex-col justify-center bg-white">
            <div class="mb-10">
                <div class="flex items-center mb-6 text-brand-500">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10Z"/><path d="M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12"/></svg>
                    <span class="font-display text-xl font-bold tracking-tight text-slate-900">OutdoorLaundry</span>
                </div>
                <h1 class="font-display text-3xl font-bold text-slate-900">Selamat Datang</h1>
                <p class="text-slate-500 mt-2 text-sm">Silakan login untuk mengelola layanan laundry gear Anda.</p>
            </div>

            <?php if (isset($_GET['reset']) && $_GET['reset'] === 'success'): ?>
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 p-4 rounded-2xl mb-6 flex items-start text-sm font-medium">
                    <svg class="w-5 h-5 mr-2 mt-0.5 shrink-0 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>Password berhasil direset! Silakan masuk menggunakan password baru Anda.</span>
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['error'])): ?>
                <div class="bg-red-50 border border-red-100 text-red-600 p-4 rounded-2xl mb-6 flex items-start text-sm font-medium">
                    <svg class="w-5 h-5 mr-2 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>Email atau password salah! Silakan periksa kembali.</span>
                </div>
            <?php endif; ?>

            <form action="auth_process.php" method="POST" class="space-y-5">
                <input type="hidden" name="action" value="login">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5 ml-1">Email Address</label>
                    <input type="email" name="email" required placeholder="pendaki@example.com" class="w-full px-5 py-3.5 bg-slate-50 border border-slate-100 rounded-full focus:ring-2 focus:ring-brand-500 focus:border-brand-500 focus:bg-white transition-all outline-none text-sm">
                </div>
                <div>
                    <div class="flex items-center justify-between mb-1.5 ml-1 mr-1">
                        <label class="block text-sm font-medium text-slate-700">Password</label>
                        <a href="forgot_password.php" class="text-xs font-semibold text-brand-500 hover:text-brand-600 hover:underline transition-colors">Lupa Password?</a>
                    </div>
                    <input type="password" name="password" required placeholder="••••••••" class="w-full px-5 py-3.5 bg-slate-50 border border-slate-100 rounded-full focus:ring-2 focus:ring-brand-500 focus:border-brand-500 focus:bg-white transition-all outline-none text-sm">
                </div>
                <button type="submit" class="w-full bg-brand-500 text-white py-3.5 rounded-full font-bold shadow-lg shadow-brand-500/30 hover:bg-brand-600 hover:shadow-brand-500/40 transform hover:-translate-y-0.5 transition-all duration-200 mt-2">
                    Masuk ke Dashboard
                </button>
            </form>
            
            <p class="mt-8 text-center text-sm text-slate-500">
                Belum memiliki akun? 
                <a href="register.php" class="text-brand-500 font-bold hover:text-brand-600 transition-colors">Daftar sekarang</a>
            </p>
        </div>
    </div>

</body>
</html>
