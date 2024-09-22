<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\CourseController;
use App\Services\DataScraperService;

class test extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'table:courses';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fill the courses table with data from the timetable website.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        DataScraperService::gatherCourses();
    }
}
