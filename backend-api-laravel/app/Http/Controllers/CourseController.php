<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Services\DataScraperService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Process;
use Illuminate\Process\Pool;

class CourseController extends Controller
{
    public function gatherCourses()
    {
        DataScraperService::gatherCourses();
//        $folder = __DIR__ . '/data-scraper-playwright';
//        $process = Process::path($folder)->run('ls -la', function (string $type, string $output) {
//            echo $output;
//        });

        // inside data-scraper-playwright folder
        // $result = Process::path(__DIR__)->run('ls -la');

//        $process = Process::path(__DIR__)->run('pwd', function (string $type, string $output) {
//            echo $output;
//        });
//
//        $result = $process->wait();
//        dd($result);

        // run "npm run courses" system command
        //  output capture as json file



    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        //
    }
}
