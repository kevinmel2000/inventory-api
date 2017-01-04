<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PPRE extends Model
{
      protected $table = 'ppreh';
    public $timestamps = false;
    public $primaryKey = 'PPRE_DateTime';
    public $incrementing = false;

        /**
     * Get the comments for the blog post.
     */
    public function ppred()
    {
        return $this->hasMany('App\PPRED', 'PPRE_DateTime', 'PPRE_DateTime');
    }
}
