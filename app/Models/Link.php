<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    protected $table = 'links';

    protected $guarded = ['id'];

    protected $fillable = [
        'titulo',
        'imagem',
        'link',
        'ordem',
        'visivel',
    ];

    const CREATED_AT = 'criado';

    const UPDATED_AT = 'modificado';
}
