<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
<<<<<<< HEAD
        'payment_success','payment_failed','payment_cancel'
=======
        //
>>>>>>> 876681c647cfc95683ddf2ed9cfe614d4d7d0bc8
    ];
}
