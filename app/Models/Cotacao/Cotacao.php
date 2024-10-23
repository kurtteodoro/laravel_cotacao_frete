<?php

namespace App\Models\Cotacao;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cotacao extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_cotacao';
    protected $table = 'cotacao';

    public function servico() {
        return $this->hasOne(\App\Models\Cotacao\Servico::class, 'id', 'id_servico');
    }

    public function usuario() {
        return $this->hasOne(\App\Models\User::class, 'id', 'id_usuario');
    }

}
