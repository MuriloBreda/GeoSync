<?php

use Illuminate\Support\Facades\Route;

// Página inicial
Route::get('/', function () {
    return view('index');
});

// Sobre
Route::get('/about', function () {
    return view('about');
});

// Contato
Route::get('/contact', function () {
    return view('contact');
});

// Serviços
Route::get('/service', function () {
    return view('service');
});

// Preços
Route::get('/price', function () {
    return view('price');
});

// Welcome (padrão Laravel)
Route::get('/welcome', function () {
    return view('welcome');
});