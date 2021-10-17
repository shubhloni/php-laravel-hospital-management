<?php

use Illuminate\Support\Facades\Route;

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
    return view('main');
});

// Route::get('family', function () {
//     return view('family.index');
// });

Auth::routes();

// Route::get('auth/register', function () {
//     return view('auth.register');
// });

Route::get('auth/add_user', function () {
    return view('auth.register');
});

// Route::post('user/store','UserController@store');

Route::resource('user','UserController');

Route::get('home', 'HomeController@index')->name('home');

Route::resource('posts','PostsController');

Route::get('family/addPatient/{id}','FamilyController@addPatient');

Route::resource('family','FamilyController');

Route::post('patient_record/update_status/{id}', [
    'uses' => 'PatientRecordController@updateStatus'
  ]);

Route::get('patient_records/create/{id}','PatientRecordController@create');

Route::resource('patient_records','PatientRecordController');

Route::post('patients/update_status/{id}', [
    'uses' => 'PatientsController@updateStatus'
  ]);

Route::resource('patients','PatientsController');

// Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
