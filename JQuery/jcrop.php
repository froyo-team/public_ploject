<?php
$user_icon = './picture/qiqi_small.jpg';
$img_src = './picture/qiqi.jpg'
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	
	$targ_w = $targ_h = 150;
	$jpeg_quality = 90;
	$src = './picture/qiqi.jpg';
	$img_r = imagecreatefromjpeg($src);
	$dst_r = ImageCreateTrueColor( $targ_w, $targ_h );

	imagecopyresampled($dst_r,$img_r,0,0,$_POST['x'],$_POST['y'],
	$targ_w,$targ_h,$_POST['w'],$_POST['h']);
	imagejpeg($dst_r,$user_icon,$jpeg_quality);

	exit;
}


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
		<script src="./js/my_jcrop.js"></script>

	
	</head>
	<body>	
	<?php
	include './header.php';

	?>	
		<div id="content">
			<div id="jcrop_limit_border">
				<div id="jcrop_img" class="img-border">

					<img src="./picture/qiqi.jpg" id="target" alt="[Jcrop Example]" />
				</div>
				 <div id="preview-pane" class="img-border">
				    <div class="preview-container">
				      <img src="./picture/qiqi.jpg" class="jcrop-preview" alt="Preview" />
				    </div>
				 </div>
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