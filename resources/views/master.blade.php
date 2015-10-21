<!DOCTYPE html>
<html lang="pt">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>Dados Abertos Governamentais</title>

		<!-- Google Font -->
		<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Dosis:300,400,500,600,700,800">
		<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Montserrat:400,700">

		<!-- Font Awesome -->
		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="{{ url('css/final.css') }}">
	</head>

	<body>
		<!-- Preloader -->
		<div id="preloader">
			<div id="status">&nbsp;</div>
		</div>

		<header id="HOME" style="background-position: 50% -125px;">
			<div class="section_overlay">
				<nav class="navbar navbar-default navbar-fixed-top">
					<div class="container">
						<!-- Brand and toggle get grouped for better mobile display -->
						<div class="navbar-header">
							<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
								<span class="sr-only">Toggle navigation</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
							<a class="navbar-brand" href="/"><img src="{{ url('images/logo.png') }}" alt="Logo DAG"></a>
						</div>

						<!-- Collect the nav links, forms, and other content for toggling -->
						<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
							@yield('nav')
						</div><!-- /.navbar-collapse -->
					</div><!-- /.container -->
				</nav>
				@yield('home')
			</div>
		</header>

		@yield('content')

		<footer>
			<div class="container">
				<div class="container">
					<div class="row">
						<div class="col-md-12 text-center">
							<div class="footer_logo   wow fadeInUp animated">
								<img src="{{ url('images/logo.png') }}" alt="">
							</div>
						</div>
					</div>
				</div>
				<div class="container">
					<div class="row">
						<div class="col-md-12 text-center   wow fadeInUp animated">
							<div class="social">
								<h2>Follow Me on Here</h2>
								<ul class="icon_list">
									<li><a href="http://www.facebook.com/abdullah.noman99"target="_blank"><i class="fa fa-facebook"></i></a></li>
									<li><a href="http://www.twitter.com/absconderm"target="_blank"><i class="fa fa-twitter"></i></a></li>
									<li><a href=""><i class="fa fa-google-plus"></i></a></li>
									<li><a href=""><i class="fa fa-linkedin"></i></a></li>
									<li><a href="http://www.dribbble.com/abdullahnoman"target="_blank"><i class="fa fa-dribbble"></i></a></li>
								</ul>
							</div>
						</div>
					</div>
				</div>
				<div class="container">
					<div class="row">
						<div class="col-md-12 text-center">
							<div class="copyright_text   wow fadeInUp animated">
								<p>&copy; brandy 2015.All Right Reserved By <a href="http://www.themeforest.net/user/thecodecafe"target="_blank">Code Cafe Team</a></p>
								<p>Made with love for creative people.</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</footer>

		<!-- Scripts -->
		<script src="{{ url('js/jquery-2.1.4.min.js') }}"></script>
		<script src="{{ url('js/bootstrap.min.js') }}"></script>
		<script src="{{ url('js/jquery.nicescroll.js') }}"></script>
		<script src="{{ url('js/owl.carousel.js') }}"></script>
		<script src="{{ url('js/wow.js') }}"></script>
		<script src="{{ url('js/script.js') }}"></script>
		@yield('scripts')
	</body>
</html>
