<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Cookie;
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
    /*$s = new App\Sub;
    $s->auth_id = 1;
    $s->user_id = 2;
    $s->save();*/
    $id = 2;
    //dd(App\Sub::where('user_id',$id)->get()->first());
    /*foreach (App\Sub::where('user_id',$id)->get() as $sub) {
        //dd($sub);
        $user = App\User::find($sub->auth_id);
        print_r($user->name);
    }*/
    print_r(App\Sub::where('user_id',$id)->get());
});
