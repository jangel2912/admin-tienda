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
	<form action="{{ route('admin.settings.payments.setpayu') }}" method="POST" class="form-horizontal">
		@csrf
		<div class="form-group {{ $errors->has('merchant_id') ? ' has-error' : '' }}">
			<label for="merchant_id" class="col-sm-3 control-label">Merchant ID:</label>
			<div class="col-sm-9">
				<input type="text" name="merchant_id" id="merchant_id" value="{{ old('merchant_id', (!is_null($payu)) ? $payu->merchant_id : '') }}" class="form-control">
			</div>
		</div>
		<div class="form-group {{ $errors->has('account_id') ? ' has-error' : '' }}">
			<label for="account_id" class="col-sm-3 control-label">Account ID:</label>
			<div class="col-sm-9">
				<input type="text" name="account_id" id="account_id" value="{{ old('account_id', (!is_null($payu)) ? $payu->account_id : '') }}" class="form-control">
			</div>
		</div>
		<div class="form-group {{ $errors->has('api_key') ? ' has-error' : '' }}">
			<label for="api_key" class="col-sm-3 control-label">API Key:</label>
			<div class="col-sm-9">
				<input type="text" name="api_key" id="api_key" value="{{ old('api_key', (!is_null($payu)) ? $payu->api_key : '') }}" class="form-control">
			</div>
		</div>
		<div class="form-group {{ $errors->has('payu_test_mode') ? ' has-error' : '' }}">
			<label for="payu_test_mode" class="col-sm-3 control-label">Entorno de prueba:</label>
			<div class="col-sm-9">
				<input type="checkbox" name="payu_test_mode" id="payu_test_mode" {{ old('payu_test_mode') || (!is_null($payu) && $payu->payu_test_mode) ? 'checked' : '' }}>
			</div>
		</div>
		<div class="form-group {{ $errors->has('active') ? ' has-error' : '' }}">
			<label for="active" class="col-sm-3 control-label">Activo:</label>
			<div class="col-sm-9">
				<input type="checkbox" name="active" id="active" {{ old('active') || (!is_null($payu) && $payu->active) ? 'checked' : '' }}>
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
