<?php

namespace App\Http\Controllers;
use App\Http\Services\DataFillService;
use App\Models\Time;
use Illuminate\Http\Request;
use Symfony\Component\Console\Helper\Table;

class TimeController extends Controller
{

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
//        $a = new DataFillService();
//        dd($a->procreate());
//
//        DataFillService::viscountUpdate(1);

        $timee = Time::all();
        return view('tables', compact('timee'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Time  $time
     * @return \Illuminate\Http\Response
     */
    public function show(Time $time)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Time  $time
     * @return \Illuminate\Http\Response
     */
    public function edit(Time $time)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Time  $time
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, Time $time )
    {
        dd($request);
        return response(redirect('timetable.home'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Time  $time
     * @return \Illuminate\Http\Response
     */
    public function destroy(Time $time)
    {
        //
    }
}
