<?php

namespace App\Http\Controllers;

use App\Sub;
use Illuminate\Http\Request;

class SubsController extends Controller
{
    public function sub(Request $request){
        if($request->key == 1){
            $sub = new Sub;
            $sub->user_id = $request->user_id;
            $sub->auth_id = $request->auth_id;
            $sub->save();
        }else{
            Sub::where('user_id',$request->user_id)->where('auth_id',$request->auth_id)->delete();
        }
        return redirect()->back();
    }
}