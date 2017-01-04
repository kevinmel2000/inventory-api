<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    protected $table = 'msuserandro';
    public $timestamps = false;
    public $primaryKey = 'MSUSERANDRO_ID';
    public $incrementing = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
     'MSUSERANDRO_ID',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'MSUSERANDRO_PASSWORD', 'MSUSERANDRO_TOKEN',
    ];
}
