<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Models\Seller_status;
use App\Models\User;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Laravel\Socialite\Facades\Socialite;


class AuthorizeController extends Controller
{
    public function register_view(): view
    {
        return view('first_project.authorize.register');
    }
    public function create(Request $request){
        dd($request);
    }
    public function register(RegisterRequest $request , User $user){
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
                return response()->json([
                    'token'=>$token,
                    'statuses'=>'success',
                ],200);

            } catch (\Throwable $th){
                Session::flash('failed_register' , 'خطایی صورت گرفته لطفا مجدد تلاش کنید');
                return response()->json([
                    'statuses'=>'failed',
                ],200);
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
                return response()->json([
                    'token'=>$token,
                    'statuses'=>'success',
                ],200);

            } catch (\Throwable $th){
                Session::flash('failed_register' , 'خطایی صورت گرفته لطفا مجدد تلاش کنید');
                return response()->json([
                    'statuses'=>'failed',
                ],200);
            }
     }
    }
    public function login_view(): view
    {
        return view('first_project.authorize.login');
    }

    public function login(LoginRequest $request){

        try {

        if (!Auth::guard('web')->attempt(['email' => $request->email, 'password' => $request->password])){

            return response()->json([
                'statuses'=>'wrong password',
            ],200);
        }

        $user=User::where('email' , $request->email)->first();
         $token = $user->createTOKEN("API TOKEN")->plainTextToken;


         return response()->json([
             'status'=>'success',
             'token'=>$token
         ],200);
        }catch (\Throwable $th){

            return response()->json([
                'statuses'=>'failed',
                'massage'=>$th->getMessage(),
            ],200);
        }

    }

    public function logout(Request $request)
    {
        $user = $request->user();
        $user->tokens->each(function ($token, $key) {
        $token->delete();
        });
        Session::forget('token');
        return response()->json([
            'statuses'=>'success',
        ],200);
    }
    public function redirect($provider){
        return Socialite::driver($provider)->redirect();
    }
    public function callback($provider)
    {
        $user = Socialite::driver($provider)->user();
        dd($user);
        return \view('first_project.authorize.login_role' , ['user'=>$user]);
    }
}
