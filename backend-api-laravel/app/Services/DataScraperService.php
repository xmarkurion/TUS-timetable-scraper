<?php

namespace App\Services;
use App\Models\Course;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Process;

class DataScraperService
{
    public static function gatherCourses()
    {
        $folder = __DIR__ . '/data-scraper-playwright';
        $output = '';
        $process = Process::path($folder)->start('npm run courses', function (string $type, string $buffer) use (&$output) {
            if (preg_match('/DATA:START(.*?)DATA:END/s', $buffer, $matches)) {
                $output .= $matches[1];
            }
        });

        // awaits process termination
        $result = $process->wait();

        $length = Str::of($output)->length();
        if(!$length > 0){
            echo 'No data found';
            return;
        }


        $data = json_decode($output, true);
        $array = [];
        foreach($data as $course){
            if(Str::length($course) > 12){
                $array[] = [
                    'code' =>  Str::before($course, ' '),
                    'description' => Str::after($course, ' ')
                ];
                continue;
            }

            // remove all spaces from string $data
            $course = Str::of($course)->replace(' ', '')->value();
            $array[] = [
                'code' =>  $course,
                'description' => $course
            ];
        }
        dd($array);
//
//            foreach($array as $course){
//                // find if course exists in database
//                $courseModel = Course::where('code', $course['code'])->first();
//
//                // if course does not exist, create it
//                if(!$courseModel){
//                    $n = new Course();
//                    $n -> code = $course['code'];
//                    $n -> description = $course['description'];
//                    $n -> save();
//                }
//
//            }
    }
}
