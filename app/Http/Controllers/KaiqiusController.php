<?php



namespace App\Http\Controllers;
use Illuminate\Http\Request;


require 'jssdk.php';




class KaiqiusController extends Controller
{
    private function getCurl($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //不输出内容  
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
    
    public function getUserList(Request $request)
    {
        
        $url = 'https://kaiqiu.cc/xcx/public/index.php/api/user/lists?key='.$request->input('name');
        $data = $this->getCurl($url);
        $resultArr = json_decode($data, true);
        $date = new \DateTime();

        
        // 获取当前年份
        $currentYear = $date->format('Y');     
        $ul = array();
        for ($i = 1; $i < $resultArr['data']['last_page']+1;$i++) {
            $url1 = 'https://kaiqiu.cc/xcx/public/index.php/api/user/lists?page='.strval($i).'&key='.$request->input('name');
            $data1 = $this->getCurl($url1);
            $resultArr1 = json_decode($data1, true);
           
            foreach ($resultArr1['data']['data'] as $value)
            {        
                    $url2 = 'https://kaiqiu.cc/xcx/public/index.php/api/User/adv_profile?uid='.strval($value['uid']);
                    
//                    $client = new Client();
//                    $request1 = new \GuzzleHttp\Psr7\Request('GET', $url2);
//                    $promise = $client->sendAsync($request1)->then(function ($response)  use($value,$currentYear,$ul){
//                    $resultArr2 = json_decode((string) $response->getBody(), true);
//                    
//                    $value['age'] = ($value['birthyear']>0) ? strval($currentYear-$value['birthyear']):'未知';
//                    $value['bg']= $resultArr2['data']['bg'];  
//                    
//                    array_push($ul,$value);                  
//                    });
//                    $promise->wait();
                    

                    $data2 = $this->getCurl($url2);
                    $resultArr2 = json_decode($data2, true);
                    $value['age'] = ($value['birthyear']>0) ? strval($currentYear-$value['birthyear']):'未知';
                    $value['bg']= $resultArr2['data']['bg'];  
                    array_push($ul,$value);                  
            }
        }
        
        

        $sort = array_column($ul, 'score');
        array_multisort($sort,SORT_DESC,$ul);
        $jssdk = new JSSDK("wx8a339e174f3421ae", "d9620e0a7cd468190dded9ad02abb9f3");  
        $signPackage = $jssdk->GetSignPackage();
        return view('infos.kaiqiuinfo' ,['uls' => $ul,'rn'=>$request->input('name'),'signPackage'=>$signPackage]);
        
        
        
    }
    
        public function getTicket()
    {
        
//        $url = 'https://kaiqiu.cc/xcx/public/index.php/api/user/lists?key='.$request->input('name');
//        $data = $this->getCurl($url);
//        $resultArr = json_decode($data, true);
//        $ul = array();
//        for ($i = 0; $i < $resultArr['data']['last_page'];$i++) {
//            $url1 = 'https://kaiqiu.cc/xcx/public/index.php/api/user/lists?page='.strval($i).'&key='.$request->input('name');
//            $data = $this->getCurl($url1);
//            $resultArr = json_decode($data, true);
//            foreach ($resultArr['data']['data'] as $value)
//            {
//                array_push($ul,$value);  
//                
//            }
//
//        }

            
        $jssdk = new JSSDK("wx8a339e174f3421ae", "d9620e0a7cd468190dded9ad02abb9f3");
            
        $signPackage = $jssdk->GetSignPackage();
        var_dump($signPackage);

        return view('infos.jssdknfo' ,['signPackage'=>$signPackage]);
        
        
    }
    
}