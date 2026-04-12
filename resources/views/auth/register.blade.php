@extends('layouts.guest')

@section('content')
    <div class="brand">Laravel SSO</div>
    <div class="hero-copy">
        <span class="eyebrow">Buat akun</span>
        <h1>Daftar akun lokal</h1>
        <p>Gunakan form ini untuk membuat akun pertama Anda dan langsung masuk ke dashboard.</p>
    </div>

    @if ($errors->any())
        <div class="alert">
            <strong>Periksa input Anda.</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf
        <label for="name">Nama</label>
        <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus>

        <label for="email">Email</label>
        <input id="email" name="email" type="email" value="{{ old('email') }}" required>

        <label for="password">Password</label>
        <input id="password" name="password" type="password" required>

        <label for="password_confirmation">Konfirmasi Password</label>
        <input id="password_confirmation" name="password_confirmation" type="password" required>

        <button class="button" type="submit">Daftar</button>
    </form>

    <div class="footer">
        Sudah punya akun? <a href="{{ route('login') }}">Masuk</a>
    </div>
@endsection
