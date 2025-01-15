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

    public function handle(): void
    {
        // make an info that with the course code
        dump("$this->name: Gathering timetable data for course: $this->code");
        $data = DataScraperService::getTimetable($this->code);
        $data = json_encode($data, JSON_PRETTY_PRINT);

        if (empty($data)) {
            dump("$this->name: No data received for course: $this->code");
            return;
        }

        // Display information about mount strings downloaded
        dump("$this->name: Gathered string length: ".strlen($data));

        // if string is < 50 fail the job
        if (strlen($data) < 50) {
            dump("$this->name: Timetable data for course: $this->code is too short.");
            $this->fail();
        }

        // Retrieve timetable
        $timetable = Timetable::where('course_id', $this->id)->first();

        // If timetable record exist update it with data
        if ($timetable) {
            $timetable->data = $data;
            $timetable->save();
            dump("$this->name: Timetable ".$this->code." updated with data.");
        } else {
            // If no timetable exists, create a new one record and add data.
            $timetable = new Timetable();
            $timetable->course_id = $this->id;
            $timetable->data = $data;
            $timetable->save();
            dump("$this->name: Timetable ".$this->code." created with data.");
        }
    }
}
