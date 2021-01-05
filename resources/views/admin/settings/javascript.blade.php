@extends('admin.layout.content')
@section('title', 'JavaScript')
@section('panel-content')
<div class="col-md-3">
	@include('admin.settings.partials.menu')
</div>
<div class="col-md-9">
	@include('admin.partials.alerts')
	<form action="{{ route('admin.settings.setjavascript') }}" method="POST" class="form-horizontal" autocomplete="off">
        @csrf
		<div class="form-group">
			<div class="col-sm-3 leyenda">
				<label for="analytics" class="control-label">Código de Google Analytics: <i class="fas fa-question-circle icon-leyenda"></i></label>
				<br>
				<small class="info-leyenda">Analiza las estadísticas de tu tienda virtual con el poder de Google Analytics. Solo debes ingresar el codigo. Ejemplo: UA-XXXXXXXX-1</small>
			</div>
			<div class="col-sm-9">
				<input type="text" name="analytics" id="analytics" class="form-control" value="{{ $analytics }}" placeholder="Ejemplo: UA-XXXXXXXX-1">
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<button type="submit" class="btn btn-success">Actualizar</button>
			</div>
		</div>
	</form>
</div>
@endsection
@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('admin/css/settings.css') }}">
@endpush
