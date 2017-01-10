<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
     protected $table = 'mcustomer';
 	protected $visible = array('MCUSTOMER_CUSTID', 'MCUSTOMER_CUSTNAME');
}
