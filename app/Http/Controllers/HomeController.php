<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        if($request->ajax()) {
            $returnHTML = View::make('user.dashboard')->renderSections()['content'];
            return response()->json(array('status' => 200, 'html' => $returnHTML));
        }
        return view('user.dashboard');
    }

    public function profile(Request $request)
    {
        $user = User::where('id',Auth::user()->id)->first();
        if($request->ajax()) {
            $returnHTML = View::make('user.profile', compact('user'))->renderSections()['content'];
            return response()->json(array('status' => 200, 'html' => $returnHTML));
        }
        return view('user.profile', compact('user'));
    }
}
