<?php
require '../lib/ImageHandle.class.php';
	$f_page_discription = 'jquery插件集成';
	$f_web_discription = 'froyo 成长记录';
	$f_keywords = 'froyo,成长,php,web,jquery,插件';
	$f_author = 'froyo';
	$f_page_title = '首页';
	$user_name="froyo";
	$user_icon = "./upload/picture/user_icon_default.jpg";

	$thumb_width = 50;
	$thumb_height = 50;
	$large_image_width = 100;
	$large_image_height = 100;

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	$jpeg_quality = 90;
	$imageHandle  = new ImageHandle();
	$src = './upload/picture/user_icon_default.jpg';
	$dest = './upload/picture/user_icon.jpg';
	$img_r = $imageHandle->creatImageFromeFile($src);
	$dst_r = ImageCreateTrueColor( $thumb_width, $thumb_height );

	imagecopyresampled($dst_r,$img_r,0,0,$_POST['x'],$_POST['y'],
	$thumb_width,$thumb_height,$_POST['w'],$_POST['h']);
	$imageHandle->SaveImageToFile($dst_r,$dest,$quality);
	imagedestroy($dst_r);

}

?>
<?php 
require './header.php';
?>
<script type="text/javascript" src="../lib/jquery-1.8.0.min.js"></script>
<link rel="stylesheet" href="../lib/jcrop_zh/css/jquery.Jcrop.css" type="text/css" />
<script type="text/javascript" src="../lib/jcrop_zh/js/jquery.Jcrop.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		//记得放在jQuery(window).load(...)内调用，否则Jcrop无法正确初始化
		$("#large_img").Jcrop({
			onChange:showPreview,
			onSelect:showCoords,
			aspectRatio:1
		});	
		//简单的事件处理程序，响应自onChange,onSelect事件，按照上面的Jcrop调用
		function showPreview(coords){
			if(parseInt(coords.w) > 0){
				//计算预览区域图片缩放的比例，通过计算显示区域的宽度(与高度)与剪裁的宽度(与高度)之比得到
				var rx = $("#preview_box").width() / coords.w; 
				var ry = $("#preview_box").height() / coords.h;
				//通过比例值控制图片的样式与显示
				$("#crop_preview").css({
					width:Math.round(rx * $("#large_img").width()) + "px",	//预览图片宽度为计算比例值与原图片宽度的乘积
					height:Math.round(rx * $("#large_img").height()) + "px",	//预览图片高度为计算比例值与原图片高度的乘积
					marginLeft:"-" + Math.round(rx * coords.x) + "px",
					marginTop:"-" + Math.round(ry * coords.y) + "px"
				});
			}
		}
		//简单的事件处理程序，响应自onChange,onSelect事件，按照上面的Jcrop调用
		function showCoords(obj){
			$("#x").val(obj.x);
			$("#y").val(obj.y);
			$("#w").val(obj.w);
			$("#h").val(obj.h);
			if(parseInt(obj.w) > 0){
				//计算预览区域图片缩放的比例，通过计算显示区域的宽度(与高度)与剪裁的宽度(与高度)之比得到
				var rx = $("#preview_box").width() / obj.w; 
				var ry = $("#preview_box").height() / obj.h;
				//通过比例值控制图片的样式与显示
				$("#crop_preview").css({
					width:Math.round(rx * $("#large_img").width()) + "px",	//预览图片宽度为计算比例值与原图片宽度的乘积
					height:Math.round(rx * $("#large_img").height()) + "px",	//预览图片高度为计算比例值与原图片高度的乘积
					marginLeft:"-" + Math.round(rx * obj.x) + "px",
					marginTop:"-" + Math.round(ry * obj.y) + "px"
				});
			}
		}
		$("#crop_submit").click(function(){
			if(parseInt($("#x").val())){
				$("#crop_form").submit();	
			}else{
				alert("要先在图片上划一个选区再单击确认剪裁的按钮哦！");	
			}
		});
	});
</script>
<link rel="stylesheet" href="./css/index.css" type="text/css" />
<div class="img">
	<div class="large_img">
		<img id="large_img" src="./upload/picture/user_icon_default.jpg" />
	</div>
    <span id="preview_box" class="crop_preview">
    	<img id="crop_preview" src="./upload/picture/user_icon_default.jpg" />
    </span>
</div>
<div class="action">
	<button id="up_img">上传图片</button>
	<form  method="post" id="crop_form">
	    <input type="hidden" id="x" name="x" />
	    <input type="hidden" id="y" name="y" />
	    <input type="hidden" id="w" name="w" />
	    <input type="hidden" id="h" name="h" />
	    <input type="button" value="确认剪裁" id="crop_submit" />
     </form>
</div>
     
<?php
require './footer.php';
?>