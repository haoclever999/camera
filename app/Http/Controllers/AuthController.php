<?php

namespace App\Http\Controllers;

use App\Mail\LayLaiMK;
use App\Models\PasswordReset;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Rules\ReCaptcha;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

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
                'email.max' => 'Email quá dài',
            ]
        );

        if (auth()->attempt(['email' => $request->email, 'password' => $request->password])) {
            if (auth()->user()->quyen != "Khách hàng")
                return redirect()->route('admin.index');
            else
                return redirect()->route('home.index');
        } else {
            Session::flash('mgs', 'Email hoặc password không đúng.');
            return redirect()->route('getDangNhap');
        }
    }

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
                'email.max' => 'Email quá dài',
            ]
        );
        $ghi_nho = $request->has('ghi_nho') ? true : false;
        if (auth()->attempt(['email' => $request->email, 'password' => $request->password], $ghi_nho)) {
            return redirect()->route('home.index');
        } else {
            Session::flash('mgs', 'Email hoặc mật khẩu không đúng.');
            return redirect()->route('getDangNhapUser');
        }
    }

    public function DangXuatUser()
    {
        auth()->logout();
        return view('auth.dangnhapUser');
    }

    public function getQuenMatKhauUser()
    {
        return view('auth.quenmatkhau');
    }

    public function postQuenMatKhauUser(Request $request)
    {
        $request->validate(
            [
                'email' => 'max:191|exists:users',
            ],
            [
                'email.max' => 'Email quá dài',
                'email.exists' => 'Email không tồn tại trong hệ thống',
            ]
        );
        $user = User::where('email', $request->email)->first();
        $token = Str::random(50);
        $pass = PasswordReset::where('email', $request->email)->first();
        if (!empty($pass))
            $pass->update(['token' => $token,]);
        else
            PasswordReset::Create([
                'email' => $user->email,
                'token' => $token,
            ]);
        Mail::to($user->email)->send(new LayLaiMK($user, $token));
        Session::flash('thongbao', 'Vui lòng kiểm tra email để thực hiện lấy lại mật khẩu.');
        return redirect()->route('getQuenMatKhauUser');
    }

    public function getDatLaiMatKhauUser($id, $token)
    {
        $user = User::find($id);
        return view('auth.datlaimatkhau', compact('user'));
    }

    public function postDatLaiMatKhauUser(Request $request, $id)
    {
        $request->validate(
            [
                'password' => 'required|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
                'password_confirm' => 'required|same:password',
            ],
            [
                'password.required' => 'Hãy nhập mật khẩu mới',
                'password.regex' => 'Mật khẩu có ít nhất 1 số, 1 chữ hoa, 1 chữ thường và 1 ký tự đặc biệt',
                'password_confirm.required' => 'Hãy nhập lại mật khẩu mới',
                'password_confirm.same' => 'Mật khẩu mới và mật khẩu nhập lại không giống nhau',

            ]
        );
        try {
            DB::beginTransaction();
            $u = User::find($id);

            $u->update([
                'password' => bcrypt(trim($request->password))
            ]);

            DB::commit();
            session()->flash('success', 'Đặt lại mật khẩu thàng công');
            return redirect()->back();
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . ' --- Line : ' . $exception->getLine());
            session()->flash('err', 'Đặt lại mật khẩu thất bại');
            return redirect()->back();
        }
    }

    public function getDangKy()
    {
        return view('auth.dangky');
    }

    public function postDangKy(Request $request)
    {
        $request->validate(
            [
                'ho_ten' => 'required|max:191',
                'email' => 'required|max:191|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix|unique:users',
                'password' => 'required|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
                'confirm_password' => 'required|same:password',
                'g-recaptcha-response' => ['required', new ReCaptcha],
            ],
            [
                'ho_ten.required' => 'Hãy nhập họ tên',
                'ho_ten.max' => 'Họ tên quá dài',
                'email.required' => 'Hãy nhập Email',
                'email.regex' => 'Email không đúng dạng. VD: abc@gmail.com',
                'email.max' => 'Email quá dài',
                'email.unique' => 'Email đã tồn tại',
                'password.required' => 'Hãy nhập mật khẩu',
                'password.regex' => 'Mật khẩu có ít nhất 1 số, 1 chữ hoa, 1 chữ thường và 1 ký tự đặc biệt',
                'confirm_password.required' => 'Hãy nhập lại mật khẩu',
                'confirm_password.same' => 'Mật khẩu và mật khẩu nhập lại không giống nhau',
                'g-recaptcha-response.required' => 'Hãy chọn tôi không phải là người máy'
            ]
        );
        try {
            DB::beginTransaction();
            User::firstOrCreate([
                'ho_ten' => trim($request->ho_ten),
                'email' => trim($request->email),
                'password' => bcrypt(trim($request->password)),
            ]);
            DB::commit();
            Session::flash('mgs-success', 'Đăng ký thành công. Hãy đăng nhập.');
            return redirect()->route('getDangNhapUser');
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . ' --- Line : ' . $exception->getLine());
            Session::flash('mgs', 'Đăng ký thất bại.');
            return redirect()->route('getDangKy');
        }
    }

    public function getDangNhapFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function postDangNhapFacebook()
    {
        try {

            $user = Socialite::driver('facebook')->user();

            $finduser = User::where('facebook_id', $user->id)->first();

            if ($finduser) {

                // Auth::login($finduser);
                auth()->attempt(['email' => $user->email, 'password' => $user->password]);
                return redirect()->route('home.index');
            } else {
                $newUser = User::updateOrCreate(['email' => $user->email], [
                    'ho_ten' => $user->name,
                    'password' => bcrypt($user->password),
                    // 'facebook_id' => $user->id, //xem laij
                ]);

                auth()->attempt(['email' => $newUser->email, 'password' => $newUser->password]);
                return redirect()->route('home.index');
            }
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
