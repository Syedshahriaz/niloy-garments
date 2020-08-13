<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OfferPrices extends Model
{
    protected $table = 'offer_prices';

    public $primaryKey = 'id';

    public $timestamps = false;
}
