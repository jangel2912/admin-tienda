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
        <form action="{{ route('admin.settings.payments.setmercadopago') }}" method="POST" class="form-horizontal" autocomplete="off">
            @csrf
            <div class="form-group {{ $errors->has('public_key') ? ' has-error' : '' }}">
                <label for="public_key" class="col-sm-3 control-label">Llave Pública:</label>
                <div class="col-sm-9">
                    <input type="text" name="public_key" id="public_key" value="{{ old('public_key', (!is_null($mercadopago)) ? $mercadopago->public_key : '') }}" class="form-control">
                </div>
            </div>
            <div class="form-group {{ $errors->has('access_token') ? ' has-error' : '' }}">
                <label for="access_token" class="col-sm-3 control-label">Token de Acceso:</label>
                <div class="col-sm-9">
                    <input type="text" name="access_token" id="access_token" value="{{ old('access_token', (!is_null($mercadopago)) ? $mercadopago->access_token : '') }}" class="form-control">
                </div>
            </div>
            <div class="form-group {{ $errors->has('mercadopago_country') ? ' has-error' : '' }}">
                <label for="mercadopago_country" class="col-sm-3 control-label">País de la cuenta:</label>
                <div class="col-sm-9">
                    <select type="text" name="mercadopago_country" id="mercadopago_country" value="{{ old('mercadopago_country', (!is_null($mercadopago)) ? $mercadopago->mercadopago_country : '') }}" class="form-control">
                        @foreach($countries as $key => $country)
                            <option value="{{ $key }}" {{ old('mercadopago_country', !is_null($mercadopago) ? $mercadopago->mercadopago_country : 'co') == $key ? 'selected' : '' }}>{{ $country }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group {{ $errors->has('active') ? ' has-error' : '' }}">
                <label for="active" class="col-sm-3 control-label">Activo:</label>
                <div class="col-sm-9">
                    <input type="checkbox" name="active" id="active" {{ old('active') || (!is_null($mercadopago) && $mercadopago->active) ? 'checked' : '' }}>
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
