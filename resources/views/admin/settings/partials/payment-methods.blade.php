
<div class="modules-header">
    <div class="row">
        <div class="col-md-12">
            <h4><strong>Configura tu pasarela de pagos y no pares de Vender</strong></h4>
            <h5>La pasarela te permite recibir pagos con tarjetas debito o crédito</h5>
        </div>
    </div>
</div>
<ul class="nav nav-tabs">
    @if (auth()->user()->dbConfig->shop->aliado === 'wompi')
        <li role="presentation" class="{{ (request()->path() == "admin/payments/wompi") ? 'active' : '' }}">
            <a href="{{ route('admin.settings.payments.getwompi') }}">Tarjeta Débito/Crédito</a>
        </li>
    @elseif (auth()->user()->dbConfig->shop->aliado === 'loreal')
        <li role="presentation" class="{{ (request()->path() == "admin/payments/mercadopago") ? 'active' : '' }}">
            <a href="{{ route('admin.settings.payments.getmercadopago') }}">MercadoPago</a>
        </li>
    @else
        <li role="presentation" class="{{ (request()->path() == "admin/payments/wompi") ? 'active' : '' }}">
            <a href="{{ route('admin.settings.payments.getwompi') }}">Wompi</a>
        </li>
        <li role="presentation" class="{{ (request()->path() == "admin/payments/epayco") ? 'active' : '' }}">
            <a href="{{ route('admin.settings.payments.getepayco') }}">ePayco</a>
        </li>
        <li role="presentation" class="{{ (request()->path() == "admin/payments/mercadopago") ? 'active' : '' }}">
            <a href="{{ route('admin.settings.payments.getmercadopago') }}">MercadoPago</a>
        </li>
        <li role="presentation" class="{{ (request()->path() == "admin/payments/kushki") ? 'active' : '' }}">
            <a href="{{ route('admin.settings.payments.getkushki') }}">Pago Kushki</a>
        </li>
        <li role="presentation" class="{{ (request()->path() == "admin/payments/payu") ? 'active' : '' }}">
            <a href="{{ route('admin.settings.payments.getpayu') }}">PayU</a>
        </li>
        <li role="presentation" class="{{ (request()->path() == "admin/payments/paymentez") ? 'active' : '' }}">
            <a href="{{ route('admin.settings.payments.getpaymentez') }}">Paymentez</a>
        </li>
        <li role="presentation" class="{{ (request()->path() == "admin/payments/paypal") ? 'active' : '' }}">
            <a href="{{ route('admin.settings.payments.getpaypal') }}">PayPal</a>
        </li>
        {{--<li role="presentation" class="{{ (request()->path() == "admin/payments/openpay") ? 'active' : '' }}">
            <a href="{{ route('admin.settings.payments.getopenpay') }}">OpenPay</a>
        </li>
        <li role="presentation" class="{{ (request()->path() == "admin/payments/paypal") ? 'active' : '' }}">
            <a href="{{ route('admin.settings.payments.getpaypal') }}">PayPal</a>
        </li>--}}
    @endif
	<li role="presentation" class="{{ (request()->path() == "admin/payments/cash") ? 'active' : '' }}">
		<a href="{{ route('admin.settings.payments.getcash') }}">Pago Contraentrega</a>
	</li>
</ul>
<br>

<div class="social">
    <ul>
        <li><a id="tutorial" data-toggle="modal" data-target="#viewVideo"></a></li>
    </ul>
</div>

@push('styles')
<!-- <link rel="stylesheet" href="{{ asset('admin/css/steps.css') }}"> -->
<style>
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

@push('modals')
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

@push('scripts')
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
