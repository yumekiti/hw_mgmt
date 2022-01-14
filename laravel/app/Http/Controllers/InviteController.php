<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Str;

class InviteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return Auth::user()->invites()->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $date = new Carbon('+3 minutes');
        return Auth::user()->invites()->create([
            'user_id' => Auth::user()->id,
            'token' => Str::random(30),
            'expired' => $date,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($token)
    {
        return $token;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::first();
        $user->
        Invites()->
        where('invite_user_id','=',$id)->
        delete();
        return  $id;
    }

    public function invite($token)
    {
        $invite = Auth::user()->invites()->where('token', '=', $token);
        if($invite->firstOrFail() && Carbon::now()->diffInMinutes($invite->firstOrFail()->expired) > 0){
             $invite->update([
                 'invite_user_id' => Auth::user()->id,
                 'token' => null,
             ]);
             return Auth::user()->invites()->create([
                 'user_id' => Auth::user()->id,
                 'invite_user_id' => $invite->user_id,
             ]);
             
         }
        return response()->noContent();
        //return Carbon::now()->diffInMinutes($invite->firstOrFail()->expired);
    }

}
