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
        // Use command to get course list php artisan table:courses - SETUP Only
        // Make sure playwright can be run in the system before running the command
        DataScraperService::gatherCourses();
    }
    /**
     * Display a listing of the resource.
     */
    //http://localhost:8000/api/courses
    public function index()
    {
        return Course::all()->toJson();
    }

    //http://localhost:8000/api/courses/active
    public function indexActive()
    {
        return Course::where('active', 1)->get()->toJson();
    }

    //http://localhost:8000/api/courses/set/active
    public function updateActive(Request $request)
    {
        $request->validate([
            'code' => 'required|string|exists:courses,code',
            'active' => 'required|boolean'
        ]);

        $message =  "Course " . $request->code . " is now " . ($request->active ? 'active' : 'inactive');
        $course = Course::setActiveByCode($request->code, $request->active);

        return response()->json([
            'message' => $message,
            'course' => $course
        ]);
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
