<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Psikotes Kandidat')</title>

    <link rel="stylesheet" href="/adminlte/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="/adminlte/css/adminlte.min.css">

    <style>
        body {
            background-color: #f4f6f9;
        }
    </style>
</head>

<body class="hold-transition">

{{-- NAVBAR --}}
<nav class="navbar navbar-expand navbar-light bg-white border-bottom">
    <span class="navbar-brand font-weight-bold">
        Psikotes Online
    </span>

    <ul class="navbar-nav ml-auto align-items-center">
        {{-- Waktu & Sapaan --}}
        <li class="nav-item mr-3">
            <span class="nav-link text-dark" id="time-greeting" style="font-weight:500"></span>
        </li>

        {{-- Logout --}}
        <li class="nav-item">
            <a href="{{ route('logout') }}" class="nav-link text-danger">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </li>
    </ul>
</nav>

{{-- CONTENT --}}
<div class="container mt-4">

    {{-- FLASH MESSAGE --}}
    @include('partials.flash')

    {{-- PAGE CONTENT --}}
    @yield('content')

</div>

<script src="/adminlte/plugins/jquery/jquery.min.js"></script>
<script src="/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/adminlte/js/adminlte.min.js"></script>

{{-- SCRIPT WAKTU DAN SAPAAN --}}
<script>
function updateTime() {
    const now = new Date();
    const hours = now.getHours();
    const minutes = now.getMinutes().toString().padStart(2,'0');
    const seconds = now.getSeconds().toString().padStart(2,'0');

    // Tanggal format: 21 Desember 2025
    const months = ["Januari","Februari","Maret","April","Mei","Juni",
                    "Juli","Agustus","September","Oktober","November","Desember"];
    const dateStr = now.getDate() + ' ' + months[now.getMonth()] + ' ' + now.getFullYear();

    // Sapaan
    let greeting = 'Selamat ';
    if(hours < 10) greeting += 'pagi';
    else if(hours < 15) greeting += 'siang';
    else if(hours < 18) greeting += 'sore';
    else greeting += 'malam';

    // Nama kandidat dari session (jika ada)
    const name = "{{ session('candidate_name') ?? '' }}";
    
    // Update element
    document.getElementById('time-greeting').innerHTML = 
        `${greeting} ${name} | ${dateStr} | ${hours}:${minutes}:${seconds}`;
}

// Update tiap detik
setInterval(updateTime, 1000);
updateTime();
</script>

@stack('js')

</body>
</html>
