<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Gate;

class AdminController extends Controller
{

    public function index()
    {
        if (!Gate::allows('quyen', "Khách hàng")) {
            return redirect()->route('home.index');
        }
        return view('backend.home');
    }
}
