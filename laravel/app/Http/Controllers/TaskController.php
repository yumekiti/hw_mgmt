<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TaskController extends Controller
{
    public function index()
    {
        return Auth::user()->tasks()->with(['lesson', 'person_lesson'])->get();
    }

    public function today(){
        return Auth::user()->tasks()->whereDate('created_at', Carbon::today())->with(['lesson', 'person_lesson'])->get();
    }

    public function date(Request $request){
        return Auth::user()->tasks()->whereDate('created_at', $request->input('date'))->with(['lesson', 'person_lesson'])->get();
    }

    public function events(){
        return Auth::user()->tasks()->where('achievement', '=', false)->get('created_at');
    }

    public function rate(){
        $tasks = Auth::user()->tasks();
        $all = $tasks->count();
        $today = Auth::user()->tasks()->whereDate('created_at', Carbon::today())->where('achievement', '=', false)->count();
        $achievement = Auth::user()->tasks()->where('achievement', '=', true)->count();
        $not = ($all - $achievement - $today);
        if($all){
            $rate = number_format($achievement / $all, 2);
        }else{
            $rate = 0;
        }

        return [
            'all' => $all,
            'achievement' => $achievement,
            'not' => $not,
            'achievement_rate' => $rate,
            'today' => $today,
        ];
    }

    public function achievement($id){
        $task = Auth::user()->tasks()->with(['lesson', 'person_lesson'])->findOrFail($id);
        $task->update([
            'achievement' => $task->achievement = !$task->achievement
        ]);
        return $task;
    }

    public function store(Request $request)
    {
        return Auth::user()->tasks()->create([
            'lesson_id' => $request->input('lesson_id'),
            'detail' => $request->input('detail'),
        ])->with('lesson')->get();
    }

    public function show($id){
        return Auth::user()->tasks()->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $task = Auth::user()->tasks()->findOrFail($id);
        $task->update([
            'detail' => $request->input('detail'),
        ]);
        return $task;
    }

    public function destory($id){
        Auth::user()->tasks()->findOrFail($id)->delete();
        return response()->noContent();
    }

    public function histories(){
        return Auth::user()->tasks()->latest('updated_at')->take(5)->with(['lesson', 'person_lesson'])->get();
    }
}
