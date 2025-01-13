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

        // check if this "If you see this all is good!" then scraper works
        if(Str::contains($output, 'If you see this all is good!')){
            echo 'Scraper works correctly';
            return "Check done. Rerun to make sure all works OK.";
        }

        // check if this "playwright: not found" ask user if it's okay to install requirements
        if(Str::contains($output, 'playwright: not found')){
            echo 'Playwright not found, do you want to install it? (y/n)';
            $handle = fopen ("php://stdin","r");
            $line = fgets($handle);
            if(trim($line) != 'y' && trim($line) != 'Y'){
                echo 'Exiting script will not work until playwright is installed...';
                exit;
            }
            echo 'Installing playwright...';
            $process = Process::path($folder)->start('npm install', function (string $type, string $buffer) use (&$output) {
                $output .= $buffer;
            });
            $process->wait();
        }

        // check if this "npx playwright install" ask user if it's okay to install requirements
        if(Str::contains($output, 'npx playwright install')){
            echo 'Playwright browser not installed, do you want to install them (y/n)';
            $handle = fopen ("php://stdin","r");
            $line = fgets($handle);
            if(trim($line) != 'y' && trim($line) != 'Y'){
                echo 'Exiting script will not work until playwright browsers are is installed...';
                exit;
            }
            echo 'Installing playwright browsers...';
            $process = Process::path($folder)->timeout(500)->start('npx playwright install', function (string $type, string $buffer) use (&$output) {
                $output .= $buffer;
            });
            $process->wait();
        }

        // check if this "Host system is missing dependencies to run browsers." ask user if it's okay to install requirements
        if(Str::contains($output, 'Host system is missing dependencies to run browsers.')){
            echo 'Host system is missing dependencies to run browsers, do you want to install them (y/n)';
            $handle = fopen ("php://stdin","r");
            $line = fgets($handle);
            if(trim($line) != 'y' && trim($line) != 'Y'){
                echo 'Exiting script will not work until playwright browsers are working.';
                exit;
            }
            echo 'Installing playwright browsers...';
            $process = Process::path($folder)->timeout(500)->start('sudo npx playwright install-deps', function (string $type, string $buffer) {
                echo $buffer;
            });
            $process->wait();
        }

        echo 'Checks successfully completed, scraper should work correctly';
        return "Check done. Rerun to make sure all works OK.";
    }

    public static function gatherCourses()
    {
        $folder = __DIR__ . '/data-scraper-playwright';
        $output = '';

        $process = Process::path($folder)->start('npm run courses', function (string $type, string $buffer) use (&$output) {
            echo $buffer;
            $output .= $buffer;
        });

        // awaits process termination
        $result = $process->wait();

        // from output get only the data between DATA:START and DATA:END
        if (preg_match('/DATA:START(.*?)DATA:END/s', $output, $matches)) {
            $output = $matches[1];
        }

        // Check if there is any data
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
                dump('Course ' . $course['code'] . ' added to database');
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

        $process = Process::path($folder)->run('npm run timetable', function (string $type, string $buffer) use (&$output) {
            echo $buffer;
            $output .= $buffer;
        });

        $process->wait();

        // match text from DATA:START to DATA:END
        if (preg_match('/DATA:START(.*?)DATA:END/s', $output, $matches)) {
            return $matches[1];
        }
    }
}
