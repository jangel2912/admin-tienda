@extends('admin.layout.content')
@section('title', 'Información SEO')
@section('panel-content')
<hr/>
<div class="row">
<div class="col-md-3">
	@include('admin.settings.partials.menu', ['activeMenu' => 'seo'])
</div>
<div class="col-md-9">
	@include('admin.partials.alerts')
    <div class="modules-header">
        <div class="row">
            <div class="col-md-12">
                <h4><strong>Permite que tu tienda sea encontrada por los buscadores</strong></h4>
                <h5>Conecta tu tienda a Google y pon una descripción que te haga destacar</h5>
            </div>
        </div>
    </div>
	<form action="{{ route('admin.settings.setseo') }}" method="POST" class="form-horizontal" autocomplete="off">
		@csrf
        <div class="form-group {{ $errors->has('google_analytics') ? ' has-error' : '' }}">
            <label for="google_analytics" class="col-sm-3 control-label">Código de Google Analytics:</label>
			<div class="col-sm-9">
                <input type="text" name="google_analytics" id="google_analytics" class="form-control" value="{{ old('google_analytics', (!is_null($google_analytics)) ? $google_analytics : '') }}" placeholder="Ejemplo: UA-XXXXXXXX-1">
				<small>Analiza las estadísticas de tu tienda virtual con el poder de Google Analitycs - &nbsp;<a target="_blank" href="https://analytics.google.com/analytics/web/provision/#/provision">Crear Cuenta.</a></small>
                <small><a target="_blank" href="https://ayuda.vendty.com/es/articles/4043951-medicion-con-google-analytics">¿Dónde encuentro mi Código de Google Analitycs?</a></small>
			</div>
		</div>
		<div class="form-group {{ $errors->has('google_tag_manager_id') ? ' has-error' : '' }}">
			<label for="google_tag_manager_id" class="col-sm-3 control-label">Google Tag Manager:</label>
			<div class="col-sm-9">
				<input name="google_tag_manager_id" type="text" class="form-control" value="{{ old('google_tag_manager_id', (!is_null($google_tag_manager_id)) ? $google_tag_manager_id : '') }}" placeholder="Ejemplo: GTM-XXXX"/>
                <small>Para conocer sobre Google Tag Manager click <a href="https://support.google.com/tagmanager/answer/6102821?hl=es#:~:text=Google%20Tag%20Manager%20es%20un,denomina%20de%20forma%20conjunta%20etiquetas." target="_blank">aquí.</a></small>
			</div>
		</div>
		<div class="form-group {{ $errors->has('google_search_console_id') ? ' has-error' : '' }}">
			<label for="google_search_console_id" class="col-sm-3 control-label">Google Search Console:</label>
			<div class="col-sm-9">
				<input name="google_search_console_id" type="text" class="form-control" value="{{ old('google_search_console_id', (!is_null($google_search_console_id)) ? $google_search_console_id : '') }}" placeholder="Ejemplo: XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX"/>
                <small>Para conocer sobre Google Search Console click <a href="https://support.google.com/webmasters/answer/9128668?hl=es" target="_blank">aquí.</a></small>
			</div>
		</div>
		<div class="form-group {{ $errors->has('facebook_pixel') ? ' has-error' : '' }}">
			<label for="facebook_pixel" class="col-sm-3 control-label">Facebook pixel:</label>
			<div class="col-sm-9">
				<input name="facebook_pixel" type="text" class="form-control" value="{{ old('facebook_pixel', (!is_null($facebook_pixel)) ? $facebook_pixel : '') }}" placeholder="Ejemplo: XXXXXXXXXXXXXXX"/>
                <small>Recolecta información de la actividad de la tienda y mide la efectividad de las campañas de Facebook Ads. Para conseguir tu id de Facebook Pixel click <a target="_blank" href="https://www.facebook.com/business/help/952192354843755?id=1205376682832142">aquí</a></small>
			</div>
		</div>
		<div class="form-group {{ $errors->has('seo_description') ? ' has-error' : '' }}">
			<label for="seo_description" class="col-sm-3 control-label">Descripción:</label>
			<div class="col-sm-9">
				<textarea name="seo_description" id="seo_description" class="form-control" placeholder="Ejemplo: Encuentra los mejores productos. Estamos a tu servicio para atenderte y prestarte la asesoría que necesitas.">{{ old('seo_description', (!is_null($seo_description)) ? $seo_description : '') }}</textarea>
                <small>Indica una breve descripción para tu tienda virtual. Esta descripción es la que mostraran los buscadores como Google sobre tu tienda.</small>
			</div>
		</div>
		<div class="form-group {{ $errors->has('seo_keywords') ? ' has-error' : '' }}">
			<label for="seo_keywords" class="col-sm-3 control-label">Palabras claves:</label>
			<div class="col-sm-9">
				<textarea name="seo_keywords" id="seo_keywords" class="form-control" placeholder="Ejemplo: tienda,productos,colombia">{{ old('seo_keywords', (!is_null($seo_keywords)) ? $seo_keywords : '') }}</textarea>
                <small>Puede indicar palabras descriptivas sobre tu tienda separadas por coma (,). Esto ayudará al posicionamiento de tu tienda y a encontrarla mucho más rápido.</small>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-3 col-sm-9">
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