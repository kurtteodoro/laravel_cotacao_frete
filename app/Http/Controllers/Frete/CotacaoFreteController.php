<?php

namespace App\Http\Controllers\Frete;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \App\Models\Cotacao\VtexValor;
use DB;

class CotacaoFreteController extends Controller
{

    /**
     * Method cotarFrete - IMPORTANTE, A VALIDAÇÃO DOS CAMPOS É FEITO EM: \App\Http\Requests\Frete\CotacaoFreteRequest
     */
    public function cotarFrete(\App\Http\Requests\Frete\CotacaoFreteRequest $request) {
        try {
            DB::beginTransaction();

            $valores = VtexValor::where('cep_inicio', '<=', $request->cep)
                ->where("cep_final", ">=", $request->cep)
                ->where("peso_inicial", "<=", $request->peso)
                ->where("peso_final", ">=", $request->peso)
                ->with('servicos', function($q) { // Relação configurada no model \App\Models\Cotacao\VtexValor.php
                    $q->with('transportadora'); // Relação configurada no model \App\Models\Cotacao\Servico.php
                })
                ->whereHas('servicos', function($q) { // Relação configurada no model \App\Models\Cotacao\VtexValor.php
                    $q->whereHas('transportadora'); // Relação configurada no model \App\Models\Cotacao\Servico.php
                })
                ->orderBy("valor", "ASC")
                ->limit(100)
                ->get();

            foreach($valores as $key => $valor) {
                $cotacao = new \App\Models\Cotacao\Cotacao();
                $cotacao->id_usuario = auth()->user()->id;
                $cotacao->id_servico = $valor->id_servico;
                $cotacao->valor = $valor->valor;
                $id_cotacao = $cotacao->save();
                if(!$id_cotacao) {
                    throw new Exception("Erro ao salvar cotação");
                }
                $valores[$key]->id_valor = $valores[$key]->id;
                $valores[$key]->id = $cotacao->id_cotacao;
            }

            DB::commit();
            return response()->json([
                "valores" => $valores
            ]);

        } catch (Exception $ex) {
            DB::rollback();
            return response()->json([
                "error" => "Houve um erro inesperado, tente novamente"
            ], 400);
        }
    }

    public function buscarCotacao(\App\Models\Cotacao\Cotacao $cotacao) {
        $cotacao->load('servico.transportadora');
        $cotacao->load('usuario');
        return response()->json([
            "cotacao" => $cotacao
        ]);
    }

}
