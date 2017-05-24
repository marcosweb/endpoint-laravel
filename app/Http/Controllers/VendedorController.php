<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Empresa;
use App\Vendedor;
use Validator;

class VendedorController extends Controller
{
    /**
     * @var Vendedor
     */
    private $vendedor;


    /**
     * VendedorController constructor.
     * @param Vendedor $vendedor
     */
    public function __construct(Vendedor $vendedor)
    {
        $this->vendedor = $vendedor;
    }


    /**
     * Lista Vendedores
     *
     * @param int $empresa ID da empresa. Se forp assado lista vendedores desta empresa
     * @return \Illuminate\Http\JsonResponse
     */
    public function getVendedores($empresa = 0)
    {
        $vendedores = $empresa ? Empresa::find($empresa)->vendedores()->get() : Vendedor::all();
        return response()->json(['vendedores' => $vendedores], 200);
    }


    /**
     * Adiciona Vendedor
     *
     * @param Request $req
     * @return \Illuminate\Http\JsonResponse
     */
    public function postVendedor(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'nome' => 'required|min:3|max:100|unique:vendedores,nome',
            'idade' => 'required|numeric',
            'empresa' => 'required|numeric'
        ]);
        if ($validator->fails()) {
            return response()->json(['erro' => $validator->messages()], 200);
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


    /**
     * Altera Vendedor
     *
     * @param Request $req
     * @param $id ID do Vendedor a ser modificado
     * @return \Illuminate\Http\JsonResponse
     */
    public function putVendedor(Request $req, $id)
    {
        dd($req->input());
        $validator = Validator::make($req->all(), [
            'nome' => 'required|min:3|max:100|unique:vendedores,nome,'.$id,
            'idade' => 'required|numeric',
            'empresa' => 'required|numeric'
        ]);
        if ($validator->fails()) {
            return response()->json(['erro' => $validator->messages()], 200);
        }
        $vendedor = Vendedor::find($id);
        if (!$vendedor) {
            return response()->json(['erro' => ['404'=>'Vendedor não encontrada!'], 404]);
        }
        $this->vendedor->nome = $req->input('nome');
        $this->vendedor->idade = $req->input('idade');
        $this->vendedor->empresa = $req->input('empresa');

        try {
            $this->vendedor->save();
        }
        catch(Exception $e){
            return response()->json(['erro' => ['500'=>'Ocorreu um erro: '.$e->getMessage()]], 500);
        }
        return response()->json(['vendedor' => $vendedor], 200);
    }


    /**
     * Exclui Vendedor
     *
     * @param $id ID do Vendedor a ser excluído
     * @return \Illuminate\Http\JsonResponse
     */
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