<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


//Route::get('/', function () {
//    //return view('welcome');
//    return redirect()->route('listar-empresas');
//});
//
//Route::get('/empresas', [
//    'uses' => 'EmpresaController@getEmpresas',
//    'as' => 'listar-empresas'
//]);
//
//Route::post('/empresa', [
//    'uses' => 'EmpresaController@postEmpresa'
//]);
//
//Route::put('/empresa', [
//    'uses' => 'EmpresaController@putEmpresa'
//]);
//
//Route::delete('/empresa/{id}', [
//    'uses' => 'EmpresaController@deleteEmpresa'
//]);