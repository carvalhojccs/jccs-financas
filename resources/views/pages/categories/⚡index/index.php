<?php

use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

new class extends Component
{
    public $name ="";
    public $color = "#3B82F6";
    public $icon = "";
    public $editingId = null;
    public $isEditing = false;
    public $colors = [
        "#EF4444", // Red
        "#F97316", // Orange
        "#F59E0B", // Amber
        "#EAB308", // Yellow
        "#84CC16", // Lime
        "#22C55E", // Green
        "#10B981", // Emerald
        "#14B8A6", // Teal
        "#06B6D4", // Cyan
        "#0EA5E9", // Sky
        "#3B82F6", // Blue
        "#6366F1", // Indigo
        "#8B5CF6", // Violet
        "#A855F7", // Purple
        "#D946EF", // Fuschia
        "#EC4899", // Pink
        "#F43F5E", // Rose
    ];

    #[Computed]
    public function categories()
    {
        return Category::withCount('expenses')
            ->where('user_id', Auth::user()->id)
            ->orderBy('name')
            ->get();
    }

    public function edit(int $categoriId): void
    {
        $this->dispatch('caregory::edit', $categoriId);
    }

    #[On('category::created')]
    #[On('category::edited')]
    public function refreshCategories(): void
    {
        unset($this->categories);
    }

    public function delete(int $categoryId): void
    {
        $category = Category::findOrFail($categoryId);

        if ($category->user_id !== Auth::id()) {
            abort(403);
        }

        if ($category->expenses()->count() > 0) {
            session()->flash('error', 'Não é possível deletar categoria com despesas.');
            return;   
        }

        $category->delete();

        $this->dispatch('category::deleted');
    }

};
