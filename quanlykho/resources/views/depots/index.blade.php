<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kho hang</title>
    <style>
        :root {
            --text: #0f172a;
            --muted: #475569;
            --glass: rgba(255, 255, 255, 0.5);
            --glass-strong: rgba(255, 255, 255, 0.62);
            --border: rgba(255, 255, 255, 0.66);
            --line: rgba(148, 163, 184, 0.3);
            --primary: #0a84ff;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            min-height: 100vh;
            padding: 28px 18px;
            font-family: "SF Pro Text", "Helvetica Neue", "Avenir Next", sans-serif;
            color: var(--text);
            background:
                radial-gradient(circle at 12% 15%, #bfdbfe, transparent 34%),
                radial-gradient(circle at 90% 9%, #bae6fd, transparent 28%),
                radial-gradient(circle at 88% 86%, #fde68a, transparent 30%),
                linear-gradient(135deg, #f8fafc 0%, #eef2ff 48%, #fff7ed 100%);
        }

        .container {
            max-width: 980px;
            margin: 0 auto;
            padding: 22px;
            border-radius: 30px;
            background: var(--glass);
            border: 1px solid var(--border);
            box-shadow: 0 24px 55px rgba(15, 23, 42, 0.16), inset 0 1px 0 rgba(255, 255, 255, 0.72);
            backdrop-filter: blur(26px) saturate(160%);
            -webkit-backdrop-filter: blur(26px) saturate(160%);
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
            gap: 12px;
            flex-wrap: wrap;
        }

        h1 {
            margin: 0;
            font-size: clamp(1.35rem, 2.4vw, 1.9rem);
            letter-spacing: -0.02em;
        }

        .hint {
            margin: 6px 0 0;
            color: var(--muted);
            font-size: 0.92rem;
        }

        a.btn {
            color: #fff;
            background: linear-gradient(135deg, var(--primary), #0066d6);
            padding: 10px 16px;
            border-radius: 999px;
            text-decoration: none;
            font-weight: 600;
            box-shadow: 0 10px 24px rgba(10, 132, 255, 0.34);
            transition: transform 180ms ease;
        }

        a.btn:hover { transform: translateY(-1px); }

        .success {
            background: rgba(220, 252, 231, 0.72);
            color: #166534;
            border: 1px solid rgba(134, 239, 172, 0.72);
            padding: 11px 14px;
            border-radius: 14px;
            margin-bottom: 14px;
        }

        .table-wrap {
            overflow: auto;
            border-radius: 18px;
            border: 1px solid var(--line);
            background: var(--glass-strong);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 640px;
        }

        th,
        td {
            border-bottom: 1px solid var(--line);
            padding: 12px 14px;
            text-align: left;
            white-space: nowrap;
        }

        th {
            font-size: 0.83rem;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            color: #334155;
            background: rgba(255, 255, 255, 0.46);
        }

        tbody tr:hover { background: rgba(255, 255, 255, 0.38); }

        td:last-child,
        th:last-child { min-width: 160px; }

        .empty {
            text-align: center;
            color: var(--muted);
            padding: 20px;
        }

        @media (max-width: 640px) {
            .container { padding: 16px; border-radius: 22px; }
            .header { align-items: flex-start; }
            a.btn { width: 100%; text-align: center; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div>
                <h1>Danh sách hàng hóa</h1>
            </div>
            <a class="btn" href="/depots/create">Thêm sản phẩm</a>
        </div>

        @if (session('success'))
            <div class="success">{{ session('success') }}</div>
        @endif

        <form method="GET" action="/depots" style="margin: 0 0 14px; display:flex; gap:8px; align-items: center; flex-wrap: wrap;">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Tìm kiếm theo tên" style="padding:8px 12px; border-radius: 999px; border:1px solid #d1d5db;" />
                <select name="sort" style="padding:8px 12px; border-radius: 999px; border:1px solid #d1d5db;">
                <option value="name" {{ request('sort')=='name' ? 'selected' : '' }}>Tên</option>
                <option value="price" {{ request('sort')=='price' ? 'selected' : '' }}>Giá</option>
                <option value="quantity" {{ request('sort')=='quantity' ? 'selected' : '' }}>Số lượng</option>
            </select>
            <select name="direction" style="padding:8px 12px; border-radius: 999px; border:1px solid #d1d5db;">
                <option value="asc" {{ request('direction','asc')=='asc' ? 'selected' : '' }}>Asc</option>
                <option value="desc" {{ request('direction')=='desc' ? 'selected' : '' }}>Desc</option>
            </select>
            <button type="submit" style="padding:8px 14px; border-radius:999px; border:0; background:#0a84ff; color:white;">Lọc</button>
        </form>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên sản phẩm</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th>Danh mục</th>
                        <th>Ngày tạo</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($depots as $depot)
                        <tr>
                            <td>{{ $depot->id }}</td>
                            <td>{{ $depot->name }}</td>
                            <td>{{ number_format($depot->price, 0, ',', '.') }} đ</td>
                            <td>{{ $depot->quantity }}</td>
                            <td>{{ $depot->category }}</td>
                            <td>{{ $depot->created_at?->format('d/m/Y H:i') }}</td>
                            <td>
                                <form action="/depots/{{ $depot->id }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa?')" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="background:#ef4444; color:#fff; border:0; padding:6px 12px; border-radius:999px; cursor:pointer; font-size:0.85rem;">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="empty" colspan="6">Chưa có sản phẩm nào.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($depots->hasPages())
            <div style="text-align:center; margin-top:12px;">{{ $depots->links() }}</div>
        @endif
    </div>
</body>
</html>
