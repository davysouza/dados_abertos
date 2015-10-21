@extends ('master')

@section('nav')
<ul class="nav navbar-nav navbar-right">
	<li><a href="/">Início</a></li>
	<li><a href="/#SERVICE">Buscar</a></li>
	<li><a href="/#ABOUT">Sobre</a></li>
</ul>
@stop
@section ('content')
<section class="about_us_area" id="ABOUT">
	<div class="container">
		<div class="row">
			<div class="col-md-12 text-center">
				<div class="about_title">
					<h2>{{ $response['titulo'] }}</h2>
					<h4>{{ $response['subtitulo'] }}</h4>
					<img src="{{ url('images/shape.png') }}" alt="">
				</div>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="row">
			<div class="col-md-12  wow fadeInRight animated">
				<div style="width:90%; padding-left:9%">
					<div>
						<canvas id="canvas" height="400" width="900"></canvas>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@stop
@section('scripts')
<script src="{{ url('js/Chart.js') }}"></script>
<script>
	var barChartData = {
		labels: [{!! $response['funcao'] !!}],
		datasets: [
			{
				fillColor: "rgba(151,187,205,0.5)",
				strokeColor: "rgba(151,187,205,0.8)",
				highlightFill: "rgba(151,187,205,0.75)",
				highlightStroke: "rgba(151,187,205,1)",
				data: [{!! $response['valor'] !!}]
			}
		]
	}
	window.onload = function () {
		var ctx = document.getElementById("canvas").getContext("2d");
		window.myBar = new Chart(ctx).Bar(barChartData, {
			responsive: true
		});
	}
</script>
@stop
