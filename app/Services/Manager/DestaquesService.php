<?php

namespace App\Services\Manager;

use App\Http\Requests\Manager\DestaqueRequest;
use App\Http\Requests\Manager\OrdemRequest;
use App\Models\Destaque;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;

class DestaquesService
{
    private $service;

    public function __construct(ArquivoService $service)
    {
        $this->service = $service;
    }

    public function cadastrar(DestaqueRequest $request): array
    {
        try {
            $destaque = new Destaque;

            $arquivo = $request->file('imagem');

            if ($arquivo && $arquivo->isValid()) {
                $destaque->imagem = $this->service->gerarNome($arquivo);
            }

            $destaque->titulo = $request->titulo;
            $destaque->conteudo = $request->conteudo;
            $destaque->cor_bg = $request->cor_bg;
            $destaque->cor_texto = $request->cor_texto;
            $destaque->formato = $request->formato;
            $destaque->link = $request->link;

            $response = $destaque->save();

            if (! $response) {
                return [
                    'success' => false,
                    'message' => 'Erro ao salvar o destaque.',
                ];
            }

            if ($response) {
                $this->service->salvar($arquivo, 'images/highlights/', $destaque->imagem);
            }

            return [
                'success' => true,
                'message' => 'Destaque cadastrado com sucesso.',
            ];
        } catch (\Throwable $e) {
            return [
                'success' => false,
                'message' => 'Erro interno ao cadastrar o destaque.',
            ];
        }
    }

    public function editar(int $id): ?array
    {
        $destaque = $this->getDestaque($id);

        if (! $destaque) {
            return [
                'success' => false,
                'message' => 'Destaque não encontrado.',
            ];
        }

        return [
            'success' => true,
            'data' => [
                'id' => $destaque->id,
                'titulo' => $destaque->titulo,
                'link' => $destaque->link,
                'imagem' => rafator('images/highlights/'.$destaque->imagem),
                'conteudo' => $destaque->conteudo,
                'cor_bg' => $destaque->cor_bg,
                'cor_texto' => $destaque->cor_texto,
                'formato' => $destaque->formato,
            ],
        ];
    }

    public function atualizar(DestaqueRequest $request, int $id): array
    {
        try {
            $destaque = $this->getDestaque($id);

            if (! $destaque) {
                return [
                    'success' => false,
                    'message' => 'Destaque não encontrado.',
                ];
            }

            $arquivo = $request->file('imagem');
            $imagemOriginal = $destaque->imagem;

            if ($arquivo && $arquivo->isValid()) {
                $destaque->imagem = $this->service->gerarNome($arquivo);
            }

            $destaque->titulo = $request->titulo;
            $destaque->conteudo = $request->conteudo;
            $destaque->cor_bg = $request->cor_bg;
            $destaque->cor_texto = $request->cor_texto;
            $destaque->formato = $request->formato;
            $destaque->link = $request->link;

            $response = $destaque->save();

            if (! $response) {
                return [
                    'success' => false,
                    'message' => 'Erro ao atualizar o destaque.',
                ];
            }

            if ($imagemOriginal && File::exists(public_path('images/highlights/'.$imagemOriginal)) && $arquivo && $arquivo->isValid()) {
                File::delete(public_path('images/highlights/'.$imagemOriginal));

                $this->service->salvar($arquivo, 'images/highlights/', $destaque->imagem);
            }

            return [
                'success' => true,
                'message' => 'Destaque atualizado com sucesso.',
            ];
        } catch (\Throwable $e) {
            return [
                'success' => false,
                'message' => 'Erro interno ao atualizar o destaque.',
            ];
        }
    }

    public function editarVisibilidade(int $id): array
    {
        try {
            $destaque = $this->getDestaque($id);

            if (! $destaque) {
                return [
                    'success' => false,
                    'message' => 'Destaque não encontrado.',
                ];
            }

            $destaque->visivel = ! $destaque->visivel;
            $response = $destaque->save();

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
                'message' => 'Erro interno ao atualizar a visibilidade do destaque.',
            ];
        }
    }

    public function editarOrdem(OrdemRequest $request): array
    {
        try {
            foreach ($request->odr as $ordem => $id) {
                Destaque::query()
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
                'message' => 'Erro interno ao atualizar a ordem dos destaques.',
            ];
        }
    }

    public function excluir(int $id): array
    {
        try {

            $response = Destaque::query()
                ->where([
                    'id' => $id,
                    'excluido' => null,
                ])
                ->update(['excluido' => Carbon::now()]);

            if (! $response) {
                return [
                    'success' => false,
                    'message' => 'Erro ao excluir destaque.',
                ];
            }

            return [
                'success' => true,
                'message' => 'Destaque excluído com sucesso.',
            ];
        } catch (\Throwable $e) {
            return [
                'success' => false,
                'message' => 'Erro interno ao excluir o destaque.',
            ];
        }
    }

    private function getDestaque(int $id): ?Destaque
    {
        return Destaque::query()
            ->where([
                'id' => $id,
                'excluido' => null,
            ])
            ->first();
    }
}
