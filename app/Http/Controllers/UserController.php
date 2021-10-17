<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
  use RegistersUsers;
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
      $this->middleware('auth');
  }
  /**
   * Display a Listing of all Resources
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    if (auth()->user()->user_role != '1')
    {
      return redirect('/home')->with('error','Unauthorized Access!!');
    }

    $users = User::all();
    return view('user.index')->with('users',$users);
  }

  public function create()
  {
    if (auth()->user()->user_role != '1')
    {
      return redirect('/home')->with('error','Unauthorized Access!!');
    }

    return view('user.register');
  }

  public function store(Request $request)
  {
    if (auth()->user()->user_role != '1')
    {
      return redirect('/home')->with('error','Unauthorized Access!!');
    }

    $this->validate($request,[
      'name' => ['required', 'string', 'max:255'],
      'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
      // 'mobile' => ['required', 'numeric', 'digits:10' ]
      'password' => ['required', 'string', 'min:8'],
      'confirm_password' => ['same:password'],
      'user_role' => ['required'],
    ]);

    $user = new User;
    $user->name = $request->input('name');
    $user->email= $request->input('email');
    // $user->mobile = $request->input('mobile');
    $user->password = Hash::make($request->input('mobile'));
    $user->user_role = $request->input('user_role');
    $user->save();

    return redirect('/user')->with('success','User Added');
  }

  public function edit($id)
  {
    if (auth()->user()->user_role != '1')
    {
      return redirect('/home')->with('error','Unauthorized Access!!');
    }

    $user = User::find($id);
    return view('user.edit')->with('user',$user);
  }

  public function update(Request $request, $id)
  {
    if (auth()->user()->user_role != '1')
    {
      return redirect('/home')->with('error','Unauthorized Access!!');
    }

    $this->validate($request,[
      'name' => ['required', 'string', 'max:255'],
      'address' => ['nullable', 'string', 'max:50'],
      'mobile' => ['nullable', 'numeric', 'digits:10'],
      'user_role' => ['required'],
    ]);

    $user = User::find($id);
    $user->name = $request->input('name');
    $user->address = $request->input('address');
    $user->mobile = $request->input('mobile');
    // $user->password = Hash::make($request->input('mobile'));
    $user->user_role = $request->input('user_role');
    $user->save();

    return redirect('/user')->with('success','User Data Updated!!');
  }

  public function destroy($id)
  {
    if (auth()->user()->user_role != '1')
    {
      return redirect('/home')->with('error','Unauthorized Access!!');
    }

    $user = User::find($id);
    if (auth()->user()->user_role != '1') {
      return redirect('/user')->with('error','Unauthorized Access!!');
    }
    $user->delete();
    return redirect('/user')->with('success','User Removed!!');
  }

}
