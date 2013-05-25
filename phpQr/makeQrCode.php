<?php
   include('./lib/phpqrcode/qrlib.php');
 
     
      $code_type = $_POST['type'];
      if($code_type ==null)
      {
         $code_type = 'URL';//replace url
      }
     
      if($_POST['info']!=null)
      {
         if($code_type == 'URL')
         {
            $data = 'MEBKM:URL\:';
         }
         $data .= $_POST['info'];
      }
      else
      {
         $data = 'wwwww';
      }
      // $data = 'JOUHU:CROP;ID:'.$code['id'].';NUM:'.$code['sequence_num'];  
      if(isset($_GET['black']) && $_GET['black'] == true)
      {
         $backColor = 0xFFFFFF;
         $foreColor = 0x000000;
      }
      else
      {
           $backColor = 0xFFFFFF;
            $foreColor = 0x005200;
      }
      $type = 0;
      if(isset($_GET['images']) && strlen($_GET['images']) >0)
      {
         $type = 2;
      }
      if(isset($_GET['sting_water']) && strlen($_GET['sting_water'])>0)
      {
       $type = 3;
      }

      if($type == 0)
      {
         QRcode::png($data, false, 'H',22, 1, false, $backColor, $foreColor);
      }
      else 
      {//ajax返回
         ob_start();
         if($type == 1)
         {
            QRcode::png($data, false, 'H', 10, 1, false, $backColor, $foreColor);
         }
         else if($type == 2)
         {
             $image = base64_decode($_GET['images']);
             QRcode::pngHaveWater($data, false, 'H', 10, 1, false, $backColor, $foreColor,false,'../'.$image);
         }
         else if($type == 3)
         {
            $string = $_GET['sting_water'];
            QRcode::pngHaveWater($data, false, 'H', 10, 1, false, $backColor, $foreColor,$string,false);        
         }
         echo base64_encode(ob_get_clean());
      }     
 
   // QRcode::pngHaveWater($data, false, 'H', 8, 2, false, $backColor, $foreColor,'汉字');
   // $image = '../upload_files/images/11.png';
   //QRcode::png($data, false, 'H', 14, 1, false, $backColor, $foreColor);无水印版
   //QRcode::pngHaveWater($data, false, 'H', 8, 2, false, $backColor, $foreColor,false,$image);
?>