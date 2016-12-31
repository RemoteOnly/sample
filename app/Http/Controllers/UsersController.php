<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function __construct(){
        $this->middleware('auth',[
            'only'=>['edit']
        ]);
    }

    public function create()
    {
        return view('users.create');
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('users.show', compact('user'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
        'name'=>'required|max:50',
        'email'=>'required|email|unique:users|max:255',
        'password'=>'required|confirmed'
      ]);

        $user = User::create([
        'name'=>$request->name,
        'email'=>$request->email,
        'password'=>$request->password
      ]);
        Auth::login($user);
        session()->flash('success', '欢迎，您将在这里开启一段新的旅程~');
        return redirect()->route('users.show', [$user]);
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $this->authorize('update' , $user);
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
                  'name' => 'required|max:50',
                  'password' => 'required|confirmed|min:6'
              ]);

        $user = User::findOrFail($id);
        $this->authorize('update', $user);
        $user->update([
                  'name' => $request->name,
                  'password' => $request->password,
              ]);

        return redirect()->route('users.show', $id);
    }
}
