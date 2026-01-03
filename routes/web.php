<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HomeRedirectController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CriterionController;
use App\Http\Controllers\EvaluationController;

if (app()->environment('production')) {
    URL::forceScheme('https');
}

// トップページ → ログイン状態で振り分け
Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('home')
        : redirect()->route('landing');
});
// landing ページ（ログアウト時のトップページ）
Route::get('/landing', function () {
    return view('landing'); // resources/views/landing.blade.php を表示
})->name('landing');


// ログインフォーム
Route::get('/login', [HomeController::class, 'showLoginForm'])->name('login');
Route::post('/login', [HomeController::class, 'login']);

// ログアウト
Route::post('/logout', [HomeController::class, 'logout'])->name('logout');

// 新規登録
Route::get('/register', [HomeController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [HomeController::class, 'register']);

// 認証済みのみアクセスできるルート
Route::middleware('auth')->group(function () {

    // ホームページ
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Company リソース
    Route::prefix('companies')->name('companies.')->group(function () {
        Route::get('/', [CompanyController::class, 'index'])->name('index');
        Route::get('/create', [CompanyController::class, 'create'])->name('create');
        Route::post('/', [CompanyController::class, 'store'])->name('store');
        Route::get('/ranking', [CompanyController::class, 'ranking'])->name('ranking');
        Route::get('/{company}/compare', [CompanyController::class, 'compare'])
            ->name('compare');

        Route::get('/{company}', [CompanyController::class, 'show'])->name('show');
        Route::get('/{company}/edit', [CompanyController::class, 'edit'])->name('edit');
        Route::put('/{company}', [CompanyController::class, 'update'])->name('update');
        Route::patch('/{company}', [CompanyController::class, 'update']);
        Route::delete('/{company}', [CompanyController::class, 'destroy'])->name('destroy');
    });

    // Criterion リソース
    Route::prefix('criteria')->name('criteria.')->group(function () {
        Route::get('/', [CriterionController::class, 'index'])->name('index');
        Route::get('/create', [CriterionController::class, 'create'])->name('create');
        Route::post('/', [CriterionController::class, 'store'])->name('store');
        Route::get('/{criterion}', [CriterionController::class, 'show'])->name('show');
        Route::get('/{criterion}/edit', [CriterionController::class, 'edit'])->name('edit');
        Route::put('/{criterion}', [CriterionController::class, 'update'])->name('update');
        Route::patch('/{criterion}', [CriterionController::class, 'update']);
        Route::delete('/{criterion}', [CriterionController::class, 'destroy'])->name('destroy');
    });

    // Evaluation リソース
    Route::prefix('evaluations')->name('evaluations.')->group(function () {
        Route::get('/', [EvaluationController::class, 'index'])->name('index');
        Route::get('/create', [EvaluationController::class, 'create'])->name('create');
        Route::post('/', [EvaluationController::class, 'store'])->name('store');
        Route::get('/{evaluation}', [EvaluationController::class, 'show'])->name('show');
        Route::get('/{evaluation}/edit', [EvaluationController::class, 'edit'])->name('edit');
        Route::put('/{evaluation}', [EvaluationController::class, 'update'])->name('update');
        Route::patch('/{evaluation}', [EvaluationController::class, 'update']);
        Route::delete('/{evaluation}', [EvaluationController::class, 'destroy'])->name('destroy');
    });
});