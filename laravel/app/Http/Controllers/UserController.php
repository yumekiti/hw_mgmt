<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\User;

class UserController extends Controller
{

    public function index()
    {
        return Auth::user();
    }

    public function store(Request $request)
    {
        return User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);
    }

    public function update(Request $request)
    {
        Auth::user()->
        update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);
        return Auth::user();
    }

    public function destory(){
        Auth::user()->delete();
        return response()->noContent();
    }

    public function login(Request $request){
        if(Auth::attempt($request->all())) {
            return Auth::user();
        }
        return response()->noContent();
    }

    public function another_user($id){
        Auth::User()->invites()->where('invite_user_id', '=', $id)->firstOrFail();
        return User::findOrFail($id);
    }

}
