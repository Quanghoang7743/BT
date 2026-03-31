<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm sinh viên</title>
    <style>
        :root {
            --bg-a: #dbeafe;
            --bg-b: #fde68a;
            --text: #0f172a;
            --muted: #475569;
            --glass: rgba(255, 255, 255, 0.48);
            --glass-border: rgba(255, 255, 255, 0.65);
            --primary: #0a84ff;
            --primary-dark: #0066d6;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: "SF Pro Text", "Helvetica Neue", "Avenir Next", sans-serif;
            color: var(--text);
            background:
                radial-gradient(circle at 16% 20%, var(--bg-a), transparent 42%),
                radial-gradient(circle at 88% 12%, #bfdbfe, transparent 36%),
                radial-gradient(circle at 80% 85%, var(--bg-b), transparent 40%),
                linear-gradient(135deg, #f8fafc 0%, #eff6ff 50%, #fff7ed 100%);
            display: grid;
            place-items: center;
            padding: 24px;
        }

        .glass {
            width: 100%;
            max-width: 680px;
            background: var(--glass);
            border: 1px solid var(--glass-border);
            border-radius: 28px;
            padding: 28px;
            box-shadow: 0 22px 48px rgba(15, 23, 42, 0.14), inset 0 1px 0 rgba(255, 255, 255, 0.72);
            backdrop-filter: blur(26px) saturate(160%);
            -webkit-backdrop-filter: blur(26px) saturate(160%);
        }

        h1 {
            margin: 0 0 8px;
            font-size: clamp(1.5rem, 2.8vw, 2rem);
            letter-spacing: -0.02em;
        }

        .subtitle {
            margin: 0 0 24px;
            color: var(--muted);
            font-size: 0.95rem;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            letter-spacing: -0.01em;
        }

        .field { margin-bottom: 18px; }

        input {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid rgba(148, 163, 184, 0.34);
            border-radius: 14px;
            background: rgba(255, 255, 255, 0.55);
            font: inherit;
            transition: border-color 180ms ease, box-shadow 180ms ease, background 180ms ease;
        }

        input:focus {
            outline: none;
            border-color: rgba(10, 132, 255, 0.58);
            background: rgba(255, 255, 255, 0.72);
            box-shadow: 0 0 0 4px rgba(10, 132, 255, 0.15);
        }

        .error {
            color: #b91c1c;
            margin: 8px 0 0;
            font-size: 0.86rem;
        }

        .actions {
            display: flex;
            gap: 12px;
            margin-top: 6px;
            flex-wrap: wrap;
        }

        button,
        a {
            border-radius: 999px;
            padding: 11px 18px;
            text-decoration: none;
            border: 1px solid transparent;
            font-weight: 600;
            font-size: 0.94rem;
            cursor: pointer;
            transition: transform 180ms ease, box-shadow 180ms ease, opacity 180ms ease;
        }

        button {
            color: #fff;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            box-shadow: 0 10px 24px rgba(10, 132, 255, 0.35);
        }

        a {
            color: #0f172a;
            background: rgba(255, 255, 255, 0.55);
            border-color: rgba(148, 163, 184, 0.3);
        }

        button:hover,
        a:hover {
            transform: translateY(-1px);
        }

        @media (max-width: 640px) {
            .glass { padding: 22px; border-radius: 22px; }
            .actions > * { flex: 1 1 auto; text-align: center; }
        }
    </style>
</head>
<body>
    <div class="glass">
        <h1>Thêm sinh viên</h1>
        <p class="subtitle">Nhập thông tin sinh viên theo phong cách giao diện Liquid Glass.</p>
        <form action="/students/store" method="POST">
            @csrf

            <div class="field">
                <label for="name">Tên sinh viên</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required>
                @error('name')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <div class="field">
                <label for="major">Ngành học</label>
                <input type="text" id="major" name="major" value="{{ old('major') }}" required>
                @error('major')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>
            <div class="field">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                @error('email')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <div class="actions">
                <button type="submit">Lưu sinh viên</button>
                <a href="/students">Quay lại danh sách</a>
            </div>
        </form>
    </div>
</body>
</html>
