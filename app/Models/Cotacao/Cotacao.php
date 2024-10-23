<?php

namespace App\Models\Cotacao;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cotacao extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_cotacao';
    protected $table = 'cotacao';

}
