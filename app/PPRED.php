<?php

namespace App;

use App\Mrmart;
use Illuminate\Database\Eloquent\Model;

class PPRED extends Model
{
    protected $table = 'ppred';
    public $timestamps = false;
    public $primaryKey = null;
    public $incrementing = false;

    /**
    * return the article item needed
    */
    public function article(){
    	return Mrmart::where('MRMART_AKTIF', '1')
    		->where('MRMART_ARTICLEID', $this->PPRED_ART)
    			->where('MRMART_GROUPID', $this->PPRED_GROUP)
    				->first();
    }
}
