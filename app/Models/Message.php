<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'messages';

    public $primaryKey = 'id';

    public $timestamps = false;


    public function message_details()
    {
        $instance = $this->hasMany('App\Models\MessageDetails','message_id','id');
        return $instance;
    }
}
