<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'ABSENSI FREE' }}</title>

    {{-- BOOTSTRAP --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    {{-- VITE --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')

    <style>
        .dropdown-btn-wrapper {
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
        }
        .dropdown-arrow {
            transition: 0.3s;
            font-size: 16px;
        }
        .dropdown-arrow.rotate {
            transform: rotate(90deg);
        }
    </style>
</head>

<body>

    {{-- SIDEBAR --}}
 <div class="sidebar">
    <div class="sidebar-title">ABSENSI FREE</div>

    {{-- ADMIN --}}
    @if(auth()->user()->role === 'admin')
        <a href="{{ route('admin.dashboard') }}"
           class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="fas fa-fw fa-tachometer-alt"></i> Dashboard
        </a>

        <a href="{{ route('admin.karyawan.index') }}"
           class="menu-item {{ request()->routeIs('admin.karyawan.*') ? 'active' : '' }}">
            <i class="fas fa-fw fa-users"></i> Data Karyawan
        </a>

        <a href="#" class="menu-item">
            <i class="fas fa-fw fa-calendar-check"></i> Kehadiran
        </a>
                <a href="#" class="menu-item">
            <i class="fas fa-fw fa-paper-plane"></i> Cuti
        </a>
    @endif

    {{-- PEGAWAI --}}
    @if(auth()->user()->role === 'pegawai')
        <a href="{{ route('pegawai.dashboard') }}"
           class="menu-item {{ request()->routeIs('pegawai.dashboard') ? 'active' : '' }}">
            <i class="fas fa-fw fa-tachometer-alt"></i> Dashboard Pegawai
        </a>

        <div class="menu-dropdown">

            <a href="{{ route('pegawai.cuti.index') }}"
               class="menu-item {{ request()->routeIs('cuti.*') ? 'active' : '' }}">
                <i class="fas fa-fw fa-file-signature"></i> Pengajuan Cuti
            </a>

            <div class="dropdown-btn-wrapper"
                 data-bs-toggle="collapse"
                 data-bs-target="#submenuCuti"
                 role="button">
                <span style="flex:1;"></span>
                <span class="dropdown-arrow {{ request()->routeIs('cuti.*') ? 'rotate' : '' }}">
                    ▶
                </span>
            </div>

            <div class="collapse {{ request()->routeIs('cuti.*') ? 'show' : '' }}"
                 id="submenuCuti">

                <a href="{{ route('pegawai.cuti.index') }}"
                   class="submenu-item {{ request()->routeIs('cuti.index') ? 'active' : '' }}">
                    ➤ Ajukan Cuti
                </a>
            </div>

        </div>
    @endif

    {{-- LOGOUT --}}
    <a href="{{ route('logout') }}"
       onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
       class="menu-item">
        <i class="fas fa-fw fa-sign-out-alt"></i> Log Out
    </a>
</div>



    {{-- MAIN CONTENT --}}
    <div class="content-wrapper">
        @yield('content')
    </div>

    @stack('scripts')

    {{-- SCRIPT ROTATE PANAH --}}
    <script>
        const arrowBtn = document.querySelector('.dropdown-btn-wrapper');
        const arrow = document.querySelector('.dropdown-arrow');

        if (arrowBtn) {
            arrowBtn.addEventListener('click', () => {
                setTimeout(() => {
                    arrow.classList.toggle('rotate');
                }, 150);
            });
        }
    </script>

</body>
</html>
