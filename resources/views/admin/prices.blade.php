@extends('admin.layout.content')
@section('title', 'Planes y Precios')
@section('panel-content')
<div>
    <div class="col-md-12" style="text-align: center;">
        <h4><strong>Encoge tu plan y no te quedes sin vender Online</strong></h4>
        <h5>Tienda Virtual, Chat, CRM, Academia</h5>
    </div>
    <div class="col-md-10 col-md-offset-2 select-pay">
        <div class="col-md-3" style="padding-left: 40px; font-size: 20px">
            <a href="#" data-toggle="modal" data-target="#settingAllBy" style="color: black;">Pagando Mensual</a>
        </div>
        <div class="col-md-2">
            <label class="switch">
                <input type="checkbox" name="all_by_active" id="payActive" data-id="">
                <span class="slider round switch-color"></span>
            </label>
        </div>
        <div class="col-md-7 year-pay">
            <a href="#" data-toggle="modal" data-target="#settingAllBy" style="color: black;">Pagando Anualmente</a>
            <a href="#" data-toggle="modal" data-target="#settingAllBy">(Ahorra 2 meses)</a>
        </div>
    </div>
    <dvi class="col-md-12" style="display:flex;">
        <div class="col-md-4 col-md-offset-4 plan">
            <h2 id="pay">Mensual</h2>
            <div class="row price">
                <div class="col-xs-7 position-right"><h1><strong id="payValor">$ 99</strong></h1></div>
                <div class="col-xs-5 position-left"><h4><strong>&nbsp;mil</strong></h4></div>
                <br>
            </div>
            <div class="col-md-12 position-center" style="color: red; font-w: 6px important; text-decoration:line-through;"><h4><strong id="payValorBefore">&nbsp;</strong></h4></div>
            <!-- <h5 class="color-text">Ideal para negocios pequeños</h5> -->
            <a id="linkPay" target="_blanck" class="btn btn-success btn-border" href="">EMPEZAR AHORA</a>
            <hr>
            <div class="text-left">
                <h3>Punto de venta</h3>
                <h5><i class="fas fa-check color-check"></i>&nbsp;Tienda Virtual</h5>
                <h5><i class="fas fa-check color-check"></i>&nbsp;Incluye Certificado SSL</h5>
                <h5><i class="fas fa-check color-check"></i>&nbsp;Configura tu Propio Dominio</h5>
                <h5><i class="fas fa-check color-check"></i>&nbsp;Productos Ilimitados</h5>
                <h5><i class="fas fa-check color-check"></i>&nbsp;Pasarela de Pagos</h5>
                <h5><i class="fas fa-check color-check"></i>&nbsp;Calculo de Envío</h5>
                <h5><i class="fas fa-check color-check"></i>&nbsp;Redes Sociales</h5>
                <h5><i class="fas fa-check color-check"></i>&nbsp;Chat Boot</h5>
                <h5><i class="fas fa-check color-check"></i>&nbsp;CRM</h5>
                <h5><i class="fas fa-check color-check"></i>&nbsp;Bono Google Ads x $75USD</h5>
                <h5><i class="fas fa-check color-check"></i>&nbsp;Academia de Marketing</h5>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#payActive').change(function() {
            if(this.checked) {
                $('#pay').html('Anual');
                $('#payValor').html('$ 999');
                $('#payValorBefore').html('Antes $ 1.188.000');
                // $('#linkPay').attr('href', 'https://checkout.wompi.co/l/X4K49w')
            } else {
                $('#pay').html('Mensual');
                $('#payValor').html('$ 99');
                $('#payValorBefore').html('');
                // $('#linkPay').attr('href', 'https://checkout.wompi.co/l/oZ2Gi8')
            }
        });
    });
</script>
@endpush

@push('styles')
    <style>
        .plan {
            border: 1px solid #ddd;
            text-align: center;
            border-radius: 20px;
            padding: 0;
        }
        .plan-year {
            margin-left: 20px;
        }
        .row {
            display: flex;
        }
        .price {
            position: relative;
        }
        .price h4 {
            position: absolute;
            bottom: 0;
            padding-bottom: 3px;
            padding-left: 0px;
        }
        .position-right {
            padding-right: 0px;
            text-align: right;
        }
        .position-right h1 {
            margin-top: 0;
        }
        .position-left {
            padding-left: 0px;
            text-align: left;
        }
        .btn-border {
            border-radius: 32px;
            margin-top: 15px;
            margin-bottom: 15px;
        }
        .color-check {
            color: #5cb85c;
        }
        .text-left {
            text-align: left;
            padding-left: 15px;
        }
        .color-text {
            color: #777;
        }
        .select-pay{
            text-align: center;
            margin-top: 50px;
            border-bottom-width: 0px;
            margin-bottom: 30px;
        }
        .year-pay {
            font-size: 20px;
            padding-right: 150px;
            padding-left: 0px;
        }
        .switch-color {
            background-color: #5cb85c;
        }
    </style>
@endpush
