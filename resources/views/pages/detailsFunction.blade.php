@extends('master')
@section('styles')
<link rel="stylesheet" href="{{ url('css/responsive-tables.css') }}">
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
@section('content')
<section class="about_us_area" id="DETAILS">
    <div class="container">
		<div class="row">
			<div class="col-md-12 text-center">
				<div class="about_title">
					<h2>{{ Session::get('titulo') }}</h2>
					<h4>{{ Session::get('cidade') }} - {{ Session::get('periodo') }}</h4>
					<img src="{{ url('images/shape.png') }}" alt="">
				</div>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="row">
			<div class="col-md-12 text-center wow fadeInRight animated">
				<center>
					<table class="responsive flat-table flat-table-2" style="font-size: 10px">
						<thead>
							<th>Credor</th>
							<th>Subsetor</th>
							<th>Fonte de Recurso</th>
							<th>Valor Pago (R$)</th>
                            <th>Natureza da Despesa</th>
						</thead>
						<tbody>
							@foreach($response as $v)
								<tr>
									<td>{!! $v['credor_secretaria'] !!}</td>
									<td>{!! $v['subfuncao'] !!}</td>
									<td>{!! $v['fonte_de_recurso'] !!}</td>
                                    <td>{!! $v['valor_pago_acumulado'] !!}</td>
                                    <td>{!! $v['natureza_da_despesa'] !!}</td>
								</tr>
							@endforeach
						</tbody>
					</table>
					{!! $response->render() !!}
				</center>
			</div>
		</div>
	</div>
</section>
@stop
@section('scripts')
<script src="{{ url('js/responsive-tables.js') }}"></script> <!-- Responsive Tables -->
@stop
