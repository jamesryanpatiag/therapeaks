<?php

use Illuminate\Support\Facades\Route;

Route::redirect('/', '/admin');

Route::get('/admin/chat-page/{patientId}', [App\Filament\Pages\ChatPage::class, 'index']);
