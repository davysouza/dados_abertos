@extends('masterAuth');
@section('content')
<div class="container" style="margin-top: 50px">
    <div class="row">
        <div class="col-md-8 col-md-offset-2 form-content">
            <h3 class="heading">Criar Nova Conta</h3>
            @foreach($errors->all() as $error)
                <p class="alert alert-danger">{!! $error !!}</p>
            @endforeach
            {!! Form::open(['url' => 'auth/register', 'class'=>'form form-horizontal', 'style'=>'margin-top:50px']) !!}
                <div class="form-group">
                    <label for="user" class="col-sm-3 control-label">Nome Completo:</label>
                    <div class="col-sm-8">
                        <input id="user" name="name" type="text" class="form-control" required autofocus>
                    </div>
                </div>
                <div class="form-group">
                    <label for="email" class="col-sm-3 control-label">Email:</label>
                    <div class="col-sm-8">
                        <input id="email" name="email" type="email" class="form-control" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="password" class="col-sm-3 control-label">Senha:</label>
                    <div class="col-sm-8">
                        <input id="password" name="password" type="password" class="form-control" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="password-confirm" class="col-sm-3 control-label">Confirmar Senha:</label>
                    <div class="col-sm-8">
                        <input id="password-confirm" name="password-confirm" type="password" class="form-control" required>
                    </div>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-default">Registrar</button>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@stop
@section('scripts')
<script>
    var password = $('#password')[0];
    var confirm_password = $('#password-confirm')[0];
    function validatePassword() {
    	if(password.value != confirm_password.value) {
    		confirm_password.setCustomValidity("Senhas não combinam.");
    	} else {
    		confirm_password.setCustomValidity('');
    	}
    }
    password.onchange = validatePassword;
    confirm_password.onkeyup = validatePassword;
</script>
<script>
    $('#user').on('invalid', function(e) {
        e.target.setCustomValidity("");
        if (e.target.validity.valueMissing) {
            e.target.setCustomValidity("Campo Obrigatório!");
        }
    });

    $('#email').on('invalid', function(e) {
        e.target.setCustomValidity("");
        if (e.target.validity.valueMissing) {
            e.target.setCustomValidity("Email Inválido!");
        }
    });
</script>
@stop
