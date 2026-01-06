<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'ABSENSI FREE' }}</title>

    {{-- BOOTSTRAP CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- FONT AWESOME --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    {{-- VITE (GLOBAL CSS & JS) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- PAGE / MODULE CSS --}}
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

<div class="d-flex">
    {{-- SIDEBAR --}}
    @include('layouts.sidebar')

    {{-- MAIN CONTENT --}}
    <div class="content-wrapper flex-grow-1 p-4">
        @yield('content')
    </div>
</div>

{{-- LOGOUT FORM --}}
<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>

{{-- JQUERY (WAJIB SEBELUM PLUGIN) --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

{{-- BOOTSTRAP JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

{{-- PAGE / MODULE JS --}}
@stack('scripts')

</body>
</html>
