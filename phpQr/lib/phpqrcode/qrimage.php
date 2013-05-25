<?php
/*
 * PHP QR Code encoder
 *
 * Image output of code using GD2
 *
 * PHP QR Code is distributed under LGPL 3
 * Copyright (C) 2010 Dominik Dzienia <deltalab at poczta dot fm>
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 3 of the License, or any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
 */
 
    define('QR_IMAGE', true);
    define('CHINEASE_FONT','../jpgraph/fonts/simhei.ttf');

    class QRimage {
    
        //----------------------------------------------------------------------
        public static function png($frame, $filename = false, $pixelPerPoint = 4, $outerFrame = 4,$saveandprint=FALSE, $back_color, $fore_color) 
        {
            $image = self::image($frame, $pixelPerPoint, $outerFrame, $back_color, $fore_color);
            
            if ($filename === false) {
                Header("Content-type: image/png");
                ImagePng($image);
            } else {
                if($saveandprint===TRUE){
                    ImagePng($image, $filename);
                    header("Content-type: image/png");
                    ImagePng($image);
                }else{
                    ImagePng($image, $filename);
                }
            }
            
            ImageDestroy($image);
        }
    
        //----------------------------------------------------------------------
        public static function jpg($frame, $filename = false, $pixelPerPoint = 8, $outerFrame = 4, $q = 85) 
        {
            $image = self::image($frame, $pixelPerPoint, $outerFrame, $back_color, $fore_color);
            
            if ($filename === false) {
                Header("Content-type: image/jpeg");
                ImageJpeg($image, null, $q);
            } else {
                ImageJpeg($image, $filename, $q);            
            }
            
            ImageDestroy($image);
        }
    
        //----------------------------------------------------------------------
        private static function image($frame, $pixelPerPoint = 4, $outerFrame = 4, $back_color = 0xFFFFFF, $fore_color = 0x000000) 
        {
            $h = count($frame);
            $w = strlen($frame[0]);
            
            $imgW = $w + 2*$outerFrame;
            $imgH = $h + 2*$outerFrame;
            
            $base_image =ImageCreate($imgW, $imgH);
            
            // convert a hexadecimal color code into decimal eps format (green = 0 1 0, blue = 0 0 1, ...)
            $r1 = round((($fore_color & 0xFF0000) >> 16), 5);
            $b1 = round((($fore_color & 0x00FF00) >> 8), 5);
            $g1 = round(($fore_color & 0x0000FF), 5);

            // convert a hexadecimal color code into decimal eps format (green = 0 1 0, blue = 0 0 1, ...)
            $r2 = round((($back_color & 0xFF0000) >> 16), 5);
            $b2 = round((($back_color & 0x00FF00) >> 8), 5);
            $g2 = round(($back_color & 0x0000FF), 5);


            
            $col[0] = ImageColorAllocate($base_image,$r2,$b2,$g2);
            $col[1] = ImageColorAllocate($base_image,$r1,$b1,$g1);

            imagefill($base_image, 0, 0, $col[0]);

            for($y=0; $y<$h; $y++) {
                for($x=0; $x<$w; $x++) {
                    if ($frame[$y][$x] == '1') {
                        ImageSetPixel($base_image,$x+$outerFrame,$y+$outerFrame,$col[1]); 
                    }
                }
            }
            
            $target_image =ImageCreate($imgW * $pixelPerPoint, $imgH * $pixelPerPoint);
            ImageCopyResized($target_image, $base_image, 0, 0, 0, 0, $imgW * $pixelPerPoint, $imgH * $pixelPerPoint, $imgW, $imgH);
            ImageDestroy($base_image);
            
            return $target_image;
        }

        public static function pngHaveWater($frame, $filename = false, $pixelPerPoint = 4, $outerFrame = 4,$saveandprint=FALSE, $back_color, $fore_color,$string=false,$image_user=false) 
        {
            $image = self::image($frame, $pixelPerPoint, $outerFrame, $back_color, $fore_color);
            $size = array();
            $size['height'] = (count($frame)+2*$outerFrame)*$pixelPerPoint;
            $size['width'] = (strlen($frame[0])+2*$outerFrame)*$pixelPerPoint;
            $water_image = self::waterImage($size,$string,$image_user);
            $new_image = $image;
            $image = imagecreatetruecolor($size['width'], $size['height']);
            imagecopy($image, $new_image, 0, 0, 0, 0, $size['width'], $size['height']);
            imagecopymerge($image, $water_image['image'], ($size['width']-$water_image['size']['width'])/2, ($size['height']-$water_image['size']['height'])/2, 0, 0, $water_image['size']['width'],$water_image['size']['height'],100);
            if ($filename === false) {
                Header("Content-type: image/png");
                ImagePng($image);
            } else {
                if($saveandprint===TRUE){
                    ImagePng($image, $filename);
                    header("Content-type: image/png");
                    ImagePng($image);
                }else{
                    ImagePng($image, $filename);
                }
            }
            
            ImageDestroy($image);
        }

        private static function waterImage($size,$string=false,$image=false)
        {
            $ration = 0.29;
            $qr_height = $size['height'];//高度
            $qr_width = $size['width'];
            $imgW = $w + 2*$outerFrame;
            $imgH = $h + 2*$outerFrame;
            $width = $ration * $qr_width;
            $height = $ration * $qr_height;        
            $im = imagecreatetruecolor($width, $height);
            $bg = imagecolorallocate($im, 255, 255, 255);
            $white = imagecolorallocate($im, 255, 255, 255);
            $grey = imagecolorallocate($im, 128, 128, 128);
            $color = imagecolorallocate($im, 255, 255, 255);  
            imagefill($im, 0, 0, $color);
            if($string)//文字水印
            {
                $text = 'Testing...';

                // Replace path by your own font path
                $font = dirname(dirname(__FILE__)).'/jpgraph/fonts/simhei.ttf';//字体采用jpgraph目录，不应该这样但是  

                // Add some shadow to the text
                //$strs ='汉字多个撒打发打发打发大事ssss发生的';
                // $strs = str_split($strs,3);
                // $strs ='汉字多个撒打发打发打发大事发生的';
                $strs = str_split($string);
                $length = count($strs);
                $i = 0;
                $j = 0;
                $new_str = array();
                for($i = 0;$i<$length;)
                {
                    if(ord($strs[$i])>127)
                    {
                        $new_str[$j] = $strs[$i].$strs[$i+1].$strs[$i+2];
                        //$new_str[$j] = iconv('utf-8', 'gb2312', $new_str[$j]);
                        $i = $i+3;
                    }
                    else
                    {
                        $new_str[$j] = $strs[$i];
                        $i += 1;
                    }
                 $j += 1;   
                }
                $font_size = 12;
                $line_num = (int)(($width-20)/($font_size+4));
                $have_line = ceil(count($new_str)/$line_num);
                $every_line_num = ceil(count($new_str)/$have_line);
                $start_x = ($width-$every_line_num*($font_size+4))/2;
                $start_y = 20+($height-$have_line*($font_size+8)-20)/2;
                $randation = imagecreatefrompng('../upload_files/temp_img/1-self-randation.png');
                $randation_size = getimagesize('../upload_files/temp_img/1-self-randation.png');
                ImageCopyResized($im, $randation, 0, 0, 0, 0, $height,$width,$randation_size[0], $randation_size[1]); 
                foreach ($new_str as $key => $str) {
                   // $str = iconv('utf-8', 'gb2312', $str);
                    //echo $str;
                    $line = (int)($key/$line_num);
                    $start_x_this = ($key%$line_num)?($start_x+($font_size+4)*($key%$line_num)):$start_x;

                    $start_y_this = $start_y + $line *($font_size+8);
                    imagettftext($im, $font_size, 0, $start_x_this, $start_y_this, $grey, $font, $str);
                }
            }
            else if($image)//图片水印
            {
                $size = getimagesize($image);
                $image_type = pathinfo($image);
                $image_type = $image_type['extension'];
                $image_type = strtolower($image_type);
                switch ($image_type) {
                    case 'png':$im_temp = imagecreatefrompng($image);break;
                    case 'jpg':
                    case 'jpeg':$im_temp = imagecreatefromjpeg($image);break;
                    case 'gif':$im_temp = imagecreatefromgif($image);break;      
                    default:return false;
                        break;
                }              
                // $im_temp = imagecreatefrompng($image);
                $color = imagecolorallocate($im, 255, 255, 255);  
                imagefill($im, 0, 0, $color);        
                $randation = imagecreatefrompng('../upload_files/temp_img/1-self-randation.png');
                $randation_size = getimagesize('../upload_files/temp_img/1-self-randation.png');
                ImageCopyResized($im, $randation, 0, 0, 0, 0, $height,$width,$randation_size[0], $randation_size[1]);        
                ImageCopyResized($im, $im_temp, 3, 3, 0, 0, $width-7,$height-6,$size[0], $size[1]);            
            }
            $warte_image = array();
            $warte_image['size'] = array();
            $warte_image['size']['width'] = $width;
            $warte_image['size']['height'] = $height;
            $warte_image['image'] = $im;
            return $warte_image;
        }
    }