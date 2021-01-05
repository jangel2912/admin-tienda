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
                <img src="/img/logo_paymentez.png" class="img-responsive img-thumbnail preview-logo bg-dark">
            </div>
            <div class="col-sm-9">
                <p>Con Paymentez al estar enlazados con switch transaccionales te integras una sola vez.</p>
            </div>
        </div>
        <div class="clearfix"></div>
        <form action="{{ route('admin.settings.payments.setpaymentez') }}" method="POST" class="form-horizontal" autocomplete="off">
            @csrf
            <div class="form-group {{ $errors->has('paymentez_app_code_client') ? ' has-error' : '' }}">
                <label for="paymentez_app_code_client" class="col-sm-3 control-label">App Code Client:</label>
                <div class="col-sm-9">
                    <input type="text" name="paymentez_app_code_client" id="paymentez_app_code_client" value="{{ old('paymentez_app_code_client', (!is_null($paymentez)) ? $paymentez->paymentez_app_code_client : '') }}" class="form-control">
                </div>
            </div>
            <div class="form-group {{ $errors->has('paymentez_app_key_client') ? ' has-error' : '' }}">
                <label for="paymentez_app_key_client" class="col-sm-3 control-label">App Key Client:</label>
                <div class="col-sm-9">
                    <input type="text" name="paymentez_app_key_client" id="paymentez_app_key_client" value="{{ old('paymentez_app_key_client', (!is_null($paymentez)) ? $paymentez->paymentez_app_key_client : '') }}" class="form-control">
                </div>
            </div>
            <div class="form-group {{ $errors->has('paymentez_app_code_server') ? ' has-error' : '' }}">
                <label for="paymentez_app_code_server" class="col-sm-3 control-label">App Code Server:</label>
                <div class="col-sm-9">
                    <input type="text" name="paymentez_app_code_server" id="paymentez_app_code_server" value="{{ old('paymentez_app_code_server', (!is_null($paymentez)) ? $paymentez->paymentez_app_code_server : '') }}" class="form-control">
                </div>
            </div>
            <div class="form-group {{ $errors->has('paymentez_app_key_server') ? ' has-error' : '' }}">
                <label for="paymentez_app_key_server" class="col-sm-3 control-label">App Key Server:</label>
                <div class="col-sm-9">
                    <input type="text" name="paymentez_app_key_server" id="paymentez_app_key_server" value="{{ old('paymentez_app_key_server', (!is_null($paymentez)) ? $paymentez->paymentez_app_key_server : '') }}" class="form-control">
                </div>
            </div>

            <div class="form-group">
                <label for="paymentez_environment" class="col-sm-3 control-label">Entorno:</label>
                <div class="col-sm-9">
                    <select name="paymentez_environment" id="paymentez_environment" class="form-control">
                        @foreach($environments as $key => $environment)
                            <option value="{{ $key }}" {{ old('mercadopago_country', (!is_null($paymentez)) && $paymentez->paymentez_environment == $key ? 'selected' : '' )}}>{{ $environment }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <!-- <div class="form-group">
                <div class="col-sm-offset-3 col-sm-9">
                    <a target="_blank" href="https://ayuda.vendty.com/es/articles/4029304-como-configurar-wompi-en-vendty">¿Dónde encuentro mis claves?</a>
                </div>
            </div> -->
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-9">
                    Crea tu cuenta Paymentez &nbsp;<a target="_blank" href="https://secure.paymentez.com/">AQUÍ</a>
                </div>
            </div>
            {{old('active') }}
            <div class="form-group {{ $errors->has('active') ? ' has-error' : '' }}">
                <label for="active" class="col-sm-3 control-label">Activo:</label>
                <div class="col-sm-9">
                    <input type="checkbox" name="active" id="active" {{ old('active') || (!is_null($paymentez) && $paymentez->active) ? 'checked' : '' }}>
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
