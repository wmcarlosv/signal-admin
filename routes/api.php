<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::get('/categories',[ApiController::class,'categories'])->name('categories');
Route::get('/signals/{category_id}',[ApiController::class,'signals'])->name('signals');
Route::get('/signal/{id}',[ApiController::class,'signal'])->name('signal');
Route::post('/student',[ApiController::class,'studentStore'])->name('studentStore');
Route::get('/get-questions',[ApiController::class,'get_questions'])->name('get_questions');

Route::post('/student-answers',[ApiController::class,'student_answers'])->name('student_answers');