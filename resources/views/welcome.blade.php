<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sama-Store AI - Votre Boutique WhatsApp en 2 Minutes 🇸🇳</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; }
        .glass { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(20px); border: 1px solid rgba(255, 255, 255, 0.3); }
        .glass-dark { background: rgba(15, 23, 42, 0.8); backdrop-filter: blur(20px); border: 1px solid rgba(255, 255, 255, 0.1); }
        .bg-mesh { 
            background-color: #f8fafc;
            background-image: 
                radial-gradient(at 0% 0%, rgba(99, 102, 241, 0.15) 0, transparent 50%), 
                radial-gradient(at 50% 0%, rgba(139, 92, 246, 0.1) 0, transparent 50%),
                radial-gradient(at 100% 0%, rgba(217, 70, 239, 0.15) 0, transparent 50%);
        }
        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }
        .animate-blob { animation: blob 7s infinite; }
        .animation-delay-2000 { animation-delay: 2s; }
        .animation-delay-4000 { animation-delay: 4s; }
        
        .hero-gradient {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>
<body class="bg-mesh text-slate-900 antialiased overflow-x-hidden">

    <!-- Blobs Décoratifs -->
    <div class="fixed top-0 -left-20 w-72 h-72 bg-indigo-300 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob"></div>
    <div class="fixed top-0 -right-20 w-72 h-72 bg-purple-300 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>
    <div class="fixed bottom-0 left-20 w-72 h-72 bg-pink-300 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-4000"></div>

    <!-- Navigation -->
    <nav class="max-w-7xl mx-auto px-6 py-8 flex justify-between items-center relative z-50">
        <div class="flex items-center gap-3 group cursor-pointer">
            <div class="w-12 h-12 bg-indigo-600 rounded-2xl flex items-center justify-center shadow-xl shadow-indigo-200 transform group-hover:rotate-12 transition-transform duration-300">
                <span class="text-white font-black text-2xl">S</span>
            </div>
            <div class="flex flex-col">
                <span class="font-black text-2xl tracking-tighter leading-none">Sama-Store <span class="text-indigo-600">AI</span></span>
                <span class="text-[10px] uppercase font-black tracking-[0.2em] text-slate-400">Le futur du commerce</span>
            </div>
        </div>
        <div class="hidden md:flex items-center gap-10 bg-white/50 backdrop-blur-md px-8 py-3 rounded-full border border-white/50 shadow-sm">
            <a href="#features" class="text-sm font-bold text-slate-600 hover:text-indigo-600 transition">Solutions</a>
            <a href="#pricing" class="text-sm font-bold text-slate-600 hover:text-indigo-600 transition">Tarifs</a>
            <a href="#faq" class="text-sm font-bold text-slate-600 hover:text-indigo-600 transition">FAQ</a>
        </div>
        <div class="flex items-center gap-4">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="bg-slate-900 text-white px-8 py-3 rounded-2xl text-sm font-black hover:bg-indigo-600 transition shadow-xl shadow-slate-200 active:scale-95">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="hidden sm:block text-sm font-black text-slate-900 hover:text-indigo-600">Connexion</a>
                    <a href="{{ route('register') }}" class="bg-indigo-600 text-white px-8 py-3 rounded-2xl text-sm font-black hover:bg-slate-900 transition shadow-xl shadow-indigo-200 active:scale-95">Lancer ma boutique</a>
                @endauth
            @endif
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="max-w-7xl mx-auto px-6 pt-24 pb-40 grid lg:grid-cols-2 gap-20 items-center relative">
        <div class="relative z-10">
            <div class="inline-flex items-center gap-3 bg-white/80 backdrop-blur-sm border border-indigo-100 text-indigo-700 px-5 py-2.5 rounded-2xl text-xs font-black mb-10 uppercase tracking-widest shadow-sm">
                <span class="flex h-3 w-3">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-3 w-3 bg-indigo-600"></span>
                </span>
                Sénégal : Inscription Ouverte 🇸🇳
            </div>
            <h1 class="text-6xl lg:text-[5.5rem] font-black leading-[1] mb-10 tracking-tighter">
                Vendez plus sur <span class="hero-gradient">WhatsApp</span> grâce à l'IA.
            </h1>
            <p class="text-xl text-slate-500 mb-12 leading-relaxed max-w-xl font-medium">
                Envoyez vos photos sur WhatsApp, l'IA s'occupe du reste. Créez votre boutique pro en <span class="text-indigo-600 font-bold">2 minutes chrono</span>.
            </p>
            <div class="flex flex-col sm:flex-row gap-6">
                <a href="{{ route('register') }}" class="group bg-indigo-600 text-white px-12 py-6 rounded-[2rem] text-xl font-black hover:bg-slate-900 transition-all duration-300 shadow-2xl shadow-indigo-300 text-center flex items-center justify-center gap-3">
                    Essayer Gratuitement
                    <svg class="w-6 h-6 group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                </a>
            </div>
            
            <div class="mt-16 flex items-center gap-6">
                <div class="flex -space-x-4">
                    <img class="w-14 h-14 rounded-2xl border-4 border-white shadow-xl" src="https://ui-avatars.com/api/?name=Faty&background=indigo&color=fff" alt="">
                    <img class="w-14 h-14 rounded-2xl border-4 border-white shadow-xl" src="https://ui-avatars.com/api/?name=Omar&background=purple&color=fff" alt="">
                    <img class="w-14 h-14 rounded-2xl border-4 border-white shadow-xl" src="https://ui-avatars.com/api/?name=Khady&background=pink&color=fff" alt="">
                    <div class="w-14 h-14 rounded-2xl bg-slate-900 border-4 border-white shadow-xl flex items-center justify-center text-white text-xs font-black">+250</div>
                </div>
                <div class="flex flex-col">
                    <div class="flex items-center gap-1">
                        @for($i=0; $i<5; $i++) <svg class="w-4 h-4 text-amber-400 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg> @endfor
                    </div>
                    <span class="text-sm font-black text-slate-900 uppercase tracking-widest">Vendeurs Satisfaits</span>
                </div>
            </div>
        </div>

        <div class="relative hidden lg:block">
            <div class="absolute -inset-10 bg-indigo-500/20 blur-[120px] rounded-full"></div>
            <!-- Interactive App Display -->
            <div class="relative group">
                <div class="bg-slate-900 rounded-[3.5rem] p-5 shadow-[0_50px_100px_-20px_rgba(0,0,0,0.4)] transform hover:-rotate-2 transition-transform duration-700">
                    <div class="bg-white rounded-[2.8rem] overflow-hidden aspect-[9/18.5] relative">
                         <img src="https://images.unsplash.com/photo-1556742044-3c52d6e88c62?q=80&w=1000&auto=format&fit=crop" class="w-full h-full object-cover">
                         <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-transparent to-transparent"></div>
                         <div class="absolute bottom-10 left-8 right-8 text-white">
                             <div class="w-12 h-1.5 bg-indigo-500 rounded-full mb-6"></div>
                             <h4 class="text-3xl font-black mb-3 italic">Votre Boutique.</h4>
                             <p class="text-sm text-slate-300 font-medium">L'IA analyse vos photos et crée vos fiches produits instantanément.</p>
                         </div>
                    </div>
                </div>
                <!-- Mini Badge Floating -->
                <div class="absolute -right-12 top-20 glass p-6 rounded-[2rem] shadow-2xl animate-bounce duration-[3000ms]">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-2xl flex items-center justify-center font-black text-xl">🌊</div>
                        <div>
                            <span class="block text-[10px] font-black text-slate-400 uppercase tracking-widest">Paiement Reçu</span>
                            <span class="block font-black text-slate-900">15.000 FCFA</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Social Proof / Brands -->
    <div class="max-w-7xl mx-auto px-6 pb-32">
        <p class="text-center text-xs font-black text-slate-400 uppercase tracking-[0.3em] mb-12">Propulsé par les meilleures technologies</p>
        <div class="flex flex-wrap justify-center items-center gap-12 md:gap-24 opacity-50 grayscale hover:grayscale-0 transition-all duration-500">
            <span class="font-black text-2xl text-slate-700">WAVE</span>
            <span class="font-black text-2xl text-slate-700 italic underline decoration-indigo-500 decoration-4">WhatsApp</span>
            <span class="font-black text-2xl text-slate-700">OpenAI</span>
            <span class="font-black text-2xl text-slate-700">Orange Money</span>
        </div>
    </div>

    <!-- Features Section -->
    <section id="features" class="bg-white py-40 relative">
        <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-3 gap-16 relative z-10">
            <div class="group">
                <div class="w-20 h-20 bg-indigo-50 text-indigo-600 rounded-3xl flex items-center justify-center mb-10 group-hover:scale-110 group-hover:bg-indigo-600 group-hover:text-white transition-all duration-500 shadow-xl shadow-indigo-100">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <h3 class="text-2xl font-black mb-6">IA Photo-to-Site</h3>
                <p class="text-lg text-slate-500 font-medium leading-relaxed">Plus besoin de saisir du texte. Prenez une photo, l'IA rédige la description et fixe le prix automatiquement. Validez et c'est en ligne !</p>
            </div>

            <div class="group">
                <div class="w-20 h-20 bg-emerald-50 text-emerald-600 rounded-3xl flex items-center justify-center mb-10 group-hover:scale-110 group-hover:bg-emerald-600 group-hover:text-white transition-all duration-500 shadow-xl shadow-emerald-100">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h3 class="text-2xl font-black mb-6">Paiements Locaux</h3>
                <p class="text-lg text-slate-500 font-medium leading-relaxed">Fini les transferts manuels. Vos clients paient via Wave ou Orange Money, et vous recevez les fonds directement. Sûr et transparent.</p>
            </div>

            <div class="group">
                <div class="w-20 h-20 bg-purple-50 text-purple-600 rounded-3xl flex items-center justify-center mb-10 group-hover:scale-110 group-hover:bg-purple-600 group-hover:text-white transition-all duration-500 shadow-xl shadow-purple-100">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                </div>
                <h3 class="text-2xl font-black mb-6">Dashboard Mobile</h3>
                <p class="text-lg text-slate-500 font-medium leading-relaxed">Suivez vos ventes depuis votre téléphone. Visualisez votre chiffre d'affaires et gérez vos stocks en un clin d'œil.</p>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section id="pricing" class="py-40 bg-slate-900 overflow-hidden relative">
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-indigo-600/20 blur-[150px] rounded-full"></div>
        <div class="max-w-3xl mx-auto px-6 text-center relative z-10">
            <h2 class="text-5xl font-black text-white mb-8 italic">Un prix simple, pour tous.</h2>
            <p class="text-indigo-200 text-xl font-medium mb-16 opacity-80">Pas de pourcentage sur vos ventes. Juste un abonnement clair pour faire grandir votre business.</p>
            
            <div class="bg-white rounded-[3rem] p-12 lg:p-16 shadow-2xl relative">
                <div class="absolute -top-6 left-1/2 -translate-x-1/2 bg-indigo-600 text-white px-8 py-2 rounded-full font-black text-xs uppercase tracking-[0.3em] shadow-xl">Best-Seller</div>
                <div class="mb-10">
                    <span class="text-6xl font-black text-slate-900 tracking-tighter">7 500</span>
                    <span class="text-slate-400 font-bold ml-2 italic">FCFA / mois</span>
                </div>
                <ul class="space-y-6 mb-12 text-left max-w-sm mx-auto">
                    <li class="flex items-center gap-4 font-bold text-slate-700">
                        <div class="w-6 h-6 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center">✓</div>
                        Produits & Ventes Illimités
                    </li>
                    <li class="flex items-center gap-4 font-bold text-slate-700">
                        <div class="w-6 h-6 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center">✓</div>
                        IA Intégrée (Photo Analysis)
                    </li>
                    <li class="flex items-center gap-4 font-bold text-slate-700">
                        <div class="w-6 h-6 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center">✓</div>
                        Lien de Boutique Personnalisé
                    </li>
                    <li class="flex items-center gap-4 font-bold text-slate-700">
                        <div class="w-6 h-6 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center">✓</div>
                        Support Prioritaire 24h/24
                    </li>
                </ul>
                <a href="{{ route('register') }}" class="block w-full bg-slate-900 text-white py-6 rounded-3xl text-xl font-black hover:bg-indigo-600 transition-all shadow-xl shadow-slate-200">
                    Démarrer mon essai de 7 jours
                </a>
                <p class="mt-6 text-slate-400 text-sm font-bold italic">Paiement via Wave & Orange Money</p>
            </div>
        </div>
    </section>

    <!-- FAQ -->
    <section id="faq" class="py-40 max-w-4xl mx-auto px-6 font-medium">
        <h2 class="text-4xl font-black text-center mb-20 italic">Vos questions fréquentes.</h2>
        <div class="space-y-8">
            <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm hover:shadow-md transition">
                <h4 class="text-xl font-black mb-4">Est-ce que je reçois l'argent directement ?</h4>
                <p class="text-slate-500">Oui. Sama-Store n'est pas un intermédiaire. Les clients paient sur votre compte Wave ou Orange Money, ou en espèces à la livraison selon votre choix.</p>
            </div>
            <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm hover:shadow-md transition">
                <h4 class="text-xl font-black mb-4">L'IA comprend-elle tous les produits ?</h4>
                <p class="text-slate-500">Notre IA est entraînée sur des milliers de produits locaux (mode, cosmétiques, électronique, alimentation). Si l'image est claire, elle saura tout décrire.</p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-slate-900 text-white py-24 px-6 border-t border-white/5">
        <div class="max-w-7xl mx-auto grid md:grid-cols-4 gap-16 mb-20">
            <div class="col-span-2">
                <div class="flex items-center gap-3 mb-8">
                    <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center">
                        <span class="text-white font-black text-xl">S</span>
                    </div>
                    <span class="font-extrabold text-2xl tracking-tighter">Sama-Store AI</span>
                </div>
                <p class="text-slate-400 max-w-sm font-medium leading-relaxed">
                    La plateforme e-commerce n°1 au Sénégal pour les vendeurs sur WhatsApp. Transformez votre passion en business rentable.
                </p>
            </div>
            <div>
                <h5 class="font-black text-sm uppercase tracking-widest mb-8">Liens Rapides</h5>
                <ul class="space-y-4 text-slate-400 font-bold">
                    <li><a href="#features" class="hover:text-white transition">Fonctionnalités</a></li>
                    <li><a href="#pricing" class="hover:text-white transition">Tarifs</a></li>
                    <li><a href="{{ route('login') }}" class="hover:text-white transition">Connexion</a></li>
                </ul>
            </div>
            <div>
                <h5 class="font-black text-sm uppercase tracking-widest mb-8">Contact</h5>
                <ul class="space-y-4 text-slate-400 font-bold">
                    <li><a href="https://wa.me/221781560233" class="hover:text-white transition">+221 78 156 02 33</a></li>
                    <li>support@sama-store.ai</li>
                </ul>
            </div>
        </div>
        <div class="max-w-7xl mx-auto pt-16 border-t border-white/5 text-center text-slate-500 text-xs font-black uppercase tracking-[0.2em]">
            &copy; 2026 Sama-Store AI. Fait avec 💙 à Dakar.
        </div>
    </footer>

</body>
</html>
