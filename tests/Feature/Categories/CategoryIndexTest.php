<?php

use App\Models\Category;
use App\Models\User;
use Livewire\Livewire;

test('renders a newly created category after receiving the creation event', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $categories = Livewire::test('pages::categories')
        ->assertDontSee('Alimentação');

    Category::query()->create([
        'user_id' => $user->id,
        'name' => 'Alimentação',
        'color' => '#EF4444',
        'icon' => null,
    ]);

    $categories
        ->dispatch('category::created')
        ->assertSee('Alimentação');
});
