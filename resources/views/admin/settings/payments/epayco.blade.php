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
	<form action="{{ route('admin.settings.payments.setepayco') }}" method="POST" class="form-horizontal">
		@csrf
		<div class="form-group {{ $errors->has('client_id') ? ' has-error' : '' }}">
			<label for="client_id" class="col-sm-3 control-label">ID Cliente:</label>
			<div class="col-sm-9">
				<input type="text" name="client_id" id="client_id" value="{{ old('client_id', (!is_null($epayco)) ? $epayco->client_id : '') }}" class="form-control">
			</div>
		</div>
		<div class="form-group {{ $errors->has('public_key') ? ' has-error' : '' }}">
			<label for="public_key" class="col-sm-3 control-label">Llave Pública:</label>
			<div class="col-sm-9">
				<input type="text" name="public_key" id="public_key" value="{{ old('public_key', (!is_null($epayco)) ? $epayco->public_key : '') }}" class="form-control">
			</div>
		</div>
		<div class="form-group {{ $errors->has('private_key') ? ' has-error' : '' }}">
			<label for="private_key" class="col-sm-3 control-label">Llave Privada:</label>
			<div class="col-sm-9">
				<input type="text" name="private_key" id="private_key" value="{{ old('private_key', (!is_null($epayco)) ? $epayco->private_key : '') }}" class="form-control">
			</div>
		</div>
		<div class="form-group {{ $errors->has('active') ? ' has-error' : '' }}">
			<label for="active" class="col-sm-3 control-label">Activo:</label>
			<div class="col-sm-9">
				<input type="checkbox" name="active" id="active" {{ old('active') || (!is_null($epayco) && $epayco->active) ? 'checked' : '' }}>
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
