<!DOCTYPE html>
<html lang="en"> 
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
	<title>HOME | POLIKLINIK PDAM Kota Malang </title>
	<link rel="stylesheet" href="<?php echo base_url(); ?>asset/doctor/css/font-awesome.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>asset/doctor/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>asset/doctor/css/style.css">
	<link href="<?php echo base_url(); ?>asset/css/font.css" rel='stylesheet' type='text/css'>
	<link href="<?php echo base_url(); ?>asset/css/nine.css" rel='stylesheet' type='text/css'>
	<script src="<?php echo base_url(); ?>asset/doctor/js/modernizr.js"></script>
	<link rel="shortcut icon" href="<?php echo base_url().'asset/img/admin/favicon.ico';?>"/>
	<!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
      <script src="js/respond.min.js"></script>
    <![endif]-->

</head>
<body>
	
	<!-- header section -->
	<header class="top-header">
		<div class="container">
			<div class="row">
				<div class="col-xs-5 header-logo">
					<br>
					<a href="index.html"><img src="<?php echo base_url(); ?>asset/doctor/img/header.png" alt="" class="img-responsive logo" width="200px"></a>
				</div>

				<div class="col-md-7">
					<nav class="navbar navbar-default">
					  <div class="container-fluid nav-bar">
					    <!-- Brand and toggle get grouped for better mobile display -->
					    <div class="navbar-header">
					      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					        <span class="sr-only">Toggle navigation</span>
					        <span class="icon-bar"></span>
					        <span class="icon-bar"></span>
					        <span class="icon-bar"></span>
					      </button>
					    </div>

					    <!-- Collect the nav links, forms, and other content for toggling -->
					    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					      
					      <ul class="nav navbar-nav navbar-right">
					        <li><a class="menu" href="#home" >Home</a></li>
					        <li><a class="menu" href="#doctor">Doctor</a></li>
					        <li><a class="menu" href="#dashboard">Dashboard</a></li>
					        <li><a class="menu" href="#alur">Alur</a></li>
					      </ul>
					    </div><!-- /navbar-collapse -->
					  </div><!-- / .container-fluid -->
					</nav>
				</div>
			</div>
		</div>
	</header> <!-- end of header area -->

	<section class="slider" id="home">
		<div class="container-fluid">
			<div class="row">
			    <div id="carouselHacked" class="carousel slide carousel-fade" data-ride="carousel">
					<div class="header-backup"></div>
			        <!-- Wrapper for slides -->
			        <div class="carousel-inner" role="listbox">
			            <div class="item active">
			            	<img src="<?php echo base_url(); ?>asset/doctor/img/slide-satu.png" alt="">
			            </div>
			            <div class="item">
			            	<img src="<?php echo base_url(); ?>asset/doctor/img/slide-dua.png" alt="">
			            </div>
			            <div class="item">
			            	<img src="<?php echo base_url(); ?>asset/doctor/img/slide-tiga.png" alt="">
			            </div>	
			        </div>
			        <!-- Controls -->
			        <a class="left carousel-control" href="#carouselHacked" role="button" data-slide="prev">
			            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
			            <span class="sr-only">Previous</span>
			        </a>
			        <a class="right carousel-control" href="#carouselHacked" role="button" data-slide="next">
			            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
			            <span class="sr-only">Next</span>
			        </a>
			    </div>
			</div>
		</div>
	</section><!-- end of slider section -->

	<!-- about section -->
	<section class="about text-center" id="doctor">
		<div class="container">
			<div class="row">
				<h2>OUR DOCTOR</h2>
				<!-- <h4>Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled</h4> -->
				<div class="col-md-2">
					
				</div>
				<div class="col-md-4 col-sm-6">
					<div class="single-about-detail clearfix">
						<div class="about-img">
							<img class="img-responsive" src="<?php echo base_url(); ?>asset/doctor/img/dokter2.png" alt="">
						</div>
						<div class="about-details">
							<div class="pentagon-text">
								<h1>A</h1>
							</div>
							<h3>Dr Andri Arif Nugroho</h3>
							<p style="text-align: center;">Senin <br>Rabu <br>Jumat</p>
						</div>
					</div>
				</div>
				<div class="col-md-4 col-sm-6">
					<div class="single-about-detail clearfix">
						<div class="about-img">
							<img class="img-responsive" src="<?php echo base_url(); ?>asset/doctor/img/dokter1.png" alt="">
						</div>
						<div class="about-details">
							<div class="pentagon-text">
								<h1>L</h1>
							</div>
							<h3>Dr Luluk Retno Wulan</h3>
							<p style="text-align: center;">Selasa <br>Kamis <br>Jumat</p>
						</div>
					</div>
				</div>
				<div class="col-md-2">
					
				</div>
			</div>
		</div>
	</section><!-- end of about section -->


	<!-- service section starts here -->
	<section class="service text-center" id="dashboard">
		<div class="container">
			<div class="row">
				<h2>DASHBOARD</h2>
				<h4>Berikut adalah ... dalam hari ini</h4>
				<div class="col-md-4 col-sm-4">
					<div class="single-service">
						<div class="single-service-img">
							<div class="service-img">
								<p><?php echo $dokter->dokter; ?></p>
							</div>
						</div>
						<h3>DOKTER</h3>
					</div>
				</div>
				<div class="col-md-4 col-sm-4">
					<div class="single-service">
						<div class="single-service-img">
							<div class="service-img">
								<p><?php echo $admin->admin; ?></p>
							</div>
						</div>
						<h3>ADMIN</h3>
					</div>
				</div>
				<div class="col-md-4 col-sm-4">
					<div class="single-service">
						<div class="single-service-img">
							<div class="service-img">
								<p><?php echo $pasien->pasien; ?></p>
							</div>
						</div>
						<h3>PASIEN</h3>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- end of service section -->

	<!-- team section -->
	<section class="team" id="alur">
		<div class="container">
			<div class="row">
				<div class="team-heading text-center">
					<h2>alur berobat</h2>
					<!-- <h4>Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled</h4> -->
				</div>
				<div class="text-center">
					<img src="<?php echo base_url(); ?>asset/doctor/img/alur.png" height="500px">
				</div>
			</div>
		</div>
	</section>
	<!-- end of team section -->

	<section class="bawah">
		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<div id="map">
						<br>
						<iframe style="width:100%" 
                              frameborder="0" style="border:0" height="350px" 
                              src="https://www.google.com/maps/embed/v1/place?key=AIzaSyCu9pyeYUjfHGX9F4g6lB0dYLwa06sP-dc
                                &q=PDAM+Malang,+Jl.+Danau+Sentani+Raya+No.100,+Madyopuro,+Kedungkandang,+Malang+City,+East+Java+65142" allowfullscreen>
            			</iframe>
					</div>
				</div>
				<div class="col-md-6" id="alamat">
				<br>
					<ul><li><i class="fa fa-calendar"></i><span> Monday - Friday :</span> 9:30 AM to 6:30 PM</li></ul>
					<ul><li><i class="fa fa-map-marker"></i><span> &nbsp; Address :</span> Jl. Danau Sentani Raya No.100, Kota Malang 65142</li></ul>
					<ul><li><i class="fa fa-phone"></i><span> Phone :</span> 0341-715 103 (Hunting)</li></ul>
					<ul><li><i class="fa fa-fax"></i><span> Fax :</span> 0341-715 107</li></ul>
					<ul><li><i class="fa fa-envelope"></i><span> Email :</span> 	humas@pdamkotamalang.com</li></ul>
				</div>
			</div>
		</div>
	</section>

	<!-- <ul><li><i class="fa fa-calendar"></i><span>Monday - Friday:</span> 9:30 AM to 6:30 PM</li></ul>
							<ul><li><i class="fa fa-map-marker"></i><span>Address:</span> 123 Some Street , London, UK, CP 123</li></ul>
							<ul><li><i class="fa fa-phone"></i><span>Phone:</span> (032) 987-1235</li></ul>
							<ul><li><i class="fa fa-fax"></i><span>Fax:</span> (123) 984-1234</li></ul>
							<ul><li><i class="fa fa-envelope"></i><span>Email:</span> info@doctor.com</li></ul> -->

	<!-- footer starts here -->
	<footer class="footer clearfix">
		<div class="container">
			<div class="row">
				<div class="col-xs-6 footer-para">
					<p><b>COPYRIGHT</b> &nbsp; <a href="http://www.pdamkotamalang.com"><img src="<?php echo base_url(); ?>asset/doctor/img/pdam.png" width="70px"></a></p>
				</div>
				<div class="col-xs-6 footer-para text-right">
					<p><b>PARTNER WITH</b> &nbsp; <a href="http://www.smktelkom-mlg.sch.id"><img src="<?php echo base_url(); ?>asset/doctor/img/logo-moklet.png" width="130px"></a></p>
				</div>
			</div>
		</div>
	</footer>

	<!-- script tags
	============================================================= -->
	<script src="<?php echo base_url(); ?>asset/doctor/js/jquery-2.1.1.js"></script>
	<!-- <script src="http://maps.google.com/maps/api/js?sensor=true"></script> -->
	<script src="<?php echo base_url(); ?>asset/doctor/js/gmaps.js"></script>
	<script src="<?php echo base_url(); ?>asset/doctor/js/smoothscroll.js"></script>
	<script src="<?php echo base_url();?>asset/doctor/js/bootstrap.min.js"></script>
	<script src="<?php echo base_url();?>asset/doctor/js/custom.js"></script>

	<!-- Map-JavaScript -->
			<script type="text/javascript" src="<?php echo base_url();?>asset/doctor/js/google.js"></script>        
			<!-- <script type="text/javascript">
				
				 function init() {
                var properti_peta = {
                    center: new google.maps.LatLng(-7.970872, 112.668341),
                    zoom: 16,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                };
                var peta = new google.maps.Map(document.getElementById("map"), properti_peta);
            	}
			     
				/*function init() {
					var mapOptions = {
						zoom: 16,
						center: new google.maps.LatLng(-7.970872, 112.668341),
						styles: [{"featureType":"all","elementType":"labels.text.fill","stylers":[{"saturation":36},{"color":"#000000"},{"lightness":40}]},{"featureType":"all","elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#000000"},{"lightness":16}]},{"featureType":"all","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#000000"},{"lightness":20}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#000000"},{"lightness":17},{"weight":1.2}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":20}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":21}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#000000"},{"lightness":17}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#000000"},{"lightness":29},{"weight":0.2}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":18}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":16}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":19}]},{"featureType":"water","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":17}]}]
					};
					var mapElement = document.getElementById('map');
					var map = new google.maps.Map(mapElement, mapOptions);
					var marker = new google.maps.Marker({
						position: new google.maps.LatLng(-7.970872, 112.668341),
						map: map,
					});
				}*/ 
				google.maps.event.addDomListener(window, 'load', init);
			</script> -->
	<!-- //Map-JavaScript -->
</body>
</html>