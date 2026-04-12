@extends('layouts.guest')

@section('content')
    <div class="brand">Laravel SSO</div>
    <div class="hero-copy">
        <span class="eyebrow">Akses aman</span>
        <h1>Masuk ke dashboard</h1>
        <p>Gunakan akun lokal untuk mengakses aplikasi. Reset password juga tersedia jika Anda lupa kredensial.</p>
    </div>

    @if (session('status'))
        <div class="status success">
            {{ session('status') }}
        </div>
    @endif

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

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <label for="email">Email</label>
        <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus>

        <label for="password">Password</label>
        <input id="password" name="password" type="password" required>

        <div class="row">
            <label for="remember">
                <input id="remember" name="remember" type="checkbox">
                Ingat saya
            </label>
            <a href="{{ route('password.request') }}">Lupa password?</a>
        </div>

        <button class="button" type="submit">Masuk</button>
    </form>

    <div class="footer">
        Belum punya akun? <a href="{{ route('register') }}">Daftar</a>
    </div>
@endsection
