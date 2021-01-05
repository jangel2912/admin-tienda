@extends('admin.layout.content')
@section('title', 'Formas de Envío')
@section('panel-content')
<div class="col-md-3">
	@include('admin.settings.partials.menu', ['activeMenu' => 'shipping'])
</div>
<div class="col-md-9">
	@include('admin.partials.alerts')
    <div id="alert-js"></div>
    <div class="modules-header">
        <div class="row">
            <div class="col-md-12">
                <h4><strong>Configura la forma como cobraras tus envíos</strong></h4>
                <h5>Tus envíos pueden ser gratis, cobrados a una sola tarifa o por destinos</h5>
            </div>
        </div>
    </div>
	<form action="{{ route('admin.settings.setshipping') }}" method="POST" class="form-horizontal" autocomplete="off">
		@csrf
        <div class="form-group {{ $errors->has('shipping') ? ' has-error' : '' }}">
            <input type="radio" name="shipping" id="AllFree" value="{{ $shipping[0]->id }}" {{ (old('shipping') === '1' || ($shipping[0]->nombre == 'envios_todos_gratis' && $shipping[0]->activo)) ? 'checked' : '' }}>
            <label for="AllFree" class="control-label">Todos los envios son Gratis</label>
		</div><hr>
		<div class="form-group {{ ($errors->has('shipping') || $errors->has('valorAllBy')) ? ' has-error' : '' }}">
            <input type="radio" name="shipping" id="AllBy" value="{{ $shipping[1]->id }}" {{ (old('shipping') === '2' || ($shipping[1]->nombre == 'envios_todos_por' && $shipping[1]->activo)) ? 'checked' : '' }}>
            <label for="AllBy" class="control-label">Todos los envios Cuestan</label>
            <input type="text" name="valorAllBy" class="form-control" value="{{ !is_null($shippingAllBy) ? $shippingAllBy->valor : '' }}">
		</div><hr>
		<div class="form-group {{ ($errors->has('shipping') || $errors->has('minimoFreeFrom') || $errors->has('valorFreeFrom')) ? ' has-error' : '' }}">
            <input type="radio" name="shipping" id="FreeFrom" value="{{ $shipping[2]->id }}" {{ (old('shipping') === '3' || ($shipping[2]->nombre == 'envios_gratis_desde' && $shipping[2]->activo)) ? 'checked' : '' }}>
            <label for="FreeFrom" class="control-label">Es Gratis si la compra supera los</label>
            <input type="text" name="minimoFreeFrom" class="form-control" value="{{ !is_null($shippingFreeFrom) ? $shippingFreeFrom->minimo : '' }}">
            <strong>si no, se cobra</strong>
            <input type="text" name="valorFreeFrom" class="form-control" value="{{ !is_null($shippingFreeFrom) ? $shippingFreeFrom->valor : '' }}">
		</div><hr>
		<div class="form-group {{ ($errors->has('shipping') || $errors->has('byDestination')) ? ' has-error' : '' }}">
            <input type="radio" name="shipping" id="byDestination" value="{{ $shipping[3]->id }}" {{ (old('shipping') === '4' || ($shipping[3]->nombre == 'envios_por_destino' && $shipping[3]->activo)) ? 'checked' : '' }}>
            <label for="byDestination" class="control-label">Cobrar por Destinos</label>
            <a type="button" class="btn" onclick="event.preventDefault(); location.href='{{ route('admin.shipping.download') }}'">Descarga Archivo</a>
            <a type="button" data-toggle="modal" data-target="#uploadExcel" class="btn">Cargar Archivo de Destinos</a>
            <a type="button" data-toggle="modal" data-target="#allDestination" class="btn">Destinos Cargados</a>
		</div><hr>
		<div class="form-group">
            <button type="submit" class="btn btn-success">Actualizar</button>
		</div>
    </form>
</div>
<div class="social">
    <ul>
        <li><a id="tutorial" data-toggle="modal" data-target="#viewVideo"></a></li>
    </ul>
</div>
@endsection

@push('modals')
    <!-- Modal -->
    <div class="modal fade bs-example-modal-lg" id="allDestination" tabindex="-1" role="dialog" aria-labelledby="allDestinationLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="allDestinationLabel">Todos los Destinos</h4>
                </div>
                <div class="modal-body">
                    <table id="destinations" class="table">
                        <thead>
                            <tr>
                                <th>Origen</th>
                                <th>Destino</th>
                                <th>Valor</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($shippingByDestination as $row)
                                <tr>
                                    <td>{{ $row->origen }}</td>
                                    <td>{{ $row->destino }}</td>
                                    <td>${{ number_format($row->valor, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="event.preventDefault(); location.href='{{ route('admin.shipping.download') }}'">Descarga un archivo de ejemplo</button>
                    {{-- <button type="button" class="btn btn-success">Agregar destino</button> --}}
                    <button type="button" data-toggle="modal" data-target="#uploadExcel" class="btn btn-success">Cargar desde Excel</button>
                    <button type="button" class="btn btn-delete" onclick="event.preventDefault(); location.href='{{ route('admin.shipping.delete') }}'">Eliminar destinos</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="uploadExcel" tabindex="-1" role="dialog" aria-labelledby="uploadExcelLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="uploadExcelLabel">Cargar Excel</h4>
                </div>
                <form id="upload-excel" action="{{ route('admin.settings.setshippingbydestination') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <p>El modelo de tu archivo de excel debe ser como la siguiente imagen:</p>
                        <img src="{{ asset('img/help-excel.jpg')  }}" alt="" class="img img-responsive">
                    </div>
                    <div class="modal-footer">
                        <input type="file" name="excel" id="excel-input" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">
                        <button type="button" id="search-file" class="btn btn-success">Buscar archivo</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <body>
        <div class="modal fade" id="viewVideo" tabindex="-1" role="dialog" aria-labelledby="uploadExcelLabel">
            <div class="modal-dialog" role="document" style="width: 900px;">
                <div class="modal-body">
                    <iframe id="playerid" width="800" height="538" src="" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </body>
@endpush

@push('styles')
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css">

    <link rel="stylesheet" type="text/css" href="{{ asset('admin/css/settings.css') }}">
    <!-- <link rel="stylesheet" href="{{ asset('admin/css/steps.css') }}"> -->
    <style>
        #excel-input {
            display: none;
        }

        .form-control {
            display:inline-block;
            width: 190px;
        }

        #tutorial {
            display: inline-block;
            margin: 0;
            float: right;
            color: #fff;
            background: #5ca745;
            text-decoration: none;
            border-radius: 5px;
            background-image: url(https://pos.vendty.com/uploads/iconos/Blanco/icono_blanco-35.svg) !important;
            background-image: url(https://pos.vendty.com/uploads/iconos/Blanco/icono_blanco-35.svg) !important;
            background-repeat: no-repeat;
            background-size: 25px;
            background-position: center;
        }

        #tutorial:after {
            color: #000;
            text-align: center;
            font-size: 11px;
            position: absolute;
            right: 27px;
            bottom: -38px;
            width: 100px;
        }
        .social {
            position: fixed;
            right: 0;
            top: 50vh;
            z-index: 2000;
        }
        .social ul li a {
            display: inline-block;
            width: 47px;
            height: 47px;
            color: #fff;
            background: #5ca745;
            text-decoration: none;
            -webkit-transition: all 500ms ease;
            -o-transition: all 500ms ease;
            transition: all 500ms ease;
            border-radius: 5px 0px 0px 5px;
            background-image: url(../../uploads/iconos/Blanco/icono_blanco-35.svg) !important;
            background-repeat: no-repeat;
            background-size: 35px;
            background-position: center;
            cursor: pointer;
        }
        .social ul {
            list-style: none;
        }
        </style>
@endpush

@push('scripts')
    <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="//cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script>
    <script>
        $('#search-file').click(function () {
            $('#excel-input').trigger('click');
        });

        $('#excel-input').change(function () {
            $('#myModal').modal('hide');
            $('#loader').show();
            $('#upload-excel').submit();
        });

        $('#destinations').DataTable({
            "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
            "language": {
                "lengthMenu": "Mostrar _MENU_ registros por página",
                "zeroRecords": "Nothing found - sorry",
                "info": "Página _PAGE_ de _PAGES_",
                "infoEmpty": "No hay registros",
                "infoFiltered": "(filtered from _MAX_ total records)",
                "search": "Buscar:",
                "oPaginate": {
                    "sFirst":    	"Primera",
                    "sPrevious": 	"Anterior",
                    "sNext":     	"Siguiente",
                    "sLast":     	"Ultima"
                },
            }
        });
    </script>
    <script>
        let video = 'https://www.youtube.com/embed/XzH-i36MKuQ';

        $('#viewVideo').on('shown.bs.modal', function () {
            $("#playerid").attr("src", video);
        });

        $('#viewVideo').on('hidden.bs.modal', function () {
            $("#playerid").attr("src", "");
        });
    </script>
@endpush
