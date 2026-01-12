<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title','HRD Panel')</title>

    {{-- ADMINLTE OFFLINE --}}
    <link rel="stylesheet" href="/adminlte/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="/adminlte/css/adminlte.min.css">

    {{-- GLOBAL UI --}}
    <link rel="stylesheet" href="/css/app-ui.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    {{-- NAVBAR --}}
    <nav class="main-header navbar navbar-expand navbar-white navbar-light border-bottom">
        <ul class="navbar-nav">
            {{-- TOGGLE SIDEBAR --}}
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                    <i class="fas fa-bars"></i>
                </a>
            </li>

            {{-- GREETING --}}
            <li class="nav-item d-none d-sm-inline-block">
                <span class="nav-link font-weight-normal">
                    <i id="greetingIcon" class="mr-1"></i>
                        <span id="greeting"></span>,
                    <strong>{{ \App\Models\Hrd::find(session('hrd_id'))->name ?? 'HRD' }}</strong>

                </span>
            </li>
        </ul>

        <ul class="navbar-nav ml-auto">
            {{-- CLOCK --}}
            <li class="nav-item d-none d-sm-inline-block">
                <span class="nav-link text-muted">
                    <i class="far fa-clock mr-1"></i>
                    <span id="clock"></span>
                </span>
            </li>

            {{-- LOGOUT --}}
            <li class="nav-item">
                <a href="{{ route('logout') }}" class="nav-link text-danger">
                    <i class="fas fa-sign-out-alt"></i>
                </a>
            </li>
        </ul>
    </nav>

    {{-- SIDEBAR --}}
    <aside class="main-sidebar sidebar-light-primary elevation-2">
        {{-- BRAND --}}
        <a href="{{ route('hrd.dashboard') }}" class="brand-link border-bottom">
            <i class="fas fa-user-shield ml-2 mr-2 text-primary"></i>
            <span class="brand-text font-weight-bold">HRD Panel</span>
        </a>


        <div class="sidebar">

            <nav class="mt-3">
                <ul class="nav nav-pills nav-sidebar flex-column nav-flat">

                    <li class="nav-item">
                        <a href="{{ route('hrd.dashboard') }}"
                           class="nav-link {{ request()->routeIs('hrd.dashboard') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-home"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('hrd.categories.index') }}"
                           class="nav-link {{ request()->routeIs('hrd.categories*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-list"></i>
                            <p>Kategori Soal</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('hrd.candidates.index') }}"
                           class="nav-link {{ request()->routeIs('hrd.candidates*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Master Kandidat</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('hrd.reports.index') }}"
                           class="nav-link {{ request()->routeIs('hrd.reports*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-chart-bar"></i>
                            <p>Laporan Kandidat</p>
                        </a>
                    </li>

                </ul>
            </nav>
        </div>
    </aside>

    {{-- CONTENT --}}
    <div class="content-wrapper">
        <div class="container-fluid py-3">

            {{-- FLASH --}}
            @include('partials.flash')

            {{-- PAGE CONTENT --}}
            @yield('content')

        </div>
    </div>

</div>

{{-- ADMINLTE JS OFFLINE --}}
<script src="/adminlte/plugins/jquery/jquery.min.js"></script>
<script src="/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/adminlte/js/adminlte.min.js"></script>

{{-- GREETING & CLOCK --}}
<script>
    function updateGreeting() {
        const hour = new Date().getHours();
        let greeting = 'Selamat Malam';
        let icon = 'fas fa-moon text-secondary';

        if (hour >= 4 && hour < 11) {
            greeting = 'Selamat Pagi';
            icon = 'fas fa-sun text-warning';
        } else if (hour >= 11 && hour < 15) {
            greeting = 'Selamat Siang';
            icon = 'fas fa-cloud-sun text-primary';
        } else if (hour >= 15 && hour < 18) {
            greeting = 'Selamat Sore';
            icon = 'fas fa-cloud-sun text-orange';
        }

        document.getElementById('greeting').innerText = greeting;
        document.getElementById('greetingIcon').className = icon;
    }
    
    function updateClock() {
        const now = new Date();
        document.getElementById('clock').innerText =
            now.toLocaleDateString('id-ID', {
                weekday: 'long',
                day: '2-digit',
                month: 'long',
                year: 'numeric'
            }) + ' • ' +
            now.toLocaleTimeString('id-ID', {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });
    }

    updateGreeting();
    updateClock();
    setInterval(updateClock, 1000);
</script>

</body>
</html>
