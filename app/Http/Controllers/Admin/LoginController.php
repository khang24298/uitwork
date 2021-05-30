<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Config;
// use JWTAuthException;
// use Tymon\JWTAuth\Exceptions;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = "/admin/home";

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Config::set('jwt.user', App\Admin::class);
        // Config::set('auth.providers', ['admins' => [
        //     'driver' => 'eloquent',
        //     'model' => App\Admin::class,
        // ]]);

        $this->middleware('guest:admin')->except('logout');
        // $this->middleware('auth:admins');
    }

    public function guard()
    {
        return Auth::guard('admins');
    }

    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    public function username()
    {
        return 'username';
    }

    public function login(Request $request)
    {
        // dd($request);
        // var_dump($request->email);
        // exit;
        $request->validate([
            'email'     => 'required|email',
            'password'  => 'required|min:6',
        ]);

        $credentials = $request->only('email', 'password');

        // $token = Auth::guard('admins')->attempt($credentials);
        // $token = JWTAuth::attempt($credentials);

        // $a = auth('admins')->attempt($credentials);
        // $b = auth()->guard('admins')->attempt($credentials);

        // if (Auth::attempt($credentials)) {
        //     echo 'Success!';
        //     exit;
        // } else {
        //     echo 'Failed!';
        //     exit;
        // }

        // dd(Auth::guard('admins')->attempt($credentials));
        dd(Auth::admin()->attempts($credentials));

        // if (Auth::guard('admins')->attempt($credentials)) {
        //     echo 'Admin Login Success!';
        //     exit;
        // } else {
        //     echo 'Admin Login Failed!';
        //     exit;
        // }

        // $credentials = $request->only('email', 'password');
        // $token = null;

        // if (!$token = JWTAuth::attempt($credentials)) {
        //     return response()->json([
        //         'status' => false,
        //         'message' => 'Invalid Email or Password',
        //     ], 401);
        // }

        // var_dump($credentials);exit;
        // dd($token);
        // return response()->json([
        //     'status'    => true,
        //     'message'   => 'Login Success',
        //     'token'     => $token,
        // ]);

        // Config::set('jwt.user', '\App\Admin');
        // Config::set('auth.providers.admins.model', \App\Admin::class);
        // // Config::set('auth.table', 'admins');
        // $credentials = $request->only('email', 'password');
        // // $token = null;
        // $token = JWTAuth::attempt($credentials);

        // dd($token);
        // try {
        //     if (!$token = JWTAuth::attempt($credentials)) {
        //         return response()->json([
        //             'response'  => 'error',
        //             'message'   => 'invalid_email_or_password',
        //         ]);
        //     }
        // } catch (JWTException $e) {
        //     return response()->json([
        //         'response'  => 'error',
        //         'message'   => 'failed_to_create_token',
        //     ]);
        // }
        // return response()->json([
        //     'response'  => 'success',
        //     'result'    => [
        //         'token'     => $token,
        //         'message'   => 'I am Admin user',
        //     ],
        // ]);
    }

    public function dashboard()
    {
        return view('admin.auth.dashboard');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('admin/login');
    }
}
