@extends('layouts.app')

@section('title', 'Lengkapi Profil - SSO Portal')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 p-4">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-8">
        
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-amber-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </div>
            <h1 class="text-2xl font-bold text-gray-800">Lengkapi Profil Anda</h1>
            <p class="text-gray-500 text-sm mt-2">Data Anda belum lengkap. Silakan isi NIP, Username, dan Email untuk melanjutkan ke Dashboard.</p>
        </div>

        <div id="errorAlert" class="hidden bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-4 text-sm"></div>

        <form id="profileForm" class="space-y-4">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">NIP</label>
                <input type="text" id="nip" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none" placeholder="Masukkan NIP Anda">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Username</label>
                <input type="text" id="username" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none" placeholder="Masukkan Username">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
                <input type="email" id="email" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none" placeholder="nama@instansi.go.id">
            </div>
            
            <button type="submit" id="submitBtn" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-lg transition mt-4">
                Simpan & Lanjutkan
            </button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const token = localStorage.getItem('access_token');
    const user = JSON.parse(localStorage.getItem('user') || '{}');

    if (!token) {
        window.location.href = '/login';
        return;
    }

    // Pre-fill data yang mungkin sudah ada
    document.getElementById('nip').value = user.nip || '';
    document.getElementById('username').value = user.username || '';
    document.getElementById('email').value = user.email || '';

    // Form handler
    document.getElementById('profileForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        const btn = document.getElementById('submitBtn');
        const errorAlert = document.getElementById('errorAlert');
        
        btn.disabled = true;
        btn.textContent = 'Menyimpan...';
        errorAlert.classList.add('hidden');

        const payload = {
            nip: document.getElementById('nip').value.trim(),
            username: document.getElementById('username').value.trim(),
            email: document.getElementById('email').value.trim(),
        };

        try {
            const response = await fetch('/api/profile/update', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + token
                },
                body: JSON.stringify(payload)
            });

            const data = await response.json();

            if (data.success) {
                // Update localStorage dengan data terbaru
                localStorage.setItem('user', JSON.stringify(data.user));
                
                // Redirect ke dashboard
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: 'Profil Anda telah dilengkapi.',
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    window.location.href = '/dashboard';
                });
            } else {
                errorAlert.textContent = data.message || 'Terjadi kesalahan validasi.';
                errorAlert.classList.remove('hidden');
            }
        } catch (err) {
            errorAlert.textContent = 'Gagal menghubungi server.';
            errorAlert.classList.remove('hidden');
        } finally {
            btn.disabled = false;
            btn.textContent = 'Simpan & Lanjutkan';
        }
    });
});
</script>
@endpush