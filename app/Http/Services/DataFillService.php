<?php

namespace App\Http\Services;

use App\Http\Controllers\Controller;
use App\Models\Time;
use Carbon\Carbon;

class DataFillService extends Controller
{
    public function procreate(){
        dump($this->make("AL_KMOBA_8_2"));
        dump($this->make("AL_KAICC_7_2"));
        dump($this->make("AL_KMOBA_7_2"));
        dump($this->make("AL_KAICC_7_1"));

    }

    public function make($name){
        $entry = new Time();
        $entry->name = $name;
        $entry->viscount = 0;
        $entry->save();
        return $entry;
    }

    public static function createdUpdate($id){
        $entry = Time::findOrFail($id);
        $entry->created_at = Carbon::now();
        $entry->save();
        return $entry;
    }

    public static function viscountUpdate($id){
        $entry = Time::findOrFail($id);
        $entry->viscount = $entry->viscount + 1;
        $entry->save();
        return $entry;
    }

    public static function moreThanEnough(int $seconds) : bool {
        return ($seconds >= 1800);
    }
}
