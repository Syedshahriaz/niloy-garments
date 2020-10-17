<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OfferPrices extends Model
{
    protected $table = 'offer_prices';

    public $primaryKey = 'id';

    public $timestamps = false;

    public function offer_details ()
    {
        $instance = $this->hasMany('App\Models\OfferPriceDetail','offer_price_id','id');
        return $instance;
    }
}
