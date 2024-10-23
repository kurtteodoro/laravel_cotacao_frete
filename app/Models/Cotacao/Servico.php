<?php

namespace App\Models\Cotacao;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servico extends Model
{
    use HasFactory;

    protected $table = 'servicos';

    public function transportadoras() {
        return $this->hasOne(\App\Models\Cotacao\Transportadora::class, "id", "id_transportadora");
    }

}
