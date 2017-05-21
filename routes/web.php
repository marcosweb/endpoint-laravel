<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    //return view('welcome');
    return redirect()->route('listar-empresas');
});

/*
 * EMPRESA
 */

Route::get('empresas', 'EmpresaController@getEmpresas')->name('lista-empresas');
Route::post('empresa', 'EmpresaController@postEmpresa');
Route::put('empresa/{id}', 'EmpresaController@putEmpresa');
Route::delete('empresa/{id}', 'EmpresaController@deleteEmpresa');


/*
 * VENDEDOR
 */

Route::get('vendedores/{empresa?}', 'VendedorController@getVendedores')->name('lista-vendedores');
Route::post('vendedor', 'VendedorController@postVendedor');
Route::put('vendedor/{id}', 'VendedorController@putVendedor');
Route::delete('vendedor/{id}', 'VendedorController@deleteVendedor');