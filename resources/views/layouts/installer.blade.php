<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ __('Installation') }} - {{ config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        * { font-family: 'Inter', sans-serif; }
        body { background: #030712; overflow-x: hidden; color: #fff; }

        .bg-grid {
            background-image:
                linear-gradient(rgba(99,102,241,.07) 1px, transparent 1px),
                linear-gradient(90deg, rgba(99,102,241,.07) 1px, transparent 1px);
            background-size: 40px 40px;
        }

        .orb {
            position: fixed;
            border-radius: 50%;
            filter: blur(80px);
            opacity: .35;
            animation: drift 12s ease-in-out infinite alternate;
            pointer-events: none;
        }
        .orb-1 { width: 600px; height: 600px; background: radial-gradient(circle, #6366f1, #8b5cf6); top: -200px; left: -200px; animation-delay: 0s; }
        .orb-2 { width: 500px; height: 500px; background: radial-gradient(circle, #06b6d4, #3b82f6); bottom: -150px; right: -150px; animation-delay: -6s; }
        .orb-3 { width: 300px; height: 300px; background: radial-gradient(circle, #f59e0b, #ef4444); top: 50%; left: 50%; transform: translate(-50%,-50%); animation-delay: -3s; opacity: .15; }

        @keyframes drift {
            from { transform: translate(0, 0) scale(1); }
            to   { transform: translate(40px, 30px) scale(1.08); }
        }

        .glass {
            background: rgba(255,255,255,.04);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(255,255,255,.08);
        }

        .glass-card {
            background: rgba(255,255,255,.05);
            backdrop-filter: blur(32px);
            -webkit-backdrop-filter: blur(32px);
            border: 1px solid rgba(255,255,255,.1);
            box-shadow: 0 32px 64px rgba(0,0,0,.4), inset 0 1px 0 rgba(255,255,255,.1);
        }

        .step-active { background: linear-gradient(135deg, #6366f1, #8b5cf6); box-shadow: 0 0 20px rgba(99,102,241,.6); }
        .step-done   { background: linear-gradient(135deg, #10b981, #059669); }
        .step-idle   { background: rgba(255,255,255,.08); border: 1px solid rgba(255,255,255,.12); }

        .connector-done { background: linear-gradient(90deg, #10b981, #6366f1); }
        .connector-idle { background: rgba(255,255,255,.1); }

        .btn-primary {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            box-shadow: 0 8px 32px rgba(99,102,241,.4);
            transition: all .2s;
        }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 12px 40px rgba(99,102,241,.5); }
        .btn-primary:active { transform: translateY(0); }

        .btn-success {
            background: linear-gradient(135deg, #10b981, #059669);
            box-shadow: 0 8px 32px rgba(16,185,129,.4);
            transition: all .2s;
        }
        .btn-success:hover { transform: translateY(-2px); box-shadow: 0 12px 40px rgba(16,185,129,.5); }

        .input-field {
            background: rgba(255,255,255,.06) !important;
            border: 1px solid rgba(255,255,255,.1) !important;
            color: #fff !important;
            transition: all .2s;
        }
        .input-field:focus {
            outline: none !important;
            border-color: rgba(99,102,241,.6) !important;
            background: rgba(99,102,241,.08) !important;
            box-shadow: 0 0 0 4px rgba(99,102,241,.12) !important;
        }
        .input-field::placeholder { color: rgba(255,255,255,.3) !important; }
        .input-field:-webkit-autofill,
        .input-field:-webkit-autofill:hover,
        .input-field:-webkit-autofill:focus {
            -webkit-text-fill-color: #fff !important;
            -webkit-box-shadow: 0 0 0 1000px rgba(30,27,75,.9) inset !important;
            transition: background-color 5000s ease-in-out 0s;
        }

        .req-row { background: rgba(255,255,255,.04); border: 1px solid rgba(255,255,255,.07); transition: background .2s; }
        .req-row:hover { background: rgba(255,255,255,.07); }
        .req-row span, .req-row p { color: inherit; }

        .badge-pass { background: rgba(16,185,129,.15); color: #34d399; border: 1px solid rgba(16,185,129,.25); }
        .badge-fail { background: rgba(239,68,68,.15); color: #f87171; border: 1px solid rgba(239,68,68,.25); }

        .label-text { color: rgba(255,255,255,.5) !important; font-size: .65rem; font-weight: 700; letter-spacing: .12em; text-transform: uppercase; display: block; margin-bottom: .375rem; }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-up { animation: fadeUp .4s ease forwards; }

        @keyframes pulse-ring {
            0%   { box-shadow: 0 0 0 0 rgba(99,102,241,.5); }
            70%  { box-shadow: 0 0 0 16px rgba(99,102,241,0); }
            100% { box-shadow: 0 0 0 0 rgba(99,102,241,0); }
        }
        .pulse-ring { animation: pulse-ring 2s infinite; }

        [x-cloak] { display: none !important; }
    </style>
    @livewireStyles
</head>
<body class="antialiased bg-grid min-h-screen">
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
    <div class="orb orb-3"></div>
    <div class="relative z-10 min-h-screen">
        {{ $slot }}
    </div>
    @livewireScripts
    <script>
        const initIcons = () => lucide.createIcons();
        document.addEventListener('DOMContentLoaded', initIcons);
        document.addEventListener('livewire:navigated', initIcons);
        document.addEventListener('livewire:updated', () => setTimeout(initIcons, 30));
        document.addEventListener('livewire:morph', () => setTimeout(initIcons, 30));
        Livewire.hook('commit', ({ component, commit, respond, succeed, fail }) => {
            succeed(({ snapshot, effect }) => { setTimeout(initIcons, 50); });
        });
    </script>
</body>
</html>
