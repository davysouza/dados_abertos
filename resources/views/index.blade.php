@extends('master')
@section('nav')
<ul class="nav navbar-nav navbar-right main-nav">
	<li><a href="#HOME">Início</a></li>
	<li><a href="#SERVICE">Buscar</a></li>
	<li><a href="#ABOUT">Sobre</a></li>
	@if(Session::get('isLogged'))
		<li><a href="user" style="text-transform: none"> Olá {!! Session::get('name') !!},</a></li>
		<li><a href="/auth/logout" style="text-transform: none">Sair</a></li>
	@else
		<li><a class="btn-login cd-signin" href="#0">Entrar</a></li>
		<li><a class="btn-signin cd-signup" href="#0">Cadastre-se</a></li>
	@endif
</ul>
@stop
@section('home')
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
					<input class="full-width has-padding has-border" id="signup-password" name="password" type="password"  placeholder="Senha" required>
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
@stop
@section('scripts')
<script src="{{ url('js/modernizr.js') }}"></script> <!-- Modernizr -->
<script src="{{ url('js/main.js') }}"></script> <!-- Gem jQuery -->
<script src="{{ url('js/my-scripts.js') }}"></script> <!-- My Scripts -->
@stop
