<?php

namespace App\Http\Controllers;
use App\Http\Services\DataFillService;
use App\Models\Time;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\Console\Helper\Table;

class TimeController extends Controller
{

    public function setup(){
        $a = new DataFillService();
        dump($a->procreate());
        dump("Setup was done");
    }

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $timee = Time::all();
        return view('tables', compact('timee'));
    }

    public function countUpdate($courseName){
        $d = Time::where('name', $courseName)->first();
        DataFillService::viscountUpdate($d->id);

        $lastCreated = $d->created_at;
        $nowDate = Carbon::now();
        $totalDiference = $nowDate->diffInSeconds($lastCreated);

        dump("Time that passed since last update: ".$totalDiference);

        if(DataFillService::moreThanEnough($totalDiference)){
            dump("The table will UPDATE CREATE DATE");
            DataFillService::createdUpdate($d->id);
            return redirect(route('home'));
        }
        return redirect(route('home'));
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
