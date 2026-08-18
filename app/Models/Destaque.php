<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Destaque extends Model
{
    protected $table = 'destaques';

    protected $guarded = ['id'];

    protected $fillable = [
        'titulo',
        'conteudo',
        'imagem',
        'link',
        'cor_bg',
        'cor_texto',
        'ordem',
        'visivel',
        'formato',
    ];

    const CREATED_AT = 'criado';

    const UPDATED_AT = 'modificado';
}
