<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }} — {{ \App\Models\SiteSetting::getValue('site_name', config('app.name')) }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background: #0f0f0f;
            color: #e5e7eb;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 24px;
            overflow: hidden;
        }

        /* Animated background blobs */
        .blob {
            position: fixed;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.15;
            animation: float 8s ease-in-out infinite;
            pointer-events: none;
        }
        .blob-1 { width: 500px; height: 500px; background: #f97316; top: -150px; left: -150px; animation-delay: 0s; }
        .blob-2 { width: 400px; height: 400px; background: #ef4444; bottom: -100px; right: -100px; animation-delay: 3s; }
        .blob-3 { width: 300px; height: 300px; background: #7c3aed; top: 50%; left: 50%; transform: translate(-50%, -50%); animation-delay: 1.5s; }

        @keyframes float {
            0%, 100% { transform: translateY(0) scale(1); }
            50% { transform: translateY(-30px) scale(1.05); }
        }

        .card {
            position: relative;
            z-index: 10;
            background: rgba(26, 26, 26, 0.85);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.06);
            border-radius: 24px;
            padding: 56px 48px;
            max-width: 520px;
            width: 100%;
            text-align: center;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.5);
        }

        .error-code {
            font-size: 96px;
            font-weight: 900;
            line-height: 1;
            background: linear-gradient(135deg, #f97316, #ef4444);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 8px;
            letter-spacing: -4px;
        }

        .error-title {
            font-size: 22px;
            font-weight: 700;
            color: #fff;
            margin-bottom: 12px;
        }

        .error-message {
            font-size: 15px;
            color: rgba(255, 255, 255, 0.45);
            line-height: 1.7;
            margin-bottom: 36px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 28px;
            border-radius: 50px;
            font-size: 14px;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.25s ease;
            cursor: pointer;
            border: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, #f97316, #ef4444);
            color: #fff;
            box-shadow: 0 4px 20px rgba(249, 115, 22, 0.35);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 28px rgba(249, 115, 22, 0.5);
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.06);
            color: rgba(255, 255, 255, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
        }

        .actions { display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; }

        .divider {
            width: 60px;
            height: 3px;
            background: linear-gradient(90deg, #f97316, #ef4444);
            border-radius: 2px;
            margin: 20px auto;
        }

        @media (max-width: 480px) {
            .card { padding: 40px 24px; }
            .error-code { font-size: 72px; }
        }
    </style>
</head>
<body>
    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>
    <div class="blob blob-3"></div>

    <div class="card">
        <div class="error-code">{{ $code }}</div>
        <div class="divider"></div>
        <div class="error-title">{{ $title }}</div>
        <div class="error-message">{{ $message }}</div>
        <div class="actions">
            <a href="{{ url('/') }}" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                {{ __('Go Home') }}
            </a>
            <a href="javascript:history.back()" class="btn btn-secondary">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m12 19-7-7 7-7"/><path d="M19 12H5"/></svg>
                {{ __('Go Back') }}
            </a>
        </div>
    </div>
</body>
</html>
