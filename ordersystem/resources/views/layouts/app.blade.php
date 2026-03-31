<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Quản lý đơn hàng')</title>
    <style>
        :root {
            --primary: #8b5cf6;
            --primary-dark: #7c3aed;
            --text: #1e293b;
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
                radial-gradient(circle at 14% 22%,#ddd6fe,transparent 36%),
                radial-gradient(circle at 88% 8%,#c4b5fd,transparent 30%),
                radial-gradient(circle at 82% 88%,#fde68a,transparent 32%),
                linear-gradient(135deg,#f8fafc 0%,#f5f3ff 50%,#fff7ed 100%);
            padding: 24px 16px;
        }
        .nav {
            max-width: 980px;
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
        .nav a:hover { transform: translateY(-1px); box-shadow: 0 6px 16px rgba(139,92,246,0.18); }
        .nav a.active { background: var(--primary); color: #fff; border-color: var(--primary); box-shadow: 0 6px 18px rgba(139,92,246,0.3); }
        .container {
            max-width: 980px;
            margin: 0 auto;
            padding: 24px;
            border-radius: 28px;
            background: var(--glass);
            border: 1px solid var(--border);
            box-shadow: 0 20px 48px rgba(30,41,59,0.12), inset 0 1px 0 rgba(255,255,255,0.7);
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
        h2 { font-size: 1.1rem; margin-bottom: 12px; }
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
            box-shadow: 0 8px 20px rgba(139,92,246,0.3);
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
        table { width: 100%; border-collapse: collapse; min-width: 500px; }
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
            border-color: rgba(139,92,246,0.5);
            box-shadow: 0 0 0 4px rgba(139,92,246,0.12);
        }
        .error-text { color: #b91c1c; font-size: 0.84rem; margin-top: 4px; }
        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 999px;
            font-size: 0.82rem;
            font-weight: 600;
            color: #fff;
        }
        .badge-pending { background: #f59e0b; }
        .badge-processing { background: #3b82f6; }
        .badge-completed { background: #10b981; }
        .actions { display: flex; gap: 10px; margin-top: 8px; flex-wrap: wrap; }
        .glass-form {
            background: rgba(255,255,255,0.45);
            border: 1px solid var(--line);
            border-radius: 18px;
            padding: 24px;
        }
        .item-row {
            display: grid;
            grid-template-columns: 1fr 100px 130px 40px;
            gap: 10px;
            align-items: start;
            margin-bottom: 12px;
        }
        .item-row input { font-size: 0.9rem; padding: 9px 12px; }
        .item-row .btn-remove {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            border: 0;
            background: #fee2e2;
            color: #dc2626;
            font-size: 1.2rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 22px;
        }
        .detail-box {
            background: rgba(255,255,255,0.45);
            border: 1px solid var(--line);
            border-radius: 18px;
            padding: 20px;
            margin-bottom: 20px;
        }
        .detail-row { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid var(--line); }
        .detail-row:last-child { border-bottom: 0; }
        .detail-label { color: var(--muted); font-size: 0.9rem; }
        .detail-value { font-weight: 600; }
        .total-row { font-size: 1.15rem; color: var(--primary-dark); }
        .inline-form { display: inline; }
        @media (max-width: 640px) {
            .container { padding: 16px; border-radius: 20px; }
            .item-row { grid-template-columns: 1fr; }
            .item-row .btn-remove { margin-top: 0; }
        }
    </style>
</head>
<body>
    <nav class="nav">
        <a href="/orders" class="{{ request()->is('orders*') ? 'active' : '' }}">Đơn hàng</a>
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
