<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head> 
	<script type="text/javascript" charset="utf-8" src="./js/jquery-1.8.0.min.js"></script>
	<script type="text/javascript" charset="utf-8" src="./js/main.js"></script>
	<link rel="stylesheet" type="text/css" href="./css/main.css">
	
	
</head>
<body>
	<div id="head">
		<div id="logo">
			<label>
				<strong>My &nbsp;phpQr &nbsp; project</strong> 
				<br/>
				  make &nbsp; by &nbsp;froyo  &amp; 2013-05-23</label>
		</div>
	</div>
	<div id="content">
		<div class="left">
			<header>GENERATE</header>
			<div class="box type">
				<h4>Select input type</h4>
				<div class="box-content type">
					<ul>
						<li class="text" data-input="text">
							<a>
								<span></span>text<small>new</small>
							</a>
						</li>
						<li class="text" data-input="URL">
							<a>
								<span></span>URL<small>new</small>
							</a>
						</li>
						<li class="text" data-input="Phone number">
							<a>
								<span></span>Phone number<small>new</small>
							</a>
						</li>
						<li class="text" data-input="VCard connected detail">
							<a>
								<span></span>VCard connected detail<small>new</small>
							</a>
						</li>
						<li class="text" data-input="Wifi Access ">
							<a>
								<span></span>Wifi Access<small>new</small>
							</a>
						</li>
					</ul>
				</div>
			</div>
			<div class="box input">
				<h4> YOU INPUT<small>start with http://</small></h4>
			</div>
			<div class="box-content">
				<textarea id="url" spellcheck="false" class="watching">http://</textarea>
				<p class="info">Measure scans on QR codes and get detailed real-time statistics! <a href="http://www.qrhacker.com/business/" class="click-track" data-action="upgrade" data-src="left-no-subsc-small-url">Learn more</a></p>
			<form id="info_input">
				
				<input name="type" type="hidden" id="qr_type">
				<input name="info" type="hidden" id="qr_info">

				<button text="提交" class="button submit-form" id="submit_info"/>
				<script type="text/javascript">
				$("#submit_info").click(
					function(){
						alert('事件生效啦！你点击了新按钮');
					}
				);
				</script>
			</form>

			</div>

		</div>
		<div class="center">
			<div class="welcome">

			</div>
			<div class="code-img">
				<img src="makeQrCode.php"/>
			</div>
		</div>
		<div class="right">
		</div>
                  
	</div>



</body>
</html>
