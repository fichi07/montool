<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\User\DashcboardController;
use App\Http\Controllers\User\MovieController;
use App\Http\Controllers\User\SubcribtionPlanController as  UserSubcriptionPlansController;
use App\Http\Controllers\Admin\MovieController as AdminMovieController; 


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

Route::redirect('/', '/login');

Route::middleware(['auth','role:user'])->prefix('dashboard')->name('user.dashboard.')->group(function(){
Route::get('/',[DashcboardController::class,'index'])->name('index');

Route::get('movie/{movie:slug}', [MovieController::class, 'show'])->name('movie.show')->middleware('checkUserSubcribtion:true');
Route::get('subcribtion-plan', [UserSubcriptionPlansController::class, 'index'])->name('subcribtionPlan.index')->middleware('checkUserSubcribtion:false');
Route::post('subcribtion-plan/{subcribtionPlan}/user-subcribe', [UserSubcriptionPlansController::class, 'userSubcribe'])->name('subcribtionPlan.userSubcribe')->middleware('checkUserSubcribtion:false');
});

Route::middleware(['auth','role:admin'])->prefix('admin')->name('admin.dashboard.')->group(function(){
    Route::resource('movie', AdminMovieController::class);
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::prefix('prototype')->name('prototype.')->group(function () {
    route::get('/login', function () {
        return Inertia::render('Prototype/Login');
    })->name('login');

    route::get('/register', function () {
       return Inertia::render('Prototype/Register'); 
    })->name('register');

    route::get('/dashboard', function () {
       return Inertia::render('Prototype/Dashboard'); 
    })->name('dashboard');

     route::get('/subcribtionPlan', function () {
       return Inertia::render('Prototype/SubcribtionPlan'); 
    })->name('subcribtionPlan');

     route::get('/movie/{slug}', function () {
       return Inertia::render('Prototype/Movie/Show'); 
    })->name('movie.show');
});
require __DIR__.'/auth.php';
