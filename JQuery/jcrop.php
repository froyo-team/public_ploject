<?php
require './libs/php/fileAction.php';
$user_icon = './picture/qiqi-small.jpg';
$img_src = './picture/qiqi.jpg';
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	if($_POST['up_img'] == 'up_img')
	{
		$fileAction = new fileAction();
		$fileAction->file = $_FILES['fileToUpload'];
		$fileAction->uploadPath = './picture';
		$img_path = $fileAction->saveUploadImageWithSameRation(array('height'=>300,'width'=>300));
		$img_path = $fileAction->getLatestFile('./picture');		
	}
	else
	{
		$fileAction = new fileAction();
		$src = $fileAction->getLatestFile('./picture');
		$targ_w = $targ_h = 150;
		$jpeg_quality = 90;
		$img_r = $fileAction->imgCreate($src);
		//$img_r = imagecreatefromjpeg($src);
		$dst_r = ImageCreateTrueColor( $targ_w, $targ_h );
		imagecopyresampled($dst_r,$img_r,0,0,$_POST['x'],$_POST['y'],
		$targ_w,$targ_h,$_POST['w'],$_POST['h']);
		imagejpeg($dst_r,$user_icon,$jpeg_quality);
	}

}
$fileAction = new fileAction();
$img_src = $fileAction->getLatestFile('./picture');



?>


<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Jquery 插件集成页面</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="discription" content="记录集成的jquery插件">
		<script src="./libs/jquery-1.8.0.min.js"></script>
		<script src="./libs/Jcrop-1902/js/jquery.Jcrop.min.js"></script>
		<link rel="stylesheet" href="./libs/Jcrop-1902/css/jquery.Jcrop.css" type="text/css" />
		<link rel="stylesheet" href="./css/jcrop.css" type="text/css">
		<link href="../lib/AjaxFileUploaderV2.1/ajaxfileupload.css" type="text/css" rel="stylesheet">
		<script type="text/javascript" src="../lib/AjaxFileUploaderV2.1/ajaxfileupload.js"></script>
		<script src="./js/my_jcrop.js"></script>

	
	</head>
	<body>	
	<?php
	include './header.php';

	?>	
		<div id="content_jcrop">
			<div id="jcrop_limit_border">
				<div id="jcrop_img" class="img-border">

					<img src="<?php echo $img_src;?>" id="target" alt="[Jcrop Example]" />
				</div>
				 <div id="preview-pane" class="img-border">
				    <div class="preview-container">
				      <img src="<?php echo $img_src;?>" class="jcrop-preview" id="crop_img" alt="Preview" />
				    </div>
				 </div>
				<form method="post" id="up_img_form" enctype="multipart/form-data">
					<input type="hidden" name="up_img" value="up_img"/>
					<div > 
						<input type="file" name="fileToUpload" id="fileToUpload" style="width:80px;"/>
						<button  id="up_img">上传新图片</button>
					</div>
				</form>
		<form  method="post" onsubmit="return checkCoords();">
			<input type="hidden" id="x" name="x" />
			<input type="hidden" id="y" name="y" />
			<input type="hidden" id="w" name="w" />
			<input type="hidden" id="h" name="h" />
			<input type="submit" value="Crop Image" class="btn btn-large btn-inverse" />
		</form>
			</div>
		</div>
	</body>
	
</html>