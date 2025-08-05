<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DespesaController;

Route::get('/despesas', [DespesaController::class, 'index'])->name('despesas.index');
Route::get('/despesas/criar', [DespesaController::class, 'create'])->name('despesas.create');
Route::post('/despesas', [DespesaController::class, 'store'])->name('despesas.store');
Route::get('/despesas/{id}/editar', [DespesaController::class, 'edit'])->name('despesas.edit');
Route::put('/despesas/{id}', [DespesaController::class, 'update'])->name('despesas.update');
Route::delete('/despesas/{id}', [DespesaController::class, 'destroy'])->name('despesas.destroy');
