<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DespesaController;

Route::get('/', [DespesaController::class, 'index'])->name('despesas.index');
Route::get('/despesas/criar', [DespesaController::class, 'create'])->name('despesas.create');
Route::get('/despesas/editar/{id}', [DespesaController::class, 'edit'])->name('despesas.edit');

Route::post('/despesas', [DespesaController::class, 'store'])->name('despesas.store');
Route::put('/despesas/atualizar/{id}', [DespesaController::class, 'update'])->name('despesas.update');
Route::delete('/despesas/deletar/{id}', [DespesaController::class, 'destroy'])->name('despesas.destroy');
