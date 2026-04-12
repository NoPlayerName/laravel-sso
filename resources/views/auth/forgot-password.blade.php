@extends('layouts.guest')

@section('content')
    <div class="brand">Laravel SSO</div>
    <div class="hero-copy">
        <span class="eyebrow">Reset lokal</span>
        <h1>Lupa password?</h1>
        <p>Kirim tautan reset ke email yang terdaftar. Di project ini email reset akan masuk ke log mailer.</p>
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

    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <label for="email">Email</label>
        <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus>

        <button class="button" type="submit">Kirim link reset</button>
    </form>

    <div class="footer">
        Kembali ke <a href="{{ route('login') }}">login</a>
    </div>
@endsection
