<?php

use App\Http\Controllers\HookController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post('webhook/transaction', [HookController::class, 'receive'])->name('webhook.receive');
Route::post('webhook/send', [HookController::class, 'sent'])->name('webhook.send');
