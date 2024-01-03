<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Models\Seller_status;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;


class AuthorizeController extends Controller
{
    public function register_view(): view
    {
        return view('first_project.authorize.register');
    }

    public function register(RegisterRequest $request){
        if ($request->role == 'seller'){
            try {
                $user=User::create([
                    'user_name'=> $request->user_name,
                    'email'=> $request->email,
                    'role'=> $request->role,
                    'password'=> Hash::make($request->password),
                ]);
                $userId = DB::getPdo()->lastInsertId();
                Seller_status::create([
                    'user_id'=>$userId
                ]);
                $token = $user->createTOKEN("API TOKEN")->plainTextToken;
                Session::put('token' , $token);
                Session::flash('success' , 'کاربر با موفقیت ثبت شد');
                return redirect()->route('login_view');

            } catch (\Throwable $th){
                Session::flash('failed_register' , 'خطایی صورت گرفته لطفا مجدد تلاش کنید');
                return back();
            }
        }else{
            try {
                $user=User::create([
                    'user_name'=> $request->user_name,
                    'email'=> $request->email,
                    'role'=> $request->role,
                    'password'=> Hash::make($request->password),
                ]);
                $token = $user->createTOKEN("API TOKEN")->plainTextToken;
                Session::put('token' , $token);
                Session::flash('success' , 'کاربر با موفقیت ثبت شد');
                return redirect()->route('login_view');

            } catch (\Throwable $th){
                Session::flash('failed_register' , 'خطایی صورت گرفته لطفا مجدد تلاش کنید');
                return back();
            }
     }
    }
    public function login_view(): view
    {
        return view('first_project.authorize.login');
    }

    public function login(LoginRequest $request){
        try {
        if (!Auth::attempt($request->only(['email','password']))){
            Session::flash('user_or_password_wrong' , 'پسورد یا نام کاربری اشتباه است');
            return back();
        }
        $user=User::where('email' , $request->email)->first();
         $token = $user->createTOKEN("API TOKEN")->plainTextToken;
         Session::put('token' , $token);

              return redirect()->route('workplace');
        }catch (\Throwable $th){
            Session::flash('failed_login' , 'خطایی صورت گرفته لطفا مجدد تلاش کنید');
            return back();
        }

    }

    public function logout(Request $request)
    {
        $user = $request->user();
        $user->tokens->each(function ($token, $key) {
        $token->delete();
        });
        Session::forget('token');
        return redirect()->route('login_view');
    }
}
