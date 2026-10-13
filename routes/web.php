<?php

use App\Livewire\PropertyListing;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');
Route::get('/properties', PropertyListing::class)->name('properties');

// created with: php artisan make:livewire Chat --class   (file: app/Livewire/Chat.php)
Route::get('/chat', \App\Livewire\Chat::class);

// created with: php artisan make:livewire Chat   (single-file, Livewire 4)
// Route::livewire('/chat', 'pages::chat');