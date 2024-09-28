<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;



class CagesController extends Controller
{
    public function index(){
        $cages = Cage::orderBy('tag','desc')-get;
        $cages = DB::table('cages')->get();
        return $cages;
        
        
    }
    
    public function getsporter(Request $request){
        $cages = Cage::orderBy('tag','desc')-get;
        $cages = DB::table('cages')->get();
        return $cages;
        
        
    }
    
    public function getCages(){
        //$cages = Cage::orderBy('tag','desc')-get;
        //$cages = DB::scalar("SELECT cages.id , cages.tag ,cages.serial , cages.type_id , COUNT(case when mouses.sex= 1 then 1 end) as male ,COUNT(case when mouses.sex= 2 then 1 end) as female FROM `cages` left join mouses on mouses.cage_id = cages.id group by cages.id");
        
        
        $cages = DB::table('cages')
             ->leftJoin('mouses', 'mouses.cage_id', '=', 'cages.id')
             ->select(DB::raw('cages.id , cages.tag ,cages.serial , cages.type_id , cages.created_at ,count(case when mouses.sex= 1 then 1 end) as male ,count(case when mouses.sex= 2 then 1 end) as female'))
             ->groupBy('cages.id')
             ->get();
       return $cages;
    }
    
        public function getCageType(Request $request){

        $cagetypes = DB::table('cage_type')
             ->get();
       return $cagetypes;
    }
    
    
    
    public function about(){
        $infos = DB::table('infos')->get();
        return view('infos.onlineinfo' ,['infos' => $infos]);
        //return view('user.index', ['users' => $users]);
    }
    
    public function orderlist()
    {
            $url = "https://api.dinghuo123.com/v2/oauth2/token?userName=tzwxg&password=WangXG3916&client_id=6009739&client_secret=cWDP9WplS76CkGcGyAcjxGiMQ9RFsRVC&grant_type=client_credentials&scope=basic";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); //decide if display 
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Accept: application/json'));
            $output = curl_exec($ch);
            $arrays = json_decode($output, true); //remove 5 chars prefix
            $listurl = "https://api.dinghuo123.com/v2/order/pull_order.json?access_token=".$arrays["data"]["access_token"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
            curl_setopt($ch, CURLOPT_URL, $listurl);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Accept: application/json'));
            $output = curl_exec($ch);
            $arrays = json_decode($output, true); //remove 5 chars prefix
            curl_close($ch);
            return $arrays;
    }
 
    
    
        
        public function geekslist()
    {
            $url = "http://www.geeksforgeeks.org";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, false); //decide if display 
            //curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Accept: application/json'));
            $output = curl_exec($ch);
            echo $output;
    }
    
    
     public function getCagesbyCage(Request $request)
     {
         
         $cageid = $request->input('cageid');
         $cages = DB::table('cages')
             ->where('cages.id', '<>', $cageid)
             ->leftJoin('mouses', 'mouses.cage_id', '=', 'cages.id')
             ->select(DB::raw('cages.id , cages.tag ,cages.serial , cages.type_id , cages.created_at, count(case when mouses.sex= 1 then 1 end) as male ,count(case when mouses.sex= 2 then 1 end) as female'))
             ->groupBy('cages.id')
             ->get();
       return $cages; 
     }
    
    public function addCage(Request $request)
    {
        //$input = $request->all();
        $tag = $request->input('tag');
        $serial = $request->input('serial');
        $typeid = $request->input('type_id');
        $datetime = $request->input('datetime');
        $apname = $request->input('apname');
        
        try {
        $id = DB::table('cages')->insertGetId(
            ['tag' => $tag, 'serial' => $serial , 'type_id' => $typeid ,'created_at' => $datetime,'room_id'=>0,'note'=>'','part_id'=>0,'member_id'=>0 ,'apname'=>$apname]
        );

        if ($id)
        {
            
            return "success";
        }
        }
        catch(Exception $e) {
            
            return "fail";
        }
        
        
     }
     
    public function getlastCages()
    {


        $id = DB::table('cages')->get();
        
        if (count($id) == 0) 
        {
            return 0;
        }
        else
        {
            return DB::table('cages')->select('id')->orderBy('id',"DESC")->pluck('id')[0];
            
        }


        
     
    }
     
        

}

    
