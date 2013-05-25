$(document).ready(function(){
function ajaxQrCode()
{
	var info_content = $('#qr_info').val();
	var code_type = $('#qr_type').val();
	$.ajax({
		url:'makeQrCode.php',
		type:'POST',
    data: {'info':info_content,'type':code_type},
		success:function(data){
			if(data != 'error')
			{
			
				$('#qrcode_img').attr('src','data:image/png;base64,'+data);
			}
		}
	});
}
$("#submit_info").click(
	function(){
		if($('.info-detail').val().length>7 && $('.info-detail').val().indexOf('http://')!=-1)
		{
			$('#qr_type').val('URL');
			$('#qr_info').val($('.info-detail').val());
			ajaxQrCode();
		}
		else
		{
			alert("don't input right info");
			return false;
		}
	}
);
});