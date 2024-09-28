<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use ConsoleTVs\Charts\Classes\Chartjs\Chart;




class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
  public function index()
  
    {

     $chart = new Chart;
    //  var_dump($return);
     $chart->labels(['One', 'Two', 'Three', 'Four']);
     $chart->dataset('My dataset', 'line', [1, 2, 3, 4]);
     $chart->dataset('My dataset 2', 'line', [4, 3, 2, 1]);   
        
        return view('infos.chartinfo', ['chart' => $chart]);
    }
    
    public function addgame()
  
    {

     $chart = new Chart;
    //  var_dump($return);
     $chart->labels(['One', 'Two', 'Three', 'Four']);
     $chart->dataset('My dataset', 'line', [1, 2, 3, 4]);
     $chart->dataset('My dataset 2', 'line', [4, 3, 2, 1]);   
        
        return view('infos.addgame');
    }
    
    
    
      public function Excel()
    {
        $spreadsheet = new Spreadsheet();
        $sheet0 = new Worksheet($spreadsheet,'主体信息统计表');
        $sheet1 = new Worksheet($spreadsheet,'物联网监测设备');
        $sheet2 = new Worksheet($spreadsheet,'视频监控设备');
        $spreadsheet->addSheet($sheet0,0);
        $spreadsheet->addSheet($sheet1,1);
        $spreadsheet->addSheet($sheet2,2);
        $timestamp = time();
        $spreadsheet->setActiveSheetIndex(1);
        $sheet0->setCellValue('A1', '序号');
        $sheet0->setCellValue('B1', '主体名称');
        $sheet0->setCellValue('C1', '应用领域');
        $sheet0->setCellValue('D1', '农产品生产（加工）产品');
        $sheet0->setCellValue('E1', '生产规模');
        $sheet0->setCellValue('F1', '联系人姓名');
        $sheet0->setCellValue('G1', '联系人电话');
        $sheet0->setCellValue('H1', '生产基地经纬度');
        $sheet0->setCellValue('I1', '主体地址');
        $sheet0->setCellValue('J1', '主体类别');
        $sheet0->setCellValue('K1', '支撑单位名称');
        $sheet0->setCellValue('L1', '支撑单位联系人');
        $sheet0->setCellValue('M1', '支撑单位联系电话');
        $sheet0->setCellValue('N1', '简介（可输入主体的生产情况、地理位置、种养品种、生产效益等）');
        $sheet0->setCellValue('O1', '图片（非必填）');
        
        $sheet1->setCellValue('A1', '序号');
        $sheet1->setCellValue('B1', '主体名称');
        $sheet1->setCellValue('C1', '设备名称');
        $sheet1->setCellValue('D1', '设备编码');
        $sheet1->setCellValue('E1', '安装位置经纬度');
        $sheet1->setCellValue('F1', '应用领域');
        $sheet1->setCellValue('G1', '设备类型');
        $sheet1->setCellValue('H1', '对接人姓名');
        $sheet1->setCellValue('I1', '对接人联系电话');
        $sheet1->setCellValue('J1', '设备所在单元名称');
        $sheet1->setCellValue('K1', '监测农产品');
        $sheet1->setCellValue('L1', '监控参数');

        
        $sheet2->setCellValue('A1', '序号');
        $sheet2->setCellValue('B1', '主体名称');
        $sheet2->setCellValue('C1', '摄像头名称');
        $sheet2->setCellValue('D1', '摄像头编码');
        $sheet2->setCellValue('E1', '安装位置经纬度');
        $sheet1->setCellValue('F1', '设备所在单元名称');
        $sheet1->setCellValue('G1', '监测农产品');
        $sheet1->setCellValue('H1', '流媒体地址');
        
        $iotinfo = DB::table('iotinfo')->distinct()->where('devicetype', '<>', '摄像头')->get();
        
        
        $letter = [];
        
        if (count($iotinfo) > 0)
            
        {
            
            
            
        }
//        for ($x = 1; $x < count($iotinfo)+1; $x++) {
//            array_push($letter, ($firstLetter++).(string)($x+1));
//        }
//        
//        return $letter;
        
        for ($i = 0; $i < count($iotinfo);$i++) {
            $firstLetter = 'A';
             $sheet0->setCellValue($firstLetter.(string)($i+2),$i+1);
             $sheet0->setCellValue(++$firstLetter.(string)($i+2),$iotinfo[$i]->owner);
             $sheet0->setCellValue(++$firstLetter.(string)($i+2),$iotinfo[$i]->factype);
             $sheet0->setCellValue(++$firstLetter.(string)($i+2),$iotinfo[$i]->product);
             $sheet0->setCellValue(++$firstLetter.(string)($i+2),$iotinfo[$i]->scale);
             $sheet0->setCellValue(++$firstLetter.(string)($i+2),$iotinfo[$i]->ownername);
             $sheet0->setCellValue(++$firstLetter.(string)($i+2),$iotinfo[$i]->phone);
             $sheet0->setCellValue(++$firstLetter.(string)($i+2),$iotinfo[$i]->lng.','.$iotinfo[$i]->lat);
             $sheet0->setCellValue(++$firstLetter.(string)($i+2),$iotinfo[$i]->address);
             $sheet0->setCellValue(++$firstLetter.(string)($i+2),$iotinfo[$i]->ownertype);
             $sheet0->setCellValue(++$firstLetter.(string)($i+2),$iotinfo[$i]->support_company);
             $sheet0->setCellValue(++$firstLetter.(string)($i+2),$iotinfo[$i]->support_owner);
             $sheet0->setCellValue(++$firstLetter.(string)($i+2),$iotinfo[$i]->support_phone);
             //$firstLetter++;
            
            
         }

        for ($i = 0; $i < count($iotinfo);$i++) {
            $firstLetter = 'A';
             $sheet1->setCellValue($firstLetter.(string)($i+2),$i+1);
             $sheet1->setCellValue(++$firstLetter.(string)($i+2),$iotinfo[$i]->owner);
             $sheet1->setCellValue(++$firstLetter.(string)($i+2),$iotinfo[$i]->factype);
             $sheet1->setCellValue(++$firstLetter.(string)($i+2),$iotinfo[$i]->product);
             $sheet1->setCellValue(++$firstLetter.(string)($i+2),$iotinfo[$i]->scale);
             $sheet1->setCellValue(++$firstLetter.(string)($i+2),$iotinfo[$i]->ownername);
             $sheet1->setCellValue(++$firstLetter.(string)($i+2),$iotinfo[$i]->phone);
             $sheet1->setCellValue(++$firstLetter.(string)($i+2),$iotinfo[$i]->lng.','.$iotinfo[$i]->lat);
             $sheet1->setCellValue(++$firstLetter.(string)($i+2),$iotinfo[$i]->address);
             $sheet1->setCellValue(++$firstLetter.(string)($i+2),$iotinfo[$i]->ownertype);
             $sheet1->setCellValue(++$firstLetter.(string)($i+2),$iotinfo[$i]->support_company);
             $sheet1->setCellValue(++$firstLetter.(string)($i+2),$iotinfo[$i]->support_owner);
             $sheet1->setCellValue(++$firstLetter.(string)($i+2),$iotinfo[$i]->support_phone);
             //$firstLetter++;
            
            
         }
        $camerainfo = DB::table('iotinfo')->distinct()->where('devicetype', '摄像头')->get();
        
        for ($i = 0; $i < count($camerainfo);$i++) {
            $firstLetter = 'A';
             $sheet2->setCellValue($firstLetter.(string)($i+2),$i+1);
             $sheet2->setCellValue(++$firstLetter.(string)($i+2),$iotinfo[$i]->owner);
             $sheet2->setCellValue(++$firstLetter.(string)($i+2),$iotinfo[$i]->devicename);
             $sheet2->setCellValue(++$firstLetter.(string)($i+2),$iotinfo[$i]->scale);
             $sheet2->setCellValue(++$firstLetter.(string)($i+2),$iotinfo[$i]->ownername);
             $sheet2->setCellValue(++$firstLetter.(string)($i+2),$iotinfo[$i]->phone);
             $sheet2->setCellValue(++$firstLetter.(string)($i+2),$iotinfo[$i]->lng.','.$iotinfo[$i]->lat);
             $sheet2->setCellValue(++$firstLetter.(string)($i+2),$iotinfo[$i]->address);
             $sheet2->setCellValue(++$firstLetter.(string)($i+2),$iotinfo[$i]->ownertype);
             $sheet2->setCellValue(++$firstLetter.(string)($i+2),$iotinfo[$i]->support_company);
             $sheet2->setCellValue(++$firstLetter.(string)($i+2),$iotinfo[$i]->support_owner);
             $sheet2->setCellValue(++$firstLetter.(string)($i+2),$iotinfo[$i]->support_phone);
   
            
         }
        
        
        
        $writer = new Xlsx($spreadsheet);
        $writer->save($timestamp.'.xls');
        header('Content-Type:application/vnd.ms-excel');
        header('Content-Disposition:attachment;filename='.$timestamp.'.xls');
        header('Cache-Control:max-age=0');
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xls');
        $writer->save('php://output');
        return 'Excel document created successfully';
    }
    
    
    public function Word() 
    {
    // 创建一个新的Word文档
    $phpWord = new PhpWord();
 
    // 添加一个新的段落
    $section = $phpWord->addSection();
    $section->addText('Hello, World!');
 
    // 写入文件
    $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
    $objWriter->save('hello_world.docx');
 
    return 'Word document created successfully';
    }
    
}

