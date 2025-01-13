<?php

namespace App\Http\Controllers;

use App\Jobs\GetTimetableJob;
use App\Models\Course;
use App\Models\Timetable;
use App\Services\DataScraperService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use function PHPUnit\Framework\isNull;

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

    public function storeAllActive(){
        $courses = Course::where('active', 1)->get();

        if(!$courses->count()){
            return response()->json([
                'message' => 'No active courses found.'
            ], 400);
        }

        foreach($courses as $course){
            GetTimetableJob::dispatch($course);
        }
        return response()->json([
            'message' => 'Process of updating active courses started. This may take some time.',
            'courses' => $courses->pluck('code')->toArray()
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        // Get the course code from the request
        $request->validate([
            'code' => 'required|string|exists:courses,code',
        ]);

        $course = Course::where('code', $request->code)->first();

        // Check if found course is active if not return error
        if(!$course->active){
            return response()->json([
                'message' => 'Course is not active, please activate it first.'
            ], 400);
        }

        // Check if there are any timetables associated with the given course code
        if(!$course->timetable){
            return response()->json([
                'message' => 'Course is active, but there is no timetable downloaded for it.'
            ], 400);
        }

        $decoded = json_decode($course->timetable->data);
        return response()->json([
            'course' => $course->code,
            'timetable' => $decoded,
            'updated_at' => $course->timetable->updated_at
        ]);
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
