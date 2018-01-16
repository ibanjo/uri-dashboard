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

use App\MobilityStatus;
use Illuminate\Http\Request;
use App\Role as Role;
use App\User as User;
use App\Department as Department;

Route::get('/', function () {
    return view('welcome');
});

// View routes
Route::middleware(['auth'])->group(function () {
    Route::prefix('view')->group(function () {
        // Match the "/view/whatever" URLs
        Route::get('users', 'UserController@viewAll')->name('view.allusers');
        Route::get('users/{id}', 'UserController@viewOne')->name('view.user');
        Route::get('students', 'UserController@viewStudents')->name('view.students');
    });
});

// Session related routes
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Password Reset Routes...
Route::prefix('password')->group(function () {
    Route::get('reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('forgotten_password');
    Route::post('email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('send_reset_link');
    Route::get('reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('reset_password');
    Route::post('reset', 'Auth\ResetPasswordController@reset');
});

Route::get('/home', 'HomeController@index')->name('home');

// Data entry routes (match '/entry/whatever' URLs)
Route::prefix('entry')->group(function () {
    // User registration
    Route::get('user', 'Auth\RegisterController@showRegistrationForm')->name('register');
    Route::post('user', 'Auth\RegisterController@register');

    Route::middleware(['auth'])->group(function () {
        // Bank related entry operations
        Route::prefix('bank')->group(function () {
            Route::post('account', 'BankController@createNewAccount')->name('new.bank.account');
        });

        // Mobility related entry operations
        Route::get('mobility/{user_id}', 'MobilityController@showNewMobilityForm')->name('entry.mobility');
        Route::post('mobility', 'MobilityController@createNewMobility')->name('new.mobility');
    });

    Route::middleware(['auth', 'admin'])->group(function() {
        Route::get('universities', 'AdminController@entryUniversities')->name('entry.universities');

        Route::post('country', 'AdminController@saveNewCountry')->name('new.country');
        Route::post('university', 'AdminController@saveNewUniversity')->name('new.university');
    });
});

// File managament routes
Route::middleware(['auth'])->group(function () {
    // Generic attachment routes
    Route::prefix('file')->group(function () {
        Route::post('upload', 'FileController@attachFile');
        Route::post('retrieve', 'FileController@retrieveAttachment')->name('file.retrieve');
        Route::get('retrieve/{name}', 'FileController@downloadAttachment')->name('file.downloadattachment');
        Route::delete('delete/{id}', 'FileController@deleteAttachment')->name('file.deleteattachment');
    });

    // Specific document-related routes
    Route::prefix('document')->group(function () {
        Route::post('upload', 'FileController@uploadDocument')->name('document.upload');
    });
});

// Edit record routes
Route::prefix('edit')->group(function () {
    Route::middleware(['auth'])->group(function () {
        Route::put('user/activebank', 'UserController@changeActiveBankAccount');
        Route::put('mobility/status', 'MobilityController@changeMobilityStatus')->name('edit.mobility.status');
        Route::put('mobility', 'MobilityController@editMobility')->name('edit.mobility');
        Route::put('mobility/abort', 'MobilityController@abortMobility')->name('mobility.abort');
    });
});

// Admin routes
Route::prefix('admin')->group(function () {
    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('approve', 'AdminController@checkUnapproved');
        Route::put('approve', 'AdminController@approveUser');
    });
});

// FIXME need to completely refactor routes (before it is too late)
