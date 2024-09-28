<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MousesController extends Controller
{
    
    
    public function addMouse(Request $request)
    {
        //$input = $request->all();
        $tag = $request->input('tag');
        $sex = $request->input('sex');
        $gene = $request->input('gene');
        $cageid = $request->input('cageid');
        $father_id = $request->input('father_id');
        $mother_id = $request->input('mother_id');
        $birthday = $request->input('birthday');
        $fathername = $request->input('fathername');
        $mothername = $request->input('mothername');
        
        
        $genes = DB::table('gn_type')->where('name', '=', $gene)->get();
        
        
        if (count($genes)>0)
        {
            
            $gene =  $genes->pluck('id')[0];
        }
        else
        {
                try {
                $id = DB::table('gn_type')->insertGetId(
                    ['name' => $gene]
                );

                if ($id)
                {

                    $gene =  $id;
                }
                }
                catch(Exception $e) {

                    return "fail";
                }
            
        }
        
        
        
        
        try {
        $id = DB::table('mouses')->insertGetId(
            ['code' => $tag, 'sex' => $sex , 'gn' => $gene ,'cage_id' => $cageid ,'birthday' => $birthday,'father_id'=>$father_id,'mother_id'=>$mother_id ,'owner_id'=>0 ,'other_father'=>$fathername ,'other_mother'=>$mothername]
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
     
    public function getlastMouses()
    {


        $id = DB::table('mouses')->get();
        
        if (count($id) == 0) 
        {
            return 0;
        }
        else
        {
            return DB::table('mouses')->select('id')->orderBy('id',"DESC")->pluck('id')[0];
            
        }


        
     
    }
    
    
    
    
    public function getMouses(){
        //$cages = Cage::orderBy('tag','desc')-get;
        //$cages = DB::scalar("SELECT cages.id , cages.tag ,cages.serial , cages.type_id , COUNT(case when mouses.sex= 1 then 1 end) as male ,COUNT(case when mouses.sex= 2 then 1 end) as female FROM `cages` left join mouses on mouses.cage_id = cages.id group by cages.id");
        
        
        $mouses = DB::table('mouses')->get();
       return $mouses;
    }
    
    
    public function getMousesdetail()
    {
         $cages = DB::table('cages')
             ->where('cages.id', '<>', $cageid)
             ->Join('mouses', 'mouses.cage_id', '=', 'cages.id')
             ->select(DB::raw('cages.id , cages.tag ,cages.serial , cages.type_id , count(case when mouses.sex= 1 then 1 end) as male ,count(case when mouses.sex= 2 then 1 end) as female'))
             ->groupBy('cages.id')
             ->get();
       return $cages;
        
    }
    
        public function getMousesbyCagex(Request $request){
        //$cages = Cage::orderBy('tag','desc')-get;
        //$cages = DB::scalar("SELECT cages.id , cages.tag ,cages.serial , cages.type_id , COUNT(case when mouses.sex= 1 then 1 end) as male ,COUNT(case when mouses.sex= 2 then 1 end) as female FROM `cages` left join mouses on mouses.cage_id = cages.id group by cages.id");
        $cageid = $request->input('cageid');
        $mouses = DB::table('mouses as j')->where('j.cage_id', '=', $cageid)->get();
        return $mouses;
    }
    
    
    
         public function getMousesbyCage(Request $request)
     {
         
         $cageid = $request->input('cageid');
         $cages = DB::table('mouses as child')
             ->where('child.cage_id', '=', $cageid)
             ->leftJoin(DB::raw('mouses as father '), DB::raw('father.id'), '=', DB::raw('child.father_id'))
             ->leftJoin(DB::raw('mouses as mother '), DB::raw('mother.id'), '=', DB::raw('child.mother_id'))
             ->leftJoin(DB::raw('gn_type as gene '), DB::raw('child.gn'), '=', DB::raw('gene.id'))
             ->select(DB::raw('gene.name as gn , child.cage_id as cage_id ,child.id as id , child.code as code,child.sex  as sex, child.birthday as birthday, father.code as father_code , mother.code as mother_code '))
             ->get();
       return $cages; 
     }
    
          public function getgn(){
        //$cages = Cage::orderBy('tag','desc')-get;
        //$cages = DB::scalar("SELECT cages.id , cages.tag ,cages.serial , cages.type_id , COUNT(case when mouses.sex= 1 then 1 end) as male ,COUNT(case when mouses.sex= 2 then 1 end) as female FROM `cages` left join mouses on mouses.cage_id = cages.id group by cages.id");
        
        
        $gns = $genes = DB::table('gn_type')->get();
        return $gns;
    }
    
    
    public function cleartable()
    {
        try
        {
        DB::table('cages')->truncate();
        DB::table('mouses')->truncate();
        DB::table('gn_type')->truncate();
        
        }
            catch(Exception $e) {
            
            return "fail";
        }
        
        return "success";
        
    }
    
    
        public function getMaleMouses(){
        //$cages = Cage::orderBy('tag','desc')-get;
        //$cages = DB::scalar("SELECT cages.id , cages.tag ,cages.serial , cages.type_id , COUNT(case when mouses.sex= 1 then 1 end) as male ,COUNT(case when mouses.sex= 2 then 1 end) as female FROM `cages` left join mouses on mouses.cage_id = cages.id group by cages.id");
        
        
        $mouses = $genes = DB::table('mouses')->where('sex', '=', 1)->get();
        return $mouses;
    }
    
    
        public function getFeMaleMouses(){
        //$cages = Cage::orderBy('tag','desc')-get;
        //$cages = DB::scalar("SELECT cages.id , cages.tag ,cages.serial , cages.type_id , COUNT(case when mouses.sex= 1 then 1 end) as male ,COUNT(case when mouses.sex= 2 then 1 end) as female FROM `cages` left join mouses on mouses.cage_id = cages.id group by cages.id");
        
        
        $mouses = $genes = DB::table('mouses')->where('sex', '=', 2)->get();
       return $mouses;
    }
    
    public function moveMousetoCage(Request $request)
    {
        
        $mouseid = $request->input('mouseid');
        $cageid = $request->input('cageid');
        

        
        try
        {
        DB::table('mouses')
            ->where('id', $mouseid)
            ->update(['cage_id' => $cageid]);
        

        }catch(Exception $e) {
            
            return "fail";
        }
        
        return "success";
        
    }
}
