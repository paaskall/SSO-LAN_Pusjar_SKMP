<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Logging out...</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gray-50 flex items-center justify-center h-screen">
    <script>
        // Hapus token dari browser
        localStorage.removeItem('access_token');
        localStorage.removeItem('user');
        
        // Arahkan ke halaman login SSO
        window.location.href = '/login';
    </script>
</body>
</html>