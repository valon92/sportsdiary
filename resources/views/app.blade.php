<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('app'); // Thjesht 'app' pa '/' përpara.
                        // Laravel e di që duhet të kërkojë 'resources/views/app.blade.php'
});