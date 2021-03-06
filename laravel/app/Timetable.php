<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\User;
use App\Lesson;
use App\PersonLesson;

class Timetable extends Model
{
    protected $fillable = [
        'week_count', 'user_id', 'lesson_id', 'start', 'end'
    ];

    protected $hidden = [
        'id', 'user_id', 'lesson_id'
    ];

    public $timestamps = false;

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function lesson(){
        return $this->hasOne(Lesson::class, 'id', 'lesson_id');
    }

    public function person_lesson(){
        return $this->hasOne(PersonLesson::class, 'lesson_id', 'lesson_id');
    }
}
