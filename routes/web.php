<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin/chat-page/{patientId}', [App\Filament\Pages\ChatPage::class, 'index']);
