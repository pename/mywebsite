<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Member;


/**
 * Login controller
 *
 * PHP version 7.0
 */
class MembersController extends Controller
{

    public function logon(Request $request)
    {
        //$input = $request->all();
        $email = $request->input('email');
        $password = $request->input('password');
        $part = $request->input('part');
        $role = $request->input('role');
        //$results = DB::select('select * from members where id = :id', ['id' => 1]);
        $members = DB::table('members')->where('email', '=', $email)->where('is_actived','=',1)->where('part_id','=',$part)->where('role_id','=',$role)->get();
        
        
        if (count($members) == 1)
        {
            //echo "=======ready verify password======";
            

             if (password_verify($password, $members[0]->password_hash))
             {
                 
                 return $members[0]->id;
             }
            
            
            
        }
        
        return "fail";

    }
    
    public function signup(Request $request)
    {
      $user = new Member($request->input());
      // echo ;

         $password_hash = password_hash($user->password, PASSWORD_DEFAULT);

            if (DB::insert('insert into members (name,email,password_hash,phone) values (?, ? ,? ,?)', [$user->name, $user->email,$password_hash,$user->phone]))
            {
                
                 return "success";
            }
            else{
                return "fail";
                
            }


    }


}
