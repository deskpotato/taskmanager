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


Route::get('tasks/search', 'TasksController@search');

Route::get('tasks/charts', 'TasksController@charts')->name('tasks.charts');
//resource路由
Route::resource('tasks', 'TasksController');

Route::post('tasks/{task}/steps/complete', 'StepController@completeAll');

Route::delete('tasks/{task}/steps/clear', 'StepController@clear');

Route::resource('tasks.steps', 'StepController');


Route::post('tasks/{id}/check','TasksController@check')->name('tasks.check');

//bigdata数据爬取路由-test

//Route::get('bigdata','BigdataController@index')->name('bigdata');

Route::get('showprofile','ShowProfile');

Route::fallback(function (){
    return "Have you lost yourself?";
});
