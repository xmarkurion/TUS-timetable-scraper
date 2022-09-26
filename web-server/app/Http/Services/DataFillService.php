<?php

namespace App\Http\Services;

use App\Http\Controllers\Controller;
use App\Models\Time;

class DataFillService extends Controller
{
    public function procreate(){
        dump($this->make("AL_KMOBA_8_2"));
        dump($this->make("AL_KAICC_7_2"));
    }

    public function make($name){
        $entry = new Time();
        $entry->name = $name;
        $entry->viscount = 0;
        $entry->save();
        return $entry;
    }

    public static function viscountUpdate($id){
        $entry = Time::findOrFail($id);
        $entry->viscount = $entry->viscount + 1;
        $entry->save();
        return $entry;
    }
}
