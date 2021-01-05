@extends('admin.layout.content')
@section('title', 'Redes Sociales')
@section('panel-content')
<hr/>
<div class="row">
    <div class="col-md-3">
        @include('admin.info.partials.menu', ['activeMenu' => 'social'])
    </div>
    <div class="col-md-9">
        @include('admin.partials.alerts')
        <form action="{{ route('admin.info.setsocialnetworks') }}" method="POST" class="form-horizontal" autocomplete="off">
            @csrf
            <div class="form-group">
                <label for="facebook" class="col-sm-3 control-label">Facebook:</label>
                <div class="col-sm-9">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fab fa-facebook"></i></span>
                        <input type="url" name="facebook" id="facebook" value="{{ (!is_null($social)) ? $social->facebook : '' }}" class="form-control">
                    </div>
                    <small>Ejemplo: https://www.facebook.com/mitienda</small>
                </div>
            </div>
            <div class="form-group">
                <label for="instagram" class="col-sm-3 control-label">Instagram:</label>
                <div class="col-sm-9">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fab fa-instagram"></i></span>
                        <input type="url" name="instagram" id="instagram" value="{{ (!is_null($social)) ? $social->instagram : '' }}" class="form-control">
                    </div>
                    <small>Ejemplo: https://www.instagram.com/mitienda</small>
                </div>
            </div>
            <div class="form-group">
                <label for="twitter" class="col-sm-3 control-label">Twitter:</label>
                <div class="col-sm-9">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fab fa-twitter"></i></span>
                        <input type="url" name="twitter" id="twitter" value="{{ (!is_null($social)) ? $social->twitter : '' }}" class="form-control">
                    </div>
                    <small>Ejemplo: https://www.twitter.com/mitienda</small>
                </div>
            </div>
            <div class="form-group">
                <label for="youtube" class="col-sm-3 control-label">YouTube:</label>
                <div class="col-sm-9">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fab fa-youtube"></i></span>
                        <input type="url" name="youtube" id="youtube" value="{{ (!is_null($social)) ? $social->youtube : '' }}" class="form-control">
                    </div>
                    <small>Ejemplo: https://www.youtube.com/channel/mitienda</small>
                </div>
            </div>
            <div class="form-group">
                <label for="linkedin" class="col-sm-3 control-label">Linkedin:</label>
                <div class="col-sm-9">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fab fa-linkedin"></i></span>
                        <input type="url" name="linkedin" id="linkedin" value="{{ (!is_null($social)) ? $social->linkedin : '' }}" class="form-control">
                    </div>
                    <small>Ejemplo: https://www.linkedin.com/in/mitienda</small>
                </div>
            </div>
            <div class="form-group">
                <label for="pinterest" class="col-sm-3 control-label">Pinterest:</label>
                <div class="col-sm-9">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fab fa-pinterest"></i></span>
                        <input type="url" name="pinterest" id="pinterest" value="{{ (!is_null($social)) ? $social->pinterest : '' }}" class="form-control">
                    </div>
                    <small>Ejemplo: https://www.pinterest.es/mitienda</small>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-10">
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
