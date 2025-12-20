<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuickPreviewController;

Route::get('/quick-preview/{id}', [QuickPreviewController::class, 'show']);

