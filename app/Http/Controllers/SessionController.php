<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SessionController extends Controller
{
    public function login()
    {
        return view('sessions.create');
    }

    public function store(Request $reuest)
    {
        $this->validate($request, [
        'email'=>'reuqired',
        'password'=>'required'
      ]);
        $credentials = [
                 'email'    => $request->email,
                 'password' => $request->password,
             ];

        if (Auth::attemp($credentials, $request->has('remember'))) {
            session()->flash('success', '欢迎回来~');
            return redirect()->route('users.show', [Auth::user()]);
        } else {
            session()->flash('danger', '很抱歉，您的邮箱和密码不匹配');
            return redirect()->back();
        }
    }

    public function logout()
    {
    }
}
