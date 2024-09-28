<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use EasyWeChat\Factory;
use EasyWeChat\Kernel\Messages\Text;
use EasyWeChat\Kernel\Messages\Article;
use EasyWeChat\Kernel\Messages\News;
use EasyWeChat\Kernel\Messages\NewsItem;
use Illuminate\Support\Facades\DB;
use App\Models\Player;
use App\Models\Issue;


class WeChatController extends Controller
{
    public function convertCDataToString($cdata) {
    return str_replace(array('<![CDATA[', ']]>'), '', $cdata);
    }
    
    
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
    
     public function serve()
    {
        //Log::info('request arrived.'); 
//正式号
        $config = [
        'app_id' => 'wx8a339e174f3421ae',
        'secret' => 'd9620e0a7cd468190dded9ad02abb9f3',
        'token' => 'jjcodepename',
        'response_type' => 'array',
        'log'=> [
            
            'level' => 'debug',
            'file'  => __DIR__.'/../../../easywechat.log',
        ],
    //...
    ];
        //测试号
//        $config = [
//        'app_id' => 'wx5ccf4c6510fba3a5',
//        'secret' => '930061bdb4ae60b8608971398bf1be41',
//        'token' => '6z7n9vutq',
//        'response_type' => 'array',
//    //...
//    ];
        //$config = require __DIR__ .'/../../../config/wechat.php';
 //       $app = app('wechat.official_account.default');
        
        
        $configx = config('wechat.official_account');
        
        //dd($configx);

        //$app = Factory::officialAccount($configx['default']);
        $app = Factory::officialAccount($config);
        
        $buttons = [
    [
        "type" => "click",
        "name" => "比赛报名",
        "key"  => "V1001_GAME_JOIN"
    ],
    [
        "type" => "view",
        "name" => "比赛创建",
        "url"  => "https://20x6107t4.oicp.vip/addgame"
    ],
                [
        "type" => "click",
        "name" => "比赛通知",
        "key"  => "V1001_GAME_Notify"
    ]
];
$app->menu->create($buttons);

$app->server->push(function ($message)use ($app) {
 switch ($message['MsgType']) {
        case 'event':
            switch ($message['Event'])
            {
               case 'CLICK':
                    switch ($message['EventKey'])
                        {   
                            case 'V1001_GAME_JOIN':
                                //$res =$app->user->get($message['FromUserName']);
//                                $items = [
//                                            new NewsItem([
//                                                'title'       => '新增该点iot信息',
//                                                'description' => '此处iot信息',
//                                                'url'         => 'https://20x6107t4.oicp.vip/addgame?openid='.$message['FromUserName'],
//                                                'image'       => 'http://mmbiz.qpic.cn/sz_mmbiz_jpg/AW3q5QQR1rWCjpJ6gxJgYy1Wibic5udf8QiadJfaeCBFhK6XEqqzBeXFDX4ca3uBVAtHBFD39K9St0ol8uXurXMoA/0',
//                                                // ...
//                                            ]),
//                                        ];
//                                
//                                Log::info('新增该点iot信息'.$message['FromUserName']); 
//                                return new News($items);
                                return  ;
                            case 'V1001_GAME_CREATE':
                                //$res =$app->user->get($message['FromUserName']);
                                Log::info('创建比赛'.$message['FromUserName']); 
                                return ;
                            case 'V1001_GAME_Notify':
//                                $ret = $app->broadcasting->sendText("大家好！欢迎使用比赛系统。");
//                                if ($ret['errcode'] == 0)
//                                    return '通知发送成功';
//                                return '群发消息次数限制，请明天再发';
                            case 'V1001_GOOD':
                                return '收到点赞';
                            default:
                                return '无效点击';
                   
                        }
                    
                   
                   break;
                case 'subscribe':
                    Log::info('注册通知'); 
//                    $player = Player::
                    return '感谢'.$message['FromUserName'].'关注，谢谢';
                    
                    
                    
                    
               default:
                   return '无效点击';
                   

            }       
            break;
        case 'text':
            switch ($message['Content'])
            {
            
//               case 'ems':
//                                $items = [
//                                            new NewsItem([
//                                                'title'       => '当前比赛',
//                                                'description' => '本周赛事',
//                                                'url'         => 'https://20x6107t4.oicp.vip/addgame?openid='.$message['FromUserName'],
//                                                'image'       => 'http://mmbiz.qpic.cn/sz_mmbiz_jpg/AW3q5QQR1rWCjpJ6gxJgYy1Wibic5udf8QiadJfaeCBFhK6XEqqzBeXFDX4ca3uBVAtHBFD39K9St0ol8uXurXMoA/0',
//                                                // ...
//                                            ]),
//                                        ];
//                                
//                                Log::info('参加比赛'.$message['FromUserName']); 
//                                return new News($items);
                                
               default:
//                   $response = Http::get('https://kaiqiu.cc/xcx/public/index.php/api/user/lists?key='.$message['Content']);
                   $url = 'https://kaiqiu.cc/xcx/public/index.php/api/user/lists?key='.$message['Content'];
                   $data = $this->getCurl($url);
                   $resultArr = json_decode($data, true);
//                   Log::info($app->template_message->getPrivateTemplates());
//                   $text = new Text();
//                   $text->content = '您好！该姓名人数为'.$resultArr['data']['total'].'人';
//                   $data = json_decode($response, true); 
//                   return new Text('您好！该姓名人数为'.$resultArr['data']['total'].'\人');
                    if ($resultArr['msg'] =="您输入的字太少")
                        {
                        return new Text($resultArr['msg']);
                        }
                    else
                                {
                                $items = [
                                            new NewsItem([
                                                'title'       => '该姓名目前有'.$resultArr['data']['total'].'人',
                                                'description' => '详细积分情况',
                                                'url'         => 'https://20x6107t4.oicp.vip/getUserList?name='.$message['Content'],
                                                'image'       => 'http://mmbiz.qpic.cn/sz_mmbiz_jpg/AW3q5QQR1rWCjpJ6gxJgYy1Wibic5udf8QiadJfaeCBFhK6XEqqzBeXFDX4ca3uBVAtHBFD39K9St0ol8uXurXMoA/0',
                                                // ...
                                            ]),
                                        ];
                                
                                Log::info('参加比赛'.$message['FromUserName']); 
                                return new News($items);
                                }
                   

            }
            break;
        case 'image':
            return '收到图片消息'.$message['PicUrl'];
           
        case 'voice':
            return '收到语音消息';
            
        case 'video':
            return '收到视频消息';
            
        case 'location':
                            $items = [
                                            new NewsItem([
                                                'title'       => '新增该点iot信息',
                                                'description' => '此处iot信息',
                                                'url'         => 'https://20x6107t4.oicp.vip/addIot?lat='.$message['Location_X'].'&lng='.$message['Location_Y'],
                                                'image'       => 'http://47.105.215.208:8081/images/onstage/logo_white.png',
                                                // ...
                                            ]),
                                        ];
                                
                                Log::info('新增该点iot信息'.$message['FromUserName']); 
                                return new News($items);

            
        case 'link':
            return '收到链接消息';
            
        case 'file':
            return '收到文件消息';
        // ... 其它消息
        default:
            return '收到其它消息';
           
    }


});
$response = $app->server->serve();
return $response;

}
}
