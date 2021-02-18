<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

//________CLIENTS (MAIN PAGE)____________________________________________________________

Route::get('/home', 'App\Http\Controllers\ClientsController@index')->middleware('auth');

Route::post('/createNewClient', 'App\Http\Controllers\ClientsController@createClient')->middleware('auth');

Route::get('/deleteClient/{id}', 'App\Http\Controllers\ClientsController@deleteClient')->middleware('auth');

Route::get('/showClient/{id}', 'App\Http\Controllers\ClientsController@showClient')->middleware('auth');

Route::post('/updateClient/{id}', 'App\Http\Controllers\ClientsController@updateClient')->middleware('auth');

Route::post('/sendEmailToGroup', 'App\Http\Controllers\MailsController@emailToGroup')->middleware('auth');

//________TEMPLATES______________________________________________________________________

Route::get('/templates', 'App\Http\Controllers\TemplatesController@index')->middleware('auth');

Route::post('/templates/createNewTemplate', 'App\Http\Controllers\TemplatesController@createTemplate')->middleware('auth');

Route::get('/templates/showTemplate/{id}', 'App\Http\Controllers\TemplatesController@showTemplate')->middleware('auth');

Route::post('/templates/updateTemplate/{id}', 'App\Http\Controllers\TemplatesController@updateTemplate')->middleware('auth');

Route::get('/templates/deleteTemplate/{id}', 'App\Http\Controllers\TemplatesController@deleteTemplate')->middleware('auth');

Route::get('/template/{id}', 'App\Http\Controllers\TemplatesController@readTemplate')->middleware('auth');

//________Mails_____________________________________________________________________________

Route::post('/sendEmailToClient', 'App\Http\Controllers\MailsController@mailForClient')->middleware('auth');

Route::post('/sendEmailToGroup', 'App\Http\Controllers\MailsController@mailForGroup')->middleware('auth');

Route::get('/scheduledEmails', 'App\Http\Controllers\ScheduledEmailsController@index')->middleware('auth');

Route::get('/scheduledEmails/deletePlanedMail/{id}', 'App\Http\Controllers\ScheduledEmailsController@deleteScheduledEmail')->middleware('auth');
