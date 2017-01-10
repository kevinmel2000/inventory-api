<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SSJDE extends Model
{
     protected $table = 'ssjdeh';
    public $timestamps = false;
    public $primaryKey = 'SSJDE_DateTime';
    public $incrementing = false;

        /**
     * Get the comments for the blog post.
     */
    public function ssjded()
    {
        return $this->hasMany('App\SSJDED', 'SSJDE_DateTime', 'SSJDE_DateTime');
    }

    public function customer(){
        return $this->hasOne('App\Customer', 'MCUSTOMER_CUSTID', 'SSJDE_CUSTID');
    }
}
