@extends('admin.layout.app')
@section('title', 'Escritorio')
@section('content')
    @include('admin.partials.alerts')
    <div class="row">
        <div class="col-sm-6 col-md-3">
            <div class="info-card blue">
                <div class="info-card-icon pull-left">
                    <i class="fas fa-globe"></i>
                </div>
                <div class="content">
                    <h3>{{ $visits }}</h3>
                    <h4>Visitas</h4>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="info-card indigo">
                <div class="info-card-icon pull-left">
                    <i class="fas fa-clipboard-list"></i>
                </div>
                <div class="content">
                    <h3>{{ $orders }}</h3>
                    <h4>Pedidos</h4>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="info-card green">
                <div class="info-card-icon pull-left">
                    <i class="far fa-credit-card"></i>
                </div>
                <div class="content">
                    <h3>{{ $sales }}</h3>
                    <h4>Ventas</h4>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="info-card green-light">
                <div class="info-card-icon pull-left">
                    <i class="fas fa-cubes"></i>
                </div>
                <div class="content">
                    <h3>{{ $quantity }}</h3>
                    <h4>Artículos Vendidos</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-8 col-md-9">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div id="container" style="min-width: 310px; height: 200px; margin: 0 auto"></div>
                </div>
            </div>
        </div>
        <div class="col-sm-4 col-md-3">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h4>Meta a cumplir</h4>
                    <hr>
                    <div id="chart-circle-container" style="height: 160px; width: 100%;" data-percent="{{ $goal }}">
                        <span>{{ $goal }}%</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('moduleTitle')
    <div class="info-module">
        <div class="col-md-12">
            <div class="container">
                <div class="col-md-2" style="background-color: #5DAE56; border-radius: 5px;">
                    <h4 style="color: white;">Sigue estos pasos para personalizar tu tienda virtual.</h4>
                </div>
                <div class="col-md-1" style="background-color: #ECF9ED; padding-top: 13.6px; padding-bottom: 13.6px; padding-left: 5px;">
                    <div class="flecha-right">
                    </div>
                </div>
                <div class="col-md-2 svg-positions">
                    <a href="{{ route('admin.settings.getbasic') }}">
                        <img height="38" src="{{ asset('admin/icons/negro/logo_svg.svg') }}" class="icons" alt="Dashboard">
                        <h5>Cambiar Logo</h5>
                    </a>
                </div>
                <div class="col-md-2 svg-positions">
                    <a href="{{ route('admin.settings.getsliders') }}">
                        <img height="38" src="{{ asset('admin/icons/negro/banner_svg.svg') }}" class="icons" alt="Dashboard">
                        <h5>Cambiar Banner</h5>
                    </a>
                </div>
                <div class="col-md-2 svg-positions">
                    <a href="{{ route('admin.products.index') }}">
                        <img height="38" src="{{ asset('admin/icons/negro/productos_svg.svg') }}" class="icons" alt="Pedidos">
                        <h5>Tus Productos</h5>
                    </a>
                </div>
                <div class="col-md-2 svg-positions">
                    <a href="{{ route('admin.settings.payments.setwompi') }}">
                        <img height="38" src="{{ asset('admin/icons/negro/redes_svg.svg') }}" class="icons" alt="Inventario">
                        <h5>Pasarelas de Pago</h5>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endpush
@push('styles')
    <link rel="stylesheet" href="{{ asset('admin/css/dashboard.css') }}">
    <style>
        .panel-body h4 {
            text-align: center;
            margin: 0;
        }

        .panel-body hr {
            margin: 10px;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('admin/css/steps.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/templates.css') }}">
@endpush
@push('scripts')
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="{{ asset('bower_components/jquery.easy-pie-chart/dist/jquery.easypiechart.min.js') }}"></script>
    <script src="{{ asset('admin/js/dashboard.js') }}"></script>
    <script type="text/javascript">
        $('#chart-circle-container').easyPieChart({
            barColor: '#37bc9b',
            scaleLength: 0,
            lineWidth: 10,
            size: 150
        });
    </script>
    @if (is_null($nit))
        <script type="text/javascript">
            $(window).on('load',function(){
                $('#myModal').modal({backdrop: 'static', keyboard: false});
            });
        </script>
    @endif
@endpush

@push('modals')
    @if (is_null($nit))
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="formMyModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="{{ route('admin.dashboard.updateData') }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h4 class="modal-title" id="formMyModalLabel">Actualiza tus datos</h4>
                        </div>
                        <div class="modal-body">
                            @include('admin.partials.alerts')
                            <div class="form-group">
                                <label for="nit" class="control-label">NIT o Cédula:</label>
                                <input type="text" name="nit" id="nit" value="{{ !is_null($nit) ? $nit : '' }}" class="form-control" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Guardar y Salir</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
@endpush
