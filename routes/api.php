<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientApi;

Route::post('sendInvitation', [ClientApi::class, 'sendInvitation']);
Route::post('getLayout', [ClientApi::class, 'getLayout']);
Route::post('deleteRecord', [ClientApi::class, 'deleteRecord']);


