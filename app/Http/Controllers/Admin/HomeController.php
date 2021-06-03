<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    use AuthenticatesUsers;

    public function __construct()
    {
        $this->middleware(['auth' => 'admin']);
    }

    public function index()
    {
        // return view('welcome');
        echo 'Admin home. Dang nhap roi thi vo duoc day!';
    }

    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function test()
    {
        echo 'Test Admin. Dang nhap roi thi vo duoc day!';
    }
}
