<?php

namespace App\Models\Cotacao;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VtexValor extends Model
{
    use HasFactory;
    
    protected $table = 'vtex_valores';

    public function servicos() {
        return $this->hasOne(\App\Models\Cotacao\Servico::class, 'id', 'id_servico');
    }

}
