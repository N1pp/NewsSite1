<?php

use App\Image;
use App\Repositories\NewsRepository;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('test', function () {
    /*$arr[] = 10;
    $arr['id'] = 11;
    $arr[] = 12;
    $arr[] = 13;
    $arr['id'] = 1;*/
    $arr = array();
    $arr['id'] = 1;
    print_r($arr);
});
