<?php

use App\Http\Controllers\ConfiguracoesController;
use App\Http\Controllers\RelatorioController;
use App\Http\Controllers\SocialController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DespesaController;
use App\Http\Controllers\LoginController;

Route::middleware(['auth'])->group(function () {

    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

//    despesas
    Route::prefix('despesas')->group(function () {
        Route::get('/', [DespesaController::class, 'index'])->name('despesas.index');
        Route::get('/criar', [DespesaController::class, 'create'])->name('despesas.create');
        Route::get('/{id}/editar', [DespesaController::class, 'edit'])->name('despesas.edit');

        Route::delete('/excluir-multiplas', [DespesaController::class, 'excluirMultiplas'])->name('despesas.excluir-multiplas');
        Route::delete('/{id}', [DespesaController::class, 'destroy'])->name('despesas.destroy');

        Route::put('/{id}', [DespesaController::class, 'update'])->name('despesas.update');

        Route::post('/', [DespesaController::class, 'store'])->name('despesas.store');
        Route::post('/filtradas', [DespesaController::class, 'filtrarDespesas'])->name('despesas.filtrar');
    });

//    configuracoes
    Route::prefix('configuracoes')->group(function () {
        Route::get('/', [ConfiguracoesController::class, 'index'])->name('configuracoes.index');
        Route::post('/perfil', [ConfiguracoesController::class, 'atualizarPerfil'])->name(
            'configuracoes.atualizar-perfil'
        );
        Route::post('/financeiro', [ConfiguracoesController::class, 'atualizarFinanceiro'])->name(
            'configuracoes.atualizar-financeiro'
        );

        Route::post('/senha', [ConfiguracoesController::class, 'alterarSenha'])->name('configuracoes.alterar-senha');
    });
});

//Route::middleware(['guest'])->group(function () {
Route::get('/', function () {
});
Route::get('/login', [LoginController::class, 'index'])->name('login');
//});
Route::post('/login', [LoginController::class, 'store'])->name('login.store');

//Login oauth2

Route::get('/auth/facebook/redirect', function () {
    return Socialite::driver('facebook')->redirect();
})->name('facebook.redirect');
Route::get('/auth/facebook/callback', [SocialController::class, 'handleFacebook'])->name('login.facebook');

