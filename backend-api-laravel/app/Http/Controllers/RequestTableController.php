<?php

namespace App\Http\Controllers;

use App\Jobs\GetTimetableJob;
use App\Models\Course;
use App\Models\RequestTable;
use Illuminate\Http\Request;

class RequestTableController extends Controller
{

    public function showPendingRequests()
    {
        $requests = RequestTable::all();

        //return in format id, course_code, created_at
        // for each course_id find the course
        $response = [];
        foreach ($requests as $request) {
            $course = Course::where('id', $request->course_id)->first();
            $response[] = [
                'id' => $request->id,
                'course_code' => $course->code,
                'created_at' => $request->created_at
            ];
        }
        if (!$requests->count()) {
            return response()->json([
                'message' => 'No pending requests found.'
            ]);
        }
        return response()->json($response);
    }

    public function acceptAllRequests()
    {
        $courseNames = [];
        $requests = RequestTable::all();
        foreach ($requests as $request) {
            $course = Course::where('id', $request->course_id)->first();
            $course->active = 1;
            $course->save();
            $courseNames[] = $course->code;

            // Delete the request and dispatch the job to get the timetable
            $request->delete();
            GetTimetableJob::dispatch($course);
        }

        if(!$requests->count()){
            return response()->json([
                'message' => 'No requests to accept'
            ]);
        }

        return response()->json([
            'message' => 'All requests accepted',
            'accepted' => $courseNames
        ]);
    }

    public function acceptSelectedIdRequest(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:request_tables,id'
        ]);

        $requestTable = RequestTable::where('id', $request->id)->first();
        $course = Course::where('id', $requestTable->course_id)->first();
        $course->active = 1;
        $course->save();
        $courseName = $course->code;

        // Delete the request and dispatch the job to get the timetable
        $requestTable->delete();
        GetTimetableJob::dispatch($course);

        return response()->json([
            'message' => 'Request accepted for course ' . $courseName
        ]);
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
        // Validate if given code exists in the courses table
        $request->validate([
            'code' => 'required|string|exists:courses,code'
        ]);

        // And active parameter for code id is not true
        $course = Course::where('code', $request->code)->first();
        if ($course->active == 1) {
            return response()->json([
                'message' => 'Course is already active'
            ]);
        }

        // Check if the request is already in the request table
        $requestTable = RequestTable::where('course_id', $course->id)->first();
        if($requestTable){
            return response()->json([
                'error' => 'Request already created for course ' . $course->code
            ], 400);
        }

        // If it's not in the request table, create a new request
        RequestTable::create([
            'course_id' => $course->id,
        ]);

        // Return response with message that request is created for course
        return response()->json([
            'message' => 'Request created for course ' . $course->code
        ]);

    }

    /**
     * Display the specified resource.
     */
    public function show(RequestTable $requestTable)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RequestTable $requestTable)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RequestTable $requestTable)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RequestTable $requestTable)
    {
        if(!$requestTable){
            return response()->json([
                'error' => 'Request not found'
            ], 404);
        }

        $requestTable->delete();
    }
}
