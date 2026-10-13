<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Services\PropertyChatbot;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/chat', function (Request $r, PropertyChatbot $bot) {
    $data = $r->validate([
        'messages' => 'required|array|max:20',
        'messages.*.role' => 'required|in:user,assistant',
        'messages.*.content' => 'required|string|max:2000',
    ]);
    return ['reply' => $bot->ask($data['messages'])];
})->middleware(['auth:sanctum', 'throttle:20,1']);