<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>{{ $store->name ?? 'Boutique Sama-Store' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; -webkit-tap-highlight-color: transparent; }
        .bg-mesh { 
            background-color: #f8fafc;
            background-image: 
                radial-gradient(at 0% 0%, rgba(99, 102, 241, 0.03) 0, transparent 50%), 
                radial-gradient(at 100% 100%, rgba(217, 70, 239, 0.03) 0, transparent 50%);
        }
        .glass { background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); border: 1px solid rgba(255, 255, 255, 0.3); }
        .glass-card { background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.8); }
        .hide-scrollbar::-webkit-scrollbar { display: none; }
        .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="bg-mesh text-slate-900 antialiased min-h-screen pb-32">

    <!-- Store Header -->
    <header class="sticky top-0 z-[50] glass border-b border-indigo-50/50 px-6 py-5">
        <div class="max-w-2xl mx-auto flex justify-between items-center">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center shadow-lg shadow-indigo-100">
                    <span class="text-white font-black text-xl italic">{{ substr($store->name ?? 'S', 0, 1) }}</span>
                </div>
                <div>
                    <h1 class="font-black text-lg tracking-tighter leading-none">{{ $store->name ?? 'Boutique' }}</h1>
                    <div class="flex items-center gap-1 mt-1">
                        <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-pulse"></span>
                        <span class="text-[9px] font-black uppercase tracking-widest text-slate-400 italic">Ouvert 🇸🇳</span>
                    </div>
                </div>
            </div>
            
            <a href="https://wa.me/{{ $store->whatsapp_number }}" class="w-10 h-10 bg-white border border-slate-100 rounded-xl flex items-center justify-center text-emerald-500 shadow-sm hover:scale-110 transition active:scale-95">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413z"/></svg>
            </a>
        </div>
    </header>

    <main class="max-w-2xl mx-auto px-6 pt-10">
        
        <!-- Welcome Hero -->
        <div class="mb-12">
            <h2 class="text-3xl font-black tracking-tighter leading-tight mb-3">Découvrez nos <span class="text-indigo-600">pépites.</span> ✨</h2>
            <p class="text-slate-500 font-medium">Faites votre choix et payez en un clic via Wave ou Orange Money.</p>
        </div>

        <!-- Categories horizontal scroll -->
        <div class="flex gap-3 overflow-x-auto hide-scrollbar mb-10 -mx-6 px-6">
            <button class="bg-slate-900 text-white px-6 py-3 rounded-2xl text-[11px] font-black uppercase tracking-widest shadow-xl shadow-slate-200 shrink-0">Tout</button>
            @foreach($products->pluck('category')->unique()->filter() as $cat)
                <button class="bg-white border border-slate-100 text-slate-400 px-6 py-3 rounded-2xl text-[11px] font-black uppercase tracking-widest hover:border-indigo-600 hover:text-indigo-600 transition shrink-0">{{ $cat }}</button>
            @endforeach
        </div>

        <!-- Products Feed -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            @forelse($products as $product)
            <div class="group relative flex flex-col bg-white rounded-[2.5rem] overflow-hidden shadow-2xl shadow-slate-200/50 border border-slate-50 transition-all hover:-translate-y-2">
                <div class="aspect-[4/3] w-full overflow-hidden bg-slate-50">
                    @if($product->image_url)
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover transition duration-700 group-hover:scale-110">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-slate-200">
                             <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                    @endif
                </div>
                
                <div class="p-8 flex-1 flex flex-col">
                    @if($product->category)
                        <span class="text-[9px] font-black uppercase tracking-[0.2em] text-indigo-500 mb-2">{{ $product->category }}</span>
                    @endif
                    <h3 class="text-xl font-black text-slate-900 tracking-tight mb-4 group-hover:text-indigo-600 transition">{{ $product->name }}</h3>
                    
                    <div class="flex items-center justify-between mt-auto pt-6 border-t border-slate-50">
                        <span class="text-2xl font-black text-slate-900 leading-none">{{ number_format($product->price, 0, ',', ' ') }} <span class="text-xs text-slate-400 font-bold ml-1 uppercase">FCFA</span></span>
                        
                        <button onclick="openCheckout('{{ $product->id }}', '{{ addslashes($product->name) }}', '{{ $product->price }}')" 
                                class="bg-slate-900 text-white px-8 py-4 rounded-2xl text-[11px] font-black uppercase tracking-widest hover:bg-indigo-600 transition-all shadow-xl shadow-slate-200 active:scale-95 group/btn">
                            <span class="flex items-center gap-2">Commander <svg class="w-4 h-4 group-hover/btn:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg></span>
                        </button>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full py-32 text-center bg-white rounded-[3rem] border border-slate-100 italic">
                <p class="text-slate-400 font-black uppercase tracking-widest">Le catalogue est en cours de mise à jour...</p>
            </div>
            @endforelse
        </div>
    </main>

    <!-- App-like Mobile Navigation -->
    <div class="fixed bottom-8 left-6 right-6 z-[60] max-w-md mx-auto">
        <div class="glass rounded-[2rem] p-3 flex justify-around items-center shadow-2xl shadow-indigo-200 border border-white/60">
            <a href="#" class="flex flex-col items-center gap-1 group">
                <div class="w-12 h-12 bg-indigo-600 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-indigo-100 transition group-active:scale-90">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                </div>
            </a>
            <a href="https://wa.me/{{ $store->whatsapp_number }}" target="_blank" class="flex flex-col items-center gap-1 group">
                <div class="w-12 h-12 bg-white border border-slate-100 rounded-2xl flex items-center justify-center text-emerald-500 shadow-sm transition group-active:scale-90">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413z"/></svg>
                </div>
            </a>
            <div class="w-px h-8 bg-slate-100"></div>
            <div class="flex flex-col items-center gap-1 group opacity-40">
                <div class="w-12 h-12 bg-white border border-slate-100 rounded-2xl flex items-center justify-center text-slate-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Checkout Modal Overhaul -->
    <div id="checkoutModal" class="fixed inset-0 bg-slate-900/80 backdrop-blur-md z-[100] hidden flex items-end justify-center opacity-0 transition-all duration-300">
        <div id="checkoutModalContent" class="bg-white/95 backdrop-blur-xl w-full max-w-lg mx-auto rounded-t-3xl p-6 md:p-8 translate-y-full transition-transform duration-500 ease-out shadow-2xl overflow-y-auto max-h-[90vh]">
            <!-- Modal drag handle -->
            <div class="w-12 h-1.5 bg-slate-200 rounded-full mx-auto mb-6"></div>
            
            <div class="flex justify-between items-start mb-6">
                <div>
                    <h3 class="text-2xl font-black text-slate-900 tracking-tighter italic">Finaliser la commande.</h3>
                    <p class="text-slate-500 font-bold text-xs mt-1 uppercase tracking-widest text-indigo-600" id="checkoutProductName"></p>
                </div>
                <button type="button" onclick="closeCheckout()" class="p-2 bg-slate-100 text-slate-400 rounded-xl hover:bg-red-50 hover:text-red-500 transition shrink-0 ml-4">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <form id="checkoutForm" method="POST" action="" class="space-y-8">
                @csrf
                <div class="grid gap-6">
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-1">Votre Nom Complet</label>
                        <input type="text" name="customer_name" required placeholder="Aïssatou Sow" class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-6 py-4 text-sm font-bold focus:border-indigo-600 focus:ring-4 focus:ring-indigo-50 outline-none transition">
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-1">Numéro Téléphone</label>
                            <input type="tel" name="customer_phone" required placeholder="77 XXX XX XX" class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-6 py-4 text-sm font-bold focus:border-indigo-600 focus:ring-4 focus:ring-indigo-50 outline-none transition">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-1">Ville / Quartier</label>
                            <input type="text" name="delivery_address" required placeholder="Dakar, Plateau" class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-6 py-4 text-sm font-bold focus:border-indigo-600 focus:ring-4 focus:ring-indigo-50 outline-none transition">
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-1">Méthode de Paiement Mobile</label>
                        <div class="grid grid-cols-2 gap-3">
                            <label class="relative cursor-pointer group">
                                <input type="radio" name="payment_provider" value="wave" required class="peer sr-only">
                                <div class="bg-slate-50 border-2 border-slate-50 rounded-2xl p-4 text-center peer-checked:border-indigo-600 peer-checked:bg-indigo-50/50 transition py-5">
                                    <div class="text-2xl mb-2">🌊</div>
                                    <span class="text-xs font-black text-slate-900 group-hover:text-indigo-600 transition">Wave</span>
                                </div>
                            </label>
                            <label class="relative cursor-pointer group">
                                <input type="radio" name="payment_provider" value="orange_money" required class="peer sr-only">
                                <div class="bg-slate-50 border-2 border-slate-50 rounded-2xl p-4 text-center peer-checked:border-orange-500 peer-checked:bg-orange-50/50 transition py-5">
                                    <div class="text-2xl mb-2">🍊</div>
                                    <span class="text-xs font-black text-slate-900 group-hover:text-orange-600 transition">OM</span>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="pt-2 pb-6 flex gap-3">
                    <button type="button" onclick="closeCheckout()" class="w-1/3 bg-slate-100 text-slate-600 font-black py-4 rounded-2xl hover:bg-slate-200 transition text-sm">
                        Retour
                    </button>
                    <button type="submit" class="w-2/3 bg-slate-900 text-white font-black py-4 rounded-2xl hover:bg-emerald-500 transition shadow-xl shadow-slate-200 flex justify-center items-center gap-2 group">
                        <span>Payer <span id="checkoutPrice"></span></span>
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </button>
                </div>
                <p class="text-[9px] text-center font-black text-slate-300 uppercase tracking-[0.2em] -mt-4">Sama-Store AI &bull; Paiement Sécurisé 🇸🇳</p>
            </form>
        </div>
    </div>

    <script>
        function openCheckout(productId, name, price) {
            document.getElementById('checkoutProductName').innerText = name;
            document.getElementById('checkoutPrice').innerText = price ? '(' + new Intl.NumberFormat('fr-FR').format(price) + ' FCFA)' : '';
            
            const form = document.getElementById('checkoutForm');
            form.action = `/s/{{ $store->slug ?? $store->whatsapp_number }}/product/${productId}/checkout`;
            
            const modal = document.getElementById('checkoutModal');
            const content = document.getElementById('checkoutModalContent');
            
            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.classList.add('opacity-100');
                content.classList.remove('translate-y-full');
            }, 10);
            
            // Lock background scroll
            document.body.style.overflow = 'hidden';
        }

        function closeCheckout() {
            const modal = document.getElementById('checkoutModal');
            const content = document.getElementById('checkoutModalContent');
            
            modal.classList.remove('opacity-100');
            content.classList.add('translate-y-full');
            
            setTimeout(() => {
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }, 500);
        }
    </script>
</body>
</html>
