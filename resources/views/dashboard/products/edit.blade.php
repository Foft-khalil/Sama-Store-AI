<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sama-Store - Modifier Produit</title>
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
            <h1 class="font-bold text-lg">Modifier le produit</h1>
        </div>
    </nav>

    <main class="max-w-3xl mx-auto px-4 py-10">
        
        <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-8">
                <div class="flex items-center gap-6 mb-10 pb-10 border-b border-slate-100">
                    <img src="{{ $product->image_url }}" class="w-24 h-24 rounded-2xl object-cover shadow-lg border-4 border-white">
                    <div>
                        <h2 class="text-2xl font-extrabold text-slate-900">{{ $product->name }}</h2>
                        <p class="text-indigo-600 font-bold tracking-tight text-lg">{{ number_format($product->price, 0, ',', ' ') }} FCFA</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('products.update', $product->id) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid gap-6">
                        <div>
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Nom du produit</label>
                            <input type="text" name="name" value="{{ $product->name }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3.5 focus:bg-white focus:ring-2 focus:ring-indigo-500 transition font-bold outline-none">
                        </div>

                        <div>
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Prix (FCFA)</label>
                            <input type="number" name="price" value="{{ $product->price }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3.5 focus:bg-white focus:ring-2 focus:ring-indigo-500 transition font-bold outline-none">
                        </div>

                        <div>
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Catégorie</label>
                            <input type="text" name="category" value="{{ $product->category }}" placeholder="Ex: Robes, Electronique..." class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3.5 focus:bg-white focus:ring-2 focus:ring-indigo-500 transition font-bold outline-none">
                        </div>

                        <div>
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Description</label>
                            <textarea name="description" rows="4" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3.5 focus:bg-white focus:ring-2 focus:ring-indigo-500 transition font-medium outline-none">{{ $product->description }}</textarea>
                        </div>

                        <div class="flex items-center gap-4 bg-slate-50 p-4 rounded-2xl border border-slate-100">
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="hidden" name="is_active" value="0">
                                <input type="checkbox" name="is_active" value="1" {{ $product->is_active ? 'checked' : '' }} class="sr-only peer">
                                <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                            </label>
                            <span class="text-sm font-bold text-slate-700 uppercase tracking-tight">Produit Actif (Visible en boutique)</span>
                        </div>
                    </div>

                    <div class="mt-10 pt-10 border-t border-slate-100 flex items-center justify-between">
                        <button type="button" onclick="if(confirm('Supprimer ce produit définitivement ?')) document.getElementById('delete-form').submit();" class="text-red-500 font-bold hover:text-red-600 transition flex items-center gap-2 px-4 py-2 hover:bg-red-50 rounded-xl">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            Supprimer
                        </button>
                        
                        <button type="submit" class="bg-indigo-600 text-white px-8 py-3.5 rounded-2xl font-extrabold hover:bg-slate-900 shadow-xl shadow-indigo-100 transition flex items-center gap-2 transform active:scale-95">
                            Sauvegarder les modifications
                        </button>
                    </div>
                </form>

                <form id="delete-form" action="{{ route('products.delete', $product->id) }}" method="POST" class="hidden">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        </div>
    </main>

</body>
</html>
