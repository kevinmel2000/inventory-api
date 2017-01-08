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
    public function ppred()
    {
        return $this->hasMany('App\SSJDED', 'SSJDE_DateTime', 'SSJDE_DateTime');
    }
}
