@extends('admin.layout.auth')

@section('content')
<div class="content-login">
    <div class="row m-0">
        <div class="col-xs-10 col-xs-offset-1 col-sm-offset-0 col-sm-5">
            <div class="login">
                <img class="brand-img" src="/admin/img/logo.png" alt="Vendty" width="200px" style="margin: auto;">
                <h2>Iniciar sesión</h2>
                @if(session()->has('danger'))
                    <div class="alert alert-danger">
                    {{ session('danger') }}
                    </div>
                @elseif(session()->has('warning'))
                    <div class="alert alert-warning">
                    {!! session('warning') !!}
                    </div>
                @endif
                <form role="form" method="POST" action="{{ url('/admin/login') }}">
                    {{ csrf_field() }}
                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="email" class="col-md-12 control-label">tu correo electrónico</label>
                        <div class="col-md-12">
                            <input id="email" type="email" class="form-control" name="email" placeholder="EMAIL" value="{{ old('email') }}" autofocus required>
                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <label for="password" class="col-md-12 control-label">tu contraseña</label>
                        <div class="col-md-12">
                            <input id="password" type="password" class="form-control" name="password" placeholder="***********" required>
                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <button type="submit" class="button-login">
                                Iniciar Sesión
                            </button>
                        </div>
                    </div>
                    <div class="links-login">
                        <a href="{{ route('register') }}">Crear una cuenta</a>
                    </div>
                </form>
            </div>
        </div>
        <div class="hidden-xs col-sm-7 gradient"></div>
    </div>
</div>
@endsection
