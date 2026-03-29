<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sama-Store AI - Abonnement</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8fafc; }</style>
</head>
<body class="text-slate-800 antialiased">

    <nav class="bg-white border-b border-slate-200 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center h-16">
            <div class="flex items-center gap-3">
                <a href="{{ route('dashboard') }}" class="text-slate-400 hover:text-slate-600 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                </a>
                <span class="font-bold text-lg">Espace Abonnement</span>
            </div>
            @if($store->is_subscribed)
                <span class="bg-emerald-100 text-emerald-700 text-xs font-bold px-3 py-1 rounded-full border border-emerald-200 uppercase letter tracking-widest">Premium Actif</span>
            @else
                <span class="bg-amber-100 text-amber-700 text-xs font-bold px-3 py-1 rounded-full border border-amber-200 uppercase tracking-widest">Période d'essai</span>
            @endif
        </div>
    </nav>

    <main class="max-w-4xl mx-auto px-4 py-12">
        <div class="text-center mb-16">
            <h1 class="text-4xl font-extrabold text-slate-900 mb-4 tracking-tight">Propulsez votre business 🚀</h1>
            <p class="text-lg text-slate-600 max-w-2xl mx-auto leading-relaxed">Choisissez le forfait idéal pour automatiser vos ventes et booster votre visibilité sur WhatsApp.</p>
        </div>

        <div class="grid md:grid-cols-2 gap-8 mb-16">
            
            <!-- Plan Basic -->
            <div class="bg-white rounded-3xl p-8 border border-slate-200 shadow-sm flex flex-col relative overflow-hidden">
                <div class="mb-8">
                    <h2 class="text-xl font-bold text-slate-900 mb-1">Plan Starter</h2>
                    <p class="text-slate-500 text-sm">Parfait pour débuter</p>
                </div>
                <div class="mb-8 flex items-baseline gap-1">
                    <span class="text-4xl font-extrabold text-slate-900">3 000</span>
                    <span class="text-slate-500 font-bold">FCFA/mois</span>
                </div>
                <ul class="space-y-4 mb-10 flex-1 text-sm font-medium text-slate-600">
                    <li class="flex items-center gap-3"><svg class="w-5 h-5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/></svg>Boutique IA illimitée</li>
                    <li class="flex items-center gap-3"><svg class="w-5 h-5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/></svg>Jusqu'à 20 produits</li>
                    <li class="flex items-center gap-3"><svg class="w-5 h-5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/></svg>Notifications WhatsApp</li>
                </ul>
                <div class="text-slate-400 text-xs italic text-center mb-4">Bientôt disponible</div>
                <button disabled class="w-full bg-slate-100 text-slate-400 font-bold py-4 rounded-2xl cursor-not-allowed">Choisir ce pack</button>
            </div>

            <!-- Plan Premium -->
            <div class="bg-slate-900 text-white rounded-3xl p-8 border-4 border-indigo-500 shadow-2xl flex flex-col relative transform hover:-translate-y-2 transition-transform duration-300">
                <div class="absolute top-0 right-8 bg-indigo-500 text-white text-[10px] font-black px-4 py-1.5 rounded-b-xl uppercase tracking-widest shadow-lg">Recommandé</div>
                
                <div class="mb-8">
                    <h2 class="text-xl font-bold mb-1">Pro & Illimité</h2>
                    <p class="text-slate-400 text-sm">Le choix des experts</p>
                </div>
                <div class="mb-8 flex items-baseline gap-1">
                    <span class="text-4xl font-extrabold">7 500</span>
                    <span class="text-slate-400 font-bold">FCFA/mois</span>
                </div>
                <ul class="space-y-4 mb-10 flex-1 text-sm font-medium text-slate-300">
                    <li class="flex items-center gap-3"><svg class="w-5 h-5 text-indigo-400" fill="currentColor" viewBox="0 0 20 20"><path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/></svg>Produits & Images illimités</li>
                    <li class="flex items-center gap-3"><svg class="w-5 h-5 text-indigo-400" fill="currentColor" viewBox="0 0 20 20"><path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/></svg>Statistiques de vente avancées</li>
                    <li class="flex items-center gap-3"><svg class="w-5 h-5 text-indigo-400" fill="currentColor" viewBox="0 0 20 20"><path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/></svg>Support Prioritaire 24h/24</li>
                    <li class="flex items-center gap-3"><svg class="w-5 h-5 text-indigo-400" fill="currentColor" viewBox="0 0 20 20"><path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/></svg>Zéro commission sur vos commandes</li>
                </ul>
                
                <form id="wavePayForm" action="{{ route('pay.wave') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full bg-indigo-500 text-white font-bold py-4 rounded-2xl hover:bg-white hover:text-indigo-600 transition-all duration-300 shadow-xl shadow-indigo-900 group flex justify-center items-center gap-2">
                        <span>S'abonner maintenant</span>
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                    </button>
                </form>
            </div>

        </div>

        <div class="text-center bg-white p-8 rounded-3xl border border-slate-100 max-w-2xl mx-auto shadow-sm">
            <h3 class="font-bold text-slate-800 mb-2">Paiement ultra-simplifié via Wave 🌊</h3>
            <p class="text-sm text-slate-500 mb-0 leading-relaxed">Cliquez sur s'abonner et valider votre transaction Wave. Votre boutique sera prolongée instantanément.</p>
        </div>
    </main>

    <!-- Payment Gateway Modal -->
    <div id="paymentModal" class="fixed inset-0 bg-slate-900/80 backdrop-blur-md z-[60] hidden flex items-center justify-center p-4">
        <div class="bg-white w-full max-w-md rounded-3xl overflow-hidden shadow-2xl transform scale-95 opacity-0 transition-all duration-300" id="paymentModalContent">
            
            <div class="bg-indigo-600 p-6 text-white text-center">
                <h3 class="text-xl font-bold">Paiement Sécurisé</h3>
                <p class="text-indigo-100 text-xs mt-1">Sama-Store AI - Abonnement Pro</p>
                <div class="mt-4 text-3xl font-black">7 500 FCFA</div>
            </div>

            <div class="p-8">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4">Choisissez votre mode de paiement</p>
                
                <div class="space-y-3 mb-8">
                    <label class="flex items-center gap-4 p-4 border-2 border-slate-100 rounded-2xl cursor-pointer hover:border-indigo-500 transition group has-[:checked]:border-indigo-600 has-[:checked]:bg-indigo-50">
                        <input type="radio" name="gateway" value="wave" checked class="hidden peer">
                        <div class="w-10 h-10 bg-sky-100 rounded-full flex items-center justify-center text-sky-600 font-bold group-hover:scale-110 transition">🌊</div>
                        <div class="flex-1">
                            <span class="block font-bold text-slate-800">Wave</span>
                            <span class="block text-[10px] text-slate-500">Sans frais de transaction</span>
                        </div>
                        <div class="w-5 h-5 rounded-full border-2 border-slate-200 peer-checked:border-indigo-600 peer-checked:bg-indigo-600 flex items-center justify-center transition">
                            <div class="w-2 h-2 bg-white rounded-full"></div>
                        </div>
                    </label>

                    <label class="flex items-center gap-4 p-4 border-2 border-slate-100 rounded-2xl cursor-pointer hover:border-indigo-500 transition group has-[:checked]:border-indigo-600 has-[:checked]:bg-indigo-50">
                        <input type="radio" name="gateway" value="orange_money" class="hidden peer">
                        <div class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center text-orange-600 font-bold group-hover:scale-110 transition">🍊</div>
                        <div class="flex-1">
                            <span class="block font-bold text-slate-800">Orange Money</span>
                            <span class="block text-[10px] text-slate-500">Validation instantanée</span>
                        </div>
                        <div class="w-5 h-5 rounded-full border-2 border-slate-200 peer-checked:border-indigo-600 peer-checked:bg-indigo-600 flex items-center justify-center transition">
                            <div class="w-2 h-2 bg-white rounded-full"></div>
                        </div>
                    </label>

                    <label class="flex items-center gap-4 p-4 border-2 border-slate-100 rounded-2xl cursor-pointer hover:border-indigo-500 transition group has-[:checked]:border-indigo-600 has-[:checked]:bg-indigo-50">
                        <input type="radio" name="gateway" value="card" class="hidden peer">
                        <div class="w-10 h-10 bg-slate-100 rounded-full flex items-center justify-center text-slate-600 font-bold group-hover:scale-110 transition">💳</div>
                        <div class="flex-1">
                            <span class="block font-bold text-slate-800">Carte Prépayée / Bancaire</span>
                            <span class="block text-[10px] text-slate-500">Visa, Mastercard</span>
                        </div>
                        <div class="w-5 h-5 rounded-full border-2 border-slate-200 peer-checked:border-indigo-600 peer-checked:bg-indigo-600 flex items-center justify-center transition">
                            <div class="w-2 h-2 bg-white rounded-full"></div>
                        </div>
                    </label>
                </div>

                <div class="space-y-4" id="phoneInputSection">
                    <label class="block">
                        <span class="text-[10px] font-bold text-slate-500 uppercase ml-1">Numéro de téléphone</span>
                        <input type="tel" value="{{ $store->whatsapp_number }}" class="mt-1 w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 outline-none focus:ring-2 focus:ring-indigo-500 transition font-bold text-slate-700">
                    </label>
                </div>

                <form id="upgradePayForm" action="{{ route('dashboard.upgrade') }}" method="POST" class="mt-8">
                    @csrf
                    <button type="submit" id="mainPayBtn" class="w-full bg-slate-900 text-white font-extrabold py-4 rounded-2xl hover:bg-indigo-600 transition flex items-center justify-center gap-2 shadow-xl shadow-slate-200">
                        <span id="btnText">Paiement Confirmer</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    </button>
                    <button type="button" onclick="closePaymentGateway()" class="w-full mt-3 text-sm font-bold text-slate-400 hover:text-slate-600 transition tracking-wide italic">Annuler</button>
                </form>

            </div>
        </div>
    </div>

    <script>
        function openPaymentGateway() {
            const modal = document.getElementById('paymentModal');
            const content = document.getElementById('paymentModalContent');
            modal.classList.remove('hidden');
            setTimeout(() => {
                content.classList.remove('scale-95', 'opacity-0');
                content.classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        function closePaymentGateway() {
            const modal = document.getElementById('paymentModal');
            const content = document.getElementById('paymentModalContent');
            content.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }

        // Logic to simulate payment processing for any subscription form
        document.querySelectorAll('form').forEach(form => {
            form.onsubmit = function(e) {
                // Find the submit button and text within THIS form
                const btn = this.querySelector('button[type="submit"]');
                const text = btn ? btn.querySelector('span') : null;
                
                if (btn) {
                    btn.disabled = true;
                    btn.classList.add('opacity-50', 'cursor-not-allowed');
                }
                
                if (text) {
                    text.innerText = "Traitement en cours...";
                }
                
                // On laisse le formulaire s'envoyer après 1.5s pour simuler l'attente
                setTimeout(() => {
                    this.submit();
                }, 1500);
                return false;
            };
        });
    </script>

</body>
</html>
