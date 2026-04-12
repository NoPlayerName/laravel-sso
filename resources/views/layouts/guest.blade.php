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
            --bg: #081120;
            --panel: rgba(8, 15, 31, 0.82);
            --panel-border: rgba(148, 163, 184, 0.18);
            --text: #e2e8f0;
            --muted: #94a3b8;
            --accent: #67e8f9;
            --accent-strong: #2563eb;
            --success: #34d399;
            --danger: #fb7185;
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
                radial-gradient(circle at top left, rgba(103, 232, 249, 0.22), transparent 28%),
                radial-gradient(circle at 85% 20%, rgba(37, 99, 235, 0.22), transparent 24%),
                radial-gradient(circle at bottom right, rgba(56, 189, 248, 0.14), transparent 26%),
                linear-gradient(135deg, #020617 0%, #0f172a 100%);
        }

        .shell {
            min-height: 100vh;
            display: grid;
            place-items: center;
            padding: 32px 16px;
        }

        .card {
            width: 100%;
            max-width: 520px;
            background: linear-gradient(180deg, rgba(15, 23, 42, 0.9), rgba(8, 15, 31, 0.9));
            border: 1px solid var(--panel-border);
            border-radius: 28px;
            box-shadow: 0 30px 80px rgba(0, 0, 0, 0.35);
            backdrop-filter: blur(18px);
            padding: 0;
            overflow: hidden;
        }

        .card-inner {
            padding: 32px;
        }

        .brand {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--accent);
            margin-bottom: 18px;
        }

        .brand::before {
            content: '';
            width: 10px;
            height: 10px;
            border-radius: 999px;
            background: linear-gradient(135deg, var(--accent), var(--accent-strong));
            box-shadow: 0 0 20px rgba(103, 232, 249, 0.55);
        }

        h1 {
            margin: 0 0 8px;
            font-size: 2.15rem;
            line-height: 1.1;
        }

        p {
            margin: 0 0 24px;
            color: var(--muted);
            line-height: 1.6;
        }

        .hero-copy {
            margin-bottom: 22px;
        }

        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 12px;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: var(--accent);
            margin-bottom: 12px;
        }

        .eyebrow::before {
            content: '';
            width: 8px;
            height: 8px;
            border-radius: 999px;
            background: var(--accent);
        }

        .status {
            border-radius: 16px;
            padding: 12px 14px;
            margin-bottom: 18px;
            border: 1px solid transparent;
        }

        .status.success {
            background: rgba(52, 211, 153, 0.12);
            border-color: rgba(52, 211, 153, 0.28);
            color: #bbf7d0;
        }

        .alert {
            background: rgba(251, 113, 133, 0.12);
            border: 1px solid rgba(251, 113, 133, 0.28);
            color: #fecdd3;
            border-radius: 16px;
            padding: 12px 14px;
            margin-bottom: 18px;
        }

        .alert ul {
            margin: 8px 0 0;
            padding-left: 18px;
        }

        label {
            display: block;
            font-size: 14px;
            margin-bottom: 6px;
            color: #cbd5e1;
        }

        input {
            width: 100%;
            border: 1px solid rgba(148, 163, 184, 0.22);
            border-radius: 16px;
            background: rgba(15, 23, 42, 0.76);
            color: var(--text);
            padding: 14px 16px;
            margin-bottom: 16px;
            outline: none;
            transition: border-color 0.18s ease, box-shadow 0.18s ease, transform 0.18s ease;
        }

        input:focus {
            border-color: rgba(103, 232, 249, 0.82);
            box-shadow: 0 0 0 4px rgba(103, 232, 249, 0.12);
        }

        .row {
            display: flex;
            justify-content: space-between;
            gap: 16px;
            align-items: center;
            margin-bottom: 16px;
        }

        .row label {
            margin: 0;
            display: inline-flex;
            gap: 10px;
            align-items: center;
        }

        .row input[type="checkbox"] {
            width: 16px;
            height: 16px;
            margin: 0;
        }

        .field-row {
            display: flex;
            justify-content: space-between;
            gap: 16px;
            align-items: center;
            margin-bottom: 16px;
        }

        .field-row a {
            color: var(--accent);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.95rem;
        }

        .button {
            width: 100%;
            border: 0;
            border-radius: 16px;
            padding: 14px 16px;
            background: linear-gradient(135deg, var(--accent), var(--accent-strong));
            color: white;
            font-weight: 700;
            cursor: pointer;
            transition: transform 0.18s ease, filter 0.18s ease;
        }

        .button:hover {
            transform: translateY(-1px);
            filter: brightness(1.05);
        }

        .footer {
            margin-top: 16px;
            color: var(--muted);
            text-align: center;
        }

        .footer a {
            color: var(--accent);
            text-decoration: none;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="shell">
        <div class="card">
            <div class="card-inner">
                @yield('content')
            </div>
        </div>
    </div>
</body>
</html>
