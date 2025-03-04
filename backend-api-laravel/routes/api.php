<?php

use App\Http\Controllers\CsrfTokenController;
use App\Http\Controllers\RequestTableController;
use App\Http\Controllers\TimetableController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;


// Authentication for new api key
// Call this as body in postman
Route::post('/key', function (Request $request) {
    if($request->device_name == null) {
        return response()->json(['error' => 'Device name is required'], 401);
    }

    $credentials = $request->only('email', 'password');

    if (!auth()->attempt($credentials)) {
        return response()->json(['error' => 'Invalid credentials'], 401);
    }

    //check if token name is in personal_access_tokens table
    $token = $request->user()->tokens()->where('name', $request->device_name)->first();

    // if name is in personal_access_tokens table, return the token, and note that the token is the same

    if($token){
        return response()->json([
            'message' => 'Token already exists create new name or delete the old one'
        ]);
    }

    //if name is not in personal_access_tokens table, create a new token
   $token = $request->user()->createToken($request->device_name);
    return response()->json(['token' => $token->plainTextToken]);

});

// Api authenticated user data.
//
//Route to get csrf token
Route::middleware(['web'])->group(function () {
    Route::get('/csrf-token', [CsrfTokenController::class, 'show']);
});

// To get this data you need to pass the token as a header
// Authorization Bearer <token>
Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});


Route::middleware('auth:sanctum')->group( function () {
    //new group function for course controller
    Route::group(['prefix' => 'courses'], function () {

        // code, active in post
        Route::post('/set/active', [CourseController::class, 'updateActive']);
    });

    Route::group(['prefix' => 'timetable'], function () {
        Route::post('/store', [TimetableController::class, 'store']);
        Route::get('/storeAll', [TimetableController::class, 'storeAllActive']);
        Route::get('', [TimetableController::class, 'show']);
    });

    Route::group(['prefix' => 'requests'], function () {
        Route::get('', [RequestTableController::class, 'showPendingRequests']);
        Route::get('/accept', [RequestTableController::class, 'acceptAllRequests']);
        Route::post('/accept', [RequestTableController::class, 'acceptSelectedIdRequest']);
    });
});


// Public routes for timetable
Route::group(['prefix' => 'timetable'], function () {
    Route::get('', [TimetableController::class, 'show']);
});

// Public routes for courses
Route::group(['prefix' => 'courses'], function () {
    Route::get('/', [CourseController::class, 'index']);
    Route::get('/active', [CourseController::class, 'indexActive']);
    Route::post('/request', [RequestTableController::class, 'store']);
});

