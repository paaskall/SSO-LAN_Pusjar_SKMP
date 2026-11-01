<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Tidak Ditemukan - SSO Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 h-screen flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl shadow-xl w-full max-w-lg p-10 text-center relative overflow-hidden">
        <div class="absolute -top-16 -right-16 w-48 h-48 bg-blue-50 rounded-full blur-2xl pointer-events-none"></div>
        
        <img src="{{ asset('assets/logo-lanri.png') }}" alt="LAN RI" class="h-16 mx-auto mb-6 relative z-10">
        
        <h1 class="text-7xl font-extrabold text-blue-600 mb-4 relative z-10">404</h1>
        <h2 class="text-2xl font-bold text-gray-800 mb-2 relative z-10">Halaman Tidak Ditemukan</h2>
        <p class="text-gray-500 mb-8 relative z-10">Maaf, halaman yang Anda cari tidak ada, sudah dipindahkan, atau URL-nya salah ketik.</p>
        
        <div class="flex justify-center gap-3 relative z-10">
            <a href="/dashboard" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl transition shadow-lg shadow-blue-200">
                Kembali ke Dashboard
            </a>
            <a href="javascript:history.back()" class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl transition">
                Halaman Sebelumnya
            </a>
        </div>
    </div>
</body>
</html>