<?php

use App\Http\Controllers\NoteController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TrashedNoteController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// =-------------------
/*
// To display all notes for the logined user
        Route::get('/notes',);

// this is the unique id in the url
        Route::get('/notes/{note}',);

// to display a form to create an note
        Route::get('/notes/create',);

// This is to save the created note
        Route::post('/notes',);
// edit
// update
// destory
*/
// --------------------------
//  Instead of this above router we are using resource Router like
//  check the laravel resource documentation in laravel 9, that will explain clear
// Route::resource('/notes',);
// ------------------------


Route::resource('/notes',NoteController::class)->middleware(['auth']);

        //  this makes number of code increases for trashed route

// this route is for triger the function in the TrashedNoteController trashed note to the user
Route::get('/trashed',[TrashedNoteController::class, 'index'])->middleware(['auth'])->name('trashed.index');

// this route is to show the trashed noted
// this route binding model cannot fetch the soft deleted notes for that we are using keywords like onlyTrashed() || withTrashed();
Route::get('/trashed/{note}', [TrashedNoteController::class, 'show'])
        ->withTrashed()
        ->middleware('auth')->name('trashed.show');

// update for trashed to restore
Route::put('/trashed/{note}',[TrashedNoteController::class, 'update'])->withTrashed()->middleware(['auth'])->name('trashed.update');


// this route is for delete the note permanently
Route::delete('/trashed/{note}',[TrashedNoteController::class, 'destroy'])->withTrashed()->middleware(['auth'])->name('trashed.destroy');


// -------------------
// Group Rotues for trashed 
// Route::prefix('/trashed')->name('trashed')->middleware(['auth'])->group(function(){
//     Route::get('/',[TrashedNoteController::class, 'index'])->name('index');
//     Route::get('/{note}',[TrashedNoteController::class,'show'])->name('show')->withTrashed();
//     Route::put('/{note}',[TrashedNoteController::class, 'update'])->name('update')->withTrashed();
//     Route::delete('/{note}',[TrashedNoteController::class, 'destroy'])->name('destroy')->withTrashed();
// });












Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
