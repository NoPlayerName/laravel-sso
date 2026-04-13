<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Authorize Application</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 2rem; background: #f6f7fb; color: #1f2937; }
        .card { max-width: 640px; margin: 0 auto; background: #fff; border: 1px solid #e5e7eb; border-radius: 8px; padding: 24px; }
        h1 { margin: 0 0 12px; font-size: 1.4rem; }
        p { margin: 10px 0; }
        ul { margin: 10px 0 18px 20px; }
        .actions { display: flex; gap: 10px; }
        button { border: 0; border-radius: 6px; padding: 10px 14px; cursor: pointer; }
        .approve { background: #166534; color: #fff; }
        .deny { background: #b91c1c; color: #fff; }
        form { display: inline; }
    </style>
</head>
<body>
<div class="card">
    <h1>Authorize {{ $client->name }}</h1>
    <p><strong>{{ $client->name }}</strong> ingin mengakses akun Anda.</p>

    @if(count($scopes ?? []) > 0)
        <p>Izin yang diminta:</p>
        <ul>
            @foreach($scopes as $scope)
                <li>{{ $scope->description ?: $scope->id }}</li>
            @endforeach
        </ul>
    @endif

    <div class="actions">
        <form method="post" action="{{ route('passport.authorizations.approve') }}">
            @csrf
            <input type="hidden" name="state" value="{{ $request->state }}">
            <input type="hidden" name="client_id" value="{{ $client->getKey() }}">
            <input type="hidden" name="auth_token" value="{{ $authToken }}">
            <button class="approve" type="submit">Authorize</button>
        </form>

        <form method="post" action="{{ route('passport.authorizations.deny') }}">
            @csrf
            @method('DELETE')
            <input type="hidden" name="state" value="{{ $request->state }}">
            <input type="hidden" name="client_id" value="{{ $client->getKey() }}">
            <input type="hidden" name="auth_token" value="{{ $authToken }}">
            <button class="deny" type="submit">Deny</button>
        </form>
    </div>
</div>
</body>
</html>
