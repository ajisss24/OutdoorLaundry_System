<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'customer') {
    header("Location: index.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch Gears
$stmt = $pdo->prepare("SELECT * FROM gears WHERE user_id = ?");
$stmt->execute([$user_id]);
$gears = $stmt->fetchAll();

// Fetch Bookings
$stmt = $pdo->prepare("SELECT b.*, g.name as gear_name FROM bookings b JOIN gears g ON b.gear_id = g.id WHERE b.user_id = ? ORDER BY b.created_at DESC");
$stmt->execute([$user_id]);
$bookings = $stmt->fetchAll();

// Fetch Treatments
$stmt = $pdo->prepare("SELECT * FROM treatments");
$stmt->execute();
$treatments = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashboard - Outdoor Laundry</title>
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
<body class="bg-slate-50 min-h-screen font-sans text-slate-800">
    <!-- Navbar -->
    <nav class="bg-white/80 backdrop-blur-md border-b border-slate-200 sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <span class="font-display font-bold text-xl text-brand-500 tracking-tight flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10Z"/><path d="M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12"/></svg>
                        OutdoorLaundry
                    </span>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="hidden md:flex flex-col items-end mr-2">
                        <span class="text-sm font-semibold text-slate-800"><?= htmlspecialchars($_SESSION['name']) ?></span>
                        <span class="text-xs text-brand-600 font-bold bg-brand-50 px-3 py-1 rounded-full mt-0.5 border border-brand-100">Customer</span>
                    </div>
                    <a href="logout.php" class="p-2 text-slate-500 hover:text-red-600 hover:bg-red-50 rounded-full transition-colors" title="Logout">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" x2="9" y1="12" y2="12"/></svg>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        
        <!-- Welcome Hero -->
        <div class="bg-brand-500 rounded-[2.5rem] p-10 mb-8 relative overflow-hidden shadow-xl shadow-brand-500/20">
            <div class="absolute top-0 right-0 -mt-10 -mr-10 text-brand-700 opacity-50">
                <svg xmlns="http://www.w3.org/2000/svg" width="200" height="200" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"><path d="m8 3 4 8 5-5 5 15H2L8 3z"/></svg>
            </div>
            <div class="relative z-10">
                <h1 class="font-display text-3xl font-bold text-white mb-2">Halo, <?= htmlspecialchars(explode(' ', $_SESSION['name'])[0]) ?>! 👋</h1>
                <p class="text-brand-100 max-w-xl">Siap untuk petualangan berikutnya? Pastikan gear outdoor kesayanganmu selalu dalam kondisi bersih, wangi, dan lapisan pelindungnya terjaga.</p>
            </div>
        </div>

        <!-- Basic Features Row -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-10">
            <div class="bg-white p-5 rounded-3xl shadow-sm border border-slate-100 flex items-center hover:-translate-y-1 hover:shadow-md transition-all duration-300">
                <div class="bg-amber-100 p-3 rounded-xl text-amber-600 mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="currentColor" stroke="none"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                </div>
                <div>
                    <p class="text-[10px] text-slate-400 uppercase font-bold tracking-wider mb-0.5">Membership</p>
                    <p class="text-sm font-semibold text-slate-800 leading-tight">Silver Member<br><span class="text-xs font-normal text-slate-500">5% Discount</span></p>
                </div>
            </div>
            <div class="bg-white p-5 rounded-3xl shadow-sm border border-slate-100 flex items-center cursor-pointer hover:-translate-y-1 hover:shadow-md transition-all duration-300" onclick="document.getElementById('edukasiModal').classList.remove('hidden')">
                <div class="bg-brand-50 p-3 rounded-xl text-brand-600 mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg> 
                </div>
                <div>
                    <p class="text-[10px] text-slate-400 uppercase font-bold tracking-wider mb-0.5">Edukasi</p>
                    <p class="text-sm font-semibold text-slate-800 leading-tight">Tips Perawatan<br><span class="text-xs font-normal text-slate-500">Baca artikel</span></p>
                </div>
            </div>
            <div class="bg-white p-5 rounded-3xl shadow-sm border border-slate-100 flex items-center hover:-translate-y-1 hover:shadow-md transition-all duration-300">
                <div class="bg-blue-50 p-3 rounded-xl text-blue-500 mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10Z"/><path d="M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12"/></svg>
                </div>
                <div>
                    <p class="text-[10px] text-slate-400 uppercase font-bold tracking-wider mb-0.5">Eco Impact</p>
                    <p class="text-sm font-semibold text-slate-800 leading-tight">12L Water Saved<br><span class="text-xs font-normal text-slate-500">Go Green</span></p>
                </div>
            </div>
            <div class="bg-white p-5 rounded-3xl shadow-sm border border-slate-100 flex items-center cursor-pointer hover:-translate-y-1 hover:shadow-md transition-all duration-300">
                <div class="bg-slate-100 p-3 rounded-xl text-slate-600 mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m9 12 2 2 4-4"/></svg>
                </div>
                <div>
                    <p class="text-[10px] text-slate-400 uppercase font-bold tracking-wider mb-0.5">Proteksi</p>
                    <p class="text-sm font-semibold text-slate-800 leading-tight">Damage Claim<br><span class="text-xs font-normal text-slate-500">Lapor kondisi</span></p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column: Gears & Tracking -->
            <div class="lg:col-span-2 space-y-8">
                <!-- My Gears -->
                <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 p-8">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="font-display text-xl font-bold text-slate-800 flex items-center">
                            <div class="w-8 h-8 rounded-lg bg-brand-50 flex items-center justify-center mr-3 text-brand-600">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.38 3.46 16 2a8 8 0 0 1-8 8 8 8 0 0 1-8 8l-1.46 4.38a2 2 0 0 0 2.54 2.54L5 20.38A8 8 0 0 1 22 16a8 8 0 0 1-8-8l1.46-4.38a2 2 0 0 0-2.54-2.54Z"/></svg>
                            </div>
                            Koleksi Gear
                        </h2>
                        <button onclick="document.getElementById('gearModal').classList.remove('hidden')" class="bg-brand-50 text-brand-600 px-5 py-2.5 rounded-full text-sm font-bold hover:bg-brand-100 transition-colors border border-brand-100">+ Tambah Gear</button>
                    </div>
                    <?php if (count($gears) == 0): ?>
                        <p class="text-slate-500 text-sm italic">Belum ada gear. Silakan tambahkan gear Anda.</p>
                    <?php else: ?>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <?php foreach($gears as $g): ?>
                            <div class="border border-slate-100 p-4 rounded-xl flex justify-between items-start bg-slate-50/50 hover:bg-slate-50 transition-colors">
                                <div>
                                    <h3 class="font-semibold text-slate-800"><?= htmlspecialchars($g['name']) ?></h3>
                                    <p class="text-xs font-medium text-brand-600 mt-1 uppercase tracking-wide"><?= htmlspecialchars($g['type']) ?></p>
                                    <p class="text-sm text-slate-500 mt-2 mb-2"><?= htmlspecialchars($g['notes']) ?></p>
                                    <button onclick="openHistoryModal(<?= $g['id'] ?>)" class="text-xs font-bold text-blue-600 hover:text-blue-800 underline">Lihat Riwayat</button>
                                </div>
                                <?php if($g['is_gore_tex']): ?>
                                    <span class="bg-slate-800 text-white text-[10px] font-bold px-2.5 py-1 rounded-full uppercase tracking-wider">Gore-Tex</span>
                                <?php endif; ?>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Bookings Tracking -->
                <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 p-8">
                    <div class="mb-6 flex items-center">
                        <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center mr-3 text-blue-600">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="16" height="16" x="4" y="4" rx="2"/><rect width="6" height="6" x="9" y="9" rx="1"/><path d="M15 2v2"/><path d="M15 20v2"/><path d="M2 15h2"/><path d="M2 9h2"/><path d="M20 15h2"/><path d="M20 9h2"/><path d="M9 2v2"/><path d="M9 20v2"/></svg>
                        </div>
                        <h2 class="font-display text-xl font-bold text-slate-800">Booking & Tracking</h2>
                    </div>
                    <?php if (count($bookings) == 0): ?>
                        <div class="text-center py-8">
                            <p class="text-slate-400 text-sm">Belum ada pesanan aktif saat ini.</p>
                        </div>
                    <?php else: ?>
                        <div class="space-y-4">
                            <?php foreach($bookings as $b): ?>
                            <div class="border border-slate-100 p-5 rounded-2xl bg-slate-50/50 hover:bg-slate-50 hover:shadow-sm transition-all duration-300">
                                <div class="flex justify-between items-center mb-3">
                                    <h3 class="font-semibold text-slate-800"><?= htmlspecialchars($b['gear_name']) ?></h3>
                                    <span class="text-xs font-bold px-3 py-1 rounded-full <?= $b['status'] == 'Selesai' ? 'bg-brand-100 text-brand-700' : 'bg-amber-100 text-amber-700' ?>">
                                        <?= htmlspecialchars($b['status']) ?>
                                    </span>
                                </div>
                                <div class="flex justify-between items-end">
                                    <div class="space-y-1">
                                        <p class="text-xs text-slate-500"><span class="font-medium text-slate-700">Kondisi:</span> <?= htmlspecialchars(implode(', ', json_decode($b['conditions']))) ?></p>
                                        <p class="text-xs text-slate-400"><?= date('d M Y H:i', strtotime($b['created_at'])) ?></p>
                                    </div>
                                    <p class="text-sm font-bold text-slate-800">Rp <?= number_format($b['price'], 0, ',', '.') ?></p>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Right Column: Booking Form -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-[2rem] shadow-lg shadow-slate-200/40 border border-slate-100 p-8 mb-8 relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-2 bg-brand-500"></div>
                    <h2 class="font-display text-xl font-bold text-slate-800 mb-6">Buat Pesanan Baru</h2>
                    <form action="api_bookings.php" method="POST" id="bookingForm" class="space-y-5">
                        <input type="hidden" name="action" value="create">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Pilih Gear</label>
                            <select name="gear_id" id="gearSelect" required class="w-full px-5 py-3 bg-slate-50 border border-slate-200 rounded-full text-sm focus:ring-2 focus:ring-brand-500 focus:border-brand-500 outline-none transition-all">
                                <option value="">-- Pilih --</option>
                                <?php foreach($gears as $g): ?>
                                    <option value="<?= $g['id'] ?>" data-goretex="<?= $g['is_gore_tex'] ?>"><?= htmlspecialchars($g['name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Tanggal Pickup</label>
                                <input type="date" name="pickup_date" required min="<?= date('Y-m-d') ?>" value="<?= date('Y-m-d') ?>" class="w-full px-5 py-3 bg-slate-50 border border-slate-200 rounded-full text-sm focus:ring-2 focus:ring-brand-500 focus:border-brand-500 outline-none transition-all">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Jumlah (Qty)</label>
                                <input type="number" name="quantity" id="quantityInput" min="1" value="1" required onchange="calculatePrice()" class="w-full px-5 py-3 bg-slate-50 border border-slate-200 rounded-full text-sm focus:ring-2 focus:ring-brand-500 focus:border-brand-500 outline-none transition-all">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Jam Pickup</label>
                            <select name="pickup_time" required class="w-full px-5 py-3 bg-slate-50 border border-slate-200 rounded-full text-sm focus:ring-2 focus:ring-brand-500 focus:border-brand-500 outline-none transition-all">
                                <option value="08.00-10.00">08.00 - 10.00</option>
                                <option value="10.00-12.00">10.00 - 12.00</option>
                                <option value="13.00-15.00">13.00 - 15.00</option>
                                <option value="15.00-17.00">15.00 - 17.00</option>
                                <option value="18.00-20.00">18.00 - 20.00</option>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-3">Kondisi Gear <span class="text-xs font-normal text-slate-500 ml-1">(Pilih yang sesuai)</span></label>
                            <div class="grid grid-cols-2 gap-3" id="conditionCheckboxes">
                                <?php 
                                foreach($treatments as $t) {
                                    if ($t['type'] == 'Condition') {
                                        $val = strtolower(explode(' ', trim($t['name']))[0]); // e.g., 'Deodorizing' -> 'deodorizing'
                                        if (strpos(strtolower($t['name']), 'mud') !== false) $val = 'lumpur';
                                        if (strpos(strtolower($t['name']), 'fungal') !== false) $val = 'jamur';
                                        if (strpos(strtolower($t['name']), 'deodorizing') !== false) $val = 'bau';
                                        if (strpos(strtolower($t['name']), 'quick') !== false) $val = 'basah';

                                        echo '<label class="flex items-center p-3 border border-slate-200 rounded-xl cursor-pointer hover:bg-slate-50 transition-colors">
                                            <input type="checkbox" name="conditions[]" value="'.$val.'" data-price="'.$t['price'].'" data-name="'.$t['name'].'" class="mr-2.5 w-4 h-4 text-brand-600 focus:ring-brand-500 border-slate-300 rounded condition-cb" onchange="calculatePrice()">
                                            <span class="text-sm font-medium text-slate-700">'.ucfirst($val).'</span>
                                        </label>';
                                    }
                                }
                                ?>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Alamat Pickup & Pengiriman</label>
                            <textarea name="pickup_address" required rows="2" placeholder="Alamat lengkap penjemputan" class="w-full px-5 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm focus:ring-2 focus:ring-brand-500 focus:border-brand-500 outline-none transition-all mb-2"></textarea>
                            <textarea name="delivery_address" required rows="2" placeholder="Alamat lengkap pengiriman kembali" class="w-full px-5 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm focus:ring-2 focus:ring-brand-500 focus:border-brand-500 outline-none transition-all"></textarea>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Metode Pembayaran</label>
                                <select name="payment_method" class="w-full px-5 py-3 bg-slate-50 border border-slate-200 rounded-full text-sm focus:ring-2 focus:ring-brand-500 focus:border-brand-500 outline-none transition-all">
                                    <option value="Transfer Bank">Transfer Bank</option>
                                    <option value="Tunai (COD)">Tunai / Bayar di Tempat</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Promo Code <span class="text-xs font-normal text-slate-500">(Opsional)</span></label>
                                <input type="text" name="promo_code" id="promoCodeInput" placeholder="Contoh: OUTDOOR10" oninput="calculatePrice()" class="w-full px-5 py-3 bg-slate-50 border border-slate-200 rounded-full text-sm focus:ring-2 focus:ring-brand-500 focus:border-brand-500 outline-none transition-all uppercase">
                            </div>
                        </div>

                        <div class="bg-gradient-to-br from-brand-50 to-brand-100/50 p-4 rounded-xl border border-brand-100 mt-4">
                            <p class="text-xs font-bold text-brand-700 uppercase tracking-wider mb-2">Rincian Pembayaran</p>
                            <p id="recommendationText" class="text-sm text-brand-900 font-medium mb-3">Pilih gear dan kondisi untuk melihat rekomendasi.</p>
                            <div class="flex justify-between items-end border-t border-brand-200/60 pt-3">
                                <span class="text-sm text-slate-600">Estimasi Total <span id="promoLabel" class="text-xs font-bold text-green-600 ml-2 hidden">(Diskon 10%)</span></span>
                                <span class="text-lg font-bold text-brand-700">Rp <span id="priceDisplay">0</span></span>
                            </div>
                            <input type="hidden" name="price" id="priceInput" value="0">
                        </div>

                        <button type="submit" class="w-full bg-slate-900 text-white py-4 rounded-full hover:bg-slate-800 transition-all transform hover:-translate-y-0.5 font-bold text-sm shadow-lg shadow-slate-900/20 mt-4">Konfirmasi Pesanan</button>
                    </form>
                </div>

                <!-- Marketplace Dummy -->
                <div class="bg-white rounded-lg shadow-sm p-6 border border-slate-200 mb-8">
                   <h3 class="font-bold text-slate-800 mb-4 border-b pb-2">Marketplace (Sewa & Beli)</h3>
                   <ul class="space-y-3 text-sm">
                     <li class="flex justify-between items-center bg-slate-50 p-2 rounded border border-slate-100">
                       <span>Sewa Carrier 60L (Weekend)</span>
                       <span class="font-bold text-green-700">Rp 50rb</span>
                     </li>
                     <li class="flex justify-between items-center bg-slate-50 p-2 rounded border border-slate-100">
                       <span>Beli Nikwax Tech Wash</span>
                       <span class="font-bold text-green-700">Rp 120rb</span>
                     </li>
                     <li class="flex justify-between items-center bg-slate-50 p-2 rounded border border-slate-100">
                       <span>Bundle: Cuci + Re-coating</span>
                       <span class="font-bold text-green-700">Rp 100rb</span>
                     </li>
                   </ul>
                </div>

                <!-- Community Reviews Dummy -->
                <div class="bg-white rounded-lg shadow-sm p-6 border border-slate-200">
                   <h3 class="font-bold text-slate-800 mb-4 border-b pb-2">Community Reviews</h3>
                   <div class="space-y-4 text-sm">
                     <div class="bg-slate-50 p-3 rounded border border-slate-100">
                       <div class="flex items-center text-amber-500 mb-1">
                         <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="currentColor" stroke="none"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                         <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="currentColor" stroke="none"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                         <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="currentColor" stroke="none"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                         <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="currentColor" stroke="none"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                         <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="currentColor" stroke="none"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                       </div>
                       <p class="text-slate-700">"Carrier saya yang bau lumpur Semeru jadi wangi banget! Re-coating Gore-Tex nya juga juara."</p>
                       <p class="text-xs text-slate-500 mt-2 font-medium">- Budi, Pendaki Aktif</p>
                     </div>
                   </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Modal Add Gear -->
    <div id="gearModal" class="fixed inset-0 bg-black/50 hidden flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-xl p-6 max-w-md w-full shadow-xl">
            <h2 class="text-lg font-bold text-slate-800 mb-4">Tambah Gear Baru</h2>
            <form action="api_gears.php" method="POST" class="space-y-4">
                <input type="hidden" name="action" value="create">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Nama Gear (Misal: Consina 60L)</label>
                    <input type="text" name="name" required class="w-full px-4 py-2 border border-slate-300 rounded-lg text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Tipe</label>
                    <select name="type" required class="w-full px-4 py-2 border border-slate-300 rounded-lg text-sm">
                        <option value="Carrier">Carrier</option>
                        <option value="Tenda">Tenda</option>
                        <option value="Sleeping Bag">Sleeping Bag</option>
                        <option value="Jaket">Jaket</option>
                        <option value="Sepatu">Sepatu</option>
                    </select>
                </div>
                <div>
                    <label class="flex items-center text-sm font-medium text-slate-700">
                        <input type="checkbox" name="is_gore_tex" value="1" class="mr-2"> Material Gore-Tex?
                    </label>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Catatan Tambahan</label>
                    <textarea name="notes" rows="2" class="w-full px-4 py-2 border border-slate-300 rounded-lg text-sm"></textarea>
                </div>
                <div class="flex justify-end space-x-2 mt-6">
                    <button type="button" onclick="document.getElementById('gearModal').classList.add('hidden')" class="px-5 py-2.5 bg-slate-200 text-slate-700 rounded-full text-sm font-bold hover:bg-slate-300">Batal</button>
                    <button type="submit" class="px-5 py-2.5 bg-brand-500 text-white rounded-full text-sm font-bold hover:bg-brand-600">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edukasi Modal -->
    <div id="edukasiModal" class="fixed inset-0 bg-black/50 hidden flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-lg p-6 max-w-md w-full shadow-xl">
            <h2 class="text-lg font-bold text-slate-800 mb-4 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2 text-green-700"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg> 
                Tips Perawatan Gore-Tex
            </h2>
            <div class="text-sm text-slate-600 space-y-3">
                <p><strong>1. Jangan gunakan deterjen biasa.</strong> Deterjen biasa dapat merusak lapisan DWR (Durable Water Repellent) pada jaket Anda.</p>
                <p><strong>2. Hindari pelembut pakaian.</strong> Pelembut dapat menyumbat pori-pori membran Gore-Tex sehingga mengurangi sirkulasi udara.</p>
                <p><strong>3. Keringkan dengan suhu rendah.</strong> Panas sedang membantu mengaktifkan kembali lapisan DWR setelah dicuci.</p>
            </div>
            <div class="mt-6 flex justify-end">
                <button onclick="document.getElementById('edukasiModal').classList.add('hidden')" class="bg-slate-800 text-white px-4 py-2 rounded text-sm hover:bg-slate-900">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <!-- Gear History Modal -->
    <div id="historyModal" class="fixed inset-0 bg-black/50 hidden flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-lg p-6 max-w-2xl w-full shadow-xl max-h-[80vh] flex flex-col">
            <h2 class="text-lg font-bold text-slate-800 mb-4 flex items-center border-b pb-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2 text-blue-600"><path d="M12 2v20"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg> 
                Riwayat Perawatan Gear
            </h2>
            <div id="historyContent" class="overflow-y-auto flex-1 text-sm text-slate-700 space-y-4 pr-2">
                <!-- Dynamically populated via JS -->
            </div>
            <div class="mt-4 pt-4 border-t flex justify-end">
                <button onclick="document.getElementById('historyModal').classList.add('hidden')" class="bg-slate-800 text-white px-4 py-2 rounded text-sm hover:bg-slate-900 font-bold">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <!-- Smart Recommendation Logic -->
    <script>
        const dbTreatments = <?= json_encode($treatments) ?>;
        const bookingsData = <?= json_encode($bookings) ?>;
        
        // Setup initial prices
        let basePrice = 50000;
        let goretexPrice = 25000;
        
        dbTreatments.forEach(t => {
            if(t.type === 'Base') basePrice = parseInt(t.price);
            if(t.type === 'Material' && t.name.toLowerCase().includes('gore-tex')) goretexPrice = parseInt(t.price);
        });

        function calculatePrice() {
            let finalPrice = basePrice;
            let recommendations = [];
            
            const gearSelect = document.getElementById('gearSelect');
            if (gearSelect.selectedIndex === 0) {
                document.getElementById('priceDisplay').innerText = "0";
                document.getElementById('priceInput').value = 0;
                document.getElementById('recommendationText').innerText = "Pilih gear dan kondisi untuk melihat rekomendasi.";
                return;
            }

            const selectedOption = gearSelect.options[gearSelect.selectedIndex];
            const isGoreTex = selectedOption ? selectedOption.dataset.goretex === "1" : false;
            
            let qty = parseInt(document.getElementById('quantityInput').value) || 1;

            const checkboxes = document.querySelectorAll('.condition-cb:checked');
            
            checkboxes.forEach(cb => {
                finalPrice += parseInt(cb.dataset.price);
                recommendations.push(cb.dataset.name);
            });

            if (isGoreTex) {
                finalPrice += goretexPrice;
                recommendations.push('Gore-Tex Re-coating');
            }

            if (recommendations.length === 0) {
                let baseName = dbTreatments.find(t => t.type === 'Base')?.name || 'Standard Wash';
                recommendations.push(baseName);
            }

            finalPrice = finalPrice * qty;

            const promoCode = document.getElementById('promoCodeInput').value.toUpperCase();
            const promoLabel = document.getElementById('promoLabel');
            if (promoCode === 'OUTDOOR10') {
                finalPrice = finalPrice - (finalPrice * 0.10);
                promoLabel.classList.remove('hidden');
            } else {
                promoLabel.classList.add('hidden');
            }

            document.getElementById('priceDisplay').innerText = finalPrice.toLocaleString('id-ID');
            document.getElementById('priceInput').value = finalPrice;
            document.getElementById('recommendationText').innerText = recommendations.join(' + ') + (qty > 1 ? ` (x${qty})` : '');
        }

        document.getElementById('gearSelect').addEventListener('change', calculatePrice);
        calculatePrice(); // initial call

        // Gear History Function
        function openHistoryModal(gearId) {
            const content = document.getElementById('historyContent');
            const history = bookingsData.filter(b => b.gear_id == gearId);
            
            if (history.length === 0) {
                content.innerHTML = '<p class="text-center italic text-slate-500 py-4">Belum ada riwayat pencucian untuk gear ini.</p>';
            } else {
                let html = '';
                history.forEach(b => {
                    html += `
                    <div class="bg-slate-50 border border-slate-200 p-4 rounded-lg">
                        <div class="flex justify-between items-center mb-2">
                            <span class="font-bold text-slate-800">Order #ODR-${String(b.id).padStart(4, '0')}</span>
                            <span class="text-xs font-bold px-2 py-1 rounded bg-slate-200 text-slate-700">${b.status}</span>
                        </div>
                        <p class="text-xs text-slate-500 mb-1">Dibuat: ${b.created_at}</p>
                        <p class="text-sm">Kondisi: <span class="font-semibold">${b.conditions}</span></p>
                        <p class="text-sm font-bold text-brand-600 mt-2">Biaya: Rp ${parseInt(b.price).toLocaleString('id-ID')}</p>
                    </div>`;
                });
                content.innerHTML = html;
            }
            document.getElementById('historyModal').classList.remove('hidden');
        }
    </script>
</body>
</html>
