<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>SSO Portal - Login</title>
    <link rel="icon" href="{{ asset('assets/logo-lanri.png') }}" type="image/x-icon">

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; }
        .form-panel { background: #ffffff; }

        /* Animasi masuk */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .fade-in-up { animation: fadeInUp 0.6s ease-out; }
    </style>
</head>
<body class="h-screen overflow-hidden bg-white">

<div class="flex h-screen">

    {{-- ================= PANEL KIRI - BRANDING ================= --}}
    <div class="hidden lg:flex lg:w-1/2 text-white flex-col justify-between p-12 relative overflow-hidden">

        {{-- FOTO GEDUNG SEBAGAI BACKGROUND UTAMA --}}
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('assets/gedung-lanri.png') }}"
                 alt="Gedung Pusjar SKMP"
                 class="w-full h-full object-cover">

            {{-- Overlay gradient biru - tipis biar gedung kentara --}}
            <div class="absolute inset-0 bg-gradient-to-br from-blue-950/75 via-blue-900/55 to-blue-700/65"></div>

            {{-- Overlay tambahan: gelap di kiri, transparan di kanan --}}
            <div class="absolute inset-0 bg-gradient-to-r from-blue-950/85 via-blue-900/40 to-transparent"></div>
        </div>

        {{-- ===== HEADER: Logo & Nama Sistem ===== --}}
        <div class="relative z-10">
            <div class="flex items-center gap-3">
                <div class="w-14 h-14 rounded-2xl bg-white/95 p-2 shadow-lg">
                    <img src="{{ asset('assets/logo-lanri.png') }}" alt="SSO" class="w-full h-full object-contain" />
                </div>
                <div>
                    <h2 class="text-xl font-extrabold tracking-wide drop-shadow-md">SSO PORTAL</h2>
                    <p class="text-[11px] text-blue-100 tracking-widest uppercase drop-shadow">Single Sign-On Terintegrasi</p>
                </div>
            </div>
            <p class="text-[10px] text-blue-100 tracking-[0.2em] uppercase mt-6 drop-shadow">PUSJAR SKMP</p>
        </div>

        {{-- ===== TENGAH: Judul & Fitur ===== --}}
        <div class="relative z-10 max-w-lg fade-in-up">
            <h1 class="text-4xl xl:text-5xl font-extrabold leading-tight mb-6 drop-shadow-lg">
                Satu Pintu,<br />
                Semua Aplikasi<br />
                Terintegrasi.
            </h1>
            <p class="text-blue-50 text-sm leading-relaxed max-w-md drop-shadow">
                Akses seluruh sistem informasi instansi hanya dengan satu akun.
                Cepat, aman, dan terintegrasi.
            </p>

            {{-- Fitur highlight --}}
            <div class="grid grid-cols-2 gap-4 mt-10">
                <div class="flex items-start gap-3 backdrop-blur-sm bg-white/10 rounded-lg p-2 border border-white/10">
                    <div class="w-8 h-8 rounded-lg bg-white/25 flex items-center justify-center flex-shrink-0">
                        <i data-lucide="shield-check" class="w-4 h-4"></i>
                    </div>
                    <div>
                        <p class="text-sm font-semibold">Aman</p>
                        <p class="text-[11px] text-blue-100">OAuth2 & JWT</p>
                    </div>
                </div>
                <div class="flex items-start gap-3 backdrop-blur-sm bg-white/10 rounded-lg p-2 border border-white/10">
                    <div class="w-8 h-8 rounded-lg bg-white/25 flex items-center justify-center flex-shrink-0">
                        <i data-lucide="zap" class="w-4 h-4"></i>
                    </div>
                    <div>
                        <p class="text-sm font-semibold">Cepat</p>
                        <p class="text-[11px] text-blue-100">Login Sekali</p>
                    </div>
                </div>
                <div class="flex items-start gap-3 backdrop-blur-sm bg-white/10 rounded-lg p-2 border border-white/10">
                    <div class="w-8 h-8 rounded-lg bg-white/25 flex items-center justify-center flex-shrink-0">
                        <i data-lucide="layers" class="w-4 h-4"></i>
                    </div>
                    <div>
                        <p class="text-sm font-semibold">Terpadu</p>
                        <p class="text-[11px] text-blue-100">Multi Aplikasi</p>
                    </div>
                </div>
                <div class="flex items-start gap-3 backdrop-blur-sm bg-white/10 rounded-lg p-2 border border-white/10">
                    <div class="w-8 h-8 rounded-lg bg-white/25 flex items-center justify-center flex-shrink-0">
                        <i data-lucide="users" class="w-4 h-4"></i>
                    </div>
                    <div>
                        <p class="text-sm font-semibold">Terpusat</p>
                        <p class="text-[11px] text-blue-100">Manajemen Akun</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- ===== FOOTER: Copyright ===== --}}
        <div class="relative z-10 flex items-center gap-3 text-xs text-blue-100">
            <div class="w-8 h-px bg-blue-300"></div>
            <span class="drop-shadow">© {{ date('Y') }} SSO Portal · PUSJAR SKMP</span>
        </div>

    </div>

    {{-- ================= PANEL KANAN - FORM LOGIN ================= --}}
    <div class="w-full lg:w-1/2 flex flex-col form-panel overflow-y-auto">

        {{-- Header Mobile --}}
        <div class="lg:hidden flex items-center justify-between px-6 pt-6 pb-2">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-blue-50 p-1.5">
                    <img src="{{ asset('assets/logo-lanri.png') }}" alt="SSO" class="w-full h-full object-contain" />
                </div>
                <div>
                    <h2 class="text-base font-extrabold text-blue-900 tracking-wide">SSO PORTAL</h2>
                    <p class="text-[9px] text-gray-500 tracking-wider uppercase">Single Sign-On</p>
                </div>
            </div>
        </div>

        <div class="flex-1 flex items-center justify-center px-6 py-10 lg:px-16">
            <div class="w-full max-w-md">

                <div class="flex flex-col items-center text-center mb-8">
                    <div class="w-24 h-24 mb-4">
                        <img src="{{ asset('assets/logo-lanri.png') }}" alt="SSO Logo" class="w-full h-full object-contain" />
                    </div>
                    <h2 class="text-xl font-extrabold text-blue-900 tracking-wide">SSO PORTAL</h2>
                    <p class="text-[10px] text-gray-500 tracking-[0.25em] uppercase mt-1">Single Sign-On Terintegrasi</p>

                    <h1 class="text-xl font-bold text-gray-800 mt-4">Masuk ke Akun Anda</h1>
                    <p class="text-xs text-gray-500 mt-1">Gunakan email terdaftar untuk melanjutkan</p>
                </div>

                {{-- Alert Error --}}
                <div id="errorAlert" class="hidden bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-4 text-sm"></div>

                <form id="loginForm" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Email / Username / NIP</label>
                        <div class="relative">
                            <i data-lucide="user" class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            <input
                                type="text"
                                id="login"
                                name="login"
                                placeholder="Email, username, atau NIP"
                                class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                required autofocus />
                        </div>
                        <p class="text-[11px] text-gray-400 mt-1">Bisa pakai email, username, atau NIP Anda.</p>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                        <div class="relative">
                            <i data-lucide="lock" class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            <input
                                type="password"
                                id="password"
                                name="password"
                                placeholder="Masukkan password"
                                class="w-full pl-10 pr-10 py-3 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                required />
                            <button type="button" onclick="togglePassword()" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition">
                                <i id="eyeIcon" data-lucide="eye" class="w-4 h-4"></i>
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center justify-between text-sm">
                        <label class="flex items-center gap-2 cursor-pointer select-none">
                            <input type="checkbox" name="remember" class="w-4 h-4 rounded border-gray-300 text-blue-700 focus:ring-blue-500" />
                            <span class="text-gray-600">Ingat saya</span>
                        </label>
                        <a href="#" onclick="lupaPassword(event)" class="text-blue-700 hover:text-blue-900 hover:underline font-medium">
                            Lupa password?
                        </a>
                    </div>

                    <button type="submit" id="submitBtn"
                        class="w-full bg-gradient-to-r from-blue-800 to-blue-600 hover:from-blue-900 hover:to-blue-700 text-white font-semibold py-3 rounded-lg transition-all shadow-lg shadow-blue-200 flex items-center justify-center gap-2 mt-2 disabled:opacity-60 disabled:cursor-not-allowed">
                        <i data-lucide="log-in" class="w-4 h-4"></i>
                        <span id="btnText">MASUK</span>
                    </button>
                </form>

                <div class="mt-10 pt-6 border-t border-gray-100 text-center">
                    <div class="inline-flex items-center gap-2 text-xs text-gray-500">
                        <img src="{{ asset('assets/logo-lanri.png') }}" alt="Logo" class="w-6 h-6 object-contain" />
                        <div class="text-left">
                            <p class="font-bold text-gray-700 leading-tight">SSO PORTAL</p>
                            <p class="text-[10px] text-gray-400 leading-tight">Single Sign-On Terintegrasi</p>
                        </div>
                    </div>
                    <p class="text-[10px] text-gray-400 mt-3">© {{ date('Y') }} SSO Portal - PUSJAR SKMP</p>
                </div>

            </div>
        </div>
    </div>

</div>

<script>
    // Init Lucide Icons
    if (window.lucide) lucide.createIcons();

    // Toggle Password Visibility
    function togglePassword() {
        const input = document.getElementById('password');
        const icon = document.getElementById('eyeIcon');
        if (input.type === 'password') {
            input.type = 'text';
            icon.setAttribute('data-lucide', 'eye-off');
        } else {
            input.type = 'password';
            icon.setAttribute('data-lucide', 'eye');
        }
        lucide.createIcons();
    }

    // Lupa Password
    function lupaPassword(e) {
        e.preventDefault();
        Swal.fire({
            icon: 'info',
            title: 'Lupa Password?',
            text: 'Silakan hubungi Administrator untuk reset password Anda.',
            confirmButtonColor: '#1e40af',
            confirmButtonText: 'OK'
        });
    }

    // Form Login Handler (API-based)
    document.getElementById('loginForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        const submitBtn = document.getElementById('submitBtn');
        const btnText = document.getElementById('btnText');
        const errorAlert = document.getElementById('errorAlert');
        const login = document.getElementById('login').value.trim();
        const password = document.getElementById('password').value;

        // Reset
        errorAlert.classList.add('hidden');

        // Loading state
        submitBtn.disabled = true;
        btnText.textContent = 'MEMPROSES...';

        try {
            const response = await fetch('/api/login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ login, password })
            });

            const data = await response.json();

            if (response.ok && data.success) {
                // Simpan token & user
                localStorage.setItem('access_token', data.access_token);
                localStorage.setItem('user', JSON.stringify(data.user));

                // Toast sukses
                Swal.fire({
                    icon: 'success',
                    title: 'Login Berhasil!',
                    text: 'Mengalihkan ke dashboard...',
                    timer: 1200,
                    showConfirmButton: false,
                    timerProgressBar: true
                });

                // Redirect
                setTimeout(() => {
                    window.location.href = '/dashboard';
                }, 1200);

            } else {
                // Error dari server
                const msg = data.message || 'Email atau password salah.';
                errorAlert.textContent = msg;
                errorAlert.classList.remove('hidden');

                Swal.fire({
                    icon: 'error',
                    title: 'Login Gagal',
                    text: msg,
                    confirmButtonColor: '#1e40af'
                });
            }

        } catch (error) {
            console.error(error);
            const msg = 'Terjadi kesalahan koneksi. Silakan coba lagi.';
            errorAlert.textContent = msg;
            errorAlert.classList.remove('hidden');

            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: msg,
                confirmButtonColor: '#1e40af'
            });

        } finally {
            submitBtn.disabled = false;
            btnText.textContent = 'MASUK';
        }
    });
</script>
</body>
</html>