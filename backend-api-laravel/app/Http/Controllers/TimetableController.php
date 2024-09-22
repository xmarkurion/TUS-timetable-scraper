<?php

namespace App\Http\Controllers;

use App\Jobs\GetTimetableJob;
use App\Models\Course;
use App\Models\Timetable;
use App\Services\DataScraperService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TimetableController extends Controller
{
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
        $request->validate([
            'code' => 'required|string|exists:courses,code',
        ]);
        $courseCode = $request->code;
        $course = Course::where('code', $courseCode)->first();

        //Check if found course is active if not return error
        if(!$course->active){
            return response()->json([
                'message' => 'Course is not active, please activate it first.'
            ], 400);
        }

        // This will dispatch a job to get the timetable as it may take some time
        GetTimetableJob::dispatch($course);

        return response()->json([
            'message' => 'Timetable is being fetched'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Timetable $timetable)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Timetable $timetable)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Timetable $timetable)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Timetable $timetable)
    {
        //
    }
}
