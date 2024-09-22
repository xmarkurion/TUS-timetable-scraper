<?php

use App\Http\Controllers\TimetableController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;

// Authentication for new api key
// Call this as body in postman
Route::post('/key', function (Request $request) {
    if($request->device_name == null) {
        return response()->json([
            'error' => 'Device name is required'
        ], 401);
    }

    $crededentials = $request->only('email', 'password');
    if(!auth()->attempt($crededentials)){
        return response()->json([
            'error' => 'Invalid credentials'
        ], 401);
    }else{
        $token_name = $request->device_name;
        $token = $request->user()->createToken($token_name);
        return response()->json([
            'token' => $token->plainTextToken
        ]);
    }
});

// Api authenticated user data.
//
// To get this data you need to pass the token as a header
// Authorization Bearer <token>
Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});


Route::middleware('auth:sanctum')->group( function () {
    //new group function for course controller
    Route::group(['prefix' => 'courses'], function () {
        Route::get('/', [CourseController::class, 'index']);

        // code, active in post
        Route::post('/set/active', [CourseController::class, 'updateActive']);
    });

    Route::group(['prefix' => 'timetable'], function () {
        Route::post('/store', [TimetableController::class, 'store']);
        Route::get('/storeAll', [TimetableController::class, 'storeAllActive']);
        Route::get('', [TimetableController::class, 'show']);
    });
});


// Public routes
Route::group(['prefix' => 'timetable'], function () {
    Route::get('', [TimetableController::class, 'show']);
});
Route::group(['prefix' => 'courses'], function () {
    Route::get('/active', [CourseController::class, 'indexActive']);
});

