<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Đặt lịch hẹn')</title>
    <style>
        :root {
            --primary: #0ea5e9;
            --primary-dark: #0284c7;
            --text: #0f172a;
            --muted: #64748b;
            --glass: rgba(255,255,255,0.55);
            --border: rgba(255,255,255,0.65);
            --line: rgba(148,163,184,0.25);
            --success: rgba(220,252,231,0.72);
            --success-text: #166534;
            --error: rgba(254,226,226,0.72);
            --error-text: #991b1b;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            min-height: 100vh;
            font-family: "SF Pro Text","Helvetica Neue","Avenir Next",sans-serif;
            color: var(--text);
            background:
                radial-gradient(circle at 18% 22%,#bae6fd,transparent 36%),
                radial-gradient(circle at 90% 10%,#a5f3fc,transparent 30%),
                radial-gradient(circle at 82% 88%,#fde68a,transparent 32%),
                linear-gradient(135deg,#f8fafc 0%,#f0f9ff 50%,#fff7ed 100%);
            padding: 24px 16px;
        }
        .nav {
            max-width: 900px;
            margin: 0 auto 20px;
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
        }
        .nav a {
            padding: 9px 18px;
            border-radius: 999px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            color: var(--text);
            background: var(--glass);
            border: 1px solid var(--border);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            transition: transform 150ms, box-shadow 150ms;
        }
        .nav a:hover { transform: translateY(-1px); box-shadow: 0 6px 16px rgba(14,165,233,0.18); }
        .nav a.active { background: var(--primary); color: #fff; border-color: var(--primary); box-shadow: 0 6px 18px rgba(14,165,233,0.3); }
        .container {
            max-width: 900px;
            margin: 0 auto;
            padding: 24px;
            border-radius: 28px;
            background: var(--glass);
            border: 1px solid var(--border);
            box-shadow: 0 20px 48px rgba(15,23,42,0.12), inset 0 1px 0 rgba(255,255,255,0.7);
            backdrop-filter: blur(22px) saturate(150%);
            -webkit-backdrop-filter: blur(22px) saturate(150%);
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
            gap: 12px;
            flex-wrap: wrap;
        }
        h1 { font-size: clamp(1.3rem,2.2vw,1.8rem); letter-spacing: -0.02em; }
        .subtitle { color: var(--muted); font-size: 0.92rem; margin-top: 4px; }
        .btn {
            display: inline-block;
            color: #fff;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            padding: 10px 18px;
            border-radius: 999px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            border: 0;
            cursor: pointer;
            box-shadow: 0 8px 20px rgba(14,165,233,0.3);
            transition: transform 150ms;
        }
        .btn:hover { transform: translateY(-1px); }
        .btn-sm { padding: 6px 12px; font-size: 0.82rem; }
        .btn-danger { background: linear-gradient(135deg, #ef4444, #dc2626); box-shadow: 0 8px 20px rgba(239,68,68,0.25); }
        .btn-outline {
            color: var(--text);
            background: rgba(255,255,255,0.55);
            border: 1px solid var(--line);
            box-shadow: none;
        }
        .alert {
            padding: 11px 14px;
            border-radius: 14px;
            margin-bottom: 14px;
            font-size: 0.92rem;
        }
        .alert-success { background: var(--success); color: var(--success-text); border: 1px solid rgba(134,239,172,0.5); }
        .alert-error { background: var(--error); color: var(--error-text); border: 1px solid rgba(252,165,165,0.5); }
        .table-wrap {
            overflow: auto;
            border-radius: 16px;
            border: 1px solid var(--line);
            background: rgba(255,255,255,0.45);
        }
        table { width: 100%; border-collapse: collapse; min-width: 480px; }
        th, td { padding: 11px 14px; text-align: left; border-bottom: 1px solid var(--line); white-space: nowrap; }
        th {
            font-size: 0.8rem;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            color: #475569;
            background: rgba(255,255,255,0.4);
        }
        tbody tr:hover { background: rgba(255,255,255,0.3); }
        .empty { text-align: center; color: var(--muted); padding: 20px; }
        label { display: block; margin-bottom: 6px; font-weight: 600; font-size: 0.92rem; }
        .field { margin-bottom: 16px; }
        .row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
        input, select {
            width: 100%;
            padding: 11px 14px;
            border: 1px solid var(--line);
            border-radius: 12px;
            background: rgba(255,255,255,0.6);
            font: inherit;
            font-size: 0.95rem;
            transition: border-color 150ms, box-shadow 150ms;
        }
        input:focus, select:focus {
            outline: none;
            border-color: rgba(14,165,233,0.5);
            box-shadow: 0 0 0 4px rgba(14,165,233,0.12);
        }
        .error-text { color: #b91c1c; font-size: 0.84rem; margin-top: 4px; }
        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 999px;
            font-size: 0.82rem;
            font-weight: 600;
        }
        .badge-upcoming { background: rgba(14,165,233,0.12); color: #0369a1; }
        .badge-past { background: rgba(148,163,184,0.2); color: #64748b; }
        .actions { display: flex; gap: 10px; margin-top: 8px; flex-wrap: wrap; }
        .glass-form {
            max-width: 560px;
            background: rgba(255,255,255,0.45);
            border: 1px solid var(--line);
            border-radius: 18px;
            padding: 24px;
        }
        .filter-bar {
            display: flex;
            gap: 10px;
            margin-bottom: 14px;
            flex-wrap: wrap;
            align-items: center;
        }
        .filter-bar input { width: auto; min-width: 160px; }
        .filter-bar .btn-sm { padding: 9px 14px; }
        .inline-form { display: inline; }
        @media (max-width: 640px) {
            .container { padding: 16px; border-radius: 20px; }
            .row { grid-template-columns: 1fr; }
            .btn { width: 100%; text-align: center; }
        }
    </style>
</head>
<body>
    <nav class="nav">
        <a href="/appointments" class="{{ request()->is('appointments*') ? 'active' : '' }}">Lịch hẹn</a>
    </nav>
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif
        @yield('content')
    </div>
</body>
</html>
