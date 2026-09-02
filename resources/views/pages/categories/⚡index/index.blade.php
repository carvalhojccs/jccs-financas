<div class="lg:col-span-2">
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800">
                {{ __('Suas categorias') }}
            </h3>
            <p class="text-sm text-gray-600 mt-1">
                {{ $this->categories->count() }} {{ __('categorias') }}
            </p>
        </div>

        @if ($this->categories->count() > 0)
            <div class="divide-y divide-gray-200">
                @foreach ($this->categories as $category)
                    <div class="p-6 hover:bg-gray-50 transition" wire:key='category-{{ $category->id }}'>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-4 flex-1">
                                <div class="w-12 h-12 rounded-lg flex items-center justify-center"
                                    style="background-color: {{ $category->color }}20;">
                                    <div class="w-6 h-6 rounded-full" style="background-color: {{ $category->color }};"></div>
                                </div>
                                <div class="flex-1">
                                    <h4 class="text-lg font-semibold text-grey-900">
                                        {{ $category->name }}
                                    </h4>
                                    <p class="text-sm text-gray-600">
                                        {{ $category->expenses_count }} {{ Str::plural('despesa', $category->expenses_count) }}
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <flux:button size="sm" icon="pencil-square" wire:click='edit({{ $category->id }})' />
                                @if ($category->expenses_count === 0)
                                    <flux:button size="sm" icon="trash" wire:click='delete({{ $category->id }})' wire:confirm='Confirma deletar essa categoria?' />
                                
                                @else
                                    <div class="flex items-center gap-2">
                                        <flux:icon.hand-raised />
                                        <span class="p-2 text-gray-400 cursor-not-allowed">
                                              Não é possível deletar categoria com despesas.
                                        </span>
                                    </div>
                                @endif                                
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
