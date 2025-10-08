<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HabitoController;
use App\Http\Controllers\RegistroController;
use App\Http\Controllers\InsightsController;
use App\Http\Controllers\PerfilController;
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
    return redirect()->route('login');
});

// Rotas autenticadas
Route::middleware(['auth'])->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Hábitos
    Route::prefix('habitos')->name('habitos.')->group(function () {
        Route::get('/', [HabitoController::class, 'index'])->name('index');
        Route::get('/criar', [HabitoController::class, 'create'])->name('create');
        Route::post('/', [HabitoController::class, 'store'])->name('store');
        Route::get('/{habito}/editar', [HabitoController::class, 'edit'])->name('edit');
        Route::put('/{habito}', [HabitoController::class, 'update'])->name('update');
        Route::delete('/{habito}', [HabitoController::class, 'destroy'])->name('destroy');
        Route::post('/{habito}/arquivar', [HabitoController::class, 'arquivar'])->name('arquivar');
        Route::post('/{habito}/reativar', [HabitoController::class, 'reativar'])->name('reativar');
        Route::post('/reordenar', [HabitoController::class, 'reordenar'])->name('reordenar');
    });
    
    // Registros Diários
    Route::prefix('registros')->name('registros.')->group(function () {
        Route::get('/', [RegistroController::class, 'index'])->name('index');
        Route::post('/{habito}/atualizar', [RegistroController::class, 'atualizar'])->name('atualizar');
        Route::post('/{habito}/incrementar', [RegistroController::class, 'incrementar'])->name('incrementar');
        Route::post('/{habito}/decrementar', [RegistroController::class, 'decrementar'])->name('decrementar');
    });
    
    // Insights
    Route::get('/insights', [InsightsController::class, 'index'])->name('insights.index');
    
    // Perfil
    Route::prefix('perfil')->name('perfil.')->group(function () {
        Route::get('/', [PerfilController::class, 'index'])->name('index');
        Route::put('/', [PerfilController::class, 'update'])->name('update');
        Route::put('/senha', [PerfilController::class, 'atualizarSenha'])->name('senha');
        Route::delete('/foto', [PerfilController::class, 'removerFoto'])->name('remover-foto');
    });
    
    // Rotas antigas do Breeze (manter compatibilidade)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
