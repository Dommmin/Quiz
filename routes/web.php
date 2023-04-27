<?php

use App\Http\Controllers\Admin\TestController;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\ResultController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');


    Route::get('results', [ResultController::class, 'index'])->name('results.index');
});

Route::get('/', [HomeController::class, 'index'])->name('quiz.index');
Route::get('quiz/{quiz}', [HomeController::class, 'show'])->name('quiz.show');
Route::post('/quiz', [HomeController::class, 'store'])->name('quiz.store');
Route::get('results/{test}', [ResultController::class, 'show'])->name('results.show');
Route::get('leaderboard', [LeaderboardController::class, 'index'])->name('leaderboard.index');


Route::middleware('guest')->group(function () {
    Route::get('auth/{provider}/redirect', [SocialiteController::class, 'loginSocial'])
        ->name('socialite.auth');

    Route::get('auth/{provider}/callback', [SocialiteController::class, 'callbackSocial'])
        ->name('socialite.callback');
});

Route::middleware('isAdmin')->group(function () {
    Route::resource('questions', QuestionController::class);
    Route::resource('quizzes', QuizController::class);

    Route::get('tests', TestController::class)->name('tests');
});
