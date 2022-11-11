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
        // Allowing the script to run inside the virtual env.
        $this->python_venv_path = $this->python_path.".venv\\Scripts\\";
    }

    /**
     *
     * @return void
     */
    public function gettable(?string $timetableName){
        //Checks if value is empty and display message accordingly
        if ($timetableName != null){
            dump("Time table value is: ".$timetableName." Let's gather the intel...");
            $scriptLocation = $this->python_path.'pass.py';
            dump(gettype($scriptLocation));
            $args =  ['python',$scriptLocation,'testing'];
            dump($args);
            $process = new Process($args);
            $process->run();

            //Get script to save new timetable in folder python/timetables
            $process = new Process($args);
            $process->run();

            // executes after the command finishes
            if (!$process->isSuccessful()) {
                    throw new ProcessFailedException($process);
                }
            echo $process->getOutput();
            return;
        }
        dump("Value is a NULL Please add timetable name.");

    }
}
