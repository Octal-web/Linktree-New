<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Http\Requests\Manager\LinkRequest;
use App\Http\Requests\Manager\OrdemRequest;
use App\Services\Manager\LinksService;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class LinksController extends Controller
{
    protected $service;

    public function __construct(LinksService $service)
    {
        parent::__construct();
        $this->service = $service;
    }

    public function adicionar(): Response
    {
        return Inertia::render('Manager/Links/adicionar');
    }

    public function novo(LinkRequest $request): RedirectResponse
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
                'msg' => 'Informe um id válido para editar o link.',
            ]);
        }

        $response = $this->service->editar($id);

        if (! $response['success']) {
            return back()->with('message', [
                'type' => 'error',
                'msg' => $response['message'],
            ]);
        }

        return Inertia::render('Manager/Links/editar', [
            'link' => $response['data'],
        ]);
    }

    public function atualizar(LinkRequest $request, ?int $id = null): RedirectResponse
    {
        if (! $id) {
            return back()->with('message', [
                'type' => 'error',
                'msg' => 'Informe um id válido para atualizar o link.',
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
                'msg' => 'Informe um id válido para editar a visibilidade do link.',
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
                'msg' => 'Informe um id válido para excluir o link.',
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
