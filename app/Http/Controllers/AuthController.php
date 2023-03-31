<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    // Admin 
    public function getDangNhap()
    {
        return view('auth.dangnhapAdmin');
    }
    public function postDangNhap(Request $request)
    {
        $request->validate(
            [
                'email' => 'max:191',
            ],
            [
                'email.max' => 'Email tối đa 191 ký tự',
            ]
        );

        if (auth()->attempt(['email' => $request->email, 'password' => $request->password])) {
            if (auth()->user()->quyen != "khách hàng")
                return redirect()->route('admin.index');
            else
                return redirect()->route('home.index');
        } else {
            Session::flash('mgs', 'Email hoặc password không đúng.');
            return redirect()->route('getDangNhap');
        }
    }
    //  register          'email' => 'required|max:191|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix|unique:users',
    public function DangXuat()
    {
        auth()->logout();
        return view('auth.dangnhapAdmin');
    }

    // User 
    public function getDangNhapUser()
    {
        return view('auth.dangnhapUser');
    }
    public function postDangNhapUser(Request $request)
    {
        $request->validate(
            [
                'email' => 'max:191',
            ],
            [
                'email.max' => 'Email tối đa 191 ký tự',
            ]
        );

        if (auth()->attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->route('home.index');
        } else {
            Session::flash('mgs', 'Email hoặc mật khẩu không đúng.');
            return redirect()->route('getDangNhapUser');
        }
    }
    //  register          'email' => 'required|max:191|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix|unique:users',
    public function DangXuatUser()
    {
        auth()->logout();
        return view('auth.dangnhapUser');
    }

    public function getQuenMatKhauUser()
    {
    }
    public function postQuenMatKhauUser()
    {
    }
    public function getDangKy()
    {
        return view('auth.dangky');
    }
    public function postDangKy()
    {
    }
}
