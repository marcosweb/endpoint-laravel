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

class EmpresaController extends Controller
{
    private $empresa;

    public function __construct(Empresa $empresa)
    {
        $this->empresa = $empresa;
    }

    public function getEmpresas()
    {
        $empresas = Empresa::all();
        return response()->json(['empresas' => $empresas], 200);
    }

    public function postEmpresa(Request $req)
    {
        $this->empresa->cnpj = $req->input('cnpj');
        $this->empresa->razao_social = $req->input('razao_social');
        $insert = $this->empresa->save();
        if (!$insert) {
            return response()->json(['erro' => 'Erro ao cadastrar empresa'], 500);
        }
        return response()->json(['empresa' => $this->empresa], 201);
    }

    public function putEmpresa(Request $req, $id)
    {
        $empresa = Empresa::find($id);
        if (!$empresa) {
            return response()->json(['message' => 'Empresa não encontrada', 404]);
        }
        $empresa->cnpj = $req->input('cnpj');
        $empresa->razao_social = $req->input('razao_social');
        $empresa->save();
        return response()->json(['empresa' => $empresa], 200);
    }

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