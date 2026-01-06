{{-- SIDEBAR --}}
<div class="sidebar">
    <div class="sidebar-title">ABSENSI FREE</div>

    {{-- ADMIN --}}
    @if(auth()->user()->role === 'admin')

        <a href="{{ route('admin.dashboard') }}"
           class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            Dashboard
        </a>

        <a href="{{ route('admin.karyawan.index') }}"
           class="menu-item {{ request()->routeIs('admin.karyawan.*') ? 'active' : '' }}">
            <i class="fas fa-fw fa-users"></i>
            Data Karyawan
        </a>
        
        <a href="{{ route('admin.presensi.index') }}"
           class="menu-item {{ request()->routeIs('admin.presensi.*') ? 'active' : '' }}">
            <i class="fas fa-fw fa-calendar-check"></i>
            Presensi
        </a>

        <a href="#" class="menu-item">
            <i class="fas fa-fw fa-paper-plane"></i>
            Cuti
        </a>

    @endif

    {{-- PEGAWAI --}}
    @if(auth()->user()->role === 'pegawai')

        <a href="{{ route('pegawai.dashboard') }}"
           class="menu-item {{ request()->routeIs('pegawai.dashboard') ? 'active' : '' }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            Dashboard Pegawai
        </a>

        <div class="menu-dropdown">
            <a href="{{ route('pegawai.presensi.index') }}"
               class="menu-item {{ request()->routeIs('pegawai.presensi.*') ? 'active' : '' }}">
                <i class="fas fa-fw fa-calendar-check"></i>
                Presensi
            </a>
        </div>

        <div class="menu-dropdown">
            <a href="{{ route('pegawai.cuti.index') }}"
               class="menu-item {{ request()->routeIs('cuti.*') ? 'active' : '' }}">
                <i class="fas fa-fw fa-file-signature"></i>
                Pengajuan Cuti
            </a>
        </div>

    @endif

    {{-- LOGOUT --}}
    <a href="{{ route('logout') }}"
       onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
       class="menu-item">
        <i class="fas fa-fw fa-sign-out-alt"></i>
        Log Out
    </a>
</div>
