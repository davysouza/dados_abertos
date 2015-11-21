@extends('master')
@section('styles')
<link rel="stylesheet" href="{{ url('css/jquery-ui.css') }}">
@stop
@section('nav')
<ul class="nav navbar-nav navbar-right">
	<li><a href="/">Início</a></li>
	<li><a href="/search/total_cities#SERVICE">Buscar</a></li>
	<li><a href="/search/total_cities#ABOUT">Sobre</a></li>
	@if(Session::get('isLogged'))
		<li><a href="/user" style="text-transform: none"> Olá {!! Session::get('name') !!},</a></li>
		<li><a href="/auth/logout" style="text-transform: none">Sair</a></li>
	@endif
</ul>
@stop
@section ('content')
<section class="about_us_area" id="CHART">
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
			<div class="col-md-8  wow fadeInRight animated">
				<div id="grafico" style="width:100%; height:500px;"></div>
			</div>
			<div class="col-md-4  wow fadeInRight animated">
				<div id="accordion">
					@foreach($response['city'] as $cidade)
						<h3>{!! $cidade['nome'] !!}</h3>
						<div class="accordion-style">
							<label>Área: </label><span> {{ $cidade['area'] }} km²</span><br>
							<label>População Estimada ({{ $cidade['populacao']['ano'] }}): </label><span> {{ $cidade['populacao']['tam'] }}  hab.</span><br>
							<label>PIB (2012): </label><span> R$ {{ $cidade['pib'] }}</span><br>
							<label>Total Investido: </label><span> R$ {{ $cidade['total'] }}</span>
						</div>
					@endforeach
				</div>
				@if(Session::get('isLogged'))
					<div class="text-right" style="padding-top:20px">
						<button id="btn_salvar" class="btnsearch cs-btn" type="submit">Salvar Gráfico</button>
					</div>
				@endif
			</div>
		</div>
	</div>
</section>
@if(Session::get('isLogged'))
<section class="about_us_area" id="MYGRAPHS">
	<div class="container">
		<div class="row">
			<div class="col-md-12 text-center">
				<div class="about_title">
					<h2>Meus Gráficos</h2>
					<img src="{{ url('images/shape.png') }}" alt="">
				</div>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="row">
			<div class="col-md-12 text-center wow fadeInRight animated">
				<center>
				@if(count($graphics) > 0)
					<table class="responsive flat-table flat-table-2">
						<thead>
							<th>Nome</th>
							<th>Tipo</th>
							<th>Período</th>
							<th>Selecionar</th>
							<th>Apagar</th>
						</thead>
						<tbody>
							@foreach($graphics as $graphic)
								<tr>
									<td>{!! $graphic['name'] !!}</td>
									<td>{!! $graphic['tipo'] !!}</td>
									<td>{!! $graphic['periodo'] !!}</td>
									<td>
										{!! Form::open(['url' => 'select/graphic']) !!}
											<input id="idgraphic" type="hidden" name="idgraphic" value="{!! $graphic['id'] !!}" />
											<button class="select btn-table btn btn-primary">Selecionar</button>
										{!! Form::close() !!}
									</td>
									<td><button id="btn-del-{!! $graphic['id'] !!}" class="erase btn-table btn btn-primary">Apagar</button></td>
								</tr>
							@endforeach
						</tbody>
					</table>
					{!! $graphics->render() !!}
				@else
					<span>Nenhum gráfico salvo até o momento.</span>
				@endif
				</center>
			</div>
		</div>
	</div>
</section>
@endif
<section class="about_us_area" id="SERVICE">
	<div class="container">
		<div class="row">
			<div class="col-md-12 text-center">
				<div class="about_title">
					<h2>Nova busca</h2>
					<img src="{{ url('images/shape.png') }}" alt="">
				</div>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="row">
			<div class="col-md-4  wow fadeInLeft animated">
				<div class="single_progress_bar linque">
					<a id="link1" class="link clicked"><h2>INVESTIMENTO POR SETOR</h2></a>
					<div class="progress">
						<div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 80%;">
							<span class="sr-only">60% Complete</span>
						</div>
					</div>
				</div>
				<div class="single_progress_bar linque">
					<a id="link2" class="link"><h2>INVESTIMENTO POR CIDADE</h2></a>
					<div class="progress">
						<div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 80%;">
							<span class="sr-only">60% Complete</span>
						</div>
					</div>
				</div>
				@if(Session::get('isLogged'))
					<div class="single_progress_bar linque">
						<a id="link3" class="link"><h2>INVESTIMENTOS TOTAIS POR CIDADE</h2></a>
						<div class="progress">
							<div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 80%;">
								<span class="sr-only">60% Complete</span>
							</div>
						</div>
					</div>
					<div class="single_progress_bar linque">
						<a id="link4" class="link"><h2>INVESTIMENTOS POR SETOR EM RELAÇÃO A POPULAÇÃO</h2></a>
						<div class="progress">
							<div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 80%;">
								<span class="sr-only">60% Complete</span>
							</div>
						</div>
					</div>
				@endif
			</div>
			<div class="col-md-4  wow fadeInRight animated s1">
				{!! Form::open(['url' => 'search/function']) !!}
				<div id="search1" class="search text-center">
					<input id="datainifunc" name="datainifunc" class="dateinput" type="date" required />
					<input id="datafimfunc" name="datafimfunc" class="dateinput" type="date" required />
					<br>
					<select id="funcao" name="funcao" style="width: 175px; height: 40px; margin: 30px">
						<option value="">Escolha uma área...</option>
						@foreach($options as $option)
							<option value="{{$option['funcao']}}" style="text-transform:capitalize; font-size:1.1em">{{ mb_strtolower($option['funcao'], 'UTF-8') }}</option>
						@endforeach
					</select>
					<button id="btn_sub" class="btnsearch cs-btn" type="submit">BUSCAR</button>
				</div>
				{!! Form::close() !!}
			</div>
			<div class="col-md-4  wow fadeInRight animated s2" style="display: none">
				{!! Form::open(['url' => 'search/city']) !!}
				<div id="search2" class="search text-center">
					<input id="datainicity" name="datainicity" class="dateinput" type="date" required />
					<input id="datafimcity" name="datafimcity" class="dateinput" type="date" required />
					<br>
					<select id="cidade" name="cidade" style="width: 175px; height: 40px; margin: 30px">
						<option value="">Escolha uma cidade... </option>
						<option value="Campinas">Campinas</option>
						<option value="Rio de Janeiro">Rio de Janeiro</option>
						<option value="São José dos Campos">São José dos Campos</option>
					</select>
					<button id="btn_sub2" class="btnsearch cs-btn" type="submit">BUSCAR</button>
				</div>
				{!! Form::close() !!}
			</div>
			@if(Session::get('isLogged'))
				<div class="col-md-4  wow fadeInRight animated s3" style="display: none">
					{!! Form::open(['url' => 'search/total_cities']) !!}
					<div id="search3" class="search text-center">
						<input id="datainitcity" name="datainitcity" class="dateinput" type="date" required />
						<input id="datafimtcity" name="datafimtcity" class="dateinput" type="date" required />
						<br>
						<button id="btn_sub3" class="btnsearch cs-btn" type="submit" style="margin: 10px">BUSCAR</button>
					</div>
					{!! Form::close() !!}
				</div>
				<div class="col-md-4  wow fadeInRight animated s4" style="display: none">
					{!! Form::open(['url' => 'search/functionNormalized']) !!}
					<div id="search4" class="search text-center">
						<input id="datainifuncn" name="datainifuncn" class="dateinput" type="date" required />
						<input id="datafimfuncn" name="datafimfuncn" class="dateinput" type="date" required />
						<br>
						<select id="funcao-norm" name="funcao-norm" style="width: 175px; height: 40px; margin: 30px">
							<option value="">Escolha uma área...</option>
							@foreach($options as $option)
								<option value="{{$option['funcao']}}" style="text-transform:capitalize; font-size:1.1em">{{ mb_strtolower($option['funcao'], 'UTF-8') }}</option>
							@endforeach
						</select>
						<button id="btn_sub4" class="btnsearch cs-btn" type="submit">BUSCAR</button>
					</div>
					{!! Form::close() !!}
				</div>
			@endif
			<div class="acesse col-md-4 text-center wow fadeInRight animated">
				@if(!Session::get('isLogged'))
					<p>Acesse sua conta para informações mais completas:</p>
					<ul class="main-nav" style="padding: 0px">
						<li><a class="cs-btn btn-login cd-entrar" href="#0">ENTRAR</a></li>
					</ul>
				@endif
			</div>
		</div>
	</div>
</section>
<div id="dialog-form" title="Salvar Gráfico">
	{!! Form::open(['url' => 'save/totalCities']) !!}
		<fieldset>
			{!! Form::hidden('periodo', $response['subtitulo']) !!}
			{!! Form::hidden('cidade', "Investimentos Totais por Cidade") !!}
			<input type="text" name="name" id="name" placeholder="digite um nome para o gráfico... " class="text ui-widget-content ui-corner-all">
			<hr>
			<div class="text-center">
				<button class="btnsearch cs-btn">Salvar</button>
			</div>
		</fieldset>
	{!! Form::close() !!}
</div>
@stop
@section('scripts')
<script>
$(function() {
	var dialog = $( "#dialog-form" ).dialog({
		autoOpen: false,
		height: 190,
		width: 370,
		modal: true,
	});

	$("#btn_salvar").click(function() {
		dialog.dialog("open");
	});
});
</script>
<script src="{{ url('js/my-scripts.js') }}"></script> <!-- My Scripts -->
<script src="{{ url('js/jquery-ui.js') }}"></script> <!-- jQuery UI -->
<script src="http://code.highcharts.com/highcharts.js"></script>
<script>
$(function() {
    $("#accordion").accordion();
});
</script>
<script>
$(function () {
	$('#grafico').highcharts({
		chart: {
			type: 'column'
		},
		title: {
			text: ''
		},
		xAxis: {
			categories: [{!! $response['cidade'] !!}]
		},
		yAxis: {
			title: {
				text: 'Investimento (em R$ Milhões)'
			}
		},
		tooltip: {
			valuePrefix: 'R$ ',
			shared: true,
			valueSuffix: ' milhões'
		},
		plotOptions: {
            column: {
                dataLabels: {
                    enabled: true,
					format: 'R$ {point.y:.2f} milhões'
                }
            }
        },
		series: [{
			name: 'Investimentos Totais',
			data: [{!! $response['valor'] !!}]
		}]
	});
});
</script>
@stop
