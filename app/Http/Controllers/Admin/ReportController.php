<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function allReport(Request $request)
    {
        //return View::make('admin.report');
        return view('admin.report');
    }
}
