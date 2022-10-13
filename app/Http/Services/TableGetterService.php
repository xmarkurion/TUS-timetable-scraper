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

    /**
     *
     * @return void
     */
    public function gettable(?string $timetableName){
        if (!$timetableName == null){
            dump("Time table value is: ".$timetableName);
        }

        $scriptLocation = $this->python_path.'pass.py';
        dump(gettype($scriptLocation));
        $args =  ['python3',$scriptLocation,'testing'];
        dump($args);
        $process = new Process($args);
        $process->run();

        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
        echo $process->getOutput();
    }
}
