<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    public function setActive($value)
    {
        $this->active = $value;
        $this->save();
    }

    public function isActive()
    {
        return $this->active;
    }

    public static function setActiveByCode($code, $value) : Course
    {
        $course = Course::where('code', $code)->first();
        $course->setActive($value);
        $course->save();
        return $course;
    }


    // Relations
    public function timetable()
    {
        return $this->hasMany(Timetable::class);
    }
}
