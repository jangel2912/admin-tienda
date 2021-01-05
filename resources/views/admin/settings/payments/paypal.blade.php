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
	<form action="{{ route('admin.settings.payments.setpaypal') }}" method="POST" class="form-horizontal">
		@csrf
		<div class="form-group {{ $errors->has('client_id') ? ' has-error' : '' }}">
			<label for="client_id" class="col-sm-3 control-label">Client ID:</label>
			<div class="col-sm-9">
				<input type="text" name="client_id" id="client_id" value="{{ old('client_id', (!is_null($paypal)) ? $paypal->client_id : '') }}" class="form-control">
			</div>
		</div>
		<div class="form-group {{ $errors->has('secret_id') ? ' has-error' : '' }}">
			<label for="secret_id" class="col-sm-3 control-label">Secret ID (Opcional):</label>
			<div class="col-sm-9">
				<input type="text" name="secret_id" id="secret_id" value="{{ old('secret_id', (!is_null($paypal)) ? $paypal->secret_id : '') }}" class="form-control">
			</div>
		</div>
		<div class="form-group {{ $errors->has('active') ? ' has-error' : '' }}">
			<label for="active" class="col-sm-3 control-label">Activo:</label>
			<div class="col-sm-9">
				<input type="checkbox" name="active" id="active" {{ old('active') || (!is_null($paypal) && $paypal->active) ? 'checked' : '' }}>
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
