<?php

namespace App\Services\Manager;

class ArquivoService
{
    public function salvar(object $arquivo, string $caminho, string $nome): void
    {
        $arquivo->move(public_path($caminho), $nome);
    }

    public function gerarNome(object $arquivo): string
    {
        return md5(uniqid((string) rand(), true)).'.'.strtolower($arquivo->extension());
    }
}
