<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel SSO') }}</title>
    <style>
        :root {
            color-scheme: dark;
            --bg: #07111f;
            --panel: rgba(15, 23, 42, 0.85);
            --border: rgba(148, 163, 184, 0.18);
            --text: #e2e8f0;
            --muted: #94a3b8;
            --accent: #67e8f9;
            --accent-strong: #2563eb;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: "Segoe UI", "Trebuchet MS", sans-serif;
            color: var(--text);
            background:
                radial-gradient(circle at top left, rgba(103, 232, 249, 0.12), transparent 32%),
                radial-gradient(circle at top right, rgba(37, 99, 235, 0.16), transparent 28%),
                linear-gradient(135deg, #020617 0%, #0f172a 100%);
        }

        .nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            padding: 20px 28px;
            border-bottom: 1px solid var(--border);
            background: rgba(3, 7, 18, 0.35);
            backdrop-filter: blur(16px);
        }

        .brand {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .brand strong {
            font-size: 1rem;
            letter-spacing: 0.06em;
            text-transform: uppercase;
        }

        .brand span {
            color: var(--muted);
            font-size: 0.92rem;
        }

        .nav form {
            margin: 0;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-right: 10px;
        }

        .nav-link {
            text-decoration: none;
            color: var(--text);
            border: 1px solid var(--border);
            border-radius: 999px;
            padding: 8px 12px;
            font-size: 0.9rem;
        }

        .nav-link.active {
            border-color: rgba(96, 165, 250, 0.55);
            color: #fff;
            background: rgba(37, 99, 235, 0.28);
        }

        .button {
            border: 1px solid rgba(96, 165, 250, 0.35);
            border-radius: 999px;
            padding: 10px 16px;
            color: white;
            background: linear-gradient(135deg, var(--accent), var(--accent-strong));
            cursor: pointer;
            font-weight: 700;
        }

        main {
            max-width: 1000px;
            margin: 0 auto;
            padding: 32px 20px 56px;
        }

        .panel {
            background: var(--panel);
            border: 1px solid var(--border);
            border-radius: 24px;
            padding: 28px;
            box-shadow: 0 30px 80px rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(18px);
        }

        .panel h1 {
            margin-top: 0;
        }
    </style>
</head>

<body>
    <header class="nav">
        <div class="brand">
            <strong>{{ config('app.name', 'Laravel SSO') }}</strong>
            <span>Local login starter</span>
        </div>
        <div style="display:flex;align-items:center;gap:10px;">
            <nav class="nav-links">
                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                    href="{{ route('dashboard') }}">Dashboard</a>
                <a class="nav-link {{ request()->routeIs('oauth.clients.*') ? 'active' : '' }}"
                    href="{{ route('oauth.clients.index') }}">OAuth Clients</a>
            </nav>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="button" type="submit">Logout</button>
            </form>
        </div>
    </header>

    <main>
        <div class="panel">
            @yield('content')
        </div>
    </main>
</body>

</html>