@extends('master')
@section('styles')
<link rel="stylesheet" href="{{ url('css/jquery-ui.css') }}">
@stop
@section('nav')
<ul class="nav navbar-nav navbar-right main-nav">
	<li><a href="/">Início</a></li>
	<li><a href="/search/city#SERVICE">Buscar</a></li>
	<li><a href="/search/city#ABOUT">Sobre</a></li>
	@if(Session::get('isLogged'))
		<li><a href="/user" style="text-transform: none"> Olá {!! Session::get('name') !!},</a></li>
		<li><a href="/auth/logout" style="text-transform: none">Sair</a></li>
	@else
		<li><a class="btn-login cd-signin" href="#0">Entrar</a></li>
		<li><a class="btn-signin cd-signup" href="#0">Cadastre-se</a></li>
	@endif
</ul>
@stop
@section ('content')
<div class="cd-user-modal"> <!-- this is the entire modal form, including the background -->
	<div class="cd-user-modal-container"> <!-- this is the container wrapper -->
		<ul class="cd-switcher" style="padding-left: 0">
			<li style="list-style-type:none"><a href="#0">Entrar</a></li>
			<li style="list-style-type:none"><a href="#1">Nova conta</a></li>
		</ul>
		<div id="cd-login"> <!-- log in form -->
			{!! Form::open(['url' => 'auth/login', 'class' => 'cd-form']) !!}
				<p class="fieldset">
					<label class="image-replace cd-email" for="signin-email">Email</label>
					<input class="full-width has-padding has-border" id="signin-email" name="email" type="email" placeholder="Email" required autofocus>
					<span class="cd-error-message">Email inválido!</span>
				</p>
				<p class="fieldset">
					<label class="image-replace cd-password" for="signin-password">Password</label>
					<input class="full-width has-padding has-border" id="signin-password" name="password" type="password"  placeholder="Senha" required>
					<a href="#0" class="hide-password">Mostrar</a>
					<span class="cd-error-message">Error message here!</span>
				</p>
				<p class="fieldset">
					<input type="checkbox" id="remember" name="remember" checked>
					<label for="remember">Lembrar da senha</label>
				</p>
				<p class="fieldset">
					<button id="btn-lg" class="full-width" type="submit">Entrar</button>
				</p>
			{!! Form::close() !!}
			<p class="cd-form-bottom-message" style="color:white"><a href="#0">Esqueceu sua senha?</a></p>
			<!-- <a href="#0" class="cd-close-form">Close</a> -->
		</div> <!-- cd-login -->
		<div id="cd-signup"> <!-- sign up form -->
			{!! Form::open(['url' => 'auth/register', 'class' => 'cd-form']) !!}
				<p class="fieldset">
					<label class="image-replace cd-username" for="signup-username">Username</label>
					<input class="full-width has-padding has-border" id="signup-username" name="name" type="text" placeholder="Usuário" required>
					<span class="cd-error-message">Error message here!</span>
				</p>
				<p class="fieldset">
					<label class="image-replace cd-email" for="signup-email">E-mail</label>
					<input class="full-width has-padding has-border" id="signup-email" name="email" type="email" placeholder="Email" required>
					<span class="cd-error-message">Email Inválido</span>
				</p>
				<p class="fieldset">
					<label class="image-replace cd-password" for="signup-password">Password</label>
					<input class="full-width has-padding has-border" id="signup-password" name="pass" type="password"  placeholder="Senha" required>
					<a href="#0" class="hide-password">Mostrar</a>
					<span class="cd-error-message">Error message here!</span>
				</p>
				<p class="fieldset">
					<label class="image-replace cd-password" for="signup-password-confirm">PasswordConfirm</label>
					<input class="full-width has-padding has-border" id="signup-password-confirm" name="pass-conf" type="password"  placeholder="Confirmar Senha">
					<a href="#0" class="hide-password">Mostrar</a>
					<span class="cd-error-message">Error message here!</span>
				</p>
				@if ($errors->any())
					<ul class="alert alert-danger">
						<li style="list-style-type:none;">Email já cadastrado!</li>
					</ul>
				@endif
				<p class="fieldset">
					<button class="full-width has-padding" type="submit">Criar nova conta</button>
				</p>
			{!! Form::close() !!}
			<!-- <a href="#0" class="cd-close-form">Close</a> -->
		</div> <!-- cd-signup -->
		<div id="cd-reset-password"> <!-- reset password form -->
			<p class="cd-form-message">Esquece sua senha? Digite o seu email. Você receberá o link para criar uma nova senha.</p>
			<form class="cd-form">
				<p class="fieldset">
					<label class="image-replace cd-email" for="reset-email">E-mail</label>
					<input class="full-width has-padding has-border" id="reset-email" type="email" placeholder="Email" required>
					<span class="cd-error-message">Error message here!</span>
				</p>
				<p class="fieldset">
					<input class="full-width has-padding" type="submit" value="Resetar Senha">
				</p>
			</form>
			<p class="cd-form-bottom-message"><a href="#0"><< Entrar</a></p>
		</div> <!-- cd-reset-password -->
		<a href="#0" class="cd-close-form">Close</a>
	</div> <!-- cd-user-modal-container -->
</div> <!-- cd-user-modal -->
<section class="about_us_area" id="GRAPHIC">
	<div class="container">
		<div class="row">
			<div class="col-md-12 text-center">
				<div class="about_title">
					<h2>{{ $response['titulo'] }}</h2>
					<h4>{{ $response['periodo'] }}</h4>
					<img src="{{ url('images/shape.png') }}" alt="">
				</div>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="row">
			<div class="col-md-9  wow fadeInLeft animated">
				<div id="grafico" style="width:100%; height:500px;"></div>
			</div>
			<div class="col-md-3  wow fadeInRight animated line">
				<h2 style="margin-top:0">{{ $response['cidade']['nome'] }}</h2><br>
				<label>Área: </label><span> {{ $response['cidade']['area'] }} km²</span><hr>
				<label>População Estimada ({{ $response['cidade']['populacao']['ano'] }}): </label><span> {{ $response['cidade']['populacao']['tam'] }}  hab.</span><hr>
				<label>PIB (2012): </label><span> R$ {{ $response['cidade']['pib'] }}</span><hr>
				<label>Total Investido: </label><span> R$ {{ $response['cidade']['total'] }}</span><hr>
				<label>Área Mais Investida: </label><span style="text-transform: capitalize"> {{ $response['cidade']['area_mais_investida'] }}</span><br>
				<div class="col-md-4">
					<h3>Tipo:</h3>
				</div>
				<div class="col-md-8" style="padding-top: 13px; padding-bottom: 15px">
					<span><input type="radio" name="type" value="column" checked> Coluna</span><br>
					<span><input type="radio" name="type" value="pie"> Pizza</span><br>
				</div>
				@if(Session::get('isLogged'))
					<div class="text-right" style="padding-top:20px">
						<button id="btn_salvar" class="btnsearch cs-btn" type="submit">Salvar Gráfico</button>
						{!! Form::open(['url' => 'details/city']) !!}
							{!! Form::hidden('titulo', $response['titulo']) !!}
							{!! Form::hidden('periodo', $response['periodo']) !!}
							{!! Form::hidden('cidade', $response['cidade']['nome']) !!}
							<button id="btn_detalhes" class="btnsearch cs-btn" type="submit" style="margin-top:10px">+ Detalhes</button>
						{!! Form::close() !!}
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
						<a id="link4" class="link"><h2>INVESTIMENTO POR SETOR EM RELAÇÃO A POPULAÇÃO</h2></a>
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
	{!! Form::open(['url' => 'save/city']) !!}
		<fieldset>
				{!! Form::hidden('periodo', $response['periodo']) !!}
				{!! Form::hidden('cidade', $response['cidade']['nome']) !!}
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
<script src="{{ url('js/modernizr.js') }}"></script> <!-- Modernizr -->
<script src="{{ url('js/main.js') }}"></script> <!-- Gem jQuery -->
<script src="http://code.highcharts.com/highcharts.js"></script>
<script>
$(function () {
	var options = {
		chart: {
        	plotBorderWidth: 0
    	},
		title: {
			text: ''
		},
		tooltip: {
			valuePrefix: 'R$ ',
			shared: true,
			valueSuffix: ' milhões'
		},
		xAxis: {
			categories: [{!! $response['funcao'] !!}]
		},
		yAxis: {
			title: {
				text: 'Investimento (em R$ Milhões)'
			}
		},
		plotOptions: {
			pie: {
				plotBorderWidth: 0,
				allowPointSelect: true,
				cursor: 'pointer',
				size: '100%',
				dataLabels: {
					enabled: true,
					format: '{point.name}: <b>{point.percentage: .1f}%</b>'
				}
			}
		},
		series: [{
			name: 'Setores',
			colorByPoint: true,
			data: [
			@foreach($response['graph'] as $g)
				{
					name: '{!! $g["name"] !!}',
					y: {!! $g['y'] !!},
				},
			@endforeach
			]
		}]
	};
	options.chart.renderTo = 'grafico';
	options.chart.type = 'column';
	var chart1 = new Highcharts.Chart(options);

	$('input[type=radio]').click(function () {
		var type = $(this).val();
		if(type === 'column') {
		    options.chart.renderTo = 'grafico';
		    options.chart.type = 'column';
		    var chart1 = new Highcharts.Chart(options);
		} else if(type === 'pie') {
	        options.chart.renderTo = 'grafico';
	        options.chart.type = 'pie';
	        var chart1 = new Highcharts.Chart(options);
		}
	});
});
</script>
<script src="{{ url('js/jquery-ui.js') }}"></script> <!-- jQuery UI -->
<script src="{{ url('js/my-scripts.js') }}"></script> <!-- My Scripts -->
@stop
