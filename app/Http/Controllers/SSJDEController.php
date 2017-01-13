<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User; use App\SSJDE;
use App\SSJDED;

class SSJDEController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $json = json_decode($request->input('json'), true);

    if($user = User::where('MSUSERANDRO_TOKEN', $json['token'])
                ->first()){
        $ssjde = new SSJDE;
        $ssjde->SSJDE_DateTime = date('Ymd-His');
        $ssjde->SSJDE_USER = $user->MSUSERANDRO_ID;
        $ssjde->SSJDE_CUSTID = $json['custid'];
        $ssjde->save();
        foreach($json['entries'] as $entry){
            $ssjded = new SSJDED;
            $ssjded->SSJDE_DateTime = $ssjde->SSJDE_DateTime;
            $ssjded->SSJDE_GROUP = $entry['SSJDE_GROUP'];
            $ssjded->SSJDE_ART =  $entry['SSJDE_ART'];
            $ssjded->SSJDE_QTY =  $entry['SSJDE_QTY'];
            $ssjded->SSJDE_SATUAN =  $entry['SSJDE_SATUAN'];
            $ssjded->SSJDE_NOTE = $entry['SSJDE_NOTE'];
            $ssjded->save();
        }
        return response()->json(array(
            'error' => false,
            'status_code' => 200
        )); 
    }else{
      return response()->json(array(
            'error' => true,
            'status_code' => 200
        )); 
    }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
           if($ssjde = SSJDE::where('SSJDE_DateTime', $id)->with('ssjded')->first()){
        //get the record from mrmart then assign it to json array
        foreach ($ssjde->ssjded as $ssjded) {
            $item = $ssjded->article();
            $ssjded->SSJDE_ARTICLENAME = $item->MFGART_ARTICLENAME;
        }

       return response()->json(array(
        'error' => false,
        'SSJDE_DateTime' => $ssjde->SSJDE_DateTime,
        'SSJDE_USER' => $ssjde->SSJDE_USER,
        'SSJDE_CUSTID' => $ssjde->SSJDE_CUSTID,
        'entries' => $ssjde->ssjded,
        'status_code' => 200,
        ));
       }else{
        return response()->json(array(
            'error' => true,
            'status_code' => 200,
            ));
        };
    }

    public function user($id){
        if($ssjde = SSJDE::where('SSJDE_USER', $id)->with('customer')->with('ssjded')->orderBy('SSJDE_DateTime', 'desc')->get()){
              //get the record from mrmart then assign it to json array
            foreach ($ssjde as $ssjdeitem) {
                $ssjdeitem->SSJDE_CUSTNAME = $ssjdeitem->customer->MCUSTOMER_CUSTNAME;
                unset($ssjdeitem['customer']);
                foreach($ssjdeitem->ssjded as $ssjded){
                    $item = $ssjded->article();
                     $ssjded->SSJDE_ARTICLENAME = "";
                    if($item != null)
                    $ssjded->SSJDE_ARTICLENAME = $item->MFGART_ARTICLENAME;

                }
              
            }

           return response()->json(array(
            'error' => false,
            'entries' => $ssjde,
            'status_code' => 200,
            ));
        }else{
            return response()->json(array(
                'error' => true,
                'status_code' => 200,
                ));
        };
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
              $json = json_decode($request->input('json'), true);

    if($user = User::where('MSUSERANDRO_TOKEN', $json['token'])
                ->first()){

        SSJDED::where('SSJDE_DateTime', $id)->delete();

        foreach($json['entries'] as $entry){
            $ssjded = new SSJDED;
            $ssjded->SSJDE_DateTime = $id;
            $ssjded->SSJDE_GROUP = $entry['SSJDE_GROUP'];
            $ssjded->SSJDE_ART =  $entry['SSJDE_ART'];
            $ssjded->SSJDE_QTY =  $entry['SSJDE_QTY'];
            $ssjded->SSJDE_SATUAN =  $entry['SSJDE_SATUAN'];
            $ssjded->SSJDE_NOTE = $entry['SSJDE_NOTE'];
            $ssjded->save();
        }
        return response()->json(array(
            'error' => false,
            'status_code' => 200
        )); 
    }else{
      return response()->json(array(
            'error' => true,
            'status_code' => 200
        )); 
    }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
         if($user = User::where('MSUSERANDRO_TOKEN', $request->input('token'))
                ->first()){

        $ssjde = SSJDE::find($id);
        $ssjde->delete();

        SSJDED::where('SSJDE_DateTime', $id)->delete();
       
        return response()->json(array(
            'error' => false,
            'status_code' => 200
        )); 
    }else{
      return response()->json(array(
            'error' => true,
            'status_code' => 200
        )); 
    }
    }
}
