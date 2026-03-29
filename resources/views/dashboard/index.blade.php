<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sama-Store AI - Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; }
        [x-cloak] { display: none !important; }
        .bg-mesh { 
            background-color: #f8fafc;
            background-image: 
                radial-gradient(at 0% 0%, rgba(99, 102, 241, 0.05) 0, transparent 50%), 
                radial-gradient(at 100% 100%, rgba(217, 70, 239, 0.05) 0, transparent 50%);
        }
        .glass { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(20px); border: 1px solid rgba(255, 255, 255, 0.3); }
        .card-shadow { box-shadow: 0 10px 40px -10px rgba(0, 0, 0, 0.04); }
    </style>
</head>
<body class="bg-mesh text-slate-900 antialiased min-h-screen" x-data="{ openAddProduct: false }">

    <!-- Sidebar / Nav -->
    <nav class="glass border-b border-indigo-50 sticky top-0 z-[60] py-4">
        <div class="max-w-[1600px] mx-auto px-6 flex justify-between items-center">
            <div class="flex items-center gap-4 group cursor-pointer">
                <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center shadow-lg shadow-indigo-100 transform group-hover:rotate-6 transition">
                    <span class="text-white font-black text-xl">S</span>
                </div>
                <div class="flex flex-col">
                    <span class="font-black text-lg tracking-tighter leading-none text-slate-900">Sama-Store <span class="text-indigo-600">Pro</span></span>
                </div>
            </div>
            
            <div class="flex items-center gap-3">
                <div class="hidden md:flex items-center gap-2 mr-6 text-sm font-bold text-slate-400">
                    <a href="{{ route('dashboard') }}" class="px-4 py-2 rounded-xl text-indigo-600 bg-indigo-50 hover:bg-white transition">Dashboard</a>
                    <a href="{{ route('dashboard.stats') }}" class="px-4 py-2 rounded-xl hover:text-slate-900 transition">Statistiques</a>
                    <a href="{{ route('dashboard.settings') }}" class="px-4 py-2 rounded-xl hover:text-slate-900 transition flex items-center gap-2">
                         Paramètres
                    </a>
                </div>
                
                <a href="{{ route('store.show', $store->slug ?? $store->whatsapp_number) }}" target="_blank" class="bg-white border border-slate-200 text-slate-900 px-5 py-2.5 rounded-xl text-sm font-black hover:border-indigo-600 hover:text-indigo-600 transition flex items-center gap-2 shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    <span>Ma Vitrine</span>
                </a>

                <div class="h-8 w-px bg-slate-200 mx-2"></div>

                <form method="POST" action="{{ route('logout') }}" class="m-0">
                    @csrf
                    <button type="submit" class="p-2.5 bg-red-50 text-red-500 rounded-xl hover:bg-red-500 hover:text-white transition group" title="Déconnexion">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <main class="max-w-[1600px] mx-auto px-6 py-12">
        
        <!-- Welcome Header -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-8 mb-12">
            <div>
                <div class="inline-flex items-center gap-2 bg-indigo-50 text-indigo-700 px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest mb-4">
                    Tableau de bord actif ⚡
                </div>
                <h1 class="text-4xl font-black text-slate-900 tracking-tighter">Bienvenue, {{ $store->name }} 👋</h1>
                <p class="text-slate-500 font-medium mt-2">Gérez vos produits et vos ventes en temps réel.</p>
            </div>
            
            <button @click="openAddProduct = true" class="bg-slate-900 text-white px-10 py-5 rounded-[1.5rem] text-lg font-black hover:bg-indigo-600 transition-all shadow-2xl shadow-slate-200 flex items-center justify-center gap-3 active:scale-95 group">
                <div class="w-8 h-8 bg-white/20 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"/></svg>
                </div>
                Ajouter un produit
            </button>
        </div>

        @if(session('success'))
            <div class="bg-emerald-50 text-emerald-600 p-6 rounded-3xl border border-emerald-100 mb-12 font-bold flex items-center gap-4 animate-bounce-short">
                <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-sm">✅</div>
                {{ session('success') }}
            </div>
        @endif

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-16">
            <div class="glass p-8 rounded-[2.5rem] card-shadow relative overflow-hidden group">
                <div class="absolute -right-4 -top-4 w-24 h-24 bg-indigo-50 rounded-full group-hover:scale-150 transition duration-700"></div>
                <div class="relative z-10">
                    <span class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4">Total Commandes</span>
                    <span class="text-4xl font-black text-slate-900 tracking-tighter">{{ $store->orders->count() }}</span>
                </div>
            </div>

            <div class="bg-indigo-600 p-8 rounded-[2.5rem] shadow-2xl shadow-indigo-100 relative overflow-hidden group">
                <div class="absolute inset-0 bg-gradient-to-br from-indigo-500 to-purple-600"></div>
                <div class="absolute right-[-20px] bottom-[-20px] opacity-10 group-hover:scale-110 transition duration-700">
                    <svg class="w-40 h-40 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1.41 16.09V20h-2.67v-1.93c-1.71-.36-3.16-1.46-3.27-3.4h1.96c.1 1.05.82 1.87 2.65 1.87 1.96 0 2.4-.98 2.4-1.59 0-.83-.44-1.61-2.67-2.14-2.48-.6-4.18-1.62-4.18-3.97 0-1.92 1.41-3.23 3.11-3.6V5h2.67v1.88c1.33.24 2.87 1.06 3.09 2.9h-1.96c-.16-1.12-1.07-1.49-2.09-1.49-1.19 0-2.43.51-2.43 1.6 0 .86.73 1.4 2.4 1.82 2.65.66 4.45 1.58 4.45 4.19 0 2.15-1.57 3.52-3.53 3.89z"/></svg>
                </div>
                <div class="relative z-10 text-white">
                    <span class="block text-[10px] font-black text-indigo-100 uppercase tracking-[0.2em] mb-4">Chiffre d'Affaires</span>
                    <span class="text-3xl font-black tracking-tighter">{{ number_format($store->orders->whereIn('status', ['delivered', 'paid'])->sum('total_amount'), 0, ',', ' ') }} <span class="text-sm border-l border-white/20 pl-3 ml-2">FCFA</span></span>
                </div>
            </div>

            <div class="glass p-8 rounded-[2.5rem] card-shadow relative overflow-hidden group">
                <div class="absolute -right-4 -top-4 w-24 h-24 bg-purple-50 rounded-full group-hover:scale-150 transition duration-700"></div>
                <div class="relative z-10">
                    <span class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4">Produits Actifs</span>
                    <span class="text-4xl font-black text-slate-900 tracking-tighter">{{ $store->products->count() }}</span>
                </div>
            </div>

            <div class="glass p-8 rounded-[2.5rem] card-shadow relative overflow-hidden group">
                <div class="absolute -right-4 -top-4 w-24 h-24 bg-emerald-50 rounded-full group-hover:scale-150 transition duration-700"></div>
                <div class="relative z-10">
                    <span class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4">Taux Conversion</span>
                    <span class="text-4xl font-black text-slate-900 tracking-tighter">-- %</span>
                </div>
            </div>
        </div>

        <div class="grid lg:grid-cols-12 gap-12">
            
            <!-- Orders Feed -->
            <div class="lg:col-span-8 space-y-8">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-2xl font-black text-slate-900 tracking-tight italic">Activité Récente</h2>
                    <div class="flex gap-2">
                        <span class="px-4 py-1.5 bg-white border border-slate-200 rounded-full text-[10px] font-black uppercase text-slate-500">Live 🔴</span>
                    </div>
                </div>

                <div class="space-y-6">
                    @forelse($store->orders as $order)
                    <div class="glass p-8 rounded-[2rem] card-shadow hover:bg-white transition-all transform hover:-translate-y-1">
                        <div class="flex flex-col md:flex-row justify-between gap-8">
                            <div class="flex items-start gap-6">
                                <div class="w-16 h-16 bg-slate-100 rounded-2xl flex items-center justify-center font-black text-slate-400">
                                    {{ substr($order->customer_name, 0, 1) }}
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-2">
                                        <h4 class="text-xl font-black text-slate-900">{{ $order->customer_name }}</h4>
                                        <span class="px-3 py-1 bg-indigo-50 text-indigo-700 text-[10px] font-black rounded-lg uppercase tracking-widest border border-indigo-100">{{ $order->payment_provider }}</span>
                                    </div>
                                    <div class="flex flex-wrap gap-x-6 gap-y-2 text-sm font-medium text-slate-500 mb-6">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                            {{ $order->customer_phone }}
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                                            {{ $order->delivery_address }}
                                        </div>
                                    </div>
                                    <div class="bg-slate-50 border border-slate-100 px-6 py-4 rounded-2xl inline-flex items-center gap-4">
                                        <span class="text-slate-400 font-black text-[10px] uppercase tracking-widest">Produit:</span>
                                        <span class="text-slate-900 font-black">{{ $order->product->name ?? 'Produit inconnu' }}</span>
                                        <div class="h-4 w-px bg-slate-200"></div>
                                        <span class="text-indigo-600 font-black">{{ number_format($order->total_amount, 0, ',', ' ') }} FCFA</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="flex flex-col items-end gap-6 justify-between border-t md:border-t-0 md:border-l border-slate-100 pt-6 md:pt-0 md:pl-10 min-w-[200px]">
                                <div class="text-right">
                                    <span class="block text-[10px] font-black text-slate-300 uppercase tracking-widest mb-1">{{ $order->created_at->diffForHumans() }}</span>
                                    <p class="text-[10px] text-slate-400 font-bold uppercase">{{ $order->created_at->format('d M Y - H:i') }}</p>
                                </div>

                                <form method="POST" action="{{ route('orders.update_status', $order->id) }}" class="flex items-center gap-2 w-full">
                                    @csrf
                                    <select name="status" class="w-full bg-white border border-slate-200 text-sm font-black rounded-xl py-3 pl-4 pr-10 focus:ring-4 focus:ring-indigo-100 outline-none hover:border-indigo-600 transition">
                                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>En attente</option>
                                        <option value="paid" {{ $order->status == 'paid' ? 'selected' : '' }}>Payé ✅</option>
                                        <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Expédié 🚚</option>
                                        <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Livré ✔️</option>
                                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Annulé ❌</option>
                                    </select>
                                    <button type="submit" class="p-3.5 bg-slate-900 text-white rounded-xl hover:bg-emerald-500 transition shadow-xl shadow-slate-200">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                    </button>
                                </form>

                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $order->customer_phone) }}" target="_blank" class="text-emerald-500 hover:text-emerald-600 font-black text-xs uppercase tracking-widest flex items-center gap-2 italic">
                                    Discuter sur WhatsApp 💬
                                </a>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="glass p-20 rounded-[3rem] text-center card-shadow">
                        <div class="w-24 h-24 bg-indigo-50 text-indigo-200 rounded-full flex items-center justify-center mx-auto mb-8">
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                        </div>
                        <h3 class="text-2xl font-black text-slate-900 mb-2 italic">Aucune commande</h3>
                        <p class="text-slate-500 font-medium max-w-xs mx-auto">Partagez votre lien de boutique pour commencer à recevoir des clients !</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Sidebar Catalogue -->
            <div class="lg:col-span-4 space-y-10">
                <div class="glass rounded-[3rem] p-10 card-shadow sticky top-32 overflow-hidden">
                    <div class="absolute -left-10 -bottom-10 w-40 h-40 bg-indigo-50 rounded-full opacity-50"></div>
                    
                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-10">
                            <h2 class="text-2xl font-black text-slate-900 tracking-tighter italic underline decoration-indigo-200 decoration-8 underline-offset-[-2px]">Catalogue</h2>
                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ $store->products->count() }} Articles</span>
                        </div>

                        <div class="space-y-4 mb-10 overflow-y-auto max-h-[500px] pr-2 scrollbar-hide">
                            @foreach($store->products as $product)
                            <div class="group flex items-center gap-4 bg-white p-4 rounded-2xl border border-slate-50 hover:bg-slate-50 hover:border-indigo-100 transition-all cursor-pointer">
                                <div class="w-14 h-14 rounded-2xl overflow-hidden bg-slate-100 shrink-0 shadow-sm">
                                    @if($product->image_url)
                                        <img src="{{ $product->image_url }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-slate-300">🖼️</div>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h5 class="text-sm font-black text-slate-900 truncate">{{ $product->name }}</h5>
                                    <p class="text-xs font-black text-indigo-600 mt-1 uppercase">{{ number_format($product->price, 0, ',', ' ') }} FCFA</p>
                                </div>
                                <div class="opacity-0 group-hover:opacity-100 transition">
                                    <a href="{{ route('products.edit', $product->id) }}" class="p-2 text-slate-300 hover:text-slate-900">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                    </a>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <div class="bg-slate-900 text-white p-8 rounded-[2rem] text-center card-shadow group overflow-hidden relative active:scale-95 transition cursor-pointer" @click="openAddProduct = true">
                            <div class="absolute inset-0 bg-indigo-600 scale-x-0 group-hover:scale-x-100 transition-transform origin-left duration-500"></div>
                            <div class="relative z-10">
                                <span class="block font-black text-lg mb-2">Ajouter un produit</span>
                                <p class="text-[10px] uppercase font-bold tracking-widest text-indigo-300 group-hover:text-white transition">ou utilisez WhatsApp 🚀</p>
                            </div>
                        </div>

                        <!-- Mini Help -->
                        <div class="mt-10 pt-10 border-t border-slate-100 text-center">
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">Besoin d'aide ?</p>
                            <a href="https://wa.me/221781560233" class="inline-flex items-center gap-2 text-indigo-600 font-extrabold text-xs uppercase tracking-widest hover:underline decoration-2 underline-offset-4">
                                Contacter le support 📞
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        @if($store->products->count() > 0)
        <!-- Floating Preview Store for User experience -->
        <div class="fixed bottom-10 right-10 z-[100] group">
            <a href="{{ route('store.show', $store->slug ?? $store->whatsapp_number) }}" target="_blank" 
               class="bg-indigo-600 text-white px-8 py-5 rounded-full flex items-center gap-4 shadow-2xl hover:bg-slate-900 transition-all transform hover:-translate-y-2 group">
                <span class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center font-black">🌍</span>
                <div class="text-left leading-none">
                    <span class="block text-[10px] uppercase font-black text-indigo-200 group-hover:text-white transition">Visible par les clients</span>
                    <span class="font-black">Ouvrir ma Boutique</span>
                </div>
            </a>
        </div>
        @endif

    </main>

    <!-- Modal Ajouter Produit (Premium Design) -->
    <div x-show="openAddProduct" 
         x-cloak 
         class="fixed inset-0 z-[100] overflow-y-auto" 
         aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="openAddProduct" 
                 x-transition:enter="ease-out duration-300" 
                 x-transition:enter-start="opacity-0" 
                 x-transition:enter-end="opacity-100" 
                 x-transition:leave="ease-in duration-200" 
                 x-transition:leave-start="opacity-100" 
                 x-transition:leave-end="opacity-0" 
                 class="fixed inset-0 bg-slate-900/90 backdrop-blur-md transition-opacity" aria-hidden="true" @click="openAddProduct = false"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div x-show="openAddProduct" 
                 x-transition:enter="ease-out duration-300" 
                 x-transition:enter-start="opacity-0 translate-y-20 scale-95" 
                 x-transition:enter-end="opacity-100 translate-y-0 scale-100" 
                 x-transition:leave="ease-in duration-200" 
                 x-transition:leave-start="opacity-100 translate-y-0 scale-100" 
                 x-transition:leave-end="opacity-0 translate-y-20 scale-95" 
                 class="inline-block align-bottom bg-white rounded-[3.5rem] text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-xl sm:w-full p-2">
                
                <div class="bg-mesh rounded-[3rem] p-10 md:p-14">
                    <div class="flex justify-between items-start mb-12">
                        <div>
                            <h3 class="text-3xl font-black text-slate-900 italic tracking-tighter" id="modal-title">Nouveau Produit.</h3>
                            <p class="text-slate-500 font-medium text-sm mt-1">Créez votre fiche produit manuellement.</p>
                        </div>
                        <button @click="openAddProduct = false" class="text-slate-400 hover:text-slate-900 transition p-2">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                        @csrf
                        <div class="grid gap-8">
                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-1">Nom du produit</label>
                                <input type="text" name="name" required class="w-full bg-white border border-slate-100 rounded-2xl px-6 py-4 text-sm font-bold focus:border-indigo-600 focus:ring-4 focus:ring-indigo-50 outline-none transition" placeholder="Ex: iPhone 15 Pro, Robe Soie...">
                            </div>
                            
                            <div class="grid grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-1">Prix (FCFA)</label>
                                    <input type="number" name="price" required class="w-full bg-white border border-slate-100 rounded-2xl px-6 py-4 text-sm font-bold focus:border-indigo-600 focus:ring-4 focus:ring-indigo-50 outline-none transition" placeholder="15 000">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-1">Catégorie</label>
                                    <input type="text" name="category" class="w-full bg-white border border-slate-100 rounded-2xl px-6 py-4 text-sm font-bold focus:border-indigo-600 focus:ring-4 focus:ring-indigo-50 outline-none transition" placeholder="Ex: Électronique">
                                </div>
                            </div>

                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-1">Description vendeuse</label>
                                <textarea name="description" rows="3" class="w-full bg-white border border-slate-100 rounded-2xl px-6 py-4 text-sm font-bold focus:border-indigo-600 focus:ring-4 focus:ring-indigo-50 outline-none transition resize-none" placeholder="Décrivez votre produit pour séduire vos clients..."></textarea>
                            </div>

                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-1 text-left">Photo du produit</label>
                                <div class="bg-white border-2 border-dashed border-indigo-100 rounded-[2rem] p-8 text-center group hover:border-indigo-600 transition cursor-pointer relative overflow-hidden">
                                    <input type="file" name="image" accept="image/*" class="absolute inset-0 opacity-0 cursor-pointer z-10">
                                    <div class="relative z-1">
                                        <div class="w-14 h-14 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition duration-300">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        </div>
                                        <p class="text-sm font-black text-slate-900">Cliquez pour ajouter une image</p>
                                        <p class="text-[10px] text-slate-400 uppercase font-bold mt-1 tracking-wider">Format PNG, JPG ou WEBP</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col gap-4 pt-4">
                            <button type="submit" class="w-full bg-slate-900 text-white font-black py-6 rounded-3xl hover:bg-indigo-600 transition shadow-2xl shadow-slate-200 flex justify-center items-center gap-3 transform active:scale-95 group">
                                <span>Publier le produit</span>
                                <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
