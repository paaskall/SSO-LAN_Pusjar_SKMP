@extends('layouts.app')

@section('title', 'Dashboard - SSO Portal')

@section('content')
<div class="min-h-screen bg-gray-50 flex">

    {{-- ================= SIDEBAR ================= --}}
    <aside id="sidebar" class="fixed lg:static inset-y-0 left-0 z-40 w-64 bg-gradient-to-b from-blue-950 via-blue-900 to-blue-800 text-white transform -translate-x-full lg:translate-x-0 transition-transform duration-300 flex flex-col">

        {{-- Logo --}}
        <div class="flex items-center gap-3 px-6 py-6 border-b border-white/10">
            <div class="w-12 h-12 rounded-xl bg-white p-1.5 shadow-lg flex-shrink-0">
                <img src="{{ asset('assets/logo-lanri.png') }}" alt="LAN RI" class="w-full h-full object-contain">
            </div>
            <div class="min-w-0">
                <h2 class="text-base font-extrabold tracking-wide truncate">SSO PORTAL</h2>
                <p class="text-[10px] text-blue-200 tracking-widest uppercase truncate">LAN RI · Pusjar SKMP</p>
            </div>
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
            <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-lg bg-white/10 text-white font-medium text-sm transition hover:bg-white/15">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Dashboard
            </a>

            <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-lg text-blue-100 hover:bg-white/10 hover:text-white font-medium text-sm transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                Akun Saya
            </a>

            <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-lg text-blue-100 hover:bg-white/10 hover:text-white font-medium text-sm transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                Pengaturan
            </a>

            <div class="pt-4 mt-4 border-t border-white/10">
                <p class="px-4 text-[10px] text-blue-300 uppercase tracking-widest mb-2">Aplikasi Terintegrasi</p>
            </div>
        </nav>

        {{-- Footer Sidebar --}}
        <div class="px-6 py-4 border-t border-white/10 text-[10px] text-blue-200">
            <p>© {{ date('Y') }} SSO Portal</p>
            <p class="text-blue-300">LAN RI · Pusjar SKMP</p>
        </div>
    </aside>

    {{-- Overlay mobile --}}
    <div id="overlay" class="fixed inset-0 bg-black/50 z-30 hidden lg:hidden" onclick="toggleSidebar()"></div>

    {{-- ================= MAIN ================= --}}
    <div class="flex-1 flex flex-col min-w-0">

        {{-- Header --}}
        <header class="bg-white border-b border-gray-200 sticky top-0 z-20">
            <div class="px-4 sm:px-6 py-4 flex items-center justify-between gap-4">

                {{-- Menu Button (mobile) --}}
                <button onclick="toggleSidebar()" class="lg:hidden text-gray-600 hover:text-gray-900">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>

                {{-- Title + Logo (desktop) --}}
                <div class="hidden lg:flex items-center gap-3">
                    <img src="{{ asset('assets/logo-lanri.png') }}" alt="LAN RI" class="w-8 h-8 object-contain">
                    <div>
                        <h1 class="text-lg font-bold text-gray-800">Dashboard</h1>
                        <p class="text-xs text-gray-500">Kelola akses aplikasi Anda</p>
                    </div>
                </div>

                {{-- Right side --}}
                <div class="flex items-center gap-3 ml-auto">
                    <div class="hidden sm:flex items-center gap-3 px-3 py-1.5 rounded-full bg-gray-50 border border-gray-200">
                        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-500 to-blue-700 text-white flex items-center justify-center text-xs font-bold" id="userAvatar">?</div>
                        <div class="text-left">
                            <p class="text-xs font-semibold text-gray-700 leading-tight" id="userName">User</p>
                            <p class="text-[10px] text-gray-500 leading-tight" id="userRole">Pengguna</p>
                        </div>
                    </div>
                    <button id="logoutBtn" class="text-sm bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        <span class="hidden sm:inline">Logout</span>
                    </button>
                </div>
            </div>
        </header>

        {{-- Content --}}
        <main class="flex-1 p-4 sm:p-6 lg:p-8">

            {{-- Welcome banner --}}
            <div class="mb-8 rounded-2xl bg-gradient-to-r from-blue-900 via-blue-700 to-blue-500 text-white p-6 sm:p-8 relative overflow-hidden shadow-lg">
                <div class="relative z-10 flex items-start gap-5">
                    <div class="w-16 h-16 sm:w-20 sm:h-20 bg-white rounded-2xl p-2 shadow-xl flex-shrink-0">
                        <img src="{{ asset('assets/logo-lanri.png') }}" alt="LAN RI" class="w-full h-full object-contain">
                    </div>
                    <div class="flex-1 min-w-0">
                        <h2 class="text-2xl sm:text-3xl font-extrabold mb-2">Selamat Datang, <span id="welcomeName">User</span>!</h2>
                        <p class="text-blue-100 text-sm max-w-2xl">
                            Anda dapat mengakses seluruh aplikasi instansi dengan satu akun. Klik salah satu aplikasi di bawah ini untuk mulai bekerja.
                        </p>
                    </div>
                </div>
                {{-- Dekorasi --}}
                <div class="absolute -top-16 -right-16 w-64 h-64 bg-white/10 rounded-full blur-3xl pointer-events-none"></div>
                <div class="absolute -bottom-20 -right-32 w-80 h-80 bg-blue-400/20 rounded-full blur-3xl pointer-events-none"></div>
            </div>

            {{-- Section Title --}}
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-lg font-bold text-gray-800">Aplikasi Terintegrasi</h3>
                    <p class="text-xs text-gray-500">Pilih aplikasi untuk diakses</p>
                </div>
            </div>

            {{-- Grid Aplikasi --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">

                {{-- Card Keuangan (SIKAP) --}}
                <button onclick="launchApp('keuangan')"
                        class="group bg-white rounded-2xl shadow-sm hover:shadow-2xl border border-gray-100 hover:border-green-200 p-6 text-left transition-all duration-300 hover:-translate-y-1 relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-green-50 to-transparent opacity-0 group-hover:opacity-100 transition"></div>
                    <div class="relative">
                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-green-400 to-green-600 text-white flex items-center justify-center mb-4 shadow-lg shadow-green-200">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <h4 class="font-bold text-gray-800 mb-1 group-hover:text-green-700 transition">SIKAP</h4>
                        <p class="text-xs text-gray-500 mb-4">Sistem Informasi Keuangan & Anggaran</p>
                        <div class="flex items-center gap-2 text-xs font-semibold text-green-600 group-hover:gap-3 transition-all">
                            <span>Buka Aplikasi</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                        </div>
                    </div>
                </button>

                {{-- Card SDM --}}
                <button onclick="launchApp('sdm')"
                        class="group bg-white rounded-2xl shadow-sm hover:shadow-2xl border border-gray-100 hover:border-blue-200 p-6 text-left transition-all duration-300 hover:-translate-y-1 relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-50 to-transparent opacity-0 group-hover:opacity-100 transition"></div>
                    <div class="relative">
                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-400 to-blue-600 text-white flex items-center justify-center mb-4 shadow-lg shadow-blue-200">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <h4 class="font-bold text-gray-800 mb-1 group-hover:text-blue-700 transition">SDM</h4>
                        <p class="text-xs text-gray-500 mb-4">Sistem Informasi Sumber Daya Manusia</p>
                        <div class="flex items-center gap-2 text-xs font-semibold text-blue-600 group-hover:gap-3 transition-all">
                            <span>Buka Aplikasi</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                        </div>
                    </div>
                </button>

                {{-- Card Latjar --}}
                <button onclick="launchApp('latjar')"
                        class="group bg-white rounded-2xl shadow-sm hover:shadow-2xl border border-gray-100 hover:border-orange-200 p-6 text-left transition-all duration-300 hover:-translate-y-1 relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-orange-50 to-transparent opacity-0 group-hover:opacity-100 transition"></div>
                    <div class="relative">
                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-orange-400 to-orange-600 text-white flex items-center justify-center mb-4 shadow-lg shadow-orange-200">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        </div>
                        <h4 class="font-bold text-gray-800 mb-1 group-hover:text-orange-700 transition">Latjar</h4>
                        <p class="text-xs text-gray-500 mb-4">Sistem Latihan & Pembelajaran</p>
                        <div class="flex items-center gap-2 text-xs font-semibold text-orange-600 group-hover:gap-3 transition-all">
                            <span>Buka Aplikasi</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                        </div>
                    </div>
                </button>

                {{-- Card CORPU --}}
                <button onclick="launchApp('corpu')"
                        class="group bg-white rounded-2xl shadow-sm hover:shadow-2xl border border-gray-100 hover:border-purple-200 p-6 text-left transition-all duration-300 hover:-translate-y-1 relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-purple-50 to-transparent opacity-0 group-hover:opacity-100 transition"></div>
                    <div class="relative">
                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-purple-400 to-purple-600 text-white flex items-center justify-center mb-4 shadow-lg shadow-purple-200">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        </div>
                        <h4 class="font-bold text-gray-800 mb-1 group-hover:text-purple-700 transition">CORPU</h4>
                        <p class="text-xs text-gray-500 mb-4">Corporate University</p>
                        <div class="flex items-center gap-2 text-xs font-semibold text-purple-600 group-hover:gap-3 transition-all">
                            <span>Buka Aplikasi</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                        </div>
                    </div>
                </button>

                {{-- Card Kajian --}}
                <button onclick="launchApp('kajian')"
                        class="group bg-white rounded-2xl shadow-sm hover:shadow-2xl border border-gray-100 hover:border-pink-200 p-6 text-left transition-all duration-300 hover:-translate-y-1 relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-pink-50 to-transparent opacity-0 group-hover:opacity-100 transition"></div>
                    <div class="relative">
                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-pink-400 to-pink-600 text-white flex items-center justify-center mb-4 shadow-lg shadow-pink-200">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                        <h4 class="font-bold text-gray-800 mb-1 group-hover:text-pink-700 transition">Kajian</h4>
                        <p class="text-xs text-gray-500 mb-4">Sistem Manajemen Kajian</p>
                        <div class="flex items-center gap-2 text-xs font-semibold text-pink-600 group-hover:gap-3 transition-all">
                            <span>Buka Aplikasi</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                        </div>
                    </div>
                </button>

            </div>
        </main>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // ===== SIDEBAR TOGGLE (mobile) =====
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');
        sidebar.classList.toggle('-translate-x-full');
        overlay.classList.toggle('hidden');
    }

    // ===== CEK LOGIN =====
    const token = localStorage.getItem('access_token');
    const user = JSON.parse(localStorage.getItem('user') || '{}');

    if (!token) {
        window.location.href = '/login';
    } else {
        const name = user.name || 'User';
        const role = user.role || 'Pengguna';

        document.getElementById('userName').textContent = name;
        document.getElementById('welcomeName').textContent = name.split(' ')[0];
        document.getElementById('userRole').textContent = role;

        // Avatar inisial
        const initials = name.split(' ').map(w => w[0]).slice(0, 2).join('').toUpperCase();
        document.getElementById('userAvatar').textContent = initials;
    }

    // ===== FUNGSI LAUNCH APP =====
    function launchApp(appName) {
        const token = localStorage.getItem('access_token');

        if (!token) {
            Swal.fire({
                icon: 'error',
                title: 'Sesi Berakhir',
                text: 'Silakan login ulang.',
                confirmButtonColor: '#1e40af'
            }).then(() => {
                window.location.href = '/login';
            });
            return;
        }

        window.location.href = `/sso/launch/${appName}?token=${encodeURIComponent(token)}`;
    }

    // ===== LOGOUT =====
    document.getElementById('logoutBtn').addEventListener('click', async function() {
        const result = await Swal.fire({
            icon: 'question',
            title: 'Logout?',
            text: 'Anda akan keluar dari SSO Portal.',
            showCancelButton: true,
            confirmButtonText: 'Ya, Logout',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6b7280'
        });

        if (!result.isConfirmed) return;

        try {
            await fetch('/api/logout', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + token
                }
            });
        } catch (e) {
            console.error('Logout error:', e);
        }

        localStorage.removeItem('access_token');
        localStorage.removeItem('user');
        window.location.href = '/login';
    });
</script>
@endpush