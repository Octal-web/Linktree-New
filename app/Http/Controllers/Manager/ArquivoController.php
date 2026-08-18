<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Http\Requests\Manager\ArquivoRequest;
use App\Services\Manager\ArquivoService;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ArquivoController extends Controller
{
    protected $service;

    public function __construct(ArquivoService $service)
    {
        parent::__construct();
        $this->service = $service;
    }

    public function enviar(ArquivoRequest $request): RedirectResponse
    {
        try {
            $arquivo = $request->file('img');

            $nome = $this->service->gerarNome($arquivo);

            $this->service->salvar(
                $arquivo,
                'images/files',
                $nome
            );

            return back()->with('message', [
                'type' => 'success',
                'msg' => 'Imagem carregada com sucesso!',
                'url' => asset("images/files/{$nome}"),
            ]);
        } catch (\Exception $e) {

            return back()->with('message', [
                'type' => 'error',
                'msg' => 'Erro interno do servidor.',
            ]);
        }
    }
}
