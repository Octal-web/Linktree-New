<?php

namespace App\Services\Manager;

use App\Http\Requests\Manager\LinkRequest;
use App\Http\Requests\Manager\OrdemRequest;
use App\Models\Link;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;

class LinksService
{
    private $service;

    public function __construct(ArquivoService $service)
    {
        $this->service = $service;
    }

    public function cadastrar(LinkRequest $request): array
    {
        try {
            $link = new Link;

            $arquivo = $request->file('imagem');

            if ($arquivo && $arquivo->isValid()) {
                $link->imagem = $this->service->gerarNome($arquivo);
            }

            $link->titulo = $request->titulo;
            $link->link = $request->link;

            $response = $link->save();

            if (! $response) {
                return [
                    'success' => false,
                    'message' => 'Erro ao salvar o link.',
                ];
            }

            if ($response) {
                $this->service->salvar($arquivo, 'images/links/', $link->imagem);
            }

            return [
                'success' => true,
                'message' => 'Link cadastrado com sucesso.',
            ];
        } catch (\Throwable $e) {

            return [
                'success' => false,
                'message' => 'Erro interno ao cadastrar o link.',
            ];
        }
    }

    public function editar(int $id): ?array
    {
        $link = $this->getLink($id);

        if (! $link) {
            return [
                'success' => false,
                'message' => 'Link não encontrado.',
            ];
        }

        return [
            'success' => true,
            'data' => [
                'id' => $link->id,
                'titulo' => $link->titulo,
                'link' => $link->link,
                'imagem' => rafator('images/links/'.$link->imagem),
            ],
        ];
    }

    public function atualizar(LinkRequest $request, int $id): array
    {
        try {
            $link = $this->getLink($id);

            if (! $link) {
                return [
                    'success' => false,
                    'message' => 'Link não encontrado.',
                ];
            }

            $arquivo = $request->file('imagem');
            $imagemOriginal = $link->imagem;

            if ($arquivo && $arquivo->isValid()) {
                $link->imagem = $this->service->gerarNome($arquivo);
            }

            $link->titulo = $request->titulo;
            $link->link = $request->link;

            $response = $link->save();

            if (! $response) {
                return [
                    'success' => false,
                    'message' => 'Erro ao atualizar o link.',
                ];
            }

            if ($imagemOriginal && File::exists(public_path('images/links/'.$imagemOriginal)) && $arquivo && $arquivo->isValid()) {
                File::delete(public_path('images/links/'.$imagemOriginal));

                $this->service->salvar($arquivo, 'images/links/', $link->imagem);
            }

            return [
                'success' => true,
                'message' => 'Link atualizado com sucesso.',
            ];
        } catch (\Throwable $e) {
            return [
                'success' => false,
                'message' => 'Erro interno ao atualizar o link.',
            ];
        }
    }

    public function editarVisibilidade(int $id): array
    {
        try {
            $link = $this->getLink($id);

            if (! $link) {
                return [
                    'success' => false,
                    'message' => 'Link não encontrado.',
                ];
            }

            $link->visivel = ! $link->visivel;
            $response = $link->save();

            if (! $response) {
                return [
                    'success' => false,
                    'message' => 'Erro ao alterar visibilidade.',
                ];
            }

            return [
                'success' => true,
                'message' => 'Visibilidade alterada com sucesso.',
            ];
        } catch (\Throwable $e) {
            return [
                'success' => false,
                'message' => 'Erro interno ao atualizar a visibilidade do link.',
            ];
        }
    }

    public function editarOrdem(OrdemRequest $request): array
    {
        try {
            foreach ($request->odr as $ordem => $id) {
                Link::query()
                    ->where([
                        'id' => $id,
                        'excluido' => null,
                    ])
                    ->update(['ordem' => $ordem]);
            }

            return [
                'success' => true,
                'message' => 'Ordem atualizada com sucesso.',
            ];
        } catch (\Throwable $e) {
            return [
                'success' => false,
                'message' => 'Erro interno ao atualizar a ordem dos links.',
            ];
        }
    }

    public function excluir(int $id): array
    {
        try {

            $response = Link::query()
                ->where([
                    'id' => $id,
                    'excluido' => null,
                ])
                ->update(['excluido' => Carbon::now()]);

            if (! $response) {
                return [
                    'success' => false,
                    'message' => 'Erro ao excluir link.',
                ];
            }

            return [
                'success' => true,
                'message' => 'Link excluído com sucesso.',
            ];
        } catch (\Throwable $e) {
            return [
                'success' => false,
                'message' => 'Erro interno ao excluir o link.',
            ];
        }
    }

    private function getLink(int $id): ?Link
    {
        return Link::query()
            ->where([
                'id' => $id,
                'excluido' => null,
            ])
            ->first();
    }
}
