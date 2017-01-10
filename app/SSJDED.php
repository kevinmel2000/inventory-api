<?php

namespace App;

use App\Mfgart;
use Illuminate\Database\Eloquent\Model;

class SSJDED extends Model
{
      protected $table = 'ssjded';
    public $timestamps = false;
    public $primaryKey = null;
    public $incrementing = false;

    /**
    * return the article item needed
    */
    public function article(){
    	return Mfgart::where('MFGART_AKTIF', '1')
    		->where('MFGART_ARTICLEID', $this->SSJDE_ART)
    			->where('MFGART_GROUPID', $this->SSJDE_GROUP)
    				->first();
    }
}
