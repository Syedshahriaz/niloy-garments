<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function adminUserList()
    {
        return view('admin.all_user');
    }
}
