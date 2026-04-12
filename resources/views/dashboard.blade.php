@extends('layouts.app')

@section('content')
    <h1>Dashboard</h1>
    <p>Anda berhasil login menggunakan akun lokal.</p>

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
