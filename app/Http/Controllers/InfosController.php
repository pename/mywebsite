<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;
use GuzzleHttp\Promise;
require 'jssdk.php';




class InfosController extends Controller
{
    private function getCurl($url ,$data) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); //不输出内容
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $data);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }


    private function getCurlNoParams($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); //不输出内容
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }


    private function postCurl($url ,$data) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); //不输出内容
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        $jsondata = json_encode($data);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsondata);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
    public function onlineinfo(){
        $infos = DB::table('infos')->get();
        return view('infos.onlineinfo' ,['infos' => $infos]);
    }
    
    public function find($id)
    {
        
        return $id;
        
    }
    
    
    public function show(){
        
        return view('infos.resume');
    }
    
    
    public function phpinfo(){
//        Cache::put('name','王晓春',7200);
 //       phpinfo();
//        $client = new Client([
//          // Base URI is used with relative requests
//          'base_uri' => 'http://www.baidu.com',
//          // You can set any number of default request options.
//          'timeout'  => 2.0,
//      ]);
//        $response = $client->request('GET');

        
        $client = new Client();
        $promises = [
        $client->getAsync('https://kaiqiu.cc/xcx/public/index.php/api/User/adv_profile?uid=386487')
                ->then(function ($response)
        { echo '10'; })];
        var_dump($promises);
        //$results = new \GuzzleHttp\Promise\unwrap($promises);
        //$results = new \GuzzleHttp\Promise\settle($promises->wait());
        //$request = new \GuzzleHttp\Psr7\Request('GET', 'https://kaiqiu.cc/xcx/public/index.php/api/User/adv_profile?uid=386487');
        //$promise = $client->sendAsync($request)->then(function ($response) {
        //   echo 'I completed! ';
        //});
        //$promise->wait();
        //phpinfo();
       // echo "finish/over." . PHP_EOL;";
        
    }
    
        public function uploadfile(){
        return view('infos.onlineinfo' ,['infos' => $infos]);
    }
    

        public function blog(){
        
        return view('infos.resume');
    }
    
            public function eng(){
        
        return view('infos.eng');
    }
    
    
            public function cn(){
        
        return view('infos.cn');
    }

    
    //     public function uploadfile(){
    //     return view('infos.onlineinfo' ,['infos' => $infos]);
    // }
    
        public function addInfo(){
   //     $infos = DB::table('infos')->get();
        return view('infos.addinfo');
    }

    
        
        public function addIotAccount(){
   //     $infos = DB::table('infos')->get();
        return view('infos.addiotaccount');
    }

    
    
    
    
    
    
    public function addIot(Request $request){
        $jssdk = new JSSDK("wx8a339e174f3421ae", "d9620e0a7cd468190dded9ad02abb9f3");  
        $signPackage = $jssdk->GetSignPackage();
        $auth_url = 'http://115.28.187.9:8005/login';
        $data = $this->postCurl($auth_url,array('username' => '038085860', 'password' => '123456'));
        $auth_result = json_decode($data, true);
        $token = $auth_result['token'];
        $iotinfo_url = 'http://115.28.187.9:8005/user/info';
        $data = $this->getCurl($iotinfo_url,array('token:'. $token));
        $info_result = json_decode($data, true);
        //return $info_result;
        return view('infos.addiot',['signPackage'=>$signPackage,'lat'=>$request->input('lat'),'lng'=>$request->input('lng'),'dts'=>$info_result['parkList'][0]['deviceTypeVoList']]);
    }
    
    public function insertInfo(Request $request){
        $tid = $request->input('tid');
        $nid = $request->input('nid');
        
        try {
        DB::table('infos')->insert(
            ['title' => $tid, 'content' => $nid]
        );

            
        return "success";

        }
        catch(\Illuminate\Database\QueryException $e) {
            
            return "fail";
        } 
      }
      
    public function insertIotAccount(Request $request){
        $tid = $request->input('tid');
        $nid = $request->input('nid');
        
        try {
        DB::table('iotaccount')->insert(
            ['id' => $tid, 'password' => $nid]
        );

            
        return "success";

        }
        catch(\Illuminate\Database\QueryException $e) {
            
            return "fail";
        } 
      }
    
    
    
    public function addIotRecord(Request $request){
        
        if ($request->input('checkmonitor'))
        {
        $deviceid = $request->input('deviceid');
        $owner = $request->input('owner');
        $ownername = $request->input('ownername');
        $devicename = $request->input('devicename');
        $phone = $request->input('phone');
        $devicetype = $request->input('devicetype');
        $lng = $request->input('lng');
        $vcode = $request->input('vcode');
        $deviceserial = $request->input('deviceserial');
        $lat = $request->input('lat');
        $product = $request->input('product');
        $address = $request->input('address');
        $factype = $request->input('factype');
        $ownertype = $request->input('ownertype');
        $support_company = $request->input('support_company');
        $support_owner = $request->input('support_owner');
        $support_phone = $request->input('support_phone');
        $scale = $request->input('scale');
        $province = $request->input('province');
        $city = $request->input('city');
        $area = $request->input('area');

        
        try {
        $id = DB::table('iotinfo')->insertGetId(
            ['deviceid' => $deviceid, 'owner' => $owner , 'ownername' =>$ownername, 'ownertype' => $ownertype ,'phone' => $phone,'devicetype' => $devicetype,'devicename'=>$devicename,'lng' => $lng,'lat' => $lat,'product' => $product,'address' => $address,'factype' => $factype,'support_company' => $support_company,'support_owner' => $support_owner,'support_phone' => $support_phone,'scale' => $scale,'province' => $province,'city' => $city,'area' => $area,'vcode' => $vcode,'deviceserial' => $deviceserial]
        );

        if ($id)
        {
            
            return "success";
        }
        else
        {
            return "fail";
            
        }
        }
        catch(\Illuminate\Database\QueryException $e) {
            
            return "fail";
        }    
            
        }
        else
        {
        $deviceid = $request->input('deviceid');
        $owner = $request->input('owner');
        $ownername = $request->input('ownername');
        $devicename = $request->input('devicename');
        $phone = $request->input('phone');
        $devicetype = $request->input('devicetype');
        $lng = $request->input('lng');
        $lat = $request->input('lat');
        $product = $request->input('product');
        $address = $request->input('address');
        $factype = $request->input('factype');
        $ownertype = $request->input('ownertype');
        $support_company = $request->input('support_company');
        $support_owner = $request->input('support_owner');
        $support_phone = $request->input('support_phone');
        $scale = $request->input('scale');
        $province = $request->input('province');
        $city = $request->input('city');
        $area = $request->input('area');

        
        try {
        $id = DB::table('iotinfo')->insertGetId(
            ['deviceid' => $deviceid, 'owner' => $owner , 'ownername' =>$ownername, 'ownertype' => $ownertype ,'phone' => $phone,'devicetype' => $devicetype,'devicename'=>$devicename,'lng' => $lng,'lat' => $lat,'product' => $product,'address' => $address,'factype' => $factype,'support_company' => $support_company,'support_owner' => $support_owner,'support_phone' => $support_phone,'scale' => $scale,'province' => $province,'city' => $city,'area' => $area]
        );

        if ($id)
        {
            
            return "success";
        }
        else
        {
            return "fail";
            
        }
        }
        catch(\Illuminate\Database\QueryException $e) {
            
            return "fail";
        }
        }
            
    }
        //return $info_result;
    
    


    public function iotInfo(){
        $iotparams_url = 'https://iot.whxph.com:44300/IOTapiv2/element';
        $iotaccs = DB::table('iotaccount')->get();
        $iotaccsjson = json_decode($iotaccs, true);
        $data = $this->getCurlNoParams($iotparams_url);
        $infos = json_decode($data, true);
        return view('infos.iotinfo',['dvs' => $infos,'acs' => $iotaccsjson]);
    }

    public function iotDetailsInfo(Request $request){
        $auth_url = 'https://iot.whxph.com:44300/'.$request->input('servertype').'/login';
        $data = $this->postCurl($auth_url,array('username' => $request->input('username'), 'password' => $request->input('password')));
        $auth_result = json_decode($data, true);
        $token = $auth_result['token'];
        $iotinfo_url = 'https://iot.whxph.com:44300/'.$request->input('servertype').'/user/info';
        $data = $this->getCurl($iotinfo_url,array('token:'. $token));
        $info_result = json_decode($data, true);
        return $info_result;
    }

    public function iotParamsInfo(Request $request){
        $auth_url = 'http://115.28.187.9:8005/login';
        $data = $this->postCurl($auth_url,array('username' => $request->input('username'), 'password' => $request->input('password')));
        $auth_result = json_decode($data, true);
        $token = $auth_result['token'];
        $iotparams_url = 'http://115.28.187.9:8005/element';
        $data = $this->getCurl($iotparams_url,array('token:'. $token));
        $params_result = json_decode($data, true);
        return $params_result;
    }

    public function iotDevicesInfo(Request $request){
        $auth_url = 'https://iot.whxph.com:44300/'.$request->input('servertype').'/login';
        $data = $this->postCurl($auth_url,array('username' => $request->input('username'), 'password' => $request->input('password')));
        $auth_result = json_decode($data, true);
        $token = $auth_result['token'];
        $iotdevices_url = 'https://iot.whxph.com:44300/'.$request->input('servertype').'/data/'.$request->input('deviceid');
        $data1 = $this->getCurl($iotdevices_url,array('token:'. $token));
        $devices_result = json_decode($data1, true);
        $iotconfigs_url = 'https://iot.whxph.com:44300/'.$request->input('servertype').'/user/'.$request->input('username');
        $data2 = $this->getCurl($iotconfigs_url,array('token:'. $token));
        $devices_config_result = json_decode($data2, true);
        return array('config'=>$devices_config_result ,'data'=>$devices_result);
    }
    public function iotpestDevicesInfo(Request $request){
        $auth_url = 'https://iot.whxph.com:44300/'.$request->input('servertype').'/login';
        $data = $this->postCurl($auth_url,array('username' => $request->input('username'), 'password' => $request->input('password')));
        $auth_result = json_decode($data, true);
        $token = $auth_result['token'];
        $iotdevices_url = 'https://iot.whxph.com:44300/'.$request->input('servertype').'/pest/dataextend/'.$request->input('deviceid');
        $data = $this->getCurlNoParams($iotdevices_url);
        $devices_result = json_decode($data, true);
        $iotconfigs_url = 'https://iot.whxph.com:44300/'.$request->input('servertype').'/pest/config/'.$request->input('deviceid');
        $data = $this->getCurlNoParams($iotconfigs_url);
        $devices_config_result = json_decode($data, true);
        return array('config'=>$devices_config_result ,'data'=>$devices_result);
    }


    public function iotpictureInfo(Request $request){
        $auth_url = 'https://iot.whxph.com:44300/'.$request->input('servertype').'/login';
        $data = $this->postCurl($auth_url,array('username' => $request->input('username'), 'password' => $request->input('password')));
        $auth_result = json_decode($data, true);
        $token = $auth_result['token'];
        $iotpicture_url = 'https://iot.whxph.com:44300/'.$request->input('servertype').'/photo/'.$request->input('deviceid').'?type=0&pageNum=1&pageSize=8';
        $data = $this->getCurl($iotpicture_url,array('token:'. $token));
        $devices_result = json_decode($data, true);
        return $devices_result;
    }
    
        public function iotpestpictureInfo(Request $request){
        $auth_url = 'https://iot.whxph.com:44300/'.$request->input('servertype').'/login';
        $data = $this->postCurl($auth_url,array('username' => $request->input('username'), 'password' => $request->input('password')));
        $auth_result = json_decode($data, true);
        $token = $auth_result['token'];
        $iotpestpicture_url = 'https://iot.whxph.com:44300/'.$request->input('servertype').'/pest/images/'.$request->input('deviceid').'?pageNum=1&pageSize=8';
        $data = $this->getCurlNoParams($iotpestpicture_url);
        $devices_result = json_decode($data, true);
        return $devices_result;
    }
    






    
        public function getParts(){
        $parts = DB::table('part')
             ->get();
       return $parts;
    }
    
    
        public function demo(){
        
        return view('infos.demo');
    }

            public function getFarms(Request $request){
                $name = $request->input('name');
        $farms = DB::table('farms')->where('name', '=', $name)->get();
             
       return $farms;
    }
            public function map(){
        
        return view('infos.map');
    }
}
