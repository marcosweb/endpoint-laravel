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
        $this->vendedor->nome = $req->input('nome');
        $this->vendedor->idade = $req->input('idade');
        $this->vendedor->empresa = $req->input('empresa');

        $insert = $this->vendedor->save();

        if (!$insert) {
            return response()->json(['erro' => 'Erro ao cadastrar o Vendedor!'], 500);
        }
        return response()->json(['vendedor' => $this->vendedor], 201);
    }

    public function putVendedor(Request $req, $id)
    {
        $vendedor = Vendedor::find($id);
        if (!$vendedor) {
            return response()->json(['message' => 'Vendedor não encontrada!', 404]);
        }
        $vendedor->nome = $req->input('nome');
        $vendedor->idade = $req->input('idade');
        $vendedor->empresa = $req->input('empresa');
        $vendedor->save();
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