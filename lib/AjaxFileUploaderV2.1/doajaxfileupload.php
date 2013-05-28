<?php
require('fileAction.php');
	$error = "";
	$msg = "";
	$fileElementName = 'fileToUpload';
	if(empty($_FILES['fileToUpload']['tmp_name']) || $_FILES['fileToUpload']['tmp_name'] == 'none')
	{
		$error = 'No file was uploaded..';
			echo "{";
			echo				"error: '" . $error . "',\n";
			echo "}";
	}
	else 
	{		
			$msg .= " File Name: " . $_FILES['fileToUpload']['name'] . ", ";
			$msg .= " File Size: " . @filesize($_FILES['fileToUpload']['tmp_name']);
			$fileAction = new fileAction();
			$fileAction->file = $_FILES['fileToUpload'];
			$fileAction->uploadPath = '../../upload_files/temp_img';
			$file_path = $fileAction->saveUploadImageWithSameRation(array('height'=>100,'width'=>100));
			@unlink($_FILES['fileToUpload']);	
	echo "{";
	echo				"error: '" . $error . "',\n";
	echo 				"image: '".base64_encode($file_path)."'\n";
	echo "}";	
	}		

?>