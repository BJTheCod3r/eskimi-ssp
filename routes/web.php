<?php

declare(strict_types=1);

use App\Http\Controllers\CampaignController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('list');
});
Route::get("/new", [CampaignController::class, 'create']);
Route::get("/edit/{id}", [CampaignController::class, 'edit']);
