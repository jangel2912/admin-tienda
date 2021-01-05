@extends('admin.layout.content')
@section('title', 'Todos Gratis')
@section('panel-content')
    <div class="col-md-3">
        @include('admin.settings.partials.menu')
    </div>
    <div class="col-md-9">
        @include('admin.partials.alerts')
        @include('admin.settings.partials.shipping')
        <form action="#" method="POST" class="form-horizontal">
            @csrf
            <div class="form-group">
                <label for="client_id" class="col-sm-2 control-label">ID Cliente:</label>
                <div class="col-sm-10">
                    <input type="text" name="client_id" id="client_id" value="" class="form-control">
                </div>
            </div>

        </form>
    </div>
@endsection
@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/css/settings.css') }}">
@endpush
