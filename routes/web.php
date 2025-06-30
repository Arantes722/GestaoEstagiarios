<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\PresencaController;
use App\Http\Controllers\DocumentoController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\RelatoriosController;
use App\Http\Controllers\DashboardController;

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\AdministradorController;
use App\Http\Controllers\Admin\EstagiarioController;
use App\Http\Controllers\Admin\PresencaController as AdminPresencaController;
use App\Http\Controllers\Admin\RelatorioController;
use App\Http\Controllers\Admin\DocumentosController;
use App\Http\Controllers\Admin\SettingsController as AdminSettingsController;

Route::get('/', function () {
    if (auth('admin')->check()) {
        return redirect()->route('admin.dashboard');
    } elseif (auth('estagiario')->check()) {
        return redirect()->route('estagiario.dashboard');
    } else {
        return redirect()->route('login');
    }
});

Route::middleware('guest')->group(function () {
    Route::get('sign-up', [RegisterController::class, 'create'])->name('register');
    Route::post('sign-up', [RegisterController::class, 'store']);

    Route::get('sign-in', [SessionsController::class, 'create'])->name('login');
    Route::post('sign-in', [SessionsController::class, 'store']);

    Route::get('forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

    Route::get('reset-password/{token}', fn($token) => view('sessions.password.reset', ['token' => $token]))->name('password.reset');
    Route::post('reset-password', [SessionsController::class, 'update'])->name('password.update');

    Route::get('verify', fn() => view('sessions.password.verify'))->name('verify');
    Route::post('verify', [SessionsController::class, 'show']);
});

Route::post('sign-out', [SessionsController::class, 'destroy'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        if (auth('admin')->check()) {
            return redirect()->route('admin.dashboard');
        } elseif (auth('estagiario')->check()) {
            return redirect()->route('estagiario.dashboard');
        }
        abort(403);
    })->name('dashboard');

    Route::get('profile', [ProfileController::class, 'create'])->name('profile');
    Route::post('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('profile/upload-photo', [ProfileController::class, 'uploadPhoto'])->name('profile.uploadPhoto');

    Route::prefix('presencas')->group(function () {
        Route::get('create', [PresencaController::class, 'create'])->name('presencas.create');
        Route::post('/', [PresencaController::class, 'store'])->name('presencas.store');
        Route::get('/', [PresencaController::class, 'index'])->name('presencas.index');
        Route::delete('{id}/cancelar', [PresencaController::class, 'cancelar'])->name('presencas.cancelar');
    });

    Route::prefix('documentos')->group(function () {
        Route::get('/', [DocumentoController::class, 'index'])->name('documentos.index');
        Route::post('/', [DocumentoController::class, 'store'])->name('documentos.store');
        Route::get('download/{id}', [DocumentoController::class, 'download'])->name('documentos.download');
        Route::delete('cancelar/{id}', [DocumentoController::class, 'cancelar'])->name('documentos.cancelar');
    });

    Route::prefix('relatorios')->group(function () {
        Route::get('/', [RelatoriosController::class, 'index'])->name('relatorios.index');
        Route::get('exportar-pdf', [RelatoriosController::class, 'exportarPDF'])->name('relatorios.exportarPDF');
        Route::get('download/{id}', [RelatoriosController::class, 'download'])->name('relatorios.download');
        Route::get('visualizar/{id}', [RelatoriosController::class, 'visualizar'])->name('relatorios.visualizar');
    });

    Route::get('settings', [SettingsController::class, 'index'])->name('settings');
});


Route::middleware('auth:estagiario')->group(function () {

    Route::get('estagiario/dashboard', [DashboardController::class, 'index'])->name('estagiario.dashboard');

    Route::get('presencas', [PresencaController::class, 'index'])->name('presencas.index');
    Route::get('presencas/create', [PresencaController::class, 'create'])->name('presencas.create');
    Route::post('presencas', [PresencaController::class, 'store'])->name('presencas.store');
    Route::delete('presencas/{id}/cancelar', [PresencaController::class, 'cancelar'])->name('presencas.cancelar');

    Route::get('documentos', [DocumentoController::class, 'index'])->name('documentos.index');
    Route::post('documentos', [DocumentoController::class, 'store'])->name('documentos.store');
    Route::get('documentos/download/{id}', [DocumentoController::class, 'download'])->name('documentos.download');
    Route::delete('documentos/cancelar/{id}', [DocumentoController::class, 'cancelar'])->name('documentos.cancelar');

    Route::get('relatorios', [RelatoriosController::class, 'index'])->name('relatorios.index');
    Route::get('relatorios/exportar-pdf', [RelatoriosController::class, 'exportarPDF'])->name('relatorios.exportarPDF');
    Route::get('relatorios/download/{id}', [RelatoriosController::class, 'download'])->name('relatorios.download');
    Route::get('relatorios/visualizar/{id}', [RelatoriosController::class, 'visualizar'])->name('relatorios.visualizar');

    Route::get('profile', [ProfileController::class, 'create'])->name('profile');
    Route::post('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('profile/upload-photo', [ProfileController::class, 'uploadPhoto'])->name('profile.uploadPhoto');

    Route::get('settings', [SettingsController::class, 'index'])->name('settings');

    Route::get('estagiario/historico/presencas', [HistoricoPresencasController::class, 'index'])->name('estagiario.historico.presencas');
    Route::get('/presencas/historico', [PresencaController::class, 'index'])->name('estagiario.historico.presencas');

  
});


Route::middleware('auth:admin')->prefix('admin')->name('admin.')->group(function () {

    Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::resource('estagios', App\Http\Controllers\Admin\EstagioController::class);

    Route::resource('administradores', AdministradorController::class);

    Route::resource('estagiarios', EstagiarioController::class)->except(['show']);

    Route::prefix('presencas')->name('presencas.')->group(function () {
        Route::get('/', [AdminPresencaController::class, 'index'])->name('index');
        Route::get('pendentes', [AdminPresencaController::class, 'pendentes'])->name('pendentes');
        Route::post('{id}/aprovar', [AdminPresencaController::class, 'aprovar'])->name('aprovar');
        Route::post('{id}/rejeitar', [AdminPresencaController::class, 'rejeitar'])->name('rejeitar');
    });

    Route::get('relatorios', [RelatorioController::class, 'index'])->name('relatorios.index');

    Route::resource('documentos', DocumentosController::class);

    Route::get('settings', [AdminSettingsController::class, 'index'])->name('settings');

    Route::get('estagios/exportar-pdf', [EstagioController::class, 'exportarPDF'])->name('estagios.exportarPDF');
    Route::get('estagios/{id}/visualizar', [EstagioController::class, 'visualizar'])->name('estagios.visualizar');

});

Route::view('billing', 'pages.billing')->name('billing');
Route::view('tables', 'pages.tables')->name('tables');
Route::view('rtl', 'pages.rtl')->name('rtl');
Route::view('virtual-reality', 'pages.virtual-reality')->name('virtual-reality');
Route::view('notifications', 'pages.notifications')->name('notifications');
Route::view('static-sign-in', 'pages.static-sign-in')->name('static-sign-in');
Route::view('static-sign-up', 'pages.static-sign-up')->name('static-sign-up');
Route::view('user-management', 'pages.laravel-examples.user-management')->name('user-management');
Route::view('user-profile', 'pages.laravel-examples.user-profile')->name('user-profile');
