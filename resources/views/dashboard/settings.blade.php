<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sama-Store - Paramètres Boutique</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8fafc; }</style>
</head>
<body class="text-slate-800 antialiased">

    <nav class="bg-white border-b border-slate-200 sticky top-0 z-50">
        <div class="max-w-3xl mx-auto px-4 py-4 flex items-center gap-4 h-16">
            <a href="{{ route('dashboard') }}" class="p-2 hover:bg-slate-100 rounded-full transition">
                <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <h1 class="font-bold text-lg">Paramètres de la Boutique</h1>
        </div>
    </nav>

    <main class="max-w-3xl mx-auto px-4 py-10">
        
        @if(session('success'))
            <div class="bg-emerald-50 text-emerald-600 p-4 rounded-xl border border-emerald-100 mb-6 font-semibold flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden mb-8">
            <div class="p-8">
                <h3 class="text-lg font-bold text-slate-900 mb-6">Identité Visuelle</h3>
                
                <form method="POST" action="{{ route('settings.update') }}">
                    @csrf
                    <div class="grid gap-8">
                        <div>
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Nom de la Boutique</label>
                            <input type="text" name="name" value="{{ $store->name }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3.5 focus:bg-white focus:ring-2 focus:ring-indigo-500 transition font-bold outline-none">
                            <p class="text-[10px] text-slate-400 mt-2 ml-1 italic">C'est le nom qui apparaîtra en haut de votre vitrine client.</p>
                        </div>

                        <div>
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Identifiant Unique (Slug)</label>
                            <div class="flex items-center">
                                <span class="bg-slate-100 px-4 py-3.5 rounded-l-xl border border-r-0 border-slate-200 text-slate-400 font-medium text-sm">sama-store.ai/s/</span>
                                <input type="text" name="slug" value="{{ $store->slug ?? $store->whatsapp_number }}" class="flex-1 bg-slate-50 border border-slate-200 rounded-r-xl px-4 py-3.5 focus:bg-white focus:ring-2 focus:ring-indigo-500 transition font-bold outline-none">
                            </div>
                            <p class="text-[10px] text-slate-400 mt-2 ml-1 italic">Le lien personnalisé de votre boutique (Pas d'espaces, pas d'accents).</p>
                        </div>
                    </div>

                    <div class="mt-10 pt-8 border-t border-slate-100 flex justify-end">
                        <button type="submit" class="bg-indigo-600 text-white px-10 py-4 rounded-2xl font-extrabold hover:bg-slate-900 shadow-xl shadow-indigo-100 transition transform active:scale-95">
                            Mettre à jour ma boutique
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden border-orange-200 bg-orange-50/20">
            <div class="p-8">
                <h3 class="text-lg font-bold text-slate-800 mb-2">Assistance Technique</h3>
                <p class="text-sm text-slate-500 mb-6">Un problème avec votre IA ou vos paiements ?</p>
                <a href="https://wa.me/221781560233?text=Aide technique Sama-Store" class="inline-flex items-center gap-2 bg-emerald-500 text-white px-6 py-3 rounded-xl font-bold hover:bg-emerald-600 transition shadow-lg shadow-emerald-100">
                    Contacter le Support WhatsApp
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                </a>
            </div>
        </div>
    </main>

</body>
</html>
