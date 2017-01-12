<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\PPRE; use App\PPRED; use App\User;
class PPREController extends Controller
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
        $ppre = new PPRE;
        $ppre->PPRE_DateTime = date('Ymd-His');
        $ppre->PPRE_USER = $user->MSUSERANDRO_ID;
        $ppre->save();
        foreach($json['entries'] as $entry){
            $ppred = new PPRED;
            $ppred->PPRE_DateTime = $ppre->PPRE_DateTime;
            $ppred->PPRED_GROUP = $entry['PPRE_GROUP'];
            $ppred->PPRED_ART =  $entry['PPRE_ART'];
            $ppred->PPRED_QTY =  $entry['PPRE_QTY'];
            $ppred->PPRED_SATUAN =  $entry['PPRE_SATUAN'];
            $ppred->PPRED_NOTE = $entry['PPRE_NOTE'];
            $ppred->save();
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
      if($ppre = PPRE::where('PPRE_DateTime', $id)->with('ppred')->first()){
        //get the record from mrmart then assign it to json array
        foreach ($ppre->ppred as $ppred) {
            $item = $ppred->article();
            $ppred->PPRED_ARTICLENAME = $item->MRMART_ARTICLENAME;
        }

       return response()->json(array(
        'error' => false,
        'PPRE_DateTime' => $ppre->PPRE_DateTime,
        'PPRE_USER' => $ppre->PPRE_USER,
        'entries' => $ppre->ppred,
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
     * Display the user's transaction
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function user($id){
      if($ppre = PPRE::where('PPRE_USER', $id)->with('ppred')->orderBy('PPRE_DateTime', 'desc')->get()){
          //get the record from mrmart then assign it to json array
        foreach ($ppre as $ppreitem) {
            foreach($ppreitem->ppred as $ppred){
                $item = $ppred->article();
                $ppred->PPRED_ARTICLENAME = $item->MRMART_ARTICLENAME;
            }
        }

       return response()->json(array(
        'error' => false,
        'entries' => $ppre,
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

        PPRED::where('PPRE_DateTime', $id)->delete();

        foreach($json['entries'] as $entry){
            $ppred = new PPRED;
            $ppred->PPRE_DateTime = $id;
            $ppred->PPRED_GROUP = $entry['PPRE_GROUP'];
            $ppred->PPRED_ART =  $entry['PPRE_ART'];
            $ppred->PPRED_QTY =  $entry['PPRE_QTY'];
            $ppred->PPRED_SATUAN =  $entry['PPRE_SATUAN'];
            $ppred->PPRED_NOTE => $entry['PPRE_NOTE'];
            $ppred->save();
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

        $ppre = PPRE::find($id);
        $ppre->delete();

        PPRED::where('PPRE_DateTime', $id)->delete();
       
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
