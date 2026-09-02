
<div class="min-h-screen bg-gray-50 dark:bg-neutral-900">
    {{-- Header --}}
    <div class="bg-gradient-to-r from-green-600 to-emerald-600 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div>
                <h1 class="text-3xl font-bold text-white">
                    {{ __('Categorias') }}
                </h1>
                <p class="text-green-100 mt-1">
                    {{ __('Organize suas despesas com categorias customizadas') }}
                </p>
            </div>
        </div>
    </div>
    {{-- Flash messages --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px8 py-8">
        @if (session()->has('message'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg flex items-center">
                <span>{{ session('message') }}</span>
                <button class="text-green-600 hover:text-green-800" onclick="this.parentElement.remove()">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="ruond" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        @endif
        @if (session()->has('error'))
            <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg flex items-center">
                <span>{{ session('message') }}</span>
                <button class="text-red-600 hover:text-red-800" onclick="this.parentElement.remove()">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="ruond" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        @endif
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- create category form --}}
        <livewire:pages::categories.create />
        {{-- edit category form --}}

        {{-- categories listing --}}
        <livewire:pages::categories />

    </div>
</div>
