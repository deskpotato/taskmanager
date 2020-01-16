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


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/', 'ProjectsController@index')->name('projects.index');

Route::post('projects','ProjectsController@store')->name('projects.store');

Route::delete('projects/{project}',['uses'=>'ProjectsController@destroy','as'=>'projects.destroy']);

Route::patch('projects/{project}',['uses'=>'ProjectsController@update','as'=>'projects.update']);

Route::get('projects/{project}',['uses'=>'ProjectsController@show','as'=>'projects.show']);


//resource路由
Route::resource('tasks', 'TasksController');

Route::delete('tasks/{task}/steps/clear', 'StepController@clear');

Route::post('tasks/{task}/steps/complete', 'StepController@completeAll');


Route::patch('tasks/{task}/steps/{step}/toggle', 'StepController@toggle');

Route::resource('tasks.steps', 'StepController');


Route::post('tasks/{id}/check','TasksController@check')->name('tasks.check');
