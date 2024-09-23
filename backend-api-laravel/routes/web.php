<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {

    return ['You shall not' => "pass!"];
});

require __DIR__.'/auth.php';
