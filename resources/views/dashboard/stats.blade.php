<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sama-Store - Statistiques Ventes</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8fafc; }</style>
</head>
<body class="text-slate-800 antialiased">

    <nav class="bg-white border-b border-slate-200 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 py-4 flex items-center justify-between h-16">
            <div class="flex items-center gap-4">
                <a href="{{ route('dashboard') }}" class="p-2 hover:bg-slate-100 rounded-full transition">
                    <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                </a>
                <h1 class="font-bold text-lg">Analyses & Performances</h1>
            </div>
            <div class="text-xs font-bold text-slate-400 uppercase tracking-widest bg-slate-50 px-3 py-1.5 rounded-lg border border-slate-100">
                7 Derniers Jours
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 py-10">
        
        <div class="grid lg:grid-cols-3 gap-8">
            
            <!-- Main Chart: Revenue -->
            <div class="lg:col-span-2 space-y-8">
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-200">
                    <div class="flex justify-between items-start mb-8">
                        <div>
                            <h3 class="text-xl font-extrabold text-slate-900">Chiffre d'Affaires</h3>
                            <p class="text-slate-400 text-sm font-medium">Evolution de vos ventes quotidiennes (FCFA)</p>
                        </div>
                        <div class="text-right">
                            <span class="text-2xl font-black text-indigo-600 block leading-none">{{ number_format(array_sum($salesData), 0, ',', ' ') }}</span>
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Total Semaine</span>
                        </div>
                    </div>
                    <div class="h-80">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>

                <div class="grid sm:grid-cols-2 gap-8">
                    <!-- Orders Count Chart -->
                    <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-200">
                        <h3 class="text-lg font-bold text-slate-800 mb-6">Modes de Paiement</h3>
                        <div class="h-64 flex items-center justify-center">
                            <canvas id="paymentChart"></canvas>
                        </div>
                    </div>

                    <!-- Additional Info -->
                    <div class="bg-indigo-600 rounded-3xl p-8 text-white relative overflow-hidden shadow-2xl shadow-indigo-100">
                        <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-white/10 rounded-full"></div>
                        <div class="relative z-10">
                            <h3 class="text-lg font-bold mb-4">Conseil IA 🤖</h3>
                            <p class="text-indigo-100 text-sm leading-relaxed mb-6 italic">
                                "Vos ventes ont augmenté de 15% ce weekend ! Pensez à relancer vos clients WhatsApp avec une offre spéciale 'Dimanche'."
                            </p>
                            <div class="bg-white/20 p-4 rounded-xl text-xs font-bold">
                                Meilleure heure de vente : 18:30
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Side column: Top Products -->
            <div class="lg:col-span-1 space-y-8">
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-200">
                    <h3 class="text-lg font-bold text-slate-900 mb-6">Top Produits ⭐</h3>
                    <div class="space-y-4">
                        @foreach($topProducts as $item)
                        <div class="flex items-center gap-4 p-3 rounded-2xl bg-slate-50 border border-slate-100">
                            <img src="{{ $item->product->image_url ?? '' }}" class="w-12 h-12 rounded-xl object-cover shadow-sm bg-slate-200">
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-bold text-slate-800 truncate">{{ $item->product->name ?? 'Produit inconnu' }}</p>
                                <p class="text-xs font-semibold text-slate-400">{{ $item->total }} commandes</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-200 text-center">
                    <div class="w-16 h-16 bg-emerald-50 text-emerald-500 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2">Prochain Paiement</h3>
                    <p class="text-slate-500 text-sm mb-0">Reste {{ now()->diffInDays($store->trial_ends_at) }} jours d'abonnement.</p>
                </div>
            </div>

        </div>
    </main>

    <script>
        // Graphique du Chiffre d'Affaires
        const ctxRevenue = document.getElementById('revenueChart').getContext('2d');
        new Chart(ctxRevenue, {
            type: 'line',
            data: {
                labels: {!! json_encode($labels) !!},
                datasets: [{
                    label: 'Ventes du jour (FCFA)',
                    data: {!! json_encode($salesData) !!},
                    borderColor: '#4f46e5',
                    backgroundColor: 'rgba(79, 70, 229, 0.1)',
                    borderWidth: 4,
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: '#4f46e5',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { borderDash: [5, 5], color: '#e2e8f0' },
                        ticks: { font: { weight: 'bold' }, color: '#94a3b8' }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { font: { weight: 'bold' }, color: '#94a3b8' }
                    }
                }
            }
        });

        // Graphique circulaire Modes de Paiement
        const ctxPayment = document.getElementById('paymentChart').getContext('2d');
        new Chart(ctxPayment, {
            type: 'doughnut',
            data: {
                labels: ['Wave', 'OM'],
                datasets: [{
                    data: [{{ $paymentMethods['Wave'] }}, {{ $paymentMethods['OM'] }}],
                    backgroundColor: ['#0ea5e9', '#f97316'],
                    borderWidth: 0,
                    hoverOffset: 10
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { 
                            usePointStyle: true, 
                            padding: 20,
                            font: { weight: 'bold', size: 12 }
                        }
                    }
                }
            }
        });
    </script>

</body>
</html>
