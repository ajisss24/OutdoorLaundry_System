<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Outdoor Laundry</title>
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
    
    <div class="w-full max-w-[1000px] bg-white rounded-[2rem] shadow-xl overflow-hidden flex flex-col md:flex-row my-8">
        <!-- Left: Form -->
        <div class="w-full md:w-1/2 p-8 sm:p-12 flex flex-col justify-center bg-white order-2 md:order-1">
            <div class="mb-8">
                <a href="index.php" class="flex items-center mb-6 text-brand-500 w-fit hover:scale-105 transition-transform">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10Z"/><path d="M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12"/></svg>
                    <span class="font-display text-xl font-bold tracking-tight text-slate-900">OutdoorLaundry</span>
                </a>
                <h1 class="font-display text-3xl font-bold text-slate-900">Buat Akun Baru</h1>
                <p class="text-slate-500 mt-2 text-sm">Daftar sekarang untuk nikmati layanan cuci gear premium.</p>
            </div>

            <?php if (isset($_GET['error'])): ?>
                <div class="bg-red-50 border border-red-100 text-red-600 p-4 rounded-2xl mb-6 flex items-start text-sm font-medium">
                    <svg class="w-5 h-5 mr-2 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>Pendaftaran gagal. Email mungkin sudah terdaftar.</span>
                </div>
            <?php endif; ?>

            <form action="auth_process.php" method="POST" class="space-y-4">
                <input type="hidden" name="action" value="register">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5 ml-1">Nama Lengkap</label>
                    <input type="text" name="name" required placeholder="Budi Pendaki" class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-full focus:ring-2 focus:ring-brand-500 focus:border-brand-500 focus:bg-white transition-all outline-none text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5 ml-1">Email Address</label>
                    <input type="email" name="email" required placeholder="pendaki@example.com" class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-full focus:ring-2 focus:ring-brand-500 focus:border-brand-500 focus:bg-white transition-all outline-none text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5 ml-1">Password</label>
                    <input type="password" name="password" required placeholder="Minimal 6 karakter" class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-full focus:ring-2 focus:ring-brand-500 focus:border-brand-500 focus:bg-white transition-all outline-none text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5 ml-1">No. Handphone (WA)</label>
                    <input type="text" name="phone" required placeholder="08123456789" class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-full focus:ring-2 focus:ring-brand-500 focus:border-brand-500 focus:bg-white transition-all outline-none text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5 ml-1">Alamat Domisili</label>
                    <textarea name="address" required rows="2" placeholder="Jl. Raya Pendakian No.1..." class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-2xl focus:ring-2 focus:ring-brand-500 focus:border-brand-500 focus:bg-white transition-all outline-none text-sm"></textarea>
                </div>
                <button type="submit" class="w-full bg-brand-500 text-white py-3.5 mt-2 rounded-full font-bold shadow-lg shadow-brand-500/30 hover:bg-brand-600 hover:shadow-brand-500/40 transform hover:-translate-y-0.5 transition-all duration-200">
                    Daftar Sekarang
                </button>
            </form>
            
            <p class="mt-6 text-center text-sm text-slate-500">
                Sudah memiliki akun? 
                <a href="login.php" class="text-brand-500 font-bold hover:text-brand-600 transition-colors">Masuk di sini</a>
            </p>
        </div>

        <!-- Right: Image / Branding -->
        <div class="w-full md:w-1/2 relative bg-brand-500 overflow-hidden hidden md:block order-1 md:order-2">
            <img src="https://images.unsplash.com/photo-1501555088652-021faa106b9b?q=80&w=2073&auto=format&fit=crop" alt="Camping Tent" class="absolute inset-0 w-full h-full object-cover opacity-30 mix-blend-multiply grayscale">
            <div class="absolute inset-0 bg-gradient-to-t from-brand-900/90 via-transparent to-transparent"></div>
            <div class="relative z-10 flex flex-col justify-end p-12 w-full h-full text-white">
                <div class="bg-white/10 backdrop-blur-md p-6 rounded-2xl border border-white/20 mb-8 inline-block max-w-sm">
                    <div class="flex items-center text-amber-400 mb-3">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                    </div>
                    <p class="text-white font-medium text-sm leading-relaxed">"Mantap! Carrier saya yang bau lumpur Semeru jadi wangi dan siap dipakai nge-camp lagi bulan depan."</p>
                    <p class="text-white/70 text-xs mt-3 font-bold uppercase tracking-wider">- Pendaki Aktif</p>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
