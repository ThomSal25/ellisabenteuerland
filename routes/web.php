<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\ImageController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [MainController::class, 'index']);


// Login
Route::controller(LoginController::class)->group(function(){
    Route::get('login', 'index')->name('login');
    Route::get('registration', 'registration')->name('registration');
    Route::get('logout', 'logout')->name('logout');
    Route::get('image', 'image')->name('image');

    Route::post('validate_registration', 'validate_registration')->name('sample.validate_registration');
    Route::post('validate_login', 'validate_login')->name('sample.validate_login');
    Route::get('dashboard', 'dashboard')->name('dashboard');
}); 

Route::get('/image', [ImageController::class,'indexImage'])->name('image.index');
Route::post('/image', [ImageController::class,'storeImage'])->name('image.store');

// Vue
Route::get('/home', [MainController::class, 'index']);
Route::get('/ueber-mich', [MainController::class, 'index']);
Route::post('/content/createContent', [ContentController::class, 'saveWithVue']);
Route::put('/content/updateContent/{id}', [ContentController::class, 'updateWithVue']); 
Route::delete('/content/deleteContent/{id}', [ContentController::class, 'deleteWithVue']);
Route::get('/content/list', [ContentController::class, 'indexContent']);

Route::post('/newImage', [ImageController::class, 'saveImage'])->name('image.save');
Route::get('/allImg', [TodoListController::class, 'loadImg']);