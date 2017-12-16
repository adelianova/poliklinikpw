<!DOCTYPE html>
<html>
<head>
	<head>
	
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta http-equiv="content-language" content="en" />
	<meta name="robots" content="noindex,nofollow" />
    <?php echo @$metadata; ?>
	<title><?php echo @$judul; ?></title>
	<script type="text/javascript"> 
			var base_url = "<?php print base_url(); ?>";	
	</script>
	<link rel="shortcut icon" href="<?php echo base_url().'asset/img/admin/favicon.ico';?>"/>
		<link rel="stylesheet" type="text/css" href="./themes/fonts/stylesheet.css">
</head>
<body class='login'>

	<div class="logo"><img src="<?php echo base_url();?>asset/img/admin/logo_poli.png" class="pdam"></div>
	<div class="titleBox"><?echo @$judul;?></div>
	<div class="box">
		<br/>
		
		<form method='post' id='formLogin'>
			<div class="inputArea">
				<input type="text" id="pengguna" name="pengguna" class="inputText" placeholder="NIP" autocomplete="off"/>
				<input type="password" id="sandi" name="sandi" class="inputText" placeholder="Password" autocomplete="off"/>
			</div>
		<p style='font-weight:bold' class='msgText' align='center'></p>
			
			
			<div class="buttonArea">
				<input type="button" id='btnLogin' value="LOGIN" class="inputButton" onClick='cekLogin()'/>
			</div>
		</form>
	</div>
	<div class="footer">&copy; SIM PDAM Kota Malang</div>
</body>
</html>
<script>

 	function cekLogin(){
		$('#formLogin').form('submit', {
		url:base_url+'index.php/ceklogin',
		onSubmit: function(){
			return jQuery(this).form('validate');
        },
		success:function(data){
			var result = eval('('+data+')');
			if(!result.login){
				$('#formLogin').form('clear');
				//$.messager.alert('INFO',result.status,'info');
				$('.msgText').html(result.status);
			}else{
				window.location=base_url+'index.php/dashboard';
			}
			
		}
	});
	}
	
	$(document).keypress(function(e) {
			if(e.which == 13) {
				$('#btnLogin').focus().click();
			}
		});

 </script>