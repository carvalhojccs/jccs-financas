<?php

use Livewire\Livewire;

test('dispatches the category name and color to the preview', function () {
    Livewire::test('pages::categories.create')
        ->set('name', 'Alimentação')
        ->assertDispatchedTo(
            'pages::categories.preview',
            'category-preview-updated',
            name: 'Alimentação',
            color: '#3b8276',
        )
        ->set('color', '#EF4444')
        ->assertDispatchedTo(
            'pages::categories.preview',
            'category-preview-updated',
            name: 'Alimentação',
            color: '#EF4444',
        );
});

test('updates the preview name and color from the category event', function () {
    Livewire::test('pages::categories.preview')
        ->dispatch('category-preview-updated', name: 'Alimentação', color: '#EF4444')
        ->assertSet('name', 'Alimentação')
        ->assertSet('color', '#EF4444');
});
