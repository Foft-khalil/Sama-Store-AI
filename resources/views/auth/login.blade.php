<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sama-Store AI - Connexion</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; }
        .bg-mesh { 
            background-color: #f8fafc;
            background-image: 
                radial-gradient(at 0% 0%, rgba(99, 102, 241, 0.1) 0, transparent 50%), 
                radial-gradient(at 100% 100%, rgba(217, 70, 239, 0.1) 0, transparent 50%);
        }
        .glass { background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(20px); border: 1px solid rgba(255, 255, 255, 0.3); box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.05); }
    </style>
</head>
<body class="bg-mesh min-h-screen flex items-center justify-center p-6 relative overflow-hidden">

    <!-- Decoration blobs -->
    <div class="absolute -top-24 -left-24 w-96 h-96 bg-indigo-500/10 rounded-full blur-3xl"></div>
    <div class="absolute -bottom-24 -right-24 w-80 h-80 bg-purple-500/10 rounded-full blur-3xl"></div>

    <div class="max-w-md w-full relative z-10">
        <!-- Logo -->
        <div class="flex flex-col items-center mb-12 transform hover:scale-105 transition duration-500">
            <div class="w-20 h-20 bg-indigo-600 rounded-[2rem] flex items-center justify-center shadow-2xl shadow-indigo-200 mb-6">
                <span class="text-white font-black text-4xl">S</span>
            </div>
            <h2 class="text-3xl font-black tracking-tighter text-slate-900 leading-none">Sama-Store <span class="text-indigo-600">AI</span></h2>
            <p class="text-slate-400 text-[10px] font-black uppercase tracking-[0.3em] mt-3">Espace Vendeur Pro</p>
        </div>

        <!-- Login Card -->
        <div class="glass rounded-[3rem] p-10 md:p-12">
            <div class="mb-10">
                <h1 class="text-2xl font-black text-slate-900 mb-2">Bon retour 👋</h1>
                <p class="text-slate-500 font-medium text-sm">Entrez votre numéro WhatsApp pour accéder à votre dashboard.</p>
            </div>

            @if($errors->any())
                <div class="bg-red-50 text-red-600 p-4 rounded-2xl mb-8 text-xs font-black border border-red-100 flex items-center gap-3">
                    <svg class="w-5 h-5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.post') }}" class="space-y-8">
                @csrf
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-1 text-left">Votre Numéro WhatsApp</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-6 flex items-center pointer-events-none text-slate-400 group-focus-within:text-indigo-600 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        </div>
                        <input type="text" name="whatsapp_number" placeholder="221 77 XXX XX XX" class="w-full pl-14 pr-6 py-5 bg-white border border-indigo-50 rounded-[1.5rem] focus:ring-4 focus:ring-indigo-100 focus:border-indigo-600 transition-all outline-none font-bold text-slate-900 tracking-tight" required autofocus>
                    </div>
                </div>

                <button type="submit" class="w-full bg-slate-900 text-white font-black py-5 rounded-[1.5rem] hover:bg-indigo-600 transition-all duration-300 shadow-2xl shadow-slate-200 flex justify-center items-center gap-3 transform active:scale-95 group">
                    <span>Ouvrir mon dashboard</span>
                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </button>
            </form>

            <div class="mt-12 text-center">
                <p class="text-slate-400 text-sm font-bold tracking-tight mb-2">Pas encore de boutique ?</p>
                <a href="{{ route('register') }}" class="text-indigo-600 font-black text-sm hover:underline underline-offset-8 decoration-2 italic">Démarrer gratuitement ici →</a>
            </div>
        </div>
        
        <p class="mt-12 text-center text-slate-400 text-[10px] font-black uppercase tracking-[0.2em]">&copy; 2026 Sama-Store AI. Sécurisé 🇸🇳</p>
    </div>

</body>
</html>
