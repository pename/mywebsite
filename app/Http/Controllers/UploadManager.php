<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * Description of UploadManager
 *
 * @author chriswang
 */
class UploadManager extends Controller {
    //put your code here
    
    
    function upload()
    {
        return view('upload');
         
    }
    
    function uploadPost(Request $request)
    {
        
        if (!$request->hasFile('file'))
        {
            return response()->json(['message'=>'没有文件上传'],422);
            
        }
        
        if (!$request->file->isValid('file'))
        {
            return response()->json(['message'=>'文件上传过程失败'],422);
            
        }
        
        $allowfileformat = ['image/jpeg','image/png','image/gif','audio/mpeg'];
        $fileformat = $request->file->getMimeType();
        if (!in_array($fileformat,$allowfileformat))
        {
             return response()->json(['message'=>$fileformat.'文件类型不允许'],422);
            
        }
        $file = $request->file;
        echo 'File Name:' . $file->getClientOriginalName();
       echo '<br>';
       echo 'File Extension Name:' . $file->getClientOriginalExtension();
       echo '<br>';
       echo 'File Directory Name:' . $file->getRealPath();
       echo '<br>';
       echo 'File Size:' . $file->getSize();
       echo '<br>';
        echo 'File Format:' . $file->getMimeType();
        echo 'File Date:' .filectime($file) ;
       echo 'File Link is :https://20x6107t4.oicp.vip/storage/'.$file->getClientOriginalName();
        echo '<br>';
    //   Storage::move($file->getRealPath().'/'.$file->getClientOriginalName(), $file->getClientOriginalName());
         if(move_uploaded_file($file->getRealPath(), "/www/wwwroot/www.pename.site/mywebsite/storage/app/public/" . $file->getClientOriginalName()))
         {
         return '文件上传成功';
         }
        else{   
           echo '文件上传失败';
         }
    }
}
