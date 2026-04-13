@extends('layouts.app')

@section('content')
<h1>OAuth Clients</h1>
<p>Buat client OAuth untuk setiap aplikasi agar integrasi SSO tidak perlu memakai CLI.</p>

@if (session('status'))
<div
    style="margin:16px 0;padding:12px 14px;border-radius:12px;background:rgba(16,185,129,.15);border:1px solid rgba(16,185,129,.4);">
    {{ session('status') }}
</div>
@endif

@if (session('created_client'))
<div
    style="margin:16px 0;padding:14px;border-radius:12px;background:rgba(37,99,235,.18);border:1px solid rgba(96,165,250,.45);display:grid;gap:8px;">
    <strong>Client Baru Dibuat (Simpan sekarang)</strong>
    <div><strong>Name:</strong> {{ session('created_client.name') }}</div>
    <div><strong>Client ID:</strong> <code>{{ session('created_client.id') }}</code></div>
    <div><strong>Type:</strong> {{ session('created_client.type') }}</div>
    @if (session('created_client.secret'))
    <div><strong>Client Secret:</strong> <code>{{ session('created_client.secret') }}</code></div>
    @else
    <div><strong>Client Secret:</strong> Tidak ada (Public PKCE)</div>
    @endif
</div>
@endif

@if ($errors->any())
<div
    style="margin:16px 0;padding:12px 14px;border-radius:12px;background:rgba(244,63,94,.12);border:1px solid rgba(251,113,133,.45);">
    <strong>Gagal menyimpan client:</strong>
    <ul style="margin:8px 0 0 20px;">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<section
    style="margin-top:22px;padding:18px;border-radius:16px;background:rgba(15,23,42,.65);border:1px solid rgba(148,163,184,.18);">
    <h2 style="margin:0 0 14px;">Tambah Client</h2>
    <form method="POST" action="{{ route('oauth.clients.store') }}" style="display:grid;gap:12px;">
        @csrf

        <label style="display:grid;gap:6px;">
            <span>Nama Aplikasi</span>
            <input type="text" name="name" value="{{ old('name') }}" placeholder="Contoh: Payroll Web" required
                style="padding:10px 12px;border-radius:10px;border:1px solid rgba(148,163,184,.35);background:#0b1220;color:#e2e8f0;">
        </label>

        <label style="display:grid;gap:6px;">
            <span>Jenis Client</span>
            <select name="client_type" required
                style="padding:10px 12px;border-radius:10px;border:1px solid rgba(148,163,184,.35);background:#0b1220;color:#e2e8f0;">
                <option value="public_pkce" @selected(old('client_type')==='public_pkce' )>Public PKCE (SPA / Mobile)
                </option>
                <option value="confidential" @selected(old('client_type')==='confidential' )>Confidential (Backend
                    Server)</option>
            </select>
        </label>

        <label style="display:grid;gap:6px;">
            <span>Redirect URI</span>
            <textarea name="redirect_uris" rows="3" required
                placeholder="Satu baris per URI. Contoh: http://localhost:3000/auth/callback"
                style="padding:10px 12px;border-radius:10px;border:1px solid rgba(148,163,184,.35);background:#0b1220;color:#e2e8f0;">{{ old('redirect_uris') }}</textarea>
        </label>

        <div>
            <button class="button" type="submit">Buat OAuth Client</button>
        </div>
    </form>
</section>

<section style="margin-top:20px;display:grid;gap:12px;">
    <h2 style="margin:0;">Client Milik Anda</h2>

    @forelse ($clients as $client)
    <article
        style="padding:14px;border-radius:14px;background:rgba(15,23,42,.65);border:1px solid rgba(148,163,184,.18);display:grid;gap:8px;">
        <div style="display:flex;justify-content:space-between;gap:12px;align-items:center;">
            <strong>{{ $client->name }}</strong>
            @if ($client->revoked)
            <span style="color:#fda4af;font-size:0.9rem;">Revoked</span>
            @else
            <span style="color:#86efac;font-size:0.9rem;">Active</span>
            @endif
        </div>
        <div><strong>Client ID:</strong> <code>{{ $client->id }}</code></div>
        <div><strong>Tipe:</strong> {{ $client->confidential() ? 'Confidential' : 'Public PKCE' }}</div>
        <div><strong>Grant:</strong> {{ implode(', ', $client->grant_types ?? []) }}</div>
        <div>
            <strong>Redirect URI:</strong>
            <ul style="margin:6px 0 0 20px;">
                @forelse ($client->redirect_uris as $uri)
                <li><code>{{ $uri }}</code></li>
                @empty
                <li>-</li>
                @endforelse
            </ul>
        </div>

        @if (! $client->revoked)
        <form method="POST" action="{{ route('oauth.clients.destroy', $client->id) }}"
            onsubmit="return confirm('Revoke client ini?')">
            @csrf
            @method('DELETE')
            <button type="submit"
                style="border:1px solid rgba(251,113,133,.45);border-radius:999px;padding:8px 14px;background:rgba(190,24,93,.25);color:#fff;cursor:pointer;">Revoke</button>
        </form>
        @endif
    </article>
    @empty
    <div style="padding:14px;border-radius:14px;background:rgba(15,23,42,.65);border:1px dashed rgba(148,163,184,.35);">
        Belum ada client. Buat client pertama untuk aplikasi Anda.
    </div>
    @endforelse
</section>
@endsection