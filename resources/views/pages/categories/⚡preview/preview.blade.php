<div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg border-2 border-dashed border-gray-300 dark:border-gray-500">
    <p class="text-sm text-gray-400 mb-2">Preview:</p>
    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm font-medium"
        style="background-color: {{ $color }}20; color: {{ $color }};">
        <span class="w-3 h-3 rounded-full" style="background-color: {{ $color }};"></span>
        {{ $name ?: 'Nome da categoria' }}
    </div>
</div>
