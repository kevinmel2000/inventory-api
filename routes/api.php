<?php

use Illuminate\Http\Request;
use App\Satuan; 
use App\Mfgart; 
use App\Mrmart; 
use App\User; 
use App\PPRE; 
use App\PPRED;
use App\Customer;
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

Route::post('/login', function(Request $request){
    if($user = User::where('MSUSERANDRO_ID', $request->input('username'))
                ->where('MSUSERANDRO_PASSWORD', md5($request->input('password')))
                ->first()){
  $user->MSUSERANDRO_TOKEN = str_random(32);
    $user->save();

    return Response::json(array(
            'error' => false,
            'id' => $user->MSUSERANDRO_ID,
            'role' => $user->MSUSERANDRO_ROLE,
            'token' => $user->MSUSERANDRO_TOKEN,
            'status_code' => 200,
        ));
    }else{
          return Response::json(array(
            'error' => true,
            'status_code' => 200
        ));
    };
});

Route::resource('ppre', 'PPREController');

//get ppre list by user
Route::get('ppreh/user/{id}', 'PPREController@user');

Route::resource('ssjde', 'SSJDEController');

Route::get('ssjde/user/{id}', 'SSJDEController@user');

Route::get('/satuan', function(Request $request){
	$satuan = Satuan::all();
	return Response::json(array(
            'error' => false,
            'satuan' => $satuan,
            'status_code' => 200
        ));
});

Route::get('/mfgart', function(Request $request){
	$produk = Mfgart::where('MFGART_AKTIF', '1')
    ->select('MFGART_GROUPID','MFGART_ARTICLEID','MFGART_ARTICLENAME')->get();
	return Response::json(array(
            'error' => false,
            'products' => $produk,
            'status_code' => 200
        ));
});

Route::get('/mrmart', function(Request $request){
	  $mrmart = Mrmart::where('MRMART_AKTIF', '1')
    ->select('MRMART_GROUPID','MRMART_ARTICLEID','MRMART_ARTICLENAME')->get();
	return Response::json(array(
            'error' => false,
            'mart' => $mrmart,
            'status_code' => 200
        ));
});


Route::get('/customer', function(Request $request){
    $cust = Customer::select('MCUSTOMER_CUSTID', 'MCUSTOMER_CUSTNAME')->get();
    return Response::json(array(
            'error' => false,
            'customers' => $cust,
            'status_code' => 200
        ));
});