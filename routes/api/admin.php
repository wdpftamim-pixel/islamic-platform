<?php

use Illuminate\Support\Facades\Route;

Route::middleware([
    'auth:sanctum',
    'role:super-admin'
])->group(function () {

    Route::get('/admin/test', function () {

        return response()->json([
            'success' => true,
            'message' => 'Super Admin Access Granted',
        ]);

    });

});
