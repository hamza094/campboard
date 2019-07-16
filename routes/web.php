<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware'=>'auth'], function () {
    
Route::get('/projects','ProjectsController@index');
Route::get('/projects/create','ProjectsController@create');    
Route::post('/projects','ProjectsController@store');
Route::get('/projects/{project}','ProjectsController@show');
Route::get('/projects/{project}/edit','ProjectsController@edit');    
Route::patch('/projects/{project}', 'ProjectsController@update')->name('project.update');  
    
Route::post('/projects/{project}/tasks', 'ProjectTasksController@store')->name('task.create');  
Route::patch('/projects/{project}/tasks/{task}', 'ProjectTasksController@update')->name('task.update');  
    
});

