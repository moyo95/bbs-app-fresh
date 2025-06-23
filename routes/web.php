<?php

// まず、あなたが必要なコントローラーをすべて use します。
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- 認証が不要なルート ---
Route::get('/', [WelcomeController::class, 'index'])->name('welcome');
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact/confirm', [ContactController::class, 'confirm'])->name('contact.confirm');
Route::post('/contact/send', [ContactController::class, 'send'])->name('contact.send');
Route::get('/contact/complete', [ContactController::class, 'complete'])->name('contact.complete');

// ★★★ ここが最重要ポイント！ ★★★
// '/posts/create' のような固定のパスを、'/posts/{post}' のような可変のパスよりも【必ず上に】書く
Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create')->middleware('auth');

// 上の 'create' に一致しなかった場合に、このルートがチェックされる
Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');


// --- 認証済み（かつメール認証済み）ユーザーのみがアクセス可能なルート ---
Route::middleware(['auth', 'verified'])->group(function () {
    
    // ダッシュボード
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // /posts/create は上に移動したので、ここからは不要
    
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
    
    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::post('/posts/{post}/like', [LikeController::class, 'toggleLike'])->name('posts.like');
    // routes/web.php

    // プロフィール関連
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/phpinfo', function () { phpinfo(); });
    
});

// Breezeが作成した認証ルートの読み込み
require __DIR__.'/auth.php';