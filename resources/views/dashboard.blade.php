@extends('layouts.app')

@section('content')
<h1>Dashboard</h1>
<p>Anda berhasil login menggunakan akun lokal.</p>
<p style="margin-top:10px;">
    Kelola OAuth client untuk aplikasi lain di
    <a href="{{ route('oauth.clients.index') }}" style="color:#67e8f9;">halaman OAuth Clients</a>.
</p>

<div style="display:grid;gap:12px;margin-top:24px;">
    <div style="padding:16px;border-radius:16px;background:rgba(15,23,42,.65);border:1px solid rgba(148,163,184,.18);">
        <strong>Nama</strong><br>
        {{ auth()->user()->name }}
    </div>
    <div style="padding:16px;border-radius:16px;background:rgba(15,23,42,.65);border:1px solid rgba(148,163,184,.18);">
        <strong>Email</strong><br>
        {{ auth()->user()->email }}
    </div>
</div>
@endsection