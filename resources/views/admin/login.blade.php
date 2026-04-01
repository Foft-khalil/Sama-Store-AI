<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sama-Store AI — Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; }
        .bg-mesh {
            background-color: #0f0f1a;
            background-image:
                radial-gradient(at 20% 30%, rgba(99,102,241,0.15) 0, transparent 50%),
                radial-gradient(at 80% 70%, rgba(168,85,247,0.15) 0, transparent 50%);
        }
        .glass { background: rgba(255,255,255,0.04); backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.08); }
    </style>
</head>
<body class="bg-mesh min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-sm">
        <!-- Logo -->
        <div class="text-center mb-10">
            <div class="w-16 h-16 bg-indigo-600 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-2xl shadow-indigo-500/30">
                <span class="text-white font-black text-2xl italic">S</span>
            </div>
            <h1 class="text-white font-black text-2xl tracking-tighter">Sama-Store AI</h1>
            <p class="text-slate-500 text-sm mt-1 font-medium">Panel Administrateur</p>
        </div>

        <!-- Alerts -->
        @if(session('error'))
            <div class="bg-red-500/10 border border-red-500/20 text-red-400 px-5 py-3 rounded-2xl text-sm font-bold mb-6 text-center">
                {{ session('error') }}
            </div>
        @endif

        <!-- Login Card -->
        <div class="glass rounded-3xl p-8">
            <form method="POST" action="{{ route('admin.login.post') }}">
                @csrf
                <div class="mb-6">
                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Mot de passe Admin</label>
                    <input
                        type="password"
                        name="password"
                        required
                        autofocus
                        placeholder="••••••••••••"
                        class="w-full bg-white/5 border border-white/10 rounded-xl px-5 py-4 text-white text-sm font-medium focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 outline-none transition placeholder-slate-600"
                    >
                </div>

                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-500 text-white font-black py-4 rounded-xl transition shadow-lg shadow-indigo-500/30 flex items-center justify-center gap-2 active:scale-95">
                    Accéder au Panel
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </button>
            </form>
        </div>

        <p class="text-center text-slate-700 text-xs mt-6 font-medium">Accès restreint · Sama-Store AI v2.0</p>
    </div>
</body>
</html>
