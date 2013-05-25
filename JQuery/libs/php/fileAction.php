<?php
class fileAction
{
	public $file;
	public $uploadPath;
	private function checkFilePathCreateIfNot()
	{
		$dir = explode('/', $this->uploadPath);
		$dir_str = '';
		foreach ($dir as $key => $value) {
			$dir_str .= $value.'/';

			if($value !='.' || $value !='..')
			{
				if(!is_dir($dir_str))
				{
					@mkdir($dir_str,'0777');
				}
			}
		}
	}

	private function dirReader($dir)   
	{
		$handle=opendir($dir);
		$i=0;
		while($file=readdir($handle))   
		{
			if($file!= "." && $file!= "..")
			{
				$file_time = explode('_', $file);
				if(count($file_time)>1)
				{
					
					if(strtotime(date($file_time[0])) < strtotime(date('Y-m-d H:i:s'))-0.5*3600)//删除半小时前的文件
					{
						if(is_file($dir.'/'.$file))
						{
							unlink($dir.'/'.$file);
						}					
					}					
				}
			}
		}
		closedir($handle);  
	}

	public function saveUploadImageWithSameRation($maxSize = array())
	{
		$file = $this->file;
		move_uploaded_file($file['tmp_name'],$this->uploadPath.'/'.$file['name']);
		$this->checkFilePathCreateIfNot();

		$image_type = pathinfo($file['name']);
		//$image_type = $iamge_type['extension'];
		$image_type = $image_type['extension'];
		$image_type = strtolower($image_type);
		$new_file_name = $this->uploadPath.'/'.date('YmdHis').'_'.'qrcode'.rand(0,1000).'.'.$image_type;
		switch ($image_type) {
			case 'png':$image = imagecreatefrompng($this->uploadPath.'/'.$file['name']);break;
			case 'jpg':
			case 'jpeg':$image = imagecreatefromjpeg($this->uploadPath.'/'.$file['name']);break;
			case 'gif':$image = imagecreatefromgif($this->uploadPath.'/'.$file['name']);break;		
			default:return false;
				break;
		}
		// $image = imagecreatefrompng($file['name']); 		
		$size = getimagesize($this->uploadPath.'/'.$file['name']);
		$ration = $size[0]/$size[1];
		if($ration > 1)//图片高大于宽
		{
			$new_height = $maxSize['height'];
			$new_width = $new_height/$ration;
		}
		else
		{
			$new_width = $maxSize['width'];
			$new_height = $new_width*$ration;			
		}
		$im = imagecreatetruecolor($new_height,$new_width);
		$bg = imagecolorallocate($im, 0, 0, 0);
    $white = imagecolorallocate($im, 255, 255, 255);
    $color = imagecolorallocate($im, 255, 255, 255);  
    imagefill($im, 0, 0, $color); 
    ImageCopyResized($im, $image, 0, 0, 0, 0, $new_height,$new_width,$size[0], $size[1]);
    // echo $this->uploadPath.'/'.$file['name'];die;
    $this->dirReader($this->uploadPath);//删除半小时前的文件
    switch($image_type)
    {
    	case 'jpg':
    	case 'jpeg': imagejpeg($im, $new_file_name);break;
    	case 'gif': imagegif($im, $new_file_name);break;
    	default :imagepng($im, $new_file_name);break;
    }
    if(is_file($this->uploadPath.'/'.$file['name']))
    {
    	unlink($this->uploadPath.'/'.$file['name']);
    }
    $file_path = '';
    $new_file_names = explode('/', $new_file_name);
    foreach ($new_file_names as $key => $value) {
    	if($value !='.' && $value !='..')
    	{
    		$file_path .=$value.'/';
    	}
    }
    $file_path = rtrim($file_path,'/');
    return $file_path;
	}
}
