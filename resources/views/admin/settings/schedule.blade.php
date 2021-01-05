@extends('admin.layout.content')
@section('title', 'Horario')
@section('panel-content')
<div class="col-md-3">
	@include('admin.settings.partials.menu', ['activeMenu' => 'schedule'])
</div>
<div class="col-md-9">
	@include('admin.partials.alerts')
    <div class="modules-header">
        <div class="row">
            <div class="col-md-12">
                <h4><strong>Actualiza tu horario</strong></h4>
                <h5>Permite que tus pedidos se generen cuando tu negocio este funcionando</h5>
            </div>
        </div>
	</div>

	@if ($schedule->count() > 0)
		<table class="table">
			<tbody>
				@foreach ($schedule as $value)
					<tr>
						<td>
							{{$value->openDays}}
						</td>
						<td>
							{{$value->pick_up}}
						</td>
						<td>
							<div class="btn-group" role="group" aria-label="options">
								<a href="{{ route('admin.settings.getsingleschedule', $value->id) }}" class="btn btn-warning btn-sm editSchedule">Editar</a>
								<a href="javascript:void(false);" onclick="event.preventDefault(); document.getElementById('remove-schedule-{{ $value->id }}').submit();" class="btn btn-danger btn-sm">Eliminar</a>
							</div>
							<form id="remove-schedule-{{ $value->id }}" action="{{ route('admin.settings.removeschedule', $value->id) }}" method="POST">
								@csrf
								@method('DELETE')
							</form>
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	@endif
	

	<button id="addHours" class="btn btn-success" >Adicionar horas</button>
	<div id="errorMessages" style="display: none;" class="alert alert-danger">
		<p>Debe seleccionar los días de la semana.</p>
		<p>La hora de inicio debe ser menos que la hora de cierre.</p>
	</div>
	<form id="AddHoursForm" action="{{ route('admin.settings.setschedule') }}" method="POST" class="form-horizontal" autocomplete="off" style="display:none;">
		@csrf
		<table class="table table-schedule">
			<tr>
				<td>
					<label class="switch">
						<input type="checkbox" name="sunday" id="sunday" value="sunday" checked/>
						<span class="slider round"></span>
					</label>
				</td>
				<td>Domingo</td>
				<td>
					<label class="switch">
						<input type="checkbox" name="monday" id="monday" value="monday" checked/>
						<span class="slider round"></span>
					</label>
				</td>
				<td>Lunes</td>
				<td>
					<label class="switch">
						<input type="checkbox" name="tuesday" id="tuesday" value="tuesday" checked/>
						<span class="slider round"></span>
					</label>
				</td>
				<td>Martes</td>
				<td width="200px" rowspan="3">
					<div class='col-sm-12'>
						<input placeholder="Desde" type='text' class="form-control" id='datetimepicker-from'/>
					</div>
				</td>
				<td width="10px" class="text-center">
					-
				</td>
				<td width="200px" rowspan="3">
					<div class='col-sm-12'>
						<input placeholder="Hasta" type='text' class="form-control" id='datetimepicker-to'/>
					</div>
				</td>
			</tr>
			<tr>
				<td>
					<label class="switch">
						<input type="checkbox" name="wednesday" id="wednesday" value="wednesday" checked/>
						<span class="slider round"></span>
					</label>
				</td>
				<td>Miércoles</td>
				<td>
					<label class="switch">
						<input type="checkbox" name="thursday" id="thursday" value="thursday" checked/>
						<span class="slider round"></span>
					</label>
				</td>
				<td>Jueves</td>
				<td>
					<label class="switch">
						<input type="checkbox" name="friday" id="friday" value="friday" checked/>
						<span class="slider round"></span>
					</label>
				</td>
				<td>Viernes</td>
			</tr>
			<tr>
				<td>
					<label class="switch">
						<input type="checkbox" name="saturday" id="saturday" value="saturday" checked/>
						<span class="slider round"></span>
					</label>
				</td>
				<td colspan="5">Sábado</td>
			</tr>
		</table>
		<div class="form-group">
			<div class="col-sm-12">
				<input type="hidden" id="scheduleId" value="0"/>
				<button id="addDayServicesDate" class="btn btn-success">Actualizar</button>
			</div>
		</div>
	</form>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ asset('admin/css/settings.css') }}">
@endpush

@push('scripts')
<script type="text/javascript" src="{{ asset('bower_components/moment/min/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>
<script src="{{ asset('admin/js/schedule.js') }}"></script>
@endpush