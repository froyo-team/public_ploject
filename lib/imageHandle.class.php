<?php
class ImageHandle
{
	private function checkFilePathCreateIfNot($path)
	{
		$dir = explode('/', $path);
		$dir_str = '';
		foreach ($dir as $key => $value) {
			$dir_str .= $value.'/';

			if($value !='.' && $value !='..' && strpos($value,".")===0)
			{
				if(!is_dir($dir_str))
				{
					@mkdir($dir_str,'0777');
				}
			}
		}
	}
	public function creatImageFromeFile($path)
	{
		$image_type = pathinfo($path);
		$image_type = $image_type['extension'];
		$image_type = strtolower($image_type);
		switch ($image_type) 
		{
			case 'png':$image = imagecreatefrompng($path);break;
			case 'jpg':
			case 'jpeg':$image = imagecreatefromjpeg($path);break;
			case 'gif':$image = imagecreatefromgif($paths);break;		
			default:return false;
				break;
		}
		return $image;
	}

	public function SaveImageToFile($image,$path,$quality)
	{
		$this->checkFilePathCreateIfNot($path);
		$image_type = pathinfo($path);
		$image_type = $image_type['extension'];
		$image_type = strtolower($image_type);
		switch ($image_type) 
		{
			case 'png':$image = imagepng($image,$path,$quality);;break;
			case 'jpg':
			case 'jpeg':$image = imagejpeg($image,$path,$quality);;break;
			case 'gif':$image = imagegif($image,$path,$quality);;break;		
			default:return false;
				break;
		}
		return $image;
	}
}
?>