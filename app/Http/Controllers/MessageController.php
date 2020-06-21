<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Common;
use App\SendMails;
use Illuminate\Support\Facades\Auth;
use Session;
use DB;
use View;

class MessageController extends Controller
{
    public function message(Request $request)
    {
        if($request->ajax()) {
            $returnHTML = View::make('user.message')->renderSections()['content'];
            return response()->json(array('status' => 200, 'html' => $returnHTML));
        }
        return view('user.message');
    }
}
