<?php

use Livewire\Attributes\On;
use Livewire\Component;

new class extends Component
{
    #[On('category::created')]
    public function categoryCreated(): void
    {
        session()->flash('message', 'Categoria cadastrada com sucesso.');
    }

    #[On('category::edited')]
    public function categoryEdited(): void
    {
        session()->flash('message', 'Categoria editada com sucesso.');
    }

    #[On('category::deleted')]
    public function categoryDeleted(): void
    {
        session()->flash('message', 'Categoria deletada com sucesso.');
    }


};