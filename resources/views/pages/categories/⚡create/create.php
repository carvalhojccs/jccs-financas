<?php

declare(strict_types=1);

use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Component;

new class extends Component
{
    public ?int $editingId = null;

    public bool $isEditing = false;

    public string $icon = '';

    public string $name = '';

    public string $color = '#3b8276';

    public array $colors = [
        '#EF4444', // Red
        '#F97316', // Orange
        '#F59E0B', // Amber
        '#EAB308', // Yellow
        '#84CC16', // Lime
        '#22C55E', // Green
        '#10B981', // Emerald
        '#14B8A6', // Teal
        '#06B6D4', // Cyan
        '#0EA5E9', // Sky
        '#3B82F6', // Blue
        '#6366F1', // Indigo
        '#8B5CF6', // Violet
        '#A855F7', // Purple
        '#D946EF', // Fuchsia
        '#EC4899', // Pink
        '#F43F5E', // Rose
    ];

    protected function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories', 'name')
                    ->ignore($this->editingId ?: null)
                    ->where('user_id', Auth::id())
            ],
            'color' => ['required', 'string'],
            'icon' => ['nullable', 'string', 'max:255']
        ];
    }

    protected $messages = [
        'name.required' =>  'Por favor informe o nome da categoria.',
        'name.unique' => 'VocÊ já tem uma categoria cadastrada com esse nome.',
        'color.required' => 'Por favor selecione uma cor para a categoria.'
    ];

    public function save()
    {
        $validated = $this->validate();

        if ($this->isEditing && $this->editingId) {
            $category = Category::findOrFail($this->editingId);

            if ($category->user_id !== Auth::id()) {
                abort(403);
            }

            $category->update([
                'name' => $this->name,
                'color' => $this->color,
                'icon' => $this->icon,
            ]);

            $this->dispatch('category::edited');
        } else {
            Category::create([
                'user_id' => Auth::id(),
                'name' => $validated['name'],
                'color' => $validated['color'],
                'icon' => $validated['icon']
            ]);

            $this->dispatch('category::created');
        }

        $this->reset(['name', 'color', 'icon', 'editingId', 'isEditing']);
        $this->resetValidation();

        $this->dispatch('category::preview.reset')
            ->to('pages::categories.preview');
    }

    public function cancelEdit(): void
    {
        $this->reset(['name', 'color', 'icon', 'editingId', 'isEditing']);
        $this->color = "#3B82F6";
    }

    public function updatedName(string $name): void
    {
        $this->dispatchCategoryPreviewUpdated($name, $this->color);
    }

    public function updatedColor(string $color): void
    {
        $this->dispatchCategoryPreviewUpdated($this->name, $color);
    }

    private function dispatchCategoryPreviewUpdated(string $name, string $color): void
    {
        $this->dispatch('category-preview-updated', name: $name, color: $color)
            ->to('pages::categories.preview');
    }

    #[On('caregory::edit')]
    public function edit(int $categoryId): void
    {
        $category = Category::findOrFail($categoryId);

        if ($category->user_id !== Auth::id()) {
            abort(403);
        }

        $this->editingId = $categoryId;
        $this->name = $category->name;
        $this->color = $category->color;
        $this->icon = $category->icon;
        $this->isEditing = true;
    }


};
