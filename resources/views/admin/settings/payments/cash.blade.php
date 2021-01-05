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
        <form action="{{ route('admin.settings.payments.setcash') }}" method="POST" class="form-horizontal">
            @csrf
            <div class="form-group {{ $errors->has('active') ? ' has-error' : '' }}">
                <label for="active" class="col-sm-2 control-label">Activo:</label>
                <div class="col-sm-1">
                    <input type="checkbox" name="active" id="active" {{ old('active') || (!is_null($cash) && $cash->active) ? 'checked' : '' }}>
                </div>
                <div class="col-sm-9">
                    <small>Utilice esta opción si recibe pago en efectivo</small>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
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
