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
	var lineChartData = {
		labels : [{!! $response['mes_ano'] !!}],
		datasets : [
			{
				label: "My First dataset",
				fillColor : "rgba(220,220,220,0.2)",
				strokeColor : "rgba(220,220,220,1)",
				pointColor : "rgba(220,220,220,1)",
				pointStrokeColor : "#fff",
				pointHighlightFill : "#fff",
				pointHighlightStroke : "rgba(220,220,220,1)",
				data : [{!! $response['campinas'] !!}]
			},
			{
				label: "My Second dataset",
				fillColor: "rgba(151,187,205,0.2)",
				strokeColor: "rgba(151,187,205,1)",
				pointColor: "rgba(151,187,205,1)",
				pointStrokeColor: "#fff",
				pointHighlightFill: "#fff",
				pointHighlightStroke: "rgba(151,187,205,1)",
				data: [{!! $response['sjc'] !!}]
			}
		]
	}


	window.onload = function(){
		var ctx = document.getElementById("canvas").getContext("2d");
		window.myLine = new Chart(ctx).Line(lineChartData, {
			responsive: true
		});
	}
</script>
@stop
