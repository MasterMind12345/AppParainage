<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EtudiantController;
use App\Http\Controllers\DelegueController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;

Route::get('/', function () {
    return view('welcome');
});

// Routes d'authentification
Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'register']);

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::prefix('etudiant')->group(function () {
        Route::get('/dashboard', [EtudiantController::class, 'dashboard'])->name('etudiant.dashboard');
        Route::post('/initier-paiement', [EtudiantController::class, 'initierPaiement'])->name('etudiant.initier-paiement');
        Route::get('/telecharger-recu/{id}', [EtudiantController::class, 'telechargerRecu'])->name('etudiant.telecharger-recu');
    });

    Route::prefix('delegue')->group(function () {
        Route::get('/dashboard', [DelegueController::class, 'dashboard'])->name('delegue.dashboard');
        Route::post('/valider-paiement/{id}', [DelegueController::class, 'validerPaiement'])->name('delegue.valider-paiement');
    });

    Route::prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/liste-paiements', [AdminController::class, 'listePaiements'])->name('admin.liste-paiements');
        Route::get('/liste-paiements/{salle}', [AdminController::class, 'listePaiements'])->name('admin.liste-paiements-salle');
        Route::post('/creer-salle', [AdminController::class, 'creerSalle'])->name('admin.creer-salle');
        Route::post('/nommer-delegue', [AdminController::class, 'nommerDelegue'])->name('admin.nommer-delegue');
    });

    Route::prefix('admin')->group(function () {
        // ... routes existantes ...

        Route::get('/telecharger-liste-paiements', [AdminController::class, 'telechargerListePaiements'])->name('admin.telecharger-liste-paiements');
        Route::get('/telecharger-liste-paiements/{salle}', [AdminController::class, 'telechargerListePaiements'])->name('admin.telecharger-liste-paiements-salle');
    });
});
