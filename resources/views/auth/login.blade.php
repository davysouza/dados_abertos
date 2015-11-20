@extends('masterAuth');
@section('content')
<div class="container" style="margin-top: 50px">
    <div class="row">
        <div class="col-md-8 col-md-offset-2 form-content">
            <h3 class="heading">Entrar</h3>
            @foreach($errors->all() as $error)
                <p class="alert alert-danger">{!! $error !!}</p>
            @endforeach
            {!! Form::open(['url' => 'auth/login', 'class'=>'form form-horizontal', 'style'=>'margin-top:50px']) !!}
                <div class="form-group">
                    <label for="email" class="col-sm-3 control-label">Email:</label>
                    <div class="col-sm-8">
                        <input id="email" name="email" type="email" class="form-control" autofocus required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="password" class="col-sm-3 control-label">Senha:</label>
                    <div class="col-sm-8">
                        <input id="password" name="password" type="password" class="form-control" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="checkbox col-sm-3 control-label">
                        {!! Form::checkbox('remember', 'remember', true) !!} Lembre-se de mim
                    </label>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-default">Entrar</button>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@stop
@section('scripts')
<script>
    $('#email').on('invalid', function(e) {
        e.target.setCustomValidity("");
        if (e.target.validity.valueMissing) {
            e.target.setCustomValidity("Email Inválido!");
        }
    });
</script>
@stop
