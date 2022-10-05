<?php

namespace App\Http\Services;
use App\Http\Controllers\Controller;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class TableGetterService
{
    private string $python_path;

    function __construct(){
        $this->python_path = base_path()."\\python\\";
    }

    public function gettable(){
        $args = 'python3 '.$this->python_path.'app.py ffff';
        dump($args);
        //$process = new Process(['python3 '.$this->python_path.'app.py '.$test]);
        //$process->run();

        // executes after the command finishes
//        if (!$process->isSuccessful()) {
//            throw new ProcessFailedException($process);
//        }
//        echo $process->getOutput();
    }
}
