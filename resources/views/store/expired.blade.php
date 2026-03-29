<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boutique Suspendue - Sama-Store AI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-white flex items-center justify-center min-h-screen p-6 text-center">

    <div class="max-w-md">
        <div class="w-24 h-24 bg-red-50 text-red-500 rounded-full flex items-center justify-center mx-auto mb-8 shadow-inner">
            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
        </div>
        
        <h1 class="text-3xl font-extrabold text-slate-900 mb-4 tracking-tight">Oups ! Boutique en Pause 🛑</h1>
        <p class="text-slate-500 mb-8 leading-relaxed">
            La boutique **{{ $store->name }}** est temporairement indisponible car sa période d'essai est terminée. 
        </p>

        <div class="bg-slate-50 border border-slate-100 p-6 rounded-2xl mb-8">
            <p class="text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">Vous êtes le propriétaire ?</p>
            <p class="text-sm text-slate-500 mb-4">Reconnectez-vous sur votre tableau de bord pour activer votre abonnement en 2 minutes.</p>
            <a href="{{ route('login') }}" class="inline-flex items-center gap-2 bg-slate-900 text-white font-bold px-6 py-3 rounded-xl hover:bg-indigo-600 transition shadow-lg">
                <span>Accéder au Dashboard</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </a>
        </div>

        <p class="text-xs text-slate-400 font-medium italic">Sama-Store AI - La technologie qui propulse les vendeurs africains.</p>
    </div>

</body>
</html>
