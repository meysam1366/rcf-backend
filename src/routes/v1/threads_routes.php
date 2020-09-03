<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\v1\Thread\ThreadController;

Route::resource('threads','ThreadController');