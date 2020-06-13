<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buyer extends Model
{
    protected $table = 'buyers';

    public $primaryKey = 'id';

    public $timestamps = false;


    protected $fillable = [
        'id', 'user_id', 'buyer_name', 'buyer_email','buyer_phone','buying_agent_name','buying_agent_email','buying_agent_phone','address','created_at','updated_at'
    ];
}
