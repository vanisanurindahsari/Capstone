<!DOCTYPE html>
<html lang="en">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Pegawai' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Tambahan untuk DataTables CSS --}}
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

        <a href="#" class="menu-item"><i>🏠</i> Dashboard</a>

        <a href="#" class="menu-item"><i>👤</i> Data Karyawan</a>

        <a href="#" class="menu-item"><i>📅</i> Kehadiran</a>

        {{-- === PENGAJUAN CUTI (FINAL FIX) === --}}
        <div class="menu-dropdown">

            {{-- LINK UTAMA (PINDAH HALAMAN) --}}
            <a href="{{ route('pegawai.dashboard') }}"
               class="menu-item 
                      {{ request()->routeIs('pegawai.dashboard') || request()->routeIs('cuti.*') ? 'active' : '' }}">
                <i>📝</i> Pengajuan Cuti
            </a>

            {{-- TOMBOL PANAH (HANYA UNTUK DROPDOWN) --}}
            <div class="dropdown-btn-wrapper"
                 data-bs-toggle="collapse"
                 data-bs-target="#submenuCuti"
                 role="button">
                <span style="flex:1; height: 1px;"></span>
                <span class="dropdown-arrow {{ request()->routeIs('cuti.*') ? 'rotate' : '' }}">▶</span>
            </div>

            {{-- SUBMENU --}}
            <div class="collapse {{ request()->routeIs('cuti.*') ? 'show' : '' }}" id="submenuCuti">
                <a href="{{ route('cuti.index') }}"
                   class="submenu-item {{ request()->routeIs('cuti.index') ? 'active' : '' }}">
                    ➤ Buat Pengajuan Cuti
                </a>
            </div>
        </div>

        <a href="#" class="menu-item"><i>💰</i> Penggajian</a>

        <a href="{{ route('logout') }}"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
           class="menu-item">
            <i>🔒</i> Log Out
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
            @csrf
        </form>
    </div>


    {{-- MAIN CONTENT --}}
    <div class="content-wrapper">
        @yield('content')
    </div>

    {{-- Tambahan untuk script DataTables --}}
    @stack('scripts')

    {{-- SCRIPT ROTATE PANAH --}}
    <script>
        const arrowBtn = document.querySelector('.dropdown-btn-wrapper');
        const arrow = document.querySelector('.dropdown-arrow');

        arrowBtn.addEventListener('click', () => {
            setTimeout(() => {
                arrow.classList.toggle('rotate');
            }, 150);
        });
    </script>

</body>
</html>
