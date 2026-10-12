<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'kurir') {
    header("Location: index.php");
    exit;
}

$kurir_id = $_SESSION['user_id'];

// Fetch Bookings Assigned to this Kurir
$stmt = $pdo->prepare("SELECT b.*, g.name as gear_name, u.name as customer_name, u.phone 
                       FROM bookings b 
                       JOIN gears g ON b.gear_id = g.id 
                       JOIN users u ON b.user_id = u.id 
                       WHERE b.kurir_id = ? AND b.status NOT IN ('Selesai Sepenuhnya') 
                       ORDER BY b.pickup_date ASC, b.created_at ASC");
$stmt->execute([$kurir_id]);
$bookings = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kurir Dashboard - Outdoor Laundry</title>
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
    <nav class="bg-slate-900 text-white sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <span class="font-display font-bold text-xl tracking-tight flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="mr-2 text-brand-500"><path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2"/><path d="M15 18H9"/><path d="M19 18h2a1 1 0 0 0 1-1v-3.65a1 1 0 0 0-.22-.624l-3.48-4.35A1 1 0 0 0 17.52 8H14"/><circle cx="17" cy="18" r="2"/><circle cx="7" cy="18" r="2"/></svg>
                        Kurir<span class="text-slate-400 font-normal ml-1">Panel</span>
                    </span>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="hidden md:flex flex-col items-end mr-2">
                        <span class="text-sm font-semibold"><?= htmlspecialchars($_SESSION['name']) ?></span>
                        <span class="text-[10px] text-brand-400 font-bold uppercase tracking-wider mt-0.5">Delivery Team</span>
                    </div>
                    <a href="logout.php" class="p-2 text-slate-400 hover:text-white hover:bg-slate-800 rounded-full transition-colors" title="Logout">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" x2="9" y1="12" y2="12"/></svg>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="mb-8">
            <h1 class="font-display text-2xl font-bold text-slate-900">Task Penugasan</h1>
            <p class="text-sm text-slate-500 mt-1">Daftar pesanan yang di-assign kepada Anda hari ini.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Tugas Pickup -->
            <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden flex flex-col">
                <div class="px-6 py-5 border-b border-slate-100 bg-amber-50/50 flex items-center">
                    <div class="bg-amber-100 text-amber-600 p-2 rounded-lg mr-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m18 15-6-6-6 6"/></svg>
                    </div>
                    <h2 class="text-lg font-bold text-slate-800">Tugas Pickup</h2>
                </div>
                <div class="p-5 space-y-4 bg-slate-50/30 flex-1">
                    <?php 
                    $hasPickup = false;
                    foreach($bookings as $b): 
                        if (in_array($b['status'], ['Pending', 'Dijemput'])):
                            $hasPickup = true;
                    ?>
                    <div class="bg-white border border-slate-200 rounded-2xl p-6 relative overflow-hidden shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-300">
                        <div class="absolute top-0 left-0 w-2 h-full bg-amber-500"></div>
                        <h3 class="font-bold text-slate-800 text-lg flex items-center justify-between">
                            <?= htmlspecialchars($b['customer_name']) ?> 
                            <span class="text-xs bg-slate-100 text-slate-600 px-2 py-1 rounded-md font-semibold font-sans tracking-wide">ID: ODR-<?= str_pad($b['id'], 4, '0', STR_PAD_LEFT) ?></span>
                        </h3>
                        
                        <div class="flex items-center justify-between mb-3 mt-1">
                            <p class="text-sm text-brand-600 font-medium flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1.5"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                                <?= htmlspecialchars($b['phone']) ?>
                            </p>
                            <span class="text-xs font-bold text-amber-700 bg-amber-100 px-2 py-0.5 rounded">Tgl: <?= htmlspecialchars($b['pickup_date']) ?></span>
                        </div>
                        
                        <div class="bg-slate-50 p-3 rounded-lg border border-slate-100 mb-4">
                            <p class="text-xs text-slate-500 uppercase font-bold tracking-wider mb-1">Item: <?= htmlspecialchars($b['gear_name']) ?> (Qty: <?= $b['quantity'] ?>)</p>
                            <p class="text-sm text-slate-600 leading-relaxed"><?= htmlspecialchars($b['pickup_address']) ?></p>
                            <a href="https://www.google.com/maps/search/?api=1&query=<?= urlencode($b['pickup_address']) ?>" target="_blank" class="inline-flex items-center text-xs font-bold text-blue-600 mt-2 hover:text-blue-800">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                Buka di Maps
                            </a>
                        </div>
                        
                        <form action="api_tracking.php" method="POST" class="flex space-x-2">
                            <input type="hidden" name="booking_id" value="<?= $b['id'] ?>">
                            <select name="status" class="flex-1 px-4 py-2.5 border border-amber-200 rounded-full text-sm bg-amber-50">
                                <option value="Dijemput" <?= $b['status'] == 'Dijemput' ? 'selected' : '' ?>>Dijemput (Menuju Lokasi)</option>
                                <option value="Diterima Admin">Sudah Diantar ke Admin</option>
                            </select>
                            <button type="submit" class="bg-amber-500 text-white px-5 py-2.5 rounded-full text-sm font-bold shadow-sm hover:bg-amber-600">Update</button>
                        </form>
                    </div>
                    <?php endif; endforeach; ?>
                    <?php if (!$hasPickup): ?>
                        <div class="text-center py-10">
                            <svg class="mx-auto h-12 w-12 text-slate-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 13l4 4L19 7"/></svg>
                            <p class="text-sm font-medium text-slate-500">Tidak ada tugas pickup.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Tugas Antar -->
            <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden flex flex-col">
                <div class="px-6 py-5 border-b border-slate-100 bg-brand-50/50 flex items-center">
                    <div class="bg-brand-100 text-brand-600 p-2 rounded-lg mr-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
                    </div>
                    <h2 class="text-lg font-bold text-slate-800">Tugas Antar</h2>
                </div>
                <div class="p-5 space-y-4 bg-slate-50/30 flex-1">
                    <?php 
                    $hasDelivery = false;
                    foreach($bookings as $b): 
                        if (in_array($b['status'], ['Selesai Dicuci', 'Dalam Perjalanan', 'Dikirim Kembali'])):
                            $hasDelivery = true;
                    ?>
                    <div class="bg-white border border-slate-200 rounded-2xl p-6 relative overflow-hidden shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-300">
                        <div class="absolute top-0 left-0 w-2 h-full bg-brand-500"></div>
                        <h3 class="font-bold text-slate-800 text-lg flex items-center justify-between">
                            <?= htmlspecialchars($b['customer_name']) ?> 
                            <span class="text-xs bg-slate-100 text-slate-600 px-2 py-1 rounded-md font-semibold font-sans tracking-wide">ID: ODR-<?= str_pad($b['id'], 4, '0', STR_PAD_LEFT) ?></span>
                        </h3>
                        <p class="text-sm text-brand-600 font-medium mb-3 mt-1 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1.5"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                            <?= htmlspecialchars($b['phone']) ?>
                        </p>
                        
                        <div class="bg-slate-50 p-3 rounded-lg border border-slate-100 mb-4">
                            <p class="text-xs text-slate-500 uppercase font-bold tracking-wider mb-1">Item: <?= htmlspecialchars($b['gear_name']) ?> (Qty: <?= $b['quantity'] ?>)</p>
                            <p class="text-sm text-slate-600 leading-relaxed"><?= htmlspecialchars($b['delivery_address']) ?></p>
                            <a href="https://www.google.com/maps/search/?api=1&query=<?= urlencode($b['delivery_address']) ?>" target="_blank" class="inline-flex items-center text-xs font-bold text-blue-600 mt-2 hover:text-blue-800">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                Buka di Maps
                            </a>
                        </div>
                        
                        <form action="api_tracking.php" method="POST" class="flex space-x-2">
                            <input type="hidden" name="booking_id" value="<?= $b['id'] ?>">
                            <select name="status" class="flex-1 px-4 py-2.5 border border-brand-200 rounded-full text-sm bg-brand-50">
                                <option value="Dalam Perjalanan" <?= $b['status'] == 'Dalam Perjalanan' ? 'selected' : '' ?>>Dalam Perjalanan</option>
                                <option value="Dikirim Kembali" <?= $b['status'] == 'Dikirim Kembali' ? 'selected' : '' ?>>Tiba di Lokasi</option>
                                <option value="Selesai Sepenuhnya">Selesai (Diterima Customer)</option>
                            </select>
                            <button type="submit" class="bg-brand-500 text-white px-5 py-2.5 rounded-full text-sm font-bold shadow-sm hover:bg-brand-600">Update</button>
                        </form>
                    </div>
                    <?php endif; endforeach; ?>
                    <?php if (!$hasDelivery): ?>
                        <div class="text-center py-10">
                            <svg class="mx-auto h-12 w-12 text-slate-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 13l4 4L19 7"/></svg>
                            <p class="text-sm font-medium text-slate-500">Tidak ada tugas antar.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
