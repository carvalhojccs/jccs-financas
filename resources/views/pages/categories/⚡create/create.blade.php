<div class="lg:col-span-1">
    <div class="bg-white rounded-xl shadow-md p-6 sticky top-8">
        <h3 class="text-lg font-semibold text-gray-800 mb-6">
            {{ $isEditing ? 'Editar categoria' : 'Criar categoria' }}
        </h3>
        <form wire:submit='save' class="space-y-4">
            {{-- category name --}}
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    {{ __('Nome da categoria') }} <span class="text-red-500">*</span>
                </label>
                <input type="text" id="name" wire:model.live="name" placeholder="Ex.: Refeição fora"
                    class="w-full px-4 py-3 border  rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('name') border-red-500 @enderror">
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            {{-- color picker --}}
            <div>
                <label for="color" class="block text-sm font-medium text-gray-700 mb-2">
                    {{ __('Cor') }} <span class="text-red-500">*</span>
                </label>
                <div class="grid grid-cols-6 gap-2">
                    @foreach ($colors as $colorOption)
                        <button type="button" wire:click="$set('color', '{{ $colorOption }}')"
                            class="w-10 h-10 rounded-lg transition transform hover:scale-110 {{ $color == $colorOption ? 'ring-4 ring-offset-2 ring-gray-400' : '' }}"
                            style="background-color: {{ $colorOption }};">
                        </button>
                    @endforeach
                </div>
                @error('color')
                    <p class="mt-1 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror
            </div>
            <!-- Preview -->
            <livewire:pages::categories.preview />

            {{-- Form Actions --}}
            <div class="flex gap-2">
                @if ($isEditing)
                    <button type="button" class="flex-1 px-4 py-3 border border-gray-300 rounded-lg text-gray-400 font-semibold hover:bg-gray-50 transition" wire:click='cancelEdit'>
                        {{ __("Cancelar") }}
                    </button>                    
                @endif

                <button type="submit" class="flex-1 px-4 py-3 bg-linear-to-r from-green-600 to-emerald-600 text-white rounded-lg font-semibold hover:shadow-lg transition">
                    {{ $isEditing ? 'Atualizar' : 'Salvar' }}
                </button>
            </div>

        </form>
    </div>
</div>
