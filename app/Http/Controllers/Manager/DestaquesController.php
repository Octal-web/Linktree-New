<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Http\Requests\Manager\DestaqueRequest;
use App\Http\Requests\Manager\OrdemRequest;
use App\Services\Manager\DestaquesService;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class DestaquesController extends Controller
{
    protected $service;

    public function __construct(DestaquesService $service)
    {
        parent::__construct();
        $this->service = $service;
    }

    public function adicionar(): Response
    {
        return Inertia::render('Manager/Destaques/adicionar');
    }

    public function novo(DestaqueRequest $request): RedirectResponse
    {
        $response = $this->service->cadastrar($request);

        if (! $response['success']) {
            return back()->with('message', [
                'type' => 'error',
                'msg' => $response['message'],
            ]);
        }

        return to_route('Manager.Home.index')->with('message', [
            'type' => 'success',
            'msg' => $response['message'],
        ]);
    }

    public function editar(?int $id = null): Response|RedirectResponse
    {
        if (! $id) {
            return back()->with('message', [
                'type' => 'error',
                'msg' => 'Informe um id válido para editar o destaque.',
            ]);
        }

        $response = $this->service->editar($id);

        if (! $response['success']) {
            return back()->with('message', [
                'type' => 'error',
                'msg' => $response['message'],
            ]);
        }

        return Inertia::render('Manager/Destaques/editar', [
            'destaque' => $response['data'],
        ]);
    }

    public function atualizar(DestaqueRequest $request, ?int $id = null): RedirectResponse
    {
        if (! $id) {
            return back()->with('message', [
                'type' => 'error',
                'msg' => 'Informe um id válido para atualizar o destaque.',
            ]);
        }

        $response = $this->service->atualizar($request, $id);

        if (! $response['success']) {
            return back()->with('message', [
                'type' => 'error',
                'msg' => $response['message'],
            ]);
        }

        return to_route('Manager.Home.index')->with('message', [
            'type' => 'success',
            'msg' => $response['message'],
        ]);
    }

    public function ordenar(OrdemRequest $request): RedirectResponse
    {
        $response = $this->service->editarOrdem($request);

        if (! $response['success']) {
            return back()->with('message', [
                'type' => 'error',
                'msg' => $response['message'],
            ]);
        }

        return to_route('Manager.Home.index')->with('message', [
            'type' => 'success',
            'msg' => $response['message'],
        ]);
    }

    public function visibilidade(?int $id = null): RedirectResponse
    {
        if (! $id) {
            return back()->with('message', [
                'type' => 'error',
                'msg' => 'Informe um id válido para editar a visibilidade do destaque.',
            ]);
        }

        $response = $this->service->editarVisibilidade($id);

        if (! $response['success']) {
            return back()->with('message', [
                'type' => 'error',
                'msg' => $response['message'],
            ]);
        }

        return to_route('Manager.Home.index')->with('message', [
            'type' => 'success',
            'msg' => $response['message'],
        ]);
    }

    public function excluir(?int $id = null): RedirectResponse
    {
        if (! $id) {
            return back()->with('message', [
                'type' => 'error',
                'msg' => 'Informe um id válido para excluir o destaque.',
            ]);
        }

        $response = $this->service->excluir($id);

        if (! $response['success']) {
            return back()->with('message', [
                'type' => 'error',
                'msg' => $response['message'],
            ]);
        }

        return to_route('Manager.Home.index')->with('message', [
            'type' => 'success',
            'msg' => $response['message'],
        ]);
    }
}
