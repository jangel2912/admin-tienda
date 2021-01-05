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
                <img src="/img/logo_kushki.png" class="img-responsive img-thumbnail preview-logo">
            </div>
            <div class="col-sm-9">
                <p>Vende de forma global y recibe dinero en tu moneda local. Conecta distintos medios de pago en cada país con una sola integración.</p>
            </div>
        </div>
        <div class="clearfix"></div>
        <form action="{{ route('admin.settings.payments.setkushki') }}" method="POST" class="form-horizontal" autocomplete="off">
            @csrf
            <div class="form-group {{ $errors->has('merchant_public_id') ? ' has-error' : '' }}">
                <label for="merchant_public_id" class="col-sm-3 control-label">Llave pública:</label>
                <div class="col-sm-9">
                    <input type="text" name="merchant_public_id" id="merchant_public_id" value="{{ old('merchant_public_id', (!is_null($kushki)) ? $kushki->merchant_public_id : '') }}" class="form-control">
                </div>
            </div>
            <div class="form-group {{ $errors->has('merchant_private_id') ? ' has-error' : '' }}">
                <label for="merchant_private_id" class="col-sm-3 control-label">Llave privada:</label>
                <div class="col-sm-9">
                    <input type="text" name="merchant_private_id" id="merchant_private_id" value="{{ old('merchant_private_id', (!is_null($kushki)) ? $kushki->merchant_private_id : '') }}" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label for="kushki_environment" class="col-sm-3 control-label">Entorno de prueba:</label>
                <div class="col-sm-9">
                    <input type="checkbox" name="kushki_environment" id="kushki_environment" {{ old('kushki_environment') || (!is_null($kushki) && $kushki->kushki_environment) ? 'checked' : '' }}>
                </div>
            </div>
            <!-- <div class="form-group">
                <div class="col-sm-offset-3 col-sm-9">
                    <a target="_blank" href="https://ayuda.vendty.com/es/articles/4029304-como-configurar-wompi-en-vendty">¿Dónde encuentro mis claves?</a>
                </div>
            </div> -->
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-9">
                    Crea tu cuenta Kushki &nbsp;<a target="_blank" href="https://uat-console.kushkipagos.com/auth/signup">AQUÍ</a>
                </div>
            </div>
            {{old('active') }}
            <div class="form-group {{ $errors->has('active') ? ' has-error' : '' }}">
                <label for="active" class="col-sm-3 control-label">Activo:</label>
                <div class="col-sm-9">
                    <input type="checkbox" name="active" id="active" {{ old('active') || (!is_null($kushki) && $kushki->active) ? 'checked' : '' }}>
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
