@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')

<div class="container">
    <h1 class="h3 mb-4 text-gray-800">Dashboard Admin</h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            <h5 class="mb-3">Selamat datang, {{ Auth::user()->name }}</h5>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="btn btn-danger" type="submit">Logout</button>
            </form>
        </div>
    </div>
</div>

@endsection
