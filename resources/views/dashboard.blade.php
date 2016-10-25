<!DOCTYPE html>
<html lang="">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Dashboard</title>

		<link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
		<style type="text/css">
			.header-logo {
				float: left;
				padding: 5px 15px;

			}
			.btn-elearning {
				background: none;
				border: none;
				color: #E7E7E7;
				padding-left: 10px;
			}
			.btn-elearning i {
				margin-right: 5px;
			}
			@media screen and (min-width: 992px) {
			    .toggle {
			    	display: none;
			    }
				
			}
			@media only screen and (max-width: 500px) {
				.top_nav .navbar-right li.top_search {
					display: none;
				}
				.top_nav .navbar-right {
					width: 10%;
				}
			}
		</style>

		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.2/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
	<body class="nav-md">
		<div class="container body">
			<div class="main_container">

				<div class="col-md-3 left_col">
					<div class="left_col scroll-view">
						
						<!-- menu profile quick info -->
						<div class="profile">
							<div class="profile_pic">
								<img src="{{ asset('images/user.jpg') }}" alt="..." class="img-circle profile_img">
							</div>
							<div class="profile_info">
								<span>Selamat Datang</span>
								<?php $profil = session()->get('dosen'); ?>
								<h2>{{ $profil['gelardpn'].' '.ucwords(strtolower($profil['nama'])).' '.$profil['gelarblk']  }}</h2>
							</div>
						</div>
						<!-- /menu profile quick info -->

						<!-- sidebar menu -->
						<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
							<div class="menu_section">
								<h3 style="padding-left: 10px; margin-bottom: 20px;">&nbsp Dosen</h3>
								<ul class="nav side-menu">
									<li><a href="{{ route('profil') }}"><i class="fa fa-home"></i> Home</a></li>
									<li><a><i class="fa fa-area-chart"></i> Akademik <span class="fa fa-chevron-down"></span></a>
										<ul class="nav child_menu">
											<li><a href="{{ route('akademik.entri-nilai') }}">Entri Nilai</a></li>
											<li><a href="{{ route('akademik.histori-mengajar') }}">Histori Mengajar</a></li>
											<li><a href="{{ route('akademik.bimbingan') }}">Mahasiswa Bimbingan</a></li>
										</ul>
									</li>
									<li><a><i class="fa fa-calendar"></i> Jadwal <span class="fa fa-chevron-down"></span></a>
										<ul class="nav child_menu">
											<li><a href="{{ route('jadwal.mengajar') }}">Jadwal Mengajar</a></li>
											<li><a href="#">Jadwal Ujian</a></li>
											<li><a href="#">Jadwal Seminar</a></li>
											<li><a href="#">Jadwal Sidang</a></li>
										</ul>
									</li>
									<li><a href="a.html"><i class="fa fa-list-ul"></i> Monitoring Evaluasi </a>
									</li>
									<li>
										<form action="http://e-learning.untan.ac.id/verifikasi" method="POST">
											<input type="hidden" name="username" value="{{ session()->get('mhs')['nim'] }}">
											<input type="hidden" name="password" value="{{ substr(session()->get('mhs')['password'], 1)  }}">
											<input type="hidden" name="_token" value="bkz1UiXXhlf8Y9sG4AjGo0RlonNbzlvXFtAuQpzf">
											<button type="submit" class="btn-elearning"> <i class="fa fa-leanpub"></i> E-Learning</button>
										</form>
									</li>
									<li><a href="{{ route('logout') }}"><i class="fa fa-power-off"></i> Keluar</a></li>
								</ul>	
							</div>
						</div>
						<!-- /sidebar menu -->
					</div>
				</div>

				<!-- top navigation -->
				<div class="top_nav">
					<div class="nav_menu">
						<nav role="navigation">
							<div class="nav toggle">
			                	<a id="menu_toggle"><i class="fa fa-bars"></i></a>
			              	</div>
			              	<div class="header-logo">
			              		<img src="{{ asset('images/siakad-untan.png') }}" alt="">
			              	</div>
							<ul class="nav navbar-nav navbar-right">
								<li class="col-md-5 col-sm-5 col-xs-8 form-group top_search" style="margin-top: 10px;">
									<div class="input-group">
										<input type="text" class="form-control" placeholder="Search for...">
										<span class="input-group-btn">
											<button class="btn btn-default" type="button"><i class="fa fa-search"></i></button>
										</span>
									</div>
								</li>
								
							</ul>
						</nav>
					</div>
				</div>
				<!-- /top navigation -->

				<!-- page content -->
				<div class="right_col" role="main">
					@yield('content')
				</div>
				<!-- /page content -->
			</div>
		</div>

		<script type="text/javascript" src="{{ asset('js/script.js') }}"></script>
		@yield('plugin')
	</body>
</html>