<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel — Sama-Store AI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; }
        .bg-mesh {
            background-color: #0a0a14;
            background-image:
                radial-gradient(at 10% 10%, rgba(99,102,241,0.1) 0, transparent 40%),
                radial-gradient(at 90% 80%, rgba(168,85,247,0.08) 0, transparent 40%);
        }
        .glass { background: rgba(255,255,255,0.03); backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.07); }
        .glass-card { background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08); }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: rgba(99,102,241,0.3); border-radius: 10px; }
    </style>
</head>
<body class="bg-mesh min-h-screen text-white antialiased">

    <!-- Top Nav -->
    <header class="sticky top-0 z-50 glass border-b border-white/5 px-6 py-4">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-indigo-600 rounded-xl flex items-center justify-center shadow-lg shadow-indigo-500/30">
                    <span class="text-white font-black text-lg italic">S</span>
                </div>
                <div>
                    <h1 class="font-black text-base leading-none tracking-tight">Sama-Store AI</h1>
                    <span class="text-[9px] font-black uppercase tracking-widest text-indigo-400">Super Admin Panel</span>
                </div>
            </div>
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" class="glass-card text-slate-400 hover:text-red-400 text-xs font-bold px-4 py-2 rounded-xl transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    Déconnexion
                </button>
            </form>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-6 py-10">

        <!-- Flash messages -->
        @if(session('success'))
            <div class="bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 px-5 py-3 rounded-2xl text-sm font-bold mb-8 flex items-center gap-2">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                {{ session('success') }}
            </div>
        @endif

        <!-- Metric Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-10">
            <div class="glass-card rounded-2xl p-6">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500 mb-3">Total Boutiques</p>
                <p class="text-5xl font-black text-white leading-none">{{ $metrics['total_stores'] }}</p>
                <p class="text-indigo-400 text-xs font-bold mt-2">🏪 Créées via WhatsApp</p>
            </div>
            <div class="glass-card rounded-2xl p-6">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500 mb-3">Total Produits</p>
                <p class="text-5xl font-black text-white leading-none">{{ $metrics['total_products'] }}</p>
                <p class="text-purple-400 text-xs font-bold mt-2">📦 Analysés par l'IA</p>
            </div>
            <div class="glass-card rounded-2xl p-6">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500 mb-3">Total Commandes</p>
                <p class="text-5xl font-black text-white leading-none">{{ $metrics['total_orders'] }}</p>
                <p class="text-emerald-400 text-xs font-bold mt-2">🛒 Reçues sur les boutiques</p>
            </div>
        </div>

        <!-- Stores Table -->
        <div class="glass-card rounded-3xl overflow-hidden">
            <div class="px-8 py-5 border-b border-white/5 flex items-center justify-between">
                <h2 class="font-black text-lg tracking-tight">Toutes les Boutiques</h2>
                <span class="text-[10px] font-black uppercase tracking-widest text-slate-500 bg-white/5 px-3 py-1 rounded-full">{{ $metrics['total_stores'] }} clients</span>
            </div>

            @if($stores->isEmpty())
                <div class="py-20 text-center">
                    <p class="text-slate-600 font-bold">Aucune boutique créée pour l'instant.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-white/5">
                                <th class="text-left px-8 py-4 text-[10px] font-black uppercase tracking-widest text-slate-600">WhatsApp</th>
                                <th class="text-left px-4 py-4 text-[10px] font-black uppercase tracking-widest text-slate-600">Nom Boutique</th>
                                <th class="text-center px-4 py-4 text-[10px] font-black uppercase tracking-widest text-slate-600">Produits</th>
                                <th class="text-center px-4 py-4 text-[10px] font-black uppercase tracking-widest text-slate-600">Commandes</th>
                                <th class="text-left px-4 py-4 text-[10px] font-black uppercase tracking-widest text-slate-600">Créée le</th>
                                <th class="text-center px-4 py-4 text-[10px] font-black uppercase tracking-widest text-slate-600">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($stores as $store)
                            <tr class="border-b border-white/5 hover:bg-white/[0.02] transition group">
                                <td class="px-8 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 bg-indigo-600/20 rounded-xl flex items-center justify-center text-indigo-400 font-black text-sm shrink-0">
                                            {{ substr($store->name ?? $store->whatsapp_number, 0, 1) }}
                                        </div>
                                        <span class="text-slate-300 font-bold">+{{ $store->whatsapp_number }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-4">
                                    <a href="{{ url('/s/' . ($store->slug ?? $store->whatsapp_number)) }}" target="_blank" class="text-indigo-400 hover:text-indigo-300 font-bold transition flex items-center gap-1">
                                        {{ $store->name ?? 'Boutique sans nom' }}
                                        <svg class="w-3 h-3 opacity-0 group-hover:opacity-100 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                    </a>
                                </td>
                                <td class="px-4 py-4 text-center">
                                    <span class="bg-purple-500/10 text-purple-400 px-3 py-1 rounded-full text-xs font-black">{{ $store->products_count }}</span>
                                </td>
                                <td class="px-4 py-4 text-center">
                                    <span class="bg-emerald-500/10 text-emerald-400 px-3 py-1 rounded-full text-xs font-black">{{ $store->orders_count }}</span>
                                </td>
                                <td class="px-4 py-4 text-slate-500 font-medium text-xs">
                                    {{ $store->created_at->format('d/m/Y') }}<br>
                                    <span class="text-slate-700">{{ $store->created_at->diffForHumans() }}</span>
                                </td>
                                <td class="px-4 py-4 text-center">
                                    <button
                                        onclick="confirmDelete({{ $store->id }}, '{{ addslashes($store->name ?? $store->whatsapp_number) }}')"
                                        class="bg-red-500/10 text-red-500 hover:bg-red-500 hover:text-white text-xs font-black px-4 py-2 rounded-xl transition"
                                    >
                                        Supprimer
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </main>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-black/70 backdrop-blur-md z-[100] hidden flex items-center justify-center p-4">
        <div class="glass-card border border-red-500/20 rounded-3xl p-8 w-full max-w-sm text-center">
            <div class="w-14 h-14 bg-red-500/10 rounded-2xl flex items-center justify-center mx-auto mb-5">
                <svg class="w-7 h-7 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
            </div>
            <h3 class="text-xl font-black text-white mb-2">Supprimer la boutique ?</h3>
            <p class="text-slate-500 text-sm font-medium mb-1">Vous êtes sur le point de supprimer :</p>
            <p class="text-white font-black mb-6" id="deleteStoreName"></p>
            <p class="text-red-400/70 text-xs font-bold mb-8">⚠️ Tous les produits et commandes associés seront définitivement supprimés.</p>
            <div class="flex gap-3">
                <button onclick="cancelDelete()" class="w-1/2 bg-white/5 hover:bg-white/10 text-slate-400 font-black py-3 rounded-xl transition text-sm">
                    Annuler
                </button>
                <form id="deleteForm" method="POST" action="" class="w-1/2">
                    @csrf
                    <button type="submit" class="w-full bg-red-600 hover:bg-red-500 text-white font-black py-3 rounded-xl transition text-sm">
                        Confirmer
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete(storeId, storeName) {
            document.getElementById('deleteStoreName').innerText = storeName;
            document.getElementById('deleteForm').action = `/s-admin/stores/${storeId}/delete`;
            document.getElementById('deleteModal').classList.remove('hidden');
        }
        function cancelDelete() {
            document.getElementById('deleteModal').classList.add('hidden');
        }
        // Close modal on backdrop click
        document.getElementById('deleteModal').addEventListener('click', function(e) {
            if (e.target === this) cancelDelete();
        });
    </script>
</body>
</html>
