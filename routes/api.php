<?php

use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {

    require __DIR__ . '/api/auth.php';
    require __DIR__ . '/api/admin.php';
    require __DIR__ . '/api/articles.php';
    require __DIR__ . '/api/categories.php';
    require __DIR__ . '/api/fatwas.php';
    require __DIR__ . '/api/books.php';

});
