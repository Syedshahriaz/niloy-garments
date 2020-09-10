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
        'payment_success','payment_fail','payment_cancel','get_unread_message','get_message_details','admin/get_message_details','admin/get_unread_message'
    ];
}
