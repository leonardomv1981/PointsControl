<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoungecardsController;
use App\Http\Controllers\MytripsController;
use App\Http\Controllers\PlansController;
use App\Http\Controllers\ProgramsController;
use App\Http\Controllers\TransactionsController;
use App\Models\Programs;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
use Laravel\Fortify\Http\Controllers\RegisteredUserController;
use Laravel\Fortify\Http\Controllers\ProfileInformationController;
use Laravel\Fortify\Http\Controllers\PasswordController;

// Grupo de rotas com prefixo de idioma
Route::group(['prefix' => '{locale}', 'where' => ['locale' => 'en|pt']], function () {
    // Rota da página inicial
    Route::get('/', function () {
        // Se o usuário estiver autenticado, redireciona para o dashboard
        if (auth()->check()) {
            return redirect()->route('dashboard');
        }
    
        return view('welcome'); // Caso contrário, exibe a página de boas-vindas
    });
    
    // Sobrescrever as rotas de autenticação do Fortify
    Route::get('/login', function () {
        return view('auth.login');
    })->middleware('guest')->name('login');

    // Página que solicita verificação
    Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->middleware('auth')->name('verification.notice');

    // Link de verificação recebido no e-mail
    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        return redirect('/' . $request->route('locale') . '/dashboard');
    })->middleware(['auth', 'signed'])->name('verification.verify');

    // Reenvio do e-mail de verificação
    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('status', 'verification-link-sent');
    })->middleware(['auth', 'throttle:6,1'])->name('verification.send');

    Route::post('/login', [AuthenticatedSessionController::class, 'store'])
        ->middleware('guest')
        ->name('login.store');

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
        ->middleware('auth')
        ->name('logout');

    Route::get('/contact', function () {
        return view('contact');
    })->middleware('guest')->name('contact');

    Route::post('/contact', [HomeController::class, 'contact'])
        ->middleware('guest')
        ->name('contact');

    Route::get('/register', function () {
        return view('auth.register');
    })->middleware('guest')->name('register');

    Route::post('/register', [RegisteredUserController::class, 'store'])
        ->middleware('guest')
        ->name('register.store');

    Route::post('/registerInvite', [HomeController::class, 'registerInvite'])
        ->middleware('guest')
        ->name('register.invite');

    // Sobrescrever as rotas do perfil do Fortify
    Route::get('/user/profile', function () {
        return view('profile.show');
    })->middleware('auth')->name('profile.show');

    Route::put('/user/profile-information', [ProfileInformationController::class, 'update'])
        ->middleware('auth')
        ->name('user-profile-information.update');

    Route::put('/user/password', [PasswordController::class, 'update'])
        ->middleware('auth')
        ->name('user-password.update');

    Route::get('/terms-of-service', function ($locale) {
        App::setLocale($locale);
        return view('terms');
    })->name('terms.show');

    Route::get('/privacy-policy', function ($locale) {
        App::setLocale($locale);
        return view('policy');
    })->name('policy.show');

    // Rotas protegidas por autenticação
    Route::middleware([
        'auth:sanctum',
        config('jetstream.auth_session'),
        'verified',
    ])->group(function () {
        Route::get('/dashboard', [ProgramsController::class, 'dashboard'])->name('dashboard');

        Route::prefix('plans')->group(function () {
            Route::get('/', [PlansController::class, 'index'])->name('plans.index');
            Route::post('/subscribe', [PlansController::class, 'subscribe'])->name('plans.subscribe');
        });

        Route::prefix('invites')->group(function () {
            Route::get('/', [HomeController::class, 'inviteIndex'])->name('invites.index');
            Route::post('/send', [HomeController::class, 'inviteSend'])->name('invites.send');
        });
        
    
        Route::prefix('programs')->group(function () {
            Route::get('/', [ProgramsController::class, 'index'])->name('programs.index');
            Route::get('/add', [ProgramsController::class, 'add'])->name('programs.add');
            Route::post('/add', [ProgramsController::class, 'add'])->name('programs.add');
            Route::post('/balance', [ProgramsController::class, 'balance'])->name('programs.balance');
            Route::post('/delete', [ProgramsController::class, 'delete'])->name('programs.delete');
        });
    
        Route::prefix('transactions')->group(function () {
            Route::get('/', [TransactionsController::class, 'index'])->name('transactions.add');
            Route::post('/', [TransactionsController::class, 'save'])->name('transactions.save');
            Route::post('/delete', [TransactionsController::class, 'delete'])->name('transactions.delete');
        });

        Route::prefix('lounges')->group(function () {
            Route::get('/', [LoungecardsController::class, 'index'])->name('lounges.index');
            Route::get('/add', [LoungecardsController::class, 'add'])->name('lounges.add');
            Route::post('/add', [LoungecardsController::class, 'add'])->name('lounges.add');
            Route::post('/delete', [LoungecardsController::class, 'delete'])->name('lounges.delete');
            Route::post('/add-access', [LoungecardsController::class, 'addAccess'])->name('lounges.add-access');
        });

        Route::prefix('trips')->group(function () {
            Route::get('/', [MytripsController::class, 'index'])->name('trips.index');
            Route::get('/add', [MytripsController::class, 'add'])->name('trips.add');
            Route::post('/add', [MytripsController::class, 'add'])->name('trips.add');
            Route::post('/delete', [MytripsController::class, 'delete'])->name('trips.delete');
        });

        Route::prefix('calculators')->group(function () {
            Route::get('/all', [HomeController::class, 'allCalculator'])->name('calculators.all');
            Route::get('/pointsAndMoney', [HomeController::class, 'pointsAndMoneyCalculator'])->name('calculators.pointsAndMoney');
        });

        Route::get('/contact', function () {
            return view('contact-login');
        })->name('contact');

    });
});

// Redirecionar para o idioma padrão ao acessar a raiz do site
Route::get('/', function () {
    return redirect('/pt');
});
