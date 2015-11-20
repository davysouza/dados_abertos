@extends('master')
@section('styles')
<link rel="stylesheet" href="{{ url('css/jquery-ui.css') }}">
@stop
@section('styles')
<link rel="stylesheet" href="{{ url('css/responsive-tables.css') }}">
@stop
@section('nav')
<ul class="nav navbar-nav navbar-right main-nav">
	<li><a href="/">INÍCIO</a></li>
	<li><a href="/user#SERVICE">BUSCAR</a></li>
	<li><a href="/user#ABOUT">Sobre</a></li>
	<li><a href="/user#MYGRAPHS">Meus Gráficos</a></li>
	<li><a href="/auth/logout">Sair</a></li>
</ul>
@stop
@section('content')
<section class="about_us_area" id="ME">
	<div class="container">
		<div class="row">
			<div class="col-md-12 text-right" style="margin-top:50px">
				<a href="#">Olá {!! Session::get('name') !!},</a>
			</div>
		</div>
	</div>
</section>
<section class="about_us_area" id="SERVICE">
	<div class="container">
		<div class="row">
			<div class="col-md-12 text-center">
				<div class="about_title">
					<h2>Faça sua busca</h2>
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
				<div class="single_progress_bar linque">
					<a id="link3" class="link"><h2>INVESTIMENTOS TOTAIS POR CIDADE</h2></a>
					<div class="progress">
						<div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 80%;">
							<span class="sr-only">60% Complete</span>
						</div>
					</div>
				</div>
				<div class="single_progress_bar linque">
					<a id="link4" class="link"><h2>INVESTIMENTO POR SETOR EM RELAÇÃO A POPULAÇÃO</h2></a>
					<div class="progress">
						<div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 80%;">
							<span class="sr-only">60% Complete</span>
						</div>
					</div>
				</div>
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
			<div class="col-md-4  wow fadeInRight animated s3" style="display: none">
				{!! Form::open(['url' => 'search/total_cities']) !!}
				<div id="search3" class="search text-center">
					<input id="datainitcity" name="datainitcity" class="dateinput" type="date" required />
					<input id="datafimtcity" name="datafimtcity" class="dateinput" type="date" required />
					<br>
					<button id="btn_sub4" class="btnsearch cs-btn" type="submit" style="margin: 10px">BUSCAR</button>
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
					<button id="btn_sub3" class="btnsearch cs-btn" type="submit">BUSCAR</button>
				</div>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
</section>
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
									<td><button class="btn-table btn btn-primary">Selecionar</button></td>
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
<div id="dialog-form" title="Apagar Gráfico">
	{!! Form::open(['url' => 'erase/graphic']) !!}
		<fieldset>
			<label>Está certo disso?</label>
			<input id="hue" type="hidden" name="id" />
			<div class="text-center">
				<button class="btnsearch cs-btn">Apagar</button>
			</div>
		</fieldset>
	{!! Form::close() !!}
</div>
@stop
@section('scripts')
<script src="{{ url('js/modernizr.js') }}"></script> <!-- Modernizr -->
<script src="{{ url('js/main.js') }}"></script> <!-- Gem jQuery -->
<script src="{{ url('js/jquery-ui.js') }}"></script> <!-- jQuery UI -->
<script src="{{ url('js/responsive-tables.js') }}"></script> <!-- Responsive Tables -->
<script>
$(function() {
	var dialog = $( "#dialog-form" ).dialog({
		autoOpen: false,
		height: 'auto',
		width: 290,
		modal: true,
        fluid: true
	});
    $(".erase").click(function() {
		var id = $(this).attr('id');
		id = id.replace('btn-del-', '');
		$("#hue").val(id);
		dialog.dialog("open");
	});
});
</script>
<script src="{{ url('js/my-scripts.js') }}"></script> <!-- My Scripts -->
@stop
