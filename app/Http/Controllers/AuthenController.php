<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthenController extends Controller
{
    public function getFormLogin(){
        return view('admin.custom_auth.login_auth');
    }

    public function login(Request $request){
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);         
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            // dd($request->all());
 
            return redirect('/dashboard');
        }else{
            return redirect('/login-auth')->with('message', 'Lỗi đăng nhập');
        }
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function getFormRegister(){
        return view('admin.custom_auth.register');

    }

    public function register_auth(Request $request){

        try {
            $request['password'] = bcrypt($request['password']);
            User::create($request->all());

            return redirect('/login-auth');
        } catch (Exception $e) {
            Log::error($e);
          
        }
    }
    
    
    public function getAllUser(){
        $users = User::with('role')->orderBy('id','DESC')->get();
        $role = Role::orderBy('id', 'ASC')->get();

        return view('admin.users.all_users', compact('users', 'role'));
    }

    public function updateRoleUser(Request $request){
       
        $data = $request->all();
        $user = User::find($data['user_id']);
        $role_id = $data['role_id'];
        $user->role_id = $role_id;
       // echo($user);

        $user->save() ;
        
      // return view('welcome');
    }

}