@extends('master')

@section('nav')
<ul class="nav navbar-nav navbar-right">
	<li><a href="#HOME">Início</a></li>
	<li><a href="#SERVICE">Buscar</a></li>
	<li><a href="#ABOUT">Sobre</a></li>
</ul>
@stop
@section('home')
<style>
	.dateinput{
		border-top: none;
		border-left: none;
		border-right: none;
		border-bottom: solid 1px #ddd;
		margin-left: 30px; 
		line-height: 2em; 
		width: 15em; 
		font-size: 20px;
		font-family: Segoe UI,Frutiger,Frutiger Linotype,Dejavu Sans,Helvetica Neue,Arial,sans-serif;
	}
	.btnsearch{
		border: none;
		padding: .8em 2em;
		background: antiquewhite;
	}
	.link{
		color: #777;
	}
	.link h2:hover{
		color: #DE5E5E;
	}
</style>

<div class="container">
	<div class="row">
		<div class="col-md-12 text-center">
			<div class="home_text wow fadeInUp animated">
				<h2>Dados Abertos Governamentais</h2>
				<p>Transparência e qualidade de informação</p>
				<img src="{{ url('images/shape.png') }}" alt="">
			</div>
		</div>
	</div>
</div>
<div class="container">
	<div class="row">
		<div class="col-md-12 text-center">
			<div class="scroll_down">
				<a href="#SERVICE"><img src="{{ url('images/scroll.png') }}" alt=""></a>
				<h4>Rolar</h4>
			</div>
		</div>
	</div>
</div>
@stop

@section('content')
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
					<a id="link1" class="link"><h2>BUSCA POR SETOR</h2></a>
					<div class="progress">
						<div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 80%;">
							<span class="sr-only">60% Complete</span>
						</div>
					</div>
				</div>
				<div class="single_progress_bar linque">
					<a id="link2" class="link"><h2>BUSCA POR CIDADE</h2></a>
					<div class="progress">
						<div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 80%;">
							<span class="sr-only">60% Complete</span>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-7  wow fadeInRight animated">
				{!! Form::open(['url' => 'search/function']) !!}
				<div id="search1" class="search">
					<input id="datainifunc" name="datainifunc" class="dateinput" type="date" required />
					<input id="datafimfunc" name="datafimfunc" class="dateinput" type="date" required />
					<br>
					<select id="funcao" name="funcao" style="width: 200px; height: 40px; margin: 30px">
						<option value="">Escolha uma área...</option>
						<option value="EDUCAÇÃO">Educação</option>
						<option value="SAÚDE">Saúde</option>
						<option value="CIÊNCIA">Ciência e Tecnologia</option>
						<option value="TRANSPORTE">Transporte</option>
						<option value="SANEAMENTO">Saneamento Básico</option>
					</select>
					<button id="btn_sub" class="btnsearch" type="submit">Buscar</button>
				</div>
				{!! Form::close() !!}
			</div>
			<div class="col-md-7  wow fadeInRight animated">
				{!! Form::open(['url' => 'search/city']) !!}
				<div id="search2" class="search" style="display: none">
					<input id="datainicity" name="datainicity" class="dateinput" type="date" required />
					<input id="datafimcity" name="datafimcity" class="dateinput" type="date" required />
					<br>
					<select id="cidade" name="cidade" style="width: 200px; height: 40px; margin: 30px">
						<option value="">Escolha uma cidade... </option>
						<option value="Campinas">Campinas</option>
						<option value="São José dos Campos">São José dos Campos</option>
					</select>
					<button id="btn_sub" class="btnsearch" type="submit">Buscar</button>
				</div>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
</section>

<section class="about_us_area" id="ABOUT">
	<div class="container">
		<div class="row">
			<div class="col-md-12 text-center">
				<div class="about_title">
					<h2>Sobre</h2>
					<img src="{{ url('images/shape.png') }}" alt="">
				</div>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="row">
			<div class="col-md-4  wow fadeInLeft animated">
			</div>
			<div class="col-md-4  wow fadeInRight animated" style="text-align: center">
				<p class="about_us_p">"Dados abertos governamentais resulta de uma necessidade da sociedade por uma maior transparência e participação na gestão dos recursos públicos. "</p>
				<hr>
			</div>
			<div class="col-md-4  wow fadeInRight animated">
				<p class="about_us_p"></p>
			</div>
		</div>
	</div>
</section>
@stop
@section('scripts')
<script>
	$("#link1").click(function () {
		$("#search2").hide(500);
		$("#search1").show(700);
	});
	$("#link2").click(function () {
		$("#search1").hide(500);
		$("#search2").show(700);
	});
</script>
@stop