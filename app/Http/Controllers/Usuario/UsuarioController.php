<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Hash;
use Exception;
use \App\Models\User;

class UsuarioController extends Controller
{
    
        
    /**
     * Method cadastrarUsuario - IMPORTANTE, A VALIDAÇÃO DE E-MAIL, SENHA E NOME É FEITO EM: \App\Http\Requests\Usuario\CadastrarUsuarioRequest
     */
    public function cadastrarUsuario(\App\Http\Requests\Usuario\CadastrarUsuarioRequest $request) {
        try {
            DB::beginTransaction();
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);

            if($user->save()) {
                DB::commit();
                return response()->json([
                    "user" => $user->only(["id", "name", "email",])
                ]);
            }
            throw new Exception("Não foi possível o salvar usuário");

        } catch(Exception $exception) {
            DB::rollback();
            return response()->json([
                "error" => "Houve um erro inesperado, tente novamente"
            ], 400);
        }
    }
    
    /**
     * Method authAPI - Realiza a autenticação do usuário e retorna o token de acesso
     */
    public function authAPI(\App\Http\Requests\Usuario\LoginUsuarioRequest $request)
    {
        try {
            $user = User::where('email', request('email'))->first();
            if($user && Hash::check(request('password'), $user->password)) {
                $token = $user->createToken("access_token")->plainTextToken;
                return response()->json([
                    'token' => $token,
                    'user' => $user->only("id", "name", "email"),
                ]);
            }

            return response()->json([
                "message" => "Credenciais inválidas"
            ], 403);
            
        } catch(Exception $exception) {
            return response()->json([
                "error" => "Houve um erro inesperado, tente novamente"
            ], 400);
        }
    }

}
