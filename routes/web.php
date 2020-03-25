<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::resource('/nombres', 'NombreController')->middleware('auth');
Route::resource('/instituciones', 'InstitucionController')->middleware('auth');
Route::resource('/cursos', 'CursoController')->middleware('auth');
Route::get('/home', 'HomeController@index')->name('home');
