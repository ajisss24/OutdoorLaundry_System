<?php
session_start();
// Redirect if already logged in
if (isset($_SESSION['user_id'])) {
    if ($_SESSION['role'] == 'admin') header("Location: dashboard_admin.php");
    else if ($_SESSION['role'] == 'kurir') header("Location: dashboard_kurir.php");
    else header("Location: dashboard_customer.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Outdoor Laundry - Solusi Cuci Gear Anda</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Poppins:wght@500;600;700;800&display=swap" rel="stylesheet">
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
<body class="bg-white font-sans text-slate-800">

    <!-- Navbar -->
    <nav class="fixed w-full bg-white/90 backdrop-blur-md z-50 transition-all border-b border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <a href="#" class="flex items-center text-brand-500">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10Z"/><path d="M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12"/></svg>
                    <span class="font-display text-xl font-bold tracking-tight text-slate-900">OutdoorLaundry</span>
                </a>

                <!-- Desktop Menu -->
                <div class="hidden md:flex space-x-8 items-center">
                    <a href="#layanan" class="text-sm font-semibold text-slate-600 hover:text-brand-500 transition-colors">Layanan</a>
                    <a href="#cara-kerja" class="text-sm font-semibold text-slate-600 hover:text-brand-500 transition-colors">Cara Kerja</a>
                    <a href="#testimoni" class="text-sm font-semibold text-slate-600 hover:text-brand-500 transition-colors">Testimoni</a>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center space-x-3">
                    <a href="login.php" class="hidden md:inline-flex text-sm font-bold text-slate-700 hover:text-brand-500 transition-colors">Masuk</a>
                    <a href="register.php" class="bg-brand-500 text-white px-6 py-2.5 rounded-full text-sm font-bold hover:bg-brand-600 shadow-lg shadow-brand-500/30 transition-all transform hover:-translate-y-0.5">Daftar Sekarang</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden bg-brand-50">
        <!-- Abstract Shapes -->
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 rounded-full bg-brand-100/50 blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 rounded-full bg-brand-100/50 blur-3xl"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="flex flex-col lg:flex-row items-center">
                <div class="w-full lg:w-1/2 lg:pr-12 text-center lg:text-left mb-12 lg:mb-0">
                    <div class="inline-flex items-center px-3 py-1.5 rounded-full bg-brand-100 text-brand-600 font-bold text-xs mb-6 uppercase tracking-wider">
                        <span class="flex h-2 w-2 rounded-full bg-brand-500 mr-2 animate-pulse"></span>
                        Spesialis Gear Outdoor
                    </div>
                    <h1 class="font-display text-4xl sm:text-5xl lg:text-6xl font-extrabold text-slate-900 leading-tight mb-6">
                        Cuci <span class="text-brand-500">Gear</span> Mudah,<br>Petualangan Lanjut!
                    </h1>
                    <p class="text-lg text-slate-600 mb-8 max-w-xl mx-auto lg:mx-0 leading-relaxed">
                        Kami merawat carrier, tenda, sleeping bag, dan jaket Gore-Tex Anda dengan teknik pencucian khusus agar awet dan performa tetap maksimal.
                    </p>
                    <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start space-y-4 sm:space-y-0 sm:space-x-4">
                        <a href="register.php" class="w-full sm:w-auto bg-brand-500 text-white px-8 py-4 rounded-full font-bold text-lg hover:bg-brand-600 shadow-xl shadow-brand-500/30 transition-all transform hover:-translate-y-1">
                            Pesan Sekarang
                        </a>
                        <a href="#cara-kerja" class="w-full sm:w-auto bg-white text-slate-700 px-8 py-4 rounded-full font-bold text-lg hover:bg-slate-50 border border-slate-200 transition-all">
                            Cara Kerjanya?
                        </a>
                    </div>
                    
                    <div class="mt-10 flex items-center justify-center lg:justify-start space-x-6 text-sm font-semibold text-slate-500">
                        <div class="flex items-center"><svg class="w-5 h-5 text-brand-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Antar Jemput</div>
                        <div class="flex items-center"><svg class="w-5 h-5 text-brand-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Bebas Rusak</div>
                        <div class="flex items-center"><svg class="w-5 h-5 text-brand-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Cepat</div>
                    </div>
                </div>
                <div class="w-full lg:w-1/2 relative">
                    <img src="outdoor_gear_before_after_1777124102179.png" alt="Hiking Gear Before After" class="rounded-[2.5rem] shadow-2xl relative z-10 w-full aspect-square max-h-[520px] object-cover object-top mx-auto">
                    <!-- Decor badge -->
                    <div class="absolute -bottom-6 -left-6 bg-white p-4 rounded-2xl shadow-xl z-20 flex items-center animate-bounce" style="animation-duration: 3s;">
                        <div class="bg-green-100 p-3 rounded-xl mr-3">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500 font-bold uppercase">Estimasi Waktu</p>
                            <p class="text-sm font-bold text-slate-900">2-3 Hari Selesai</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Fitur / Layanan -->
    <section id="layanan" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="font-display text-3xl md:text-4xl font-bold text-slate-900 mb-4">Layanan Perawatan Maksimal</h2>
                <p class="text-slate-600 text-lg">Tidak asal cuci. Kami memahami karakteristik setiap material outdoor seperti Taslan, Gore-Tex, dan Down.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Card 1 -->
                <div class="bg-brand-50 rounded-[2rem] p-0 overflow-hidden transition-transform hover:-translate-y-2 duration-300 shadow-sm">
                    <img src="service_carrier_tent_1777124124533.png" alt="Cuci Carrier" class="w-full h-48 object-cover">
                    <div class="p-8">
                        <div class="bg-white w-12 h-12 rounded-xl flex items-center justify-center shadow-sm mb-4 -mt-14 relative z-10">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-brand-500"><path d="M20 16V7a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v9m16 0H4m16 0 1.28 2.55a1 1 0 0 1-.9 1.45H3.62a1 1 0 0 1-.9-1.45L4 16"/></svg>
                        </div>
                        <h3 class="font-display text-xl font-bold text-slate-900 mb-3">Cuci Carrier & Tenda</h3>
                        <p class="text-slate-600 text-sm leading-relaxed">Pembersihan lumpur mendalam dan penghilangan bau tak sedap tanpa merusak struktur dan lapisan coating bawaan.</p>
                    </div>
                </div>
                <!-- Card 2 -->
                <div class="bg-brand-50 rounded-[2rem] p-0 overflow-hidden transition-transform hover:-translate-y-2 duration-300 shadow-sm">
                    <img src="service_reproof_goretex_1777124311459.png" alt="Reproof Gore-Tex" class="w-full h-48 object-cover">
                    <div class="p-8">
                        <div class="bg-white w-12 h-12 rounded-xl flex items-center justify-center shadow-sm mb-4 -mt-14 relative z-10">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-brand-500"><path d="M2 12h20"/><path d="M20 12v8a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-8"/><path d="M4 6v6"/><path d="M20 6v6"/><path d="M4 6a8 8 0 0 1 16 0"/></svg>
                        </div>
                        <h3 class="font-display text-xl font-bold text-slate-900 mb-3">Reproof Gore-Tex</h3>
                        <p class="text-slate-600 text-sm leading-relaxed">Jaket kesayangan Anda bocor atau merembes? Kami menggunakan chemical khusus untuk mengembalikan sifat Water Repellent (DWR).</p>
                    </div>
                </div>
                <!-- Card 3 -->
                <div class="bg-brand-50 rounded-[2rem] p-0 overflow-hidden transition-transform hover:-translate-y-2 duration-300 shadow-sm">
                    <img src="service_transparent_price_1777124365809.png" alt="Harga Transparan" class="w-full h-48 object-cover">
                    <div class="p-8">
                        <div class="bg-white w-12 h-12 rounded-xl flex items-center justify-center shadow-sm mb-4 -mt-14 relative z-10">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-brand-500"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                        </div>
                        <h3 class="font-display text-xl font-bold text-slate-900 mb-3">Harga Transparan</h3>
                        <p class="text-slate-600 text-sm leading-relaxed">Hitung estimasi harga langsung dari aplikasi. Pilih metode pembayaran favorit Anda termasuk COD dan E-Wallet.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How it works -->
    <section id="cara-kerja" class="py-20 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="font-display text-3xl md:text-4xl font-bold text-slate-900 mb-4">Cara Kerja Kami</h2>
                <p class="text-slate-600 text-lg">Hanya 4 langkah mudah, gear Anda bersih kembali.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 relative">
                <!-- Line connector for desktop -->
                <div class="hidden md:block absolute top-1/4 left-1/8 w-3/4 h-0.5 bg-brand-200 z-0"></div>
                
                <!-- Step 1 -->
                <div class="relative z-10 flex flex-col items-center text-center">
                    <div class="w-16 h-16 rounded-full bg-brand-500 text-white flex items-center justify-center font-display font-bold text-2xl mb-6 shadow-lg shadow-brand-500/40">1</div>
                    <h4 class="font-bold text-slate-900 mb-2">Booking Online</h4>
                    <p class="text-sm text-slate-500">Daftar akun dan pilih jadwal penjemputan gear Anda.</p>
                </div>
                <!-- Step 2 -->
                <div class="relative z-10 flex flex-col items-center text-center mt-8 md:mt-0">
                    <div class="w-16 h-16 rounded-full bg-white border-4 border-brand-500 text-brand-500 flex items-center justify-center font-display font-bold text-2xl mb-6 shadow-sm">2</div>
                    <h4 class="font-bold text-slate-900 mb-2">Kurir Menjemput</h4>
                    <p class="text-sm text-slate-500">Tim kami akan mengambil gear langsung dari rumah Anda.</p>
                </div>
                <!-- Step 3 -->
                <div class="relative z-10 flex flex-col items-center text-center mt-8 md:mt-0">
                    <div class="w-16 h-16 rounded-full bg-white border-4 border-brand-500 text-brand-500 flex items-center justify-center font-display font-bold text-2xl mb-6 shadow-sm">3</div>
                    <h4 class="font-bold text-slate-900 mb-2">Proses Cuci</h4>
                    <p class="text-sm text-slate-500">Gear dicuci sesuai treatment, Anda bisa pantau statusnya.</p>
                </div>
                <!-- Step 4 -->
                <div class="relative z-10 flex flex-col items-center text-center mt-8 md:mt-0">
                    <div class="w-16 h-16 rounded-full bg-white border-4 border-brand-500 text-brand-500 flex items-center justify-center font-display font-bold text-2xl mb-6 shadow-sm">4</div>
                    <h4 class="font-bold text-slate-900 mb-2">Selesai & Diantar</h4>
                    <p class="text-sm text-slate-500">Gear wangi dan siap digunakan untuk pendakian selanjutnya!</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Community Reviews Section -->
    <section id="testimoni" class="py-20 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="font-display text-3xl md:text-4xl font-bold text-slate-900 mb-4">Apa Kata Pendaki Lain?</h2>
                <p class="text-slate-600 text-lg">Kepercayaan ribuan petualang adalah prioritas kami.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-6">
                <!-- Review 1 -->
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
                    <div class="flex text-amber-400 mb-3">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    </div>
                    <p class="text-slate-600 text-xs mb-4 italic">"Jaket Gore-Tex saya jadi kayak baru lagi airnya ngalir doang!"</p>
                    <div class="flex items-center">
                        <div class="w-8 h-8 rounded-full bg-slate-200 mr-2"></div>
                        <div>
                            <p class="text-xs font-bold text-slate-900">Aris</p>
                            <p class="text-[10px] text-slate-500">Pendaki Lawu</p>
                        </div>
                    </div>
                </div>
                <!-- Review 2 -->
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
                    <div class="flex text-amber-400 mb-3">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    </div>
                    <p class="text-slate-600 text-xs mb-4 italic">"Kurirnya tepat waktu dan carrier saya wangi banget!"</p>
                    <div class="flex items-center">
                        <div class="w-8 h-8 rounded-full bg-slate-200 mr-2"></div>
                        <div>
                            <p class="text-xs font-bold text-slate-900">Budi</p>
                            <p class="text-[10px] text-slate-500">Pecinta Alam</p>
                        </div>
                    </div>
                </div>
                <!-- Review 3 -->
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
                    <div class="flex text-amber-400 mb-3">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    </div>
                    <p class="text-slate-600 text-xs mb-4 italic">"Gak nyangka tenda kotor sisa muncak bisa bersih total!"</p>
                    <div class="flex items-center">
                        <div class="w-8 h-8 rounded-full bg-slate-200 mr-2"></div>
                        <div>
                            <p class="text-xs font-bold text-slate-900">Citra</p>
                            <p class="text-[10px] text-slate-500">Backpacker</p>
                        </div>
                    </div>
                </div>
                <!-- Review 4 -->
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
                    <div class="flex text-amber-400 mb-3">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    </div>
                    <p class="text-slate-600 text-xs mb-4 italic">"Harga bersahabat tapi hasilnya bener-bener pro."</p>
                    <div class="flex items-center">
                        <div class="w-8 h-8 rounded-full bg-slate-200 mr-2"></div>
                        <div>
                            <p class="text-xs font-bold text-slate-900">Dedi</p>
                            <p class="text-[10px] text-slate-500">Solo Traveler</p>
                        </div>
                    </div>
                </div>
                <!-- Review 5 -->
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
                    <div class="flex text-amber-400 mb-3">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    </div>
                    <p class="text-slate-600 text-xs mb-4 italic">"Sangat terbantu buat yang gak sempet cuci tenda sendiri."</p>
                    <div class="flex items-center">
                        <div class="w-8 h-8 rounded-full bg-slate-200 mr-2"></div>
                        <div>
                            <p class="text-xs font-bold text-slate-900">Eka</p>
                            <p class="text-[10px] text-slate-500">Hiker</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-brand-500 rounded-[3rem] p-10 md:p-16 text-center relative overflow-hidden shadow-2xl shadow-brand-500/20">
                <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10 mix-blend-overlay"></div>
                <h2 class="font-display text-3xl md:text-5xl font-bold text-white mb-6 relative z-10">Siap mencuci gear kotor Anda?</h2>
                <p class="text-brand-100 text-lg mb-10 max-w-2xl mx-auto relative z-10">Gunakan kode promo <span class="font-bold text-white bg-brand-600 px-3 py-1 rounded-lg">OUTDOOR10</span> untuk mendapatkan diskon 10% pada pesanan pertama Anda.</p>
                <a href="register.php" class="inline-block bg-white text-brand-600 font-bold text-lg px-10 py-4 rounded-full shadow-xl hover:scale-105 transition-transform relative z-10">
                    Mulai Sekarang
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-slate-900 text-slate-300 py-12 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <div class="col-span-1 md:col-span-2">
                    <a href="#" class="flex items-center text-brand-500 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10Z"/><path d="M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12"/></svg>
                        <span class="font-display text-xl font-bold tracking-tight text-white">OutdoorLaundry</span>
                    </a>
                    <p class="text-sm text-slate-400 max-w-sm leading-relaxed">Platform layanan cuci perlengkapan outdoor pertama yang memberikan garansi kualitas dan layanan antar jemput gratis.</p>
                </div>
                <div>
                    <h4 class="text-white font-bold mb-4 uppercase text-xs tracking-wider">Perusahaan</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-brand-500 transition-colors">Tentang Kami</a></li>
                        <li><a href="#layanan" class="hover:text-brand-500 transition-colors">Layanan</a></li>
                        <li><a href="https://wa.me/6281234567890" target="_blank" class="hover:text-brand-500 transition-colors">Kontak (WhatsApp)</a></li>
                        <li class="flex space-x-3 mt-4">
                            <a href="https://twitter.com" target="_blank" class="text-slate-400 hover:text-white transition-colors">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
                            </a>
                            <a href="https://instagram.com" target="_blank" class="text-slate-400 hover:text-white transition-colors">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.584.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4s1.791-4 4-4 4 1.791 4 4-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                            </a>
                        </li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-bold mb-4 uppercase text-xs tracking-wider">Bantuan</h4>
                    <ul class="space-y-2 text-sm">
                        <li><button onclick="showHelp('FAQ', 'faq')" class="hover:text-brand-500 transition-colors text-left">FAQ</button></li>
                        <li><button onclick="showHelp('Syarat & Ketentuan', 'snk')" class="hover:text-brand-500 transition-colors text-left">Syarat & Ketentuan</button></li>
                        <li><button onclick="showHelp('Kebijakan Privasi', 'privacy')" class="hover:text-brand-500 transition-colors text-left">Kebijakan Privasi</button></li>
                    </ul>
                </div>
            </div>
            <div class="pt-8 border-t border-slate-800 text-sm text-center text-slate-500">
                &copy; <?= date('Y') ?> OutdoorLaundry System. All rights reserved.
            </div>
        </div>
    </footer>

    <!-- Custom Modal for Help -->
    <div id="helpModal" class="hidden fixed inset-0 z-[100] overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity bg-slate-900/60 backdrop-blur-sm" onclick="closeHelp()"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
            <div class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-[2.5rem] shadow-2xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="px-8 pt-8 pb-6 bg-white">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-2xl font-display font-bold text-slate-900" id="helpTitle"></h3>
                        <button onclick="closeHelp()" class="text-slate-400 hover:text-slate-600 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                    <div class="text-slate-600 leading-relaxed space-y-4" id="helpContent">
                        <!-- Content will be injected here -->
                    </div>
                </div>
                <div class="px-8 py-6 bg-slate-50 flex justify-end">
                    <button onclick="closeHelp()" class="bg-brand-500 text-white px-8 py-3 rounded-full font-bold text-sm hover:bg-brand-600 shadow-lg shadow-brand-500/20 transition-all">
                        Mengerti
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showHelp(title, type) {
            const modal = document.getElementById('helpModal');
            const titleEl = document.getElementById('helpTitle');
            const contentEl = document.getElementById('helpContent');
            
            titleEl.innerText = title;
            
            let html = '';
            if (type === 'faq') {
                html = `
                    <div class="space-y-4">
                        <div class="bg-brand-50 p-4 rounded-2xl">
                            <p class="font-bold text-brand-700 mb-1">Berapa lama proses pencucian?</p>
                            <p class="text-sm text-slate-600">Proses standar memakan waktu 2-3 hari kerja tergantung jenis gear.</p>
                        </div>
                        <div class="bg-brand-50 p-4 rounded-2xl">
                            <p class="font-bold text-brand-700 mb-1">Apakah ada garansi jika gear rusak?</p>
                            <p class="text-sm text-slate-600">Ya, kami memberikan garansi penggantian atau perbaikan jika kerusakan terjadi akibat kelalaian tim kami.</p>
                        </div>
                        <div class="bg-brand-50 p-4 rounded-2xl">
                            <p class="font-bold text-brand-700 mb-1">Apakah melayani antar-jemput?</p>
                            <p class="text-sm text-slate-600">Ya, kami melayani antar-jemput gratis untuk area jangkauan tertentu.</p>
                        </div>
                    </div>
                `;
            } else if (type === 'snk') {
                html = `
                    <ul class="list-disc pl-5 text-sm space-y-2">
                        <li>Gear yang akan dicuci harus dalam kondisi tidak robek parah (kecuali untuk reparasi).</li>
                        <li>Kami tidak bertanggung jawab atas barang berharga yang tertinggal di dalam gear.</li>
                        <li>Pembayaran dilakukan di awal atau saat penjemputan barang.</li>
                        <li>Estimasi waktu dapat berubah jika ada kendala cuaca pada proses pengeringan alami.</li>
                    </ul>
                `;
            } else if (type === 'privacy') {
                html = `
                    <p class="text-sm">Kami sangat menghargai privasi Anda. Data yang kami kumpulkan hanya digunakan untuk:</p>
                    <ul class="list-disc pl-5 text-sm space-y-2">
                        <li>Proses penjemputan dan pengantaran barang.</li>
                        <li>Informasi status pesanan melalui WhatsApp/Email.</li>
                        <li>Pemberian promo khusus member.</li>
                    </ul>
                    <p class="text-sm">Kami tidak akan pernah membagikan data Anda kepada pihak ketiga tanpa izin Anda.</p>
                `;
            }
            
            contentEl.innerHTML = html;
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeHelp() {
            document.getElementById('helpModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
    </script>
</body>
</html>
