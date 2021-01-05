@extends('admin.layout.content')
@section('title', 'Plan Invalido')
@section('panel-content')
<div class="col-md-3">
	@include('admin.settings.partials.menu')
</div>
<div class="col-md-9">
	@include('admin.partials.alerts')
	<div class="row">
		<div class="col-md-9 col-md-offset-1">
			<div class="alert alert-info" style="text-align: center;">
				<h4>Para poder configurar la pasarela de pago ePayco o PayU debe tiener una Plan Empresarial.</h4>
				<p>Si desea actualizar su plan actual, puede comunicarse con nosotros a traves del Nro. de Teléfono <a href="tel:+573194751398">+57 319 475 1398</a> o al Correo Electrénico: <a href="mailto:info@vendty.com">info@vendty.com</a></p>
			</div>
		</div>
	</div>
</div>
@endsection
@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('admin/css/settings.css') }}">
@endpush