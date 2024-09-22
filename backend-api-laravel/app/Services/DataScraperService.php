<?php

namespace App\Services;
use App\Models\Course;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\File;
use PhpParser\JsonDecoder;

class DataScraperService
{
    public static function checkIfScraperWorks(){
        $folder = __DIR__ . '/data-scraper-playwright';
        $output = '';
        $process = Process::path($folder)->start('npm run check', function (string $type, string $buffer) use (&$output) {
            $output .= $buffer;
        });
        // awaits process termination
        $process->wait();
        return $output;
    }

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

        // Star decoding the json data
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

        // Add the courses to the database
        foreach($array as $course){
            // find if course exists in database
            $courseModel = Course::where('code', $course['code'])->first();

            // if course does not exist, create it
            if(!$courseModel){
                $n = new Course();
                $n -> code = $course['code'];
                $n -> description = $course['description'];
                $n -> save();
            }
        }
    }

    //This operation involves running a Playwright test to get the timetable of a course with a given code.
    //The new json file is created then npm reads that file for best compatibility
    public static function getTimetable($code)
    {
        // create json file under data-scraper-playwright/data/course.json with $code value
        // Create an array with the data
        $data = [
            'course' => $code,
        ];
        $jsonData = json_encode($data, JSON_PRETTY_PRINT);
        $filePath = base_path('app/Services/data-scraper-playwright/data/course.json');
        // Write the JSON data to the file
        File::put($filePath, $jsonData);

        //playwright test timetable.spec.ts
        $folder = __DIR__ . '/data-scraper-playwright';
        $output = '';

        // run works differently than start as it waits for the process to finish
        $process = Process::path($folder)->run('npm run timetable', function (string $type, string $buffer) use (&$output) {
            if (preg_match('/DATA:START(.*?)DATA:END/s', $buffer, $matches)) {
                $output .= $matches[1];
            }
        });
        return $output;
    }
}
