<?php

namespace App\Services\Manager;

use App\Models\Destaque;
use App\Models\Link;

class HomeService
{
    public function carregarDados(): array
    {
        $links = Link::query()
            ->where('excluido', null)
            ->orderBy('ordem', 'asc')
            ->get()
            ->map(function ($link) {
                return [
                    'id' => $link->id,
                    'titulo' => $link->titulo,
                    'link' => $link->link,
                    'imagem' => rafator('images/links/'.$link->imagem),
                    'visivel' => $link->visivel,
                ];
            });

        $destaques = Destaque::query()
            ->where('excluido', null)
            ->orderBy('ordem', 'asc')
            ->get()
            ->map(function ($link) {
                return [
                    'id' => $link->id,
                    'titulo' => $link->titulo,
                    'link' => $link->link,
                    'imagem' => rafator('images/highlights/'.$link->imagem),
                    'visivel' => $link->visivel,
                ];
            });

        return [
            'links' => $links,
            'destaques' => $destaques,
        ];
    }
}
