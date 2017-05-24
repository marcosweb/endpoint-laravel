<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Empresa;
use Validator;

class EmpresaController extends Controller
{
    private $empresa;

    /**
     * EmpresaController constructor.
     * @param Empresa $empresa
     */
    public function __construct(Empresa $empresa)
    {
        $this->empresa = $empresa;
    }


    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getEmpresas()
    {
        $empresas = Empresa::all();
        return response()->json(['empresas' => $empresas], 200);
    }


    /**
     * Adicionar Empresa
     *
     * @param Request $req
     * @return \Illuminate\Http\JsonResponse
     */
    public function postEmpresa(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'cnpj' => 'required|min:14|max:15|unique:empresas,cnpj',
            'razao_social' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['erro' => $validator->messages()], 200);
        }
        $this->empresa->cnpj = $req->input('cnpj');
        $this->empresa->razao_social = $req->input('razao_social');
        $insert = $this->empresa->save();
        if (!$insert) {
            return response()->json(['erro' => 'Erro ao cadastrar empresa'], 500);
        }
        return response()->json(['empresa' => $this->empresa], 201);
    }


    /**
     * Alterar Empresa
     *
     * @param Request $req
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function putEmpresa(Request $req, $id)
    {
        $empresa = Empresa::find($id);
        $validator = Validator::make($req->all(), [
            'cnpj' => 'required|min:14|max:15|unique:empresas,cnpj,'.$id,
            'razao_social' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['erro' => $validator->messages()], 200);
        }
        $empresa = Empresa::find($id);
        if (!$empresa) {
            return response()->json(['message' => 'Empresa não encontrada', 404]);
        }
        $empresa->cnpj = $req->input('cnpj');
        $empresa->razao_social = $req->input('razao_social');
        $empresa->save();
        return response()->json(['empresa' => $empresa], 200);
    }


    /**
     * Excluir Empresa
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteEmpresa($id)
    {
        $empresa = Empresa::find($id);
        $del = $empresa->delete();
        if (!$del) {
            return response()->json(['erro'=>'Erro ao Deletar'.$empresa->razao_social]);
        }
        return response()->json([
            'message' => 'Empresa Deletada',
            'empresa'=>$empresa
        ], 200);
    }

}