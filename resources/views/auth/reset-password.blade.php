@extends('layouts.guest')

@section('content')
    <div class="brand">Laravel SSO</div>
    <div class="hero-copy">
        <span class="eyebrow">Set password baru</span>
        <h1>Reset password</h1>
        <p>Buat password baru untuk akun Anda.</p>
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

    <form method="POST" action="{{ route('password.store') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <label for="email">Email</label>
        <input id="email" name="email" type="email" value="{{ old('email', $request->email) }}" required autofocus>

        <label for="password">Password baru</label>
        <input id="password" name="password" type="password" required>

        <label for="password_confirmation">Konfirmasi password</label>
        <input id="password_confirmation" name="password_confirmation" type="password" required>

        <button class="button" type="submit">Simpan password baru</button>
    </form>

    <div class="footer">
        Kembali ke <a href="{{ route('login') }}">login</a>
    </div>
@endsection
