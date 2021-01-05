@extends('admin.layout.content')
@section('title', 'Pedidos')
@section('panel-content')
    <hr>
    <div class="row">
        <div class="col-md-5">
            <form action="/admin/orders" method="get"  style="display:flex;">
                {{ csrf_field() }}
                <div class="form-group">
                    <div class='input-group date' id='date_initial'>
                        <input type='text' class="form-control" id="initial_date" name="initial_date" placeholder="Fecha Inicial" value="{{ request()->initial_date }}"/>
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>
                <div class="form-group">
                    <div class='input-group date' id='date_final'>
                        <input type="text" class="form-control" id="final_date" name="final_date" placeholder="Fecha Final" value="{{ request()->final_date }}"/>
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>
                <button class="btn btn-success btn-block" type="submit" style="width: 100px;height: 10%;border-top-left-radius: 0;border-bottom-left-radius: 0;" value="Submit">Buscar</button>
            </form>
        </div>
        <div class="col-md-5 col-md-offset-2 text-right">
            <div class="btn-group">
                <button type="button" class="btn btn-primary" onclick="download()">Descargar Pedidos</button>
            </div>
        </div>
    </div>
    <br>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>#</th>
            <th>Nombre</th>
            <th>Cédula</th>
            <th>Correo Electrónico</th>
            <th>Fecha</th>
            <th>Valor</th>
            <th>Estado</th>
            <th>Pago</th>
            <th>Entrega</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($orders as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->nombre }}</td>
                <td>{{ $order->dni }}</td>
                <td>{{ $order->email }}</td>
                <td>{{ $order->fecha->format('d/m/Y h:i A') }}</td>
                <td>{{ $order->present()->subTotal() }}</td>
                <td>{{ $order->present()->orderStatus() }}</td>
                <td>{{ $order->metodo_pago }}</td>
                <td>
                    @if (isset($order->schedule->pickUp) && !empty($order->schedule->pickUp) )
                        {{$order->schedule->pickUp}}
                    @else
                        <span class='label label-warning'>Inmediata</span>
                    @endif
                </td>
                <td>
                    <div class="btn-group" role="group" aria-label="...">
                        <button type="button" class="btn btn-default modal-details" data-sale="{{ $order->id }}">
                            <img alt="editar" src="{{ asset('admin/icons/gris/icono_gris-23.svg') }}">
                        </button>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $orders->links() }}
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" integrity="sha512-aEe/ZxePawj0+G2R+AaIxgrQuKT68I28qh+wgLrcAJOz3rxCP+TwrK5SPN+E5I+1IQjNtcfvb96HDagwrKRdBw==" crossorigin="anonymous" />
    <style>
        .btn-group img {
            width: 100%;
            margin-right: -133px;
            display: block;
        }
    </style>
@endpush

@push('modals')
    <!-- Modal -->
    <div class="modal fade bs-example-modal-lg" id="orderDetails" tabindex="-1" role="dialog" aria-labelledby="orderDetailsLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="orderDetailsLabel">Detalles de la Solicitud de Venta Online #<span id="id-sale"></span></h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h3>Datos del Cliente</h3>
                            <table class="table table-bordered">
                                <tbody>
                                <tr>
                                    <th>Nombre y Apellido:</th>
                                    <td id="name-customer"></td>
                                </tr>
                                <tr>
                                    <th>Cédula:</th>
                                    <td id="dni-customer"></td>
                                </tr>
                                <tr>
                                    <th>Correo Electrénico:</th>
                                    <td id="email-customer"></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h3>Datos para el Envío</h3>
                            <table class="table table-bordered">
                                <tbody>
                                <tr>
                                    <th>Contacto:</th>
                                    <td id="name-contact"></td>
                                </tr>
                                <tr>
                                    <th>Correo Electrónico:</th>
                                    <td id="email-contact"></td>
                                </tr>
                                <tr>
                                    <th>Teléfono:</th>
                                    <td id="phone-contact"></td>
                                </tr>
                                <tr>
                                    <th>Dirección de envío:</th>
                                    <td id="address-contact"></td>
                                </tr>
                                <tr>
                                    <th>Ciudad:</th>
                                    <td id="city-contact"></td>
                                </tr>
                                <tr>
                                    <th>Detalles de tu direcci&oacute;n:</th>
                                    <td id="address-details"></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <h3>Productos</h3>
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Precio Unitario</th>
                                    <th>Cantidad</th>
                                    <th>Subtotal</th>
                                </tr>
                                </thead>
                                <tbody id="producs-sale">

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <h3>Cupones</h3>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th width="80%">Nombre</th>
                                        <th>Precio</th>
                                    </tr>
                                </thead>
                                <tbody id="coupons">

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div id="note_customer">

                    </div>
                    <div id="schedule">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
@endpush

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.27.0/moment-with-locales.min.js" integrity="sha512-qSnlnyh7EcD3vTqRoSP4LYsy2yVuqqmnkM9tW4dWo6xvAoxuVXyM36qZK54fyCmHoY1iKi9FJAUZrlPqmGNXFw==" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.27.0/locale/es.min.js" integrity="sha512-tgY2qswcbQir80Vp67s5ZdbKikl99YmVXp3V/C4Acthk4gI29ONbQ+MR8B5tpESkNoa0N1P7HnSuzC6nOflrwA==" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js" integrity="sha512-GDey37RZAxFkpFeJorEUwNoIbkTwsyC736KNSYucu1WJWFK9qTdzYub8ATxktr6Dwke7nbFaioypzbDOQykoRg==" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.27.0/locale/es.min.js" integrity="sha512-tgY2qswcbQir80Vp67s5ZdbKikl99YmVXp3V/C4Acthk4gI29ONbQ+MR8B5tpESkNoa0N1P7HnSuzC6nOflrwA==" crossorigin="anonymous"></script>
    <script type="text/javascript">
        moment.locale('es');

        $('.modal-details').click(function(event) {
            event.preventDefault();
            var _id = $(this).data('sale');
            $('#producs-sale').html('');
            $('#coupons').html('');
            $('#schedule').html('');
            $.getJSON('/admin/order/' + _id, function(json, textStatus) {
                $('#id-sale').text(json.id);
                $('#name-customer').text(json.nombre + ' ' + json.apellidos);
                $('#dni-customer').text(json.dni);
                $('#email-customer').text(json.email);
                $('#email-contact').text(json.email);
                $('#phone-contact').text(json.movil);
                $('#address-contact').text(json.direccion);
                $('#city-contact').text(json.poblacion);
                $('#address-details').text(json.notas);

                if (json.notas_adicionales !== "") {
                    $('#note_customer').html('<div class="alert alert-info" role="alert"><h5>¡Nota de ' + json.nombre + '!</h5><span id="note">' + json.notas_adicionales + '</span></div>');
                } else {
                    $('#note_customer').html('');
                }

                if(json.schedule !== null){
                    $('#schedule').html("<div class='alert alert-warning' role='alert'><p>Esta orden debe ser entregada " + moment(json.schedule.sale_date).format("DD/MM/YYYY") + " "+ moment(json.schedule.sale_time, "HH:mm").format("hh:mm a") + "</p></div>");
                }
                else{
                    $('#schedule').html("<div class='alert alert-warning' role='alert'><p>Entrega inmediata</p></div>");
                }

                $.each(json.online_venta_prod, function(index, val) {
                    var aditionsResult = "";
                    var modificationsResult = "";
                    
                    if(val.online_venta_aditions.length > 0) {
                        $.each(val.online_venta_aditions, function(index, aditions) {
                            aditionsResult += "<li>" + aditions.qty + " " + aditions.adition.aditional.nombre + "</li>";
                        });
                        aditionsResult = "<p><strong>Adiciones</strong><p><ul>" + aditionsResult + "</ul>";
                    }

                    if(val.online_venta_modifications.length > 0) {
                        $.each(val.online_venta_modifications, function(index, modifications) {
                            modificationsResult += "<li>" + modifications.modification.nombre + "</li>";
                        });
                        modificationsResult = "<p><strong>Modificaciones</strong><p><ul>" + modificationsResult + "</ul>";
                    }
                    
                    $('#producs-sale').append('<tr><td><h4>' + val.descripcion + '</h4> ' + aditionsResult + modificationsResult + '</td><td>' + val.precio + '</td><td>' + val.cantidad + '</td><td>' + val.total + '</td></tr>');
                });

                
                if(json.clients.length > 0){
                    $.each(json.clients, function(index, val) {
                        $('#coupons').append('<tr><td>' + val.coupon.nombre + '</td><td>' + val.coupon_value + '</td></tr>');
                    });
                }
                else {
                    $('#coupons').append('<tr><td colspan="2" class="text-center">No existen cupones en este pedido.</td></tr>');
                }



                $('#orderDetails').modal('show');
            });
        });

        $(function () {
            $('#date_initial').datetimepicker({format: 'YYYY-MM-DD'});
            $('#date_final').datetimepicker({format: 'YYYY-MM-DD'});
            $("#date_initial").on("dp.change", function (e) {
                $('#date_final').data("DateTimePicker").minDate(e.date);
            });
            $("#date_final").on("dp.change", function (e) {
                $('#date_initial').data("DateTimePicker").maxDate(e.date);
            });
        });

        function download() {
            $url = '{{ route("admin.orders.download") }}';
            $initial_date = $('#initial_date').val();
            $final_date = $('#final_date').val();

            location.href = $url + '?initial_date=' + $initial_date + '&final_date=' + $final_date
        };
    </script>
@endpush
