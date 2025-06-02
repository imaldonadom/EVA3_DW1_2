<?php

use Illuminate\Support\Facades\Route;

Route::get('/proyectos-web', function () {
    return view('index'); // busca views/index.blade.php
});