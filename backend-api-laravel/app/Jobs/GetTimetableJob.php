<?php

namespace App\Jobs;

use App\Models\Timetable;
use App\Services\DataScraperService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GetTimetableJob implements ShouldQueue
{
    use Queueable;
    protected $code;
    protected $id;
    protected $name;

    /**
     * Create a new job instance.
     */
    public function __construct($course)
    {
        $this->code = $course->code;
        $this->id = $course->id;
        // get current php class name
        $this->name = get_class($this);
    }

    /**
     * Execute the job.
     */
//    public function handle(): void
//    {
//        dump("$this->name: Gathering timetable data for course: $this->code");
//        $data =  DataScraperService::getTimetable($this->code);
//
//        dump("$this->name: Checking if timetable exists for course: $this->code");
//        $timetable = Timetable::where('course_id', $this->id)->first();
//
//        if($timetable){
//            $timetable->data = $data;
//            $timetable->save();
//            dump("$this->name: Timetable updated with data.");
//            return;
//        }
//
//        //If no create a new timetable
//        $timetable = new Timetable();
//        $timetable->course_id = $this->id;
//        $timetable->data = $data;
//        $timetable->save();
//        dump("$this->name: Timetable created with data.");
//    }

    public function handle(): void
    {
        // make an info that with the course code
        dump("$this->name: Gathering timetable data for course: $this->code");
        $data = DataScraperService::getTimetable($this->code);

        if (empty($data)) {
            dump("$this->name: No data received for course: $this->code");
            return;
        }

        // the id flowing.

        dump("$this->name: Checking if timetable exists for course: $this->code");
        $timetable = Timetable::where('course_id', $this->id)->first();

        if ($timetable) {
            $timetable->data = $data;
            $timetable->save();
            dump("$this->name: Timetable updated with data.");
        } else {
            // If no timetable exists, create a new one
            $timetable = new Timetable();
            $timetable->course_id = $this->id;
            $timetable->data = $data;
            $timetable->save();
            dump("$this->name: Timetable created with data.");
        }
    }
}
