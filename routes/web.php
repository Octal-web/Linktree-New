<?php

use App\Http\Controllers\Manager\ArquivoController as ManagerArquivoController;
use App\Http\Controllers\Manager\DestaquesController as ManagerDestaquesController;
use App\Http\Controllers\Manager\HomeController as ManagerHomeController;
use App\Http\Controllers\Manager\LinksController as ManagerLinksController;
use App\Http\Controllers\Manager\UsuariosController as ManagerUsuariosController;
use Illuminate\Support\Facades\Route;

// Route::prefix('/links')->group(function () {
Route::prefix('/manager')->group(function () {
    Route::get('/', [ManagerUsuariosController::class, 'login'])->name('Manager.Usuarios.login');
    Route::post('/', [ManagerUsuariosController::class, 'autenticar'])->name('login');

    Route::post('/usuarios/logout', [ManagerUsuariosController::class, 'logout'])->name('Manager.Usuarios.logout');

    Route::group(['middleware' => ['auth']], function () {
        Route::get('/home', [ManagerHomeController::class, 'index'])->name('Manager.Home.index');

        Route::post('/enviar-imagem', [ManagerArquivoController::class, 'enviar'])->name('Manager.Arquivo.enviar');

        Route::prefix('/links')->group(function () {
            Route::put('/ordenar', [ManagerLinksController::class, 'ordenar'])->name('Manager.Links.ordenar');
            Route::put('/visibilidade/{id}', [ManagerLinksController::class, 'visibilidade'])->name('Manager.Links.visibilidade');
            Route::post('/excluir/{id}', [ManagerLinksController::class, 'excluir'])->name('Manager.Links.excluir');

            Route::get('/adicionar', [ManagerLinksController::class, 'adicionar'])->name('Manager.Links.adicionar');
            Route::post('/adicionar', [ManagerLinksController::class, 'novo'])->name('Manager.Links.novo');

            Route::get('/editar/{id}', [ManagerLinksController::class, 'editar'])->name('Manager.Links.editar');
            Route::post('/editar/{id}', [ManagerLinksController::class, 'atualizar'])->name('Manager.Links.atualizar');
        });

        Route::prefix('/destaques')->group(function () {
            Route::put('/ordenar', [ManagerDestaquesController::class, 'ordenar'])->name('Manager.Destaques.ordenar');
            Route::put('/visibilidade/{id}', [ManagerDestaquesController::class, 'visibilidade'])->name('Manager.Destaques.visibilidade');
            Route::post('/excluir/{id}', [ManagerDestaquesController::class, 'excluir'])->name('Manager.Destaques.excluir');

            Route::get('/adicionar', [ManagerDestaquesController::class, 'adicionar'])->name('Manager.Destaques.adicionar');
            Route::post('/adicionar', [ManagerDestaquesController::class, 'novo'])->name('Manager.Destaques.novo');

            Route::get('/editar/{id}', [ManagerDestaquesController::class, 'editar'])->name('Manager.Destaques.editar');
            Route::post('/editar/{id}', [ManagerDestaquesController::class, 'atualizar'])->name('Manager.Destaques.atualizar');
        });
    });
});
// });
