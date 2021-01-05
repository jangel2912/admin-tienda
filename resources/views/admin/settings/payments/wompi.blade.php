@extends('admin.layout.content')
@section('title', 'Ajustes')
@section('panel-content')
<hr/>
<div class="row">
    <div class="col-md-3">
        @include('admin.settings.partials.menu', ['activeMenu' => 'payment'])
    </div>
    <div class="col-md-9">
        @include('admin.partials.alerts')
        @include('admin.settings.partials.payment-methods')
        <div class="form-group">
            <div class="col-sm-3">
                <img src="/img/logo_wompi.png" class="img-responsive img-thumbnail preview-logo">
            </div>
            <div class="col-sm-9">
                <p>WOMPI es la pasarela de pagos de Bancolombia que te permite recibir pagos con tarjetas debito, credito, Nequi y transferencias entre cuentas Bancolombia, Actívate en el plan #ColombiaNosNecesitaATodos hasta el 31 de Mayo y no tendrás cargos de comisión hasta el 15 de Junio de 2020.</p>
            </div>
        </div>
        <form action="{{ route('admin.settings.payments.setwompi') }}" method="POST" class="form-horizontal" autocomplete="off">
            @csrf
            <div class="form-group {{ $errors->has('public_key') ? ' has-error' : '' }}">
                <label for="public_key" class="col-sm-3 control-label">Llave pública:</label>
                <div class="col-sm-9">
                    <input type="text" name="public_key" id="public_key" value="{{ old('public_key', (!is_null($wompi)) ? $wompi->public_key : '') }}" class="form-control">
                </div>
            </div>
            <div class="form-group {{ $errors->has('private_key') ? ' has-error' : '' }}">
                <label for="private_key" class="col-sm-3 control-label">Llave privada:</label>
                <div class="col-sm-9">
                    <input type="text" name="private_key" id="private_key" value="{{ old('private_key', (!is_null($wompi)) ? $wompi->private_key : '') }}" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-9">
                    <a target="_blank" href="https://ayuda.vendty.com/es/articles/4029304-como-configurar-wompi-en-vendty">¿Dónde encuentro mis claves?</a>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-9">
                    Crea tu cuenta Wompi &nbsp;<a target="_blank" href="https://comercios.wompi.co/">AQUÍ</a>
                </div>
            </div>
            {{old('active') }}
            <div class="form-group {{ $errors->has('active') ? ' has-error' : '' }}">
                <label for="active" class="col-sm-3 control-label">Activo:</label>
                <div class="col-sm-9">
                    <input type="checkbox" name="active" id="active" {{ old('active') || (!is_null($wompi) && $wompi->active) ? 'checked' : '' }}>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-9">
                    <button type="submit" class="btn btn-success">Actualizar</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/css/settings.css') }}">
@endpush
