<?php
/**
 * Created by PhpStorm.
 * User: Marcos
 * Date: 19/05/2017
 * Time: 20:04
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Empresa;
use App\Vendedor;
use Validator;

class VendedorController extends Controller
{
    private $vendedor;

    public function __construct(Vendedor $vendedor)
    {
        $this->vendedor = $vendedor;
    }

    public function getVendedores($empresa = 0)
    {
        $vendedores = $empresa ? Empresa::find($empresa)->vendedores()->get() : Vendedor::all();
        return response()->json(['vendedores' => $vendedores], 200);
    }

    public function postVendedor(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'nome' => 'required',
            'idade' => 'required',
            'empresa' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['erro' => 'Ocorreu Erro de Validação!'], 200);
        }

        $this->validate($req, [
            'nome' => 'required',
            'idade' => 'required',
            'empresa' => 'required'
        ]);
        $existe = Vendedor::where('nome',$req->input('nome'))->first();

        if ($existe) {
            return response()->json(['erro' => 'Este vendedor já está cadastrado em outra empresa!'], 200);
        }
        $this->vendedor->nome = $req->input('nome');
        $this->vendedor->idade = $req->input('idade');
        $this->vendedor->empresa = $req->input('empresa');

        try {
            $insert = $this->vendedor->save();
        }
        catch(Exception $e){
            return response()->json(['erro' => 'Ocorreu um erro: '.$e->getMessage()], 500);
        }

        if (!$insert) {
            return response()->json(['erro' => 'Erro ao cadastrar o Vendedor!'], 500);
        }
        return response()->json(['vendedor' => $this->vendedor], 201);
    }

    public function putVendedor(Request $req, $id)
    {
        $validator = Validator::make($req->all(), [
            'id' => 'required',
            'nome' => 'required',
            'idade' => 'required',
            'empresa' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['erro' => 'Ocorreu Erro de Validação!'], 200);
        }

        $vendedor = Vendedor::find($id);

        if (!$vendedor) {
            return response()->json(['message' => 'Vendedor não encontrada!', 404]);
        }
        $vendedor->nome = $req->input('nome');
        $vendedor->idade = $req->input('idade');
        $vendedor->empresa = $req->input('empresa');

        try {
            $this->vendedor->save();
        }
        catch(Exception $e){
            return response()->json(['erro' => 'Ocorreu um erro: '.$e->getMessage()], 500);
        }
        return response()->json(['vendedor' => $vendedor], 200);
    }

    public function deleteVendedor($id)
    {
        $vendedor = Vendedor::find($id);
        $del = $vendedor->delete();
        if (!$del) {
            return response()->json(['erro'=>'Erro ao Deletar'.$vendedor->nome]);
        }
        return response()->json([
            'message' => 'O Vendedor foi Excluído!',
            'vendedor'=>$vendedor
        ], 200);
    }

}