<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mp3;


class Mp3sController extends Controller
{
        public function mp3(){
        
        //return Mp3::getallfiles();
        //$tmp = Mp3::getallfiles();

            
        //return Mp3::getallfiles();
        return view('mp3s.mp3' ,['mp3s' => Mp3::getallfiles()]);
            
            //return Mp3::getallfiles();
        
            //var_dump($tmp);
            

    }
    
    public function mp3list(){
        
        //return Mp3::getallfiles();
        
        
        return Mp3::getallfileswithkey();
    }
    
    
    public function RemoveMp3(Request $request)
    {
        
        return Mp3::removemp3($request->input('name'));
        
    }
}
