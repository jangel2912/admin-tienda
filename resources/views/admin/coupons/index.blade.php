@extends('admin.layout.content')
@section('title', 'Cupones')
@section('panel-content')
    <hr/>
    @include('admin.partials.alerts')
    <div class="row">
        <div class="col-md-4">
        {{--
            <form action="/admin/categories" method="get" style="display:flex;">
                {{ csrf_field() }}
                <input class="text-input" name="search_text" placeholder="Nombre de la categoría" style="padding: 6px 12px;margin-top: 0px;width: calc(100% - 40px);border-top-right-radius: 0;border-bottom-right-radius: 0;" type="text" name="q" value="{{ request()->search_text }}" />
                <button class="btn btn-success btn-block" type="submit" style="width: 100px;height: 10%;border-top-left-radius: 0;border-bottom-left-radius: 0;" value="Submit">Buscar</button>
            </form>
        --}}
        </div>
        <div class="col-md-2 col-md-offset-6">
            <a href="{{ route('admin.coupons.create') }}" class="btn btn-success btn-block">Nuevo Cupón</a>
        </div>
    </div>
    <ul class="nav nav-tabs">
        <li role="presentation" class="active"><a href="#">Lista de Cupones</a></li>
    </ul>
    <table id="coupons" class="table">
        <thead>
        <tr>
            <th>Nombre</th>
            <th>Tipo de cupón</th>
            <th>Importe del cupón</th>
            <th>Descripción</th>
            <th>Fecha de caducidad</th>
            <th>Opciones</th>
        </tr>
        </thead>
        <tbody>
        @foreach($coupons as $coupon)
            <tr>
                <td>{{ $coupon->nombre }}</td>
                <td>{{ $coupon->coupon_type}}</td>
                <td>{{ $coupon->importe}}</td>
                <td>{{ $coupon->descripcion}}</td>
                <td>{{ $coupon->end_in->format('d/m/Y') }}</td>
                <td>
                    <div class="btn-group" role="group" aria-label="options">
                        <a href="{{ route('admin.coupons.edit', $coupon) }}" class="btn btn-warning btn-sm">Editar</a>
                        <a href="{{ route('admin.coupons.destroy', $coupon) }}" onclick="event.preventDefault(); document.getElementById('deactivate-coupon-{{ $coupon->id }}').submit();" class="btn btn-danger btn-sm">Eliminar</a>
                    </div>
                    <form id="deactivate-coupon-{{ $coupon->id }}" action="{{ route('admin.coupons.destroy', $coupon) }}" method="POST">
                        @csrf
                        @method('DELETE')
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
