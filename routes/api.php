<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Customer;
use App\Http\Controllers\Api\AnalysisController;
use Illuminate\Support\Facades\Log;


Route::middleware('auth:sanctum')
->get('/searchCustomers', function (Request $request) {
    return Customer::apiSearchCustomer($request->search);
        // ->withPath("/customers?search={$request->search}")
});


Route::middleware('auth:sanctum')
->get('/analysis', [AnalysisController::class, 'index'])
->name('api.analysis');



// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
