<?php

namespace App\Http\Controllers;

use App\Models\DanhMuc;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home()
    {
        $dm = DanhMuc::all();
        return view('frontend.user_home', compact('dm'));
    }
}
