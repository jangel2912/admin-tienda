@extends('admin.layout.auth')

@section('content')
<div class="elementor-image">
    <img height="47" src="/img/logo.png" alt="Vendty Software POS logo" style="padding-right: 20px;" />
    <img height="47" src="/img/logo_bluecaribu.png" alt="Bluecaribu logo" />
</div>
<div class="elementor-widget-container">
    <h2 class="elementor-heading-title">Crea tu tienda virtual en solo 5 minutos</h2>
</div>
<div class="container">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h1 class="title">Pruébalo Gratis 7 Días</h1>
            <h3 class="subtitle">Te ayudamos a configurar y te capacitamos</h3>
        </div>
        <div class="panel-body">
            <form id="shopForm" class="form-horizontal" role="form" method="POST" action="{{ route('register') }}">
                {{ csrf_field() }}

                <div class="row">
                    <div class="col-md-12">
                        <input id="first_name" type="text" class="form-element" name="first_name" value="{{ old('first_name') }}" placeholder="Nombre" required="required" aria-required="true" autofocus />
                        @if ($errors->has('first_name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('first_name') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="col-md-12">
                        <input id="last_name" type="text" class="form-element" name="last_name" value="{{ old('last_name') }}" placeholder="Apellido" required="required" aria-required="true" autofocus />
                        @if ($errors->has('last_name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('last_name') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="col-md-12">
                        <input id="email" type="email" class="form-element" name="email" value="{{ old('email') }}" placeholder="Email" required="required" aria-required="true" />
                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="col-md-5">
                        <select id="prefix" name="prefix" class="form-element" required="required" aria-required="true">
                            <option value="57" {{ old('prefix') == '57' ? 'selected' : '' }}>🇨🇴 +57</option>
                            <option value="54" {{ old('prefix') == '54' ? 'selected' : '' }}>🇦🇷 +54</option>
                            <option value="591" {{ old('prefix') == '591' ? 'selected' : '' }}>🇧🇴 +591</option>
                            <option value="55" {{ old('prefix') == '55' ? 'selected' : '' }}>🇧🇷 +55</option>
                            <option value="56" {{ old('prefix') == '56' ? 'selected' : '' }}>🇨🇱 +56</option>
                            <option value="506" {{ old('prefix') == '506' ? 'selected' : '' }}>🇨🇷 +506</option>
                            <option value="593" {{ old('prefix') == '593' ? 'selected' : '' }}>🇪🇨 +593</option>
                            <option value="503" {{ old('prefix') == '503' ? 'selected' : '' }}>🇸🇻 +503</option>
                            <option value="502" {{ old('prefix') == '502' ? 'selected' : '' }}>🇬🇹 +502</option>
                            <option value="504" {{ old('prefix') == '504' ? 'selected' : '' }}>🇭🇳 +504</option>
                            <option value="52" {{ old('prefix') == '52' ? 'selected' : '' }}>🇲🇽 +52</option>
                            <option value="505" {{ old('prefix') == '505' ? 'selected' : '' }}>🇳🇮 +505</option>
                            <option value="51" {{ old('prefix') == '51' ? 'selected' : '' }}>🇵🇪 +51</option>
                            <option value="595" {{ old('prefix') == '595' ? 'selected' : '' }}>🇵🇾 +595</option>
                            <option value="1" {{ old('prefix') == '1' ? 'selected' : '' }}>🇵🇷 +1</option>
                            <option value="598" {{ old('prefix') == '598' ? 'selected' : '' }}>🇺🇾 +598</option>
                            <option value="58" {{ old('prefix') == '58' ? 'selected' : '' }}>🇻🇪 +58</option>>
                        </select>
                    </div>
                    <div class="col-md-7 no-padding-left">
                        <input id="phone" type="text" class="form-element" name="phone" value="{{ old('phone') }}" placeholder="Teléfono" required="required" aria-required="true" />
                    </div>
                    <div class="col-md-12">
                        @if ($errors->has('prefix'))
                            <span class="help-block">
                                <strong>{{ $errors->first('prefix') }}</strong>
                            </span>
                        @endif
                        @if ($errors->has('phone'))
                            <span class="help-block">
                                <strong>{{ $errors->first('phone') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="col-md-12">
                        <input id="shopname" type="text" class="form-element" name="shopname" value="{{ old('shopname') }}" placeholder="Nombre de tu tienda" required="required" aria-required="true" />
                        @if ($errors->has('shopname'))
                            <span class="help-block">
                                <strong>{{ $errors->first('shopname') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="col-md-12">
                        <input id="nit" type="text" class="form-element" name="nit" value="{{ old('nit') }}" placeholder="NIT o Cédula" required="required" aria-required="true" />
                        @if ($errors->has('nit'))
                            <span class="help-block">
                                <strong>{{ $errors->first('nit') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="col-md-1" style="margin-top:20px;">
                        <input type="checkbox" name="terms" value="1" {{ old('terms') == '1' ? 'checked' : '' }}>
                    </div>
                    <div class="col-md-11 no-padding-left" style="margin-top:20px;">
                        <p>Aceptar nuestros <a href="https://vendty.com/terminosycondiciones.pdf">términos y condiciones</a></p>
                    </div>
                    <div class="col-md-12">
                        @if ($errors->has('terms'))
                            <span class="help-block">
                                <strong>{{ $errors->first('terms') }}</strong>
                            </span>
                        @endif
                    </div>

                    <input type="hidden" class="form-element" name="ally" value="bluecaribu" />

                    <div class="col-md-12">
                        <button id="submitButton" type="submit"  onclick="$('#loader').show();" class="button">Crear Mi Tienda</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@include('admin.partials.zoho')
<style>
.container {
    background-color: #fff;
    border: 1px solid #ededed;
    border-radius: 5px;
    padding: 30px 70px 20px;
    margin-bottom: 5px;
    width: 545px;
}
.panel-body {
    margin: 15px 20px 0;
}
.form-element {
    width: 100%;
    max-width: 100%;
    border: 1px solid #ededed;
    background-color: #fff;
    font-family: roboto,Sans-serif;
    font-weight: 400;
    color: #7a7a7a;
    margin-top: 10px;
    font-size: 15px;
    min-height: 40px;
    padding: 5px 14px;
    border-radius: 3px;
}
.form-element::placeholder {
    color: #7a7a7a;
    font-size: 15px;
}
.button {
    cursor: pointer;
    background-color: #23a455;
    min-height: 72px;
    font-size: 24px;
    font-family: roboto,Sans-serif;
    font-weight: 500;
    margin-top: 30px;
    width: 100%;
    border-radius: 36px;
    color: #fff;
}
.button:hover {
    background-color: #007a3f;
}
.title {
    color: #23a455;
    font-size: 37px;
    font-weight: 600;
    margin: 0;
    line-height: 1;
}
.subtitle {
    color: #000;
    font-size: 19px;
    font-weight: 400;
    margin: 0;
    line-height: 1;
}
body {
    font-family: "Poppins",Sans-serif;
    letter-spacing: -1px;
    text-align: center;
    background-color: #f7f7f7;
}
.elementor-widget-container {
    margin: 0 0 34px;
}
.elementor-heading-title {
    color: #444a4c;
    font-size: 22px;
    font-weight: 600;
    margin: 0;
    line-height: 1;
}
.elementor-image {
    margin-bottom: 20px;
    padding: 30px 30px 0;
}
.no-padding-left {
    padding-left: 0;
}
.help-block{
    color: red;
}
</style>
@endsection

@push('scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
			$("#submitButton").click(function(e){
				e.preventDefault();

				//Own fields
				var nombre = $("#first_name").val();
				var lastName = $("#last_name").val();
				var correo = $("#email").val();
				var telefono = $("#prefix").val() + $("#phone").val();
				var empresa = $("#shopname").val();

				//Crm fields
				var xnQsjsdp = $("input[name='xnQsjsdp']").val();
				var zc_gad = $("input[name='zc_gad']").val();
				var xmIwtLD = $("input[name='xmIwtLD']").val();
				var actionType = $("input[name='actionType']").val();
				var returnURL = $("input[name='returnURL']").val();
				var LEADCF6 = $("select[name='LEADCF6']").val();
				var LEADCF7 = "Bancolombia";
                var LEADCF3 = "BlueCaribu";
				var formUrl = $("#crmWebToEntityForm form").attr('action');

				$.ajax({
					url: formUrl,
					dataType: "html",
					data: {
						'xnQsjsdp': xnQsjsdp,
						'zc_gad': zc_gad,
						'xmIwtLD': xmIwtLD,
						'actionType': actionType,
						'returnURL': returnURL,
						'First Name': nombre,
						'Last Name': lastName,
						'Email': correo,
						'Phone': telefono,
						'LEADCF6': LEADCF6,
                        'LEADCF7': LEADCF7,
                        'LEADCF3': LEADCF3
					},
					success: function(response){
						$("#shopForm").submit();
					},
					error: function(jqXHR, textStatus, errorThrow){
						console.log(textStatus + " " + textStatus);
						$("#shopForm").submit();
					}
				});
			});
		});
    </script>
@endpush
