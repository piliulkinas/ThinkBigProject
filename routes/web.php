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

Route::get('/home', 'App\Http\Controllers\ClientsController@index');

Route::post('/createNewClient', 'App\Http\Controllers\ClientsController@createClient');

Route::get('/deleteClient/{id}', 'App\Http\Controllers\ClientsController@deleteClient');

Route::get('/showClient/{id}', 'App\Http\Controllers\ClientsController@showClient');

Route::post('/updateClient/{id}', 'App\Http\Controllers\ClientsController@updateClient');

Route::post('/sendEmailToGroup', 'App\Http\Controllers\MailsController@emailToGroup');

//________TEMPLATES______________________________________________________________________

Route::get('/templates', 'App\Http\Controllers\TemplatesController@index');

Route::post('/templates/createNewTemplate', 'App\Http\Controllers\TemplatesController@createTemplate');

Route::get('/templates/showTemplate/{id}', 'App\Http\Controllers\TemplatesController@showTemplate');

Route::post('/templates/updateTemplate/{id}', 'App\Http\Controllers\TemplatesController@updateTemplate');

Route::get('/templates/deleteTemplate/{id}', 'App\Http\Controllers\TemplatesController@deleteTemplate');

Route::get('/template/{id}', 'App\Http\Controllers\TemplatesController@readTemplate');

//________Mails_____________________________________________________________________________

Route::post('/sendEmailToClient', 'App\Http\Controllers\MailsController@mailForClient');

Route::post('/sendEmailToGroup', 'App\Http\Controllers\MailsController@mailForGroup');

Route::get('/scheduledEmails', 'App\Http\Controllers\ScheduledEmailsController@index');

Route::get('/scheduledEmails/deletePlanedMail/{id}', 'App\Http\Controllers\ScheduledEmailsController@deleteScheduledEmail');
