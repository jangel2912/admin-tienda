@extends('admin.layout.app')
@section('title', 'Paso 1 - Wizard')
@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-12">
                    <h4><strong>Bienvenido a tu asistente de configuración</strong></h4>
                    <h5>Sigue los siguientes pasos y en 5 minutos tendrás tu tienda virtual en línea</h5>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <div class="step-container">
                @include('admin.wizard.partials.steps')
                <div class="step-content">
                    <form action="{{ route('admin.wizard.firststep.store') }}" method="POST" class="form-horizontal" autocomplete="off">
                        <div class="row">
                            <div class="col-md-8 col-md-offset-2">
                                @include('admin.partials.alerts')
                            </div>
                            <div class="col-md-6 col-md-offset-3">
                                @csrf
                                <div class="form-group {{ $errors->has('shopname') ? ' has-error' : '' }}">
                                    <label for="shopname" class="col-sm-4 control-label">Nombre de tu tienda*:</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="shopname" id="shopname" value="{{ old('shopname', (!is_null($shop)) ? $shop->shopname : '') }}" class="form-control" placeholder="Ejemplo: Mi Tienda Store" required>
                                    </div>
                                </div>

                                <div class="form-group {{ $errors->has('dominio_local') ? ' has-error' : '' }}">
                                    <label for="dominio_local" class="col-sm-4 control-label">Dominio Local*:</label>
                                    <div class="col-sm-8 local_domain_shop">
                                        <input type="text" name="dominio_local" id="dominio_local" value="{{ old('dominio_local', (!is_null($shop)) ? $shop->dominio_local : '') }}" class="form-control local_domain" placeholder="Ejemplo: mitiendastore" required>
                                        <input type="text" value=".vendty.com" class="form-control shop" readonly>
                                    </div>
                                </div>

                                @if (count($warehouses) > 1)
                                <div class="form-group {{ $errors->has('warehouse') ? ' has-error' : '' }}">
                                    <label for="warehouse" class="col-sm-4 control-label">Almacen*:</label>
                                    <div class="col-sm-8">
                                        <select name="warehouse" id="warehouse" class="form-control" required>
                                            @foreach($warehouses as $warehouse)
                                                <option value="{{ $warehouse->id }}" {{ (!is_null($shop) && $shop->id_almacen == $warehouse->id) ? 'selected' : '' }}>{{ $warehouse->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                @else
                                    <input type="hidden" name="warehouse" id="warehouse" value="{{ old('warehouse', (!is_null($warehouses[0])) ? $warehouses[0]->id : '') }}" class="form-control" placeholder="Ejemplo: Mi Tienda Store" required>
                                @endif

                                <div class="form-group {{ $errors->has('country') ? ' has-error' : '' }}">
                                    <label for="country" class="col-sm-4 control-label">País*:</label>
                                    <div class="col-sm-8">
                                        <select name="country" id="country" class="form-control" required>
                                            @foreach($countries as $country)
                                                <option value="{{ $country }}" {{ old('country', auth_user()->pais) == $country ? 'selected' : '' }}>{{ $country }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group {{ $errors->has('currency') ? ' has-error' : '' }}">
                                    <label for="currency" class="col-sm-4 control-label">Moneda*:</label>
                                    <div class="col-sm-8">
                                        <select name="currency" id="currency" class="form-control" required>
                                            @foreach($currencies as $currency)
                                                <option value="{{ $currency['AlphabeticCode'] }}" {{ old('currency', option('tipo_moneda')) == $currency['AlphabeticCode'] ? 'selected' : '' }}>{{ $currency['AlphabeticCode'] . ' - ' . $currency['Currency'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <p class="required">* Campos requeridos</p>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-2 col-sm-offset-8">
                                <button type="submit" class="btn btn-success btn-block">Siguiente</button>
                            </div>
                        </div>
                        <br>
                        <small>(*) Encuentra tus  credenciales de acceso en el la bandeja de entrada o SPAM de tu correo</small>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('admin/css/steps.css') }}">
@endpush
