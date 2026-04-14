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

// Welcome (padrão Laravel)
Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/login', function() {
    return view('login');
});

Route::get('/accont', function() {
    return view('createAccount');
});

Route::get('/avaliar', function() {
    return view('avaliacao');
});

Route::get('/cadastroMercadoria', function() {
    return view('cadastromercadoria');
});

Route::get('/chat', function () {
    return view('chat');
})->name('chat');