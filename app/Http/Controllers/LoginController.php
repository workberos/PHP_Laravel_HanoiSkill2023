<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Organizer;

class LoginController extends Controller
{
    public function login()
    {
        return view('login.index');
    }


    public function loginPost(Request $request)
    {



        $organizer = Organizer::where('email', $request->email)
            ->where('password_hash', md5($request->password))
            ->first();
        if ($organizer) {
            session(['currentOrganizer' => $organizer]);
            return redirect()->route('events.index');
        }
        $message = 'Tên đăng nhập hoặc mật khẩu không đúng';
        return view('login.index', ['message' => $message]);
    }
}
