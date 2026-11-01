@extends('layouts.app')

@section('title', 'Manajemen User - SSO Portal')

@section('content')
<div class="min-h-screen bg-gray-50 flex">

    {{-- ================= SIDEBAR ================= --}}
    <aside id="sidebar" class="fixed lg:static inset-y-0 left-0 z-40 w-64 bg-gradient-to-b from-blue-950 via-blue-900 to-blue-800 text-white transform -translate-x-full lg:translate-x-0 transition-transform duration-300 flex flex-col">

        <div class="flex items-center gap-3 px-6 py-6 border-b border-white/10">
            <img src="{{ asset('assets/logo-lanri.png') }}" alt="LAN RI" class="h-12 w-auto flex-shrink-0 object-contain brightness-0 invert">
            <div class="min-w-0">
                <h2 class="text-base font-extrabold tracking-wide truncate">SSO PORTAL</h2>
                <p class="text-[10px] text-blue-200 tracking-widest uppercase truncate">LAN RI · Pusjar SKMP</p>
            </div>
        </div>

        <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
            <a href="/dashboard" class="flex items-center gap-3 px-4 py-3 rounded-lg text-blue-100 hover:bg-white/10 hover:text-white font-medium text-sm transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Dashboard
            </a>

            <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-lg text-blue-100 hover:bg-white/10 hover:text-white font-medium text-sm transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                Akun Saya
            </a>

            <a href="/admin/users" aria-current="page" class="flex items-center gap-3 px-4 py-3 rounded-lg bg-white/10 text-white font-medium text-sm transition hover:bg-white/15">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                Manajemen User
            </a>

            <div class="pt-4 mt-4 border-t border-white/10">
                <p class="px-4 text-[10px] text-blue-300 uppercase tracking-widest mb-2">Aplikasi Terintegrasi</p>
            </div>
        </nav>

        <div class="px-6 py-4 border-t border-white/10 text-[10px] text-blue-200">
            <p>© {{ date('Y') }} SSO Portal</p>
            <p class="text-blue-300">LAN RI · Pusjar SKMP</p>
        </div>
    </aside>

    <div id="overlay" class="fixed inset-0 bg-black/50 z-30 hidden lg:hidden" onclick="toggleSidebar()"></div>

    {{-- ================= MAIN ================= --}}
    <div class="flex-1 flex flex-col min-w-0">

        {{-- Header --}}
        <header class="bg-white border-b border-gray-200 sticky top-0 z-20">
            <div class="px-4 sm:px-6 py-4 flex items-center justify-between gap-4">
                <button onclick="toggleSidebar()" aria-label="Buka menu" class="lg:hidden text-gray-600 hover:text-gray-900">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>

                <div class="flex items-center gap-3">
                    <img src="{{ asset('assets/lan.png') }}" alt="LAN RI" class="h-10 w-auto object-contain">
                    <div class="hidden sm:block">
                        <h1 class="text-lg font-bold text-gray-800">Manajemen User</h1>
                        <p class="text-xs text-gray-500">Atur akses aplikasi dan peran pengguna</p>
                    </div>
                </div>

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
            <div class="max-w-7xl mx-auto">

                {{-- Statistik --}}
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 mb-6">
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 sm:p-5">
                        <p class="text-xs font-medium text-gray-500">Total User</p>
                        <p class="mt-1 text-2xl sm:text-3xl font-extrabold text-gray-900" id="statTotal">–</p>
                    </div>
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 sm:p-5">
                        <p class="text-xs font-medium text-gray-500">Super Admin</p>
                        <p class="mt-1 text-2xl sm:text-3xl font-extrabold text-blue-900" id="statAdmin">–</p>
                    </div>
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 sm:p-5">
                        <p class="text-xs font-medium text-gray-500">Akses SIKAP</p>
                        <p class="mt-1 text-2xl sm:text-3xl font-extrabold text-emerald-600" id="statKeuangan">–</p>
                    </div>
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 sm:p-5">
                        <p class="text-xs font-medium text-gray-500">Akses SIPERDI</p>
                        <p class="mt-1 text-2xl sm:text-3xl font-extrabold text-teal-600" id="statSiperdi">–</p>
                    </div>
                </div>

                {{-- Panel daftar user --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

                    {{-- Toolbar --}}
                    <div class="p-4 sm:p-6 border-b border-gray-100 space-y-4">
                        <div>
                            <h2 class="text-lg font-bold text-gray-900">Daftar User &amp; Akses Aplikasi</h2>
                            <p class="mt-1 text-sm text-gray-500" id="resultInfo">Memuat data...</p>
                        </div>

                        <div class="flex flex-col gap-3 md:flex-row">
                            <div class="relative flex-1">
                                <svg class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M11 18a7 7 0 100-14 7 7 0 000 14z"/></svg>
                                <input id="searchInput" type="search" placeholder="Cari nama atau username..." aria-label="Cari user"
                                       class="block w-full rounded-lg border border-gray-300 bg-white py-2.5 pl-9 pr-3 text-sm text-gray-900 placeholder:text-gray-400 focus:border-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-700/20">
                            </div>
                            <select id="filterRole" aria-label="Filter role global" class="rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm text-gray-700 focus:border-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-700/20">
                                <option value="">Semua role</option>
                            </select>
                            <select id="filterApp" aria-label="Filter akses aplikasi" class="rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm text-gray-700 focus:border-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-700/20">
                                <option value="">Semua akses</option>
                            </select>
                        </div>
                    </div>

                    {{-- Tabel (tablet & desktop) --}}
                    <div class="hidden md:block overflow-x-auto">
                        <table class="min-w-full text-left text-sm">
                            <thead class="bg-gray-50 text-xs text-gray-500">
                                <tr>
                                    <th scope="col" class="px-6 py-3 font-semibold">Nama / Username</th>
                                    <th scope="col" class="px-6 py-3 font-semibold">Role Global</th>
                                    <th scope="col" class="px-6 py-3 font-semibold">Akses Aplikasi</th>
                                    <th scope="col" class="px-6 py-3 font-semibold text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="userTableBody" class="divide-y divide-gray-100"></tbody>
                        </table>
                    </div>

                    {{-- Daftar kartu (mobile) --}}
                    <div id="userCardList" class="md:hidden divide-y divide-gray-100"></div>

                    {{-- Status kosong / error --}}
                    <div id="stateBox" class="hidden px-6 py-14 text-center"></div>
                </div>
            </div>
        </main>
    </div>
</div>

{{-- ================= MODAL EDIT AKSES ================= --}}
<div id="editModal" class="fixed inset-0 z-50 hidden items-end justify-center bg-black/50 sm:items-center sm:p-4" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
    <div class="w-full max-w-md max-h-[90vh] overflow-y-auto rounded-t-2xl bg-white shadow-xl sm:rounded-2xl">

        <div class="flex items-start justify-between gap-4 border-b border-gray-100 px-5 py-4 sm:px-6">
            <div class="flex items-center gap-3 min-w-0">
                <div id="modalAvatar" class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full bg-gradient-to-br from-blue-500 to-blue-700 text-sm font-bold text-white">?</div>
                <div class="min-w-0">
                    <h3 id="modalTitle" class="text-base font-bold text-gray-900">Atur Akses Aplikasi</h3>
                    <p id="modalUserName" class="truncate text-sm text-gray-500"></p>
                </div>
            </div>
            <button type="button" onclick="closeModal()" aria-label="Tutup" class="rounded-md p-1 text-gray-400 transition hover:text-gray-700">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <form id="accessForm">
            <input type="hidden" id="editUserId">
            <div id="appsList" class="space-y-3 p-5 sm:p-6"></div>

            <div class="flex flex-col-reverse gap-2 border-t border-gray-100 px-5 py-4 sm:flex-row sm:justify-end sm:px-6">
                <button type="button" onclick="closeModal()" class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-50">Batal</button>
                <button type="submit" id="saveBtn" class="inline-flex items-center justify-center rounded-lg bg-blue-800 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-900 disabled:opacity-60">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // ===== SIDEBAR TOGGLE (mobile) =====
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('-translate-x-full');
        document.getElementById('overlay').classList.toggle('hidden');
    }

    // ===== CEK LOGIN =====
    const token = localStorage.getItem('access_token');
    const me = JSON.parse(localStorage.getItem('user') || '{}');

    if (!token) {
        window.location.href = '/login';
    } else if ((me.role || 'user') !== 'super_admin') {
        window.location.href = '/dashboard';
    } else {
        const name = me.name || 'User';
        document.getElementById('userName').textContent = name;
        document.getElementById('userRole').textContent = 'Super Admin';
        document.getElementById('userAvatar').textContent = initials(name);
    }

    document.getElementById('logoutBtn').addEventListener('click', function () {
        window.location.href = '/sso-logout';
    });

    // ===== KONFIGURASI APLIKASI (tambah baris baru di sini untuk aplikasi lain) =====
    const APPS = [
        { slug: 'keuangan', name: 'SIKAP',   desc: 'Keuangan',
          chip: 'bg-emerald-50 text-emerald-700 ring-emerald-200', defaultRole: 'user',
          roles: [['admin_keuangan', 'Admin Keuangan'], ['keuangan', 'Keuangan'], ['pimpinan', 'Pimpinan'], ['user', 'User']] },
        { slug: 'siperdi',  name: 'SIPERDI', desc: 'Perjalanan Dinas',
          chip: 'bg-teal-50 text-teal-700 ring-teal-200', defaultRole: 'pegawai',
          roles: [['pegawai', 'Pegawai'], ['keuangan', 'Keuangan'], ['pimpinan', 'Pimpinan']] },
    ];

    let allUsers = [];

    // ===== HELPER =====
    function esc(v) {
        return String(v ?? '').replace(/[&<>"']/g, c => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]));
    }
    function initials(name) {
        return String(name || '?').split(' ').filter(Boolean).map(w => w[0]).slice(0, 2).join('').toUpperCase() || '?';
    }
    function userApps(u) {
        return (u.apps || []).map(a => typeof a === 'string' ? { slug: a, role: null } : a);
    }
    function roleBadge(role) {
        if (role === 'super_admin') {
            return '<span class="inline-flex items-center rounded-full bg-blue-50 px-2.5 py-0.5 text-xs font-semibold text-blue-800 ring-1 ring-inset ring-blue-200">Super Admin</span>';
        }
        const label = (role === 'user' || !role) ? 'Pengguna' : esc(role);
        return `<span class="inline-flex items-center rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-semibold text-gray-700 ring-1 ring-inset ring-gray-200">${label}</span>`;
    }
    function appChips(u) {
        const apps = userApps(u);
        if (!apps.length) return '<span class="text-sm text-gray-400">Belum ada akses</span>';
        return apps.map(a => {
            const cfg = APPS.find(x => x.slug === a.slug);
            const label = cfg ? cfg.name : String(a.slug).toUpperCase();
            const roleLabel = cfg && a.role ? (cfg.roles.find(r => r[0] === a.role) || [])[1] || a.role : a.role;
            const cls = cfg ? cfg.chip : 'bg-gray-100 text-gray-700 ring-gray-200';
            return `<span class="inline-flex items-center gap-1 rounded-full px-2.5 py-0.5 text-xs font-semibold ring-1 ring-inset ${cls}">${esc(label)}${roleLabel ? `<span class="font-normal opacity-80">· ${esc(roleLabel)}</span>` : ''}</span>`;
        }).join(' ');
    }
    const editBtn = id => `<button type="button" data-edit="${id}" class="rounded-md border border-gray-300 px-3 py-1.5 text-xs font-semibold text-gray-700 transition hover:border-blue-800 hover:text-blue-800">Edit Akses</button>`;

    // ===== AMBIL DATA =====
    async function fetchUsers() {
        showSkeleton();
        try {
            const res = await fetch('/api/admin/users', {
                headers: { 'Authorization': 'Bearer ' + token, 'Accept': 'application/json' }
            });
            if (res.status === 401) { window.location.href = '/login'; return; }
            if (res.status === 403) { showState('Akses ditolak', 'Anda tidak memiliki izin untuk melihat halaman ini.'); return; }
            if (!res.ok) throw new Error('HTTP ' + res.status);
            const json = await res.json();
            allUsers = json.data || [];
            buildFilters();
            render();
        } catch (e) {
            showState('Gagal memuat data', 'Periksa koneksi Anda, lalu coba lagi.', true);
        }
    }

    function buildFilters() {
        const roleSel = document.getElementById('filterRole');
        const appSel = document.getElementById('filterApp');
        const roles = [...new Set(allUsers.map(u => u.role).filter(Boolean))];
        roleSel.innerHTML = '<option value="">Semua role</option>' +
            roles.map(r => `<option value="${esc(r)}">${r === 'super_admin' ? 'Super Admin' : (r === 'user' ? 'Pengguna' : esc(r))}</option>`).join('');
        appSel.innerHTML = '<option value="">Semua akses</option>' +
            APPS.map(a => `<option value="${a.slug}">Akses ${esc(a.name)}</option>`).join('') +
            '<option value="__none">Tanpa akses</option>';
    }

    // ===== RENDER =====
    function render() {
        const q = document.getElementById('searchInput').value.trim().toLowerCase();
        const fr = document.getElementById('filterRole').value;
        const fa = document.getElementById('filterApp').value;

        const list = allUsers.filter(u => {
            const apps = userApps(u).map(a => a.slug);
            if (q && !(`${u.name} ${u.username}`.toLowerCase().includes(q))) return false;
            if (fr && u.role !== fr) return false;
            if (fa === '__none' && apps.length) return false;
            if (fa && fa !== '__none' && !apps.includes(fa)) return false;
            return true;
        });

        // Statistik (dari seluruh data)
        document.getElementById('statTotal').textContent = allUsers.length;
        document.getElementById('statAdmin').textContent = allUsers.filter(u => u.role === 'super_admin').length;
        document.getElementById('statKeuangan').textContent = allUsers.filter(u => userApps(u).some(a => a.slug === 'keuangan')).length;
        document.getElementById('statSiperdi').textContent = allUsers.filter(u => userApps(u).some(a => a.slug === 'siperdi')).length;
        document.getElementById('resultInfo').textContent = `Menampilkan ${list.length} dari ${allUsers.length} user`;

        const tbody = document.getElementById('userTableBody');
        const cards = document.getElementById('userCardList');

        if (!list.length) {
            tbody.innerHTML = ''; cards.innerHTML = '';
            showState(allUsers.length ? 'Tidak ada user yang cocok' : 'Belum ada user',
                      allUsers.length ? 'Coba ubah kata kunci atau filter pencarian.' : 'Data user akan tampil di sini.');
            return;
        }
        hideState();

        tbody.innerHTML = list.map(u => `
            <tr class="transition-colors hover:bg-gray-50">
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div class="flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-full bg-blue-50 text-xs font-bold text-blue-800">${esc(initials(u.name))}</div>
                        <div class="min-w-0">
                            <div class="font-semibold text-gray-900">${esc(u.name)}</div>
                            <div class="text-xs text-gray-500">${esc(u.username)}</div>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4">${roleBadge(u.role)}</td>
                <td class="px-6 py-4"><div class="flex flex-wrap gap-1.5">${appChips(u)}</div></td>
                <td class="px-6 py-4 text-right">${editBtn(u.id)}</td>
            </tr>`).join('');

        cards.innerHTML = list.map(u => `
            <div class="p-4">
                <div class="flex items-start justify-between gap-3">
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full bg-blue-50 text-sm font-bold text-blue-800">${esc(initials(u.name))}</div>
                        <div class="min-w-0">
                            <div class="truncate font-semibold text-gray-900">${esc(u.name)}</div>
                            <div class="truncate text-xs text-gray-500">${esc(u.username)}</div>
                        </div>
                    </div>
                    ${roleBadge(u.role)}
                </div>
                <div class="mt-3 flex flex-wrap gap-1.5">${appChips(u)}</div>
                <button type="button" data-edit="${u.id}" class="mt-4 w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm font-semibold text-gray-700 transition hover:border-blue-800 hover:text-blue-800">Edit Akses</button>
            </div>`).join('');
    }

    function showSkeleton() {
        hideState();
        document.getElementById('userTableBody').innerHTML = '';
        const row = '<div class="flex items-center gap-3 p-4 sm:px-6"><div class="h-9 w-9 animate-pulse rounded-full bg-gray-200"></div><div class="flex-1 space-y-2"><div class="h-3 w-1/3 animate-pulse rounded bg-gray-200"></div><div class="h-3 w-1/4 animate-pulse rounded bg-gray-100"></div></div></div>';
        document.getElementById('userCardList').innerHTML = row.repeat(4);
        // tampilkan skeleton juga di desktop lewat state box
        const box = document.getElementById('stateBox');
        box.className = 'hidden md:block p-0 divide-y divide-gray-100';
        box.innerHTML = row.repeat(4);
    }

    function showState(title, text, retry) {
        const box = document.getElementById('stateBox');
        box.className = 'px-6 py-14 text-center';
        box.innerHTML = `
            <div class="mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-gray-100 text-gray-400">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
            </div>
            <p class="font-semibold text-gray-800">${esc(title)}</p>
            <p class="mt-1 text-sm text-gray-500">${esc(text)}</p>
            ${retry ? '<button type="button" id="retryBtn" class="mt-4 rounded-lg bg-blue-800 px-5 py-2 text-sm font-semibold text-white transition hover:bg-blue-900">Coba lagi</button>' : ''}`;
        document.getElementById('userCardList').innerHTML = '';
        document.getElementById('userTableBody').innerHTML = '';
        if (retry) {
            document.getElementById('resultInfo').textContent = 'Data tidak dapat dimuat';
            document.getElementById('retryBtn').addEventListener('click', fetchUsers);
        }
    }

    function hideState() {
        const box = document.getElementById('stateBox');
        box.className = 'hidden';
        box.innerHTML = '';
    }

    // ===== MODAL AKSES =====
    function openModal(id) {
        const user = allUsers.find(u => String(u.id) === String(id));
        if (!user) return;

        document.getElementById('editUserId').value = user.id;
        document.getElementById('modalUserName').textContent = `${user.name} (${user.username})`;
        document.getElementById('modalAvatar').textContent = initials(user.name);

        const current = userApps(user);
        document.getElementById('appsList').innerHTML = APPS.map(app => {
            const owned = current.find(a => a.slug === app.slug);
            const selected = (owned && owned.role) || app.defaultRole;
            return `
            <div class="rounded-xl border border-gray-200 p-4">
                <label class="flex cursor-pointer items-center justify-between gap-3">
                    <span class="min-w-0">
                        <span class="block text-sm font-semibold text-gray-900">${esc(app.name)}</span>
                        <span class="block text-xs text-gray-500">${esc(app.desc)}</span>
                    </span>
                    <span class="relative inline-flex flex-shrink-0">
                        <input type="checkbox" id="chk-${app.slug}" data-app="${app.slug}" class="peer sr-only" ${owned ? 'checked' : ''}>
                        <span class="h-6 w-11 rounded-full bg-gray-300 transition peer-checked:bg-blue-800 peer-focus-visible:ring-2 peer-focus-visible:ring-blue-800 peer-focus-visible:ring-offset-2"></span>
                        <span class="pointer-events-none absolute left-0.5 top-0.5 h-5 w-5 rounded-full bg-white shadow transition peer-checked:translate-x-5"></span>
                    </span>
                </label>
                <div id="wrap-${app.slug}" class="${owned ? '' : 'hidden'} mt-3 border-t border-gray-100 pt-3">
                    <label for="role-${app.slug}" class="mb-1 block text-xs font-medium text-gray-500">Role di ${esc(app.name)}</label>
                    <select id="role-${app.slug}" class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-800 focus:border-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-700/20">
                        ${app.roles.map(r => `<option value="${r[0]}" ${r[0] === selected ? 'selected' : ''}>${esc(r[1])}</option>`).join('')}
                    </select>
                </div>
            </div>`;
        }).join('');

        const modal = document.getElementById('editModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.classList.add('overflow-hidden');
    }

    function closeModal() {
        const modal = document.getElementById('editModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.classList.remove('overflow-hidden');
    }

    // ===== EVENT =====
    document.addEventListener('click', function (e) {
        const btn = e.target.closest('[data-edit]');
        if (btn) openModal(btn.dataset.edit);
        if (e.target.id === 'editModal') closeModal();
    });
    document.addEventListener('keydown', e => { if (e.key === 'Escape') closeModal(); });

    document.getElementById('appsList').addEventListener('change', function (e) {
        const slug = e.target.dataset && e.target.dataset.app;
        if (slug) document.getElementById('wrap-' + slug).classList.toggle('hidden', !e.target.checked);
    });

    ['searchInput', 'filterRole', 'filterApp'].forEach(id => {
        document.getElementById(id).addEventListener(id === 'searchInput' ? 'input' : 'change', render);
    });

    document.getElementById('accessForm').addEventListener('submit', async function (e) {
        e.preventDefault();
        const id = document.getElementById('editUserId').value;
        const appsData = APPS
            .filter(a => document.getElementById('chk-' + a.slug).checked)
            .map(a => ({ slug: a.slug, role: document.getElementById('role-' + a.slug).value }));

        const saveBtn = document.getElementById('saveBtn');
        saveBtn.disabled = true;
        saveBtn.textContent = 'Menyimpan...';

        try {
            const res = await fetch(`/api/admin/users/${id}/access`, {
                method: 'POST',
                headers: {
                    'Authorization': 'Bearer ' + token,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ apps: appsData })
            });

            if (res.ok) {
                closeModal();
                await fetchUsers();
                Swal.fire({ icon: 'success', title: 'Berhasil', text: 'Hak akses diperbarui', confirmButtonColor: '#1e40af' });
            } else {
                Swal.fire({ icon: 'error', title: 'Gagal', text: 'Terjadi kesalahan', confirmButtonColor: '#1e40af' });
            }
        } catch (err) {
            Swal.fire({ icon: 'error', title: 'Gagal', text: 'Tidak dapat terhubung ke server', confirmButtonColor: '#1e40af' });
        } finally {
            saveBtn.disabled = false;
            saveBtn.textContent = 'Simpan';
        }
    });

    document.addEventListener('DOMContentLoaded', fetchUsers);
</script>
@endpush