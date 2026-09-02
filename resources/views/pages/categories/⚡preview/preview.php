<?php

use Livewire\Attributes\On;
use Livewire\Component;

new class extends Component
{
    public string $color = '#3b8276';

    public string $name = '';

    #[On('category-preview-updated')]
    public function updatePreview(string $name, string $color): void
    {
        $this->name = $name;
        $this->color = $color;
    }

    #[On('category::preview.reset')]
    public function resetPreview(): void
    {
        $this->reset('name', 'color');
    }
};
