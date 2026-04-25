<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>License Required</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 flex items-center justify-center min-h-screen p-6">
    <div class="max-w-md w-full bg-white rounded-[2rem] shadow-2xl shadow-blue-900/10 p-10 text-center border border-slate-100">
        <div class="w-20 h-20 bg-red-50 rounded-3xl flex items-center justify-center mx-auto mb-8">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-red-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m14.5 9-5 5"/><path d="m9.5 9 5 5"/>
            </svg>
        </div>
        
        <h1 class="text-2xl font-extrabold text-slate-900 mb-4">License Verification Failed</h1>
        <p class="text-slate-500 leading-relaxed mb-8">
            {{ $message ?? 'This product requires a valid license to operate. Please contact the administrator to activate your installation.' }}
        </p>

        <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100 mb-8 text-xs font-mono text-slate-400 break-all">
            Fingerprint: {{ md5(php_uname() . php_sapi_name() . (isset($_SERVER['SERVER_ADDR']) ? $_SERVER['SERVER_ADDR'] : 'local')) }}
        </div>

        <div class="flex flex-col gap-3">
            <a href="{{ route('license.activate') }}" class="inline-flex items-center justify-center w-full py-4 bg-blue-600 text-white rounded-2xl font-bold hover:bg-blue-700 transition-all shadow-lg shadow-blue-600/20">
                Activate Now
            </a>
            <a href="mailto:admin@example.com" class="inline-flex items-center justify-center w-full py-4 bg-slate-100 text-slate-600 rounded-2xl font-bold hover:bg-slate-200 transition-all">
                Contact Support
            </a>
        </div>
    </div>
</body>
</html>
