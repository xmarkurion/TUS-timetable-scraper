<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


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

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});
