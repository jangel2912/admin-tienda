<ul class="nav nav-pills nav-stacked">
	<li role="presentation">
		<a href="{{ route('admin.settings.getbasic') }}" class="{{isset($activeMenu) && $activeMenu == 'basic' ? 'settings-menu-active' : '' }}">
            <ion-icon name="information-circle-outline"></ion-icon>
            Información General
        </a>
    </li>
	<li role="presentation">
		<a href="{{ route('admin.settings.getlogo') }}" class="{{isset($activeMenu) && $activeMenu == 'logos' ? 'settings-menu-active' : '' }}">
			<ion-icon name="images-outline"></ion-icon>
			Logos
		</a>
	</li>
	<li role="presentation">
		<a href="{{ route('admin.settings.getdomains') }}" class="{{isset($activeMenu) && $activeMenu == 'domains' ? 'settings-menu-active' : '' }}">
			<ion-icon name="browsers-outline"></ion-icon>
			Dominio
		</a>
	</li>
	<li role="presentation">
		<a href="{{ route('admin.settings.getsliders') }}" class="{{isset($activeMenu) && $activeMenu == 'sliders' ? 'settings-menu-active' : '' }}">
			<ion-icon name="images-outline"></ion-icon>
			Banners
		</a>
	</li>
	<li role="presentation">
		<a href="{{ route('admin.settings.gettemplates') }}" class="{{isset($activeMenu) && $activeMenu == 'templates' ? 'settings-menu-active' : '' }}">
			<ion-icon name="cube-outline"></ion-icon>
            Plantillas
		</a>
	</li>
	<li role="presentation">
		<a href="{{ route('admin.settings.getseo') }}" class="{{isset($activeMenu) && $activeMenu == 'seo' ? 'settings-menu-active' : '' }}">
			<ion-icon name="logo-google"></ion-icon>
			SEO y Analytics
		</a>
	</li>
	<li role="presentation">
        @if (auth()->user()->dbConfig->shop->aliado === 'loreal')
            <a href="{{ route('admin.settings.payments.getmercadopago') }}" class="{{isset($activeMenu) && $activeMenu == 'payment' ? 'settings-menu-active' : '' }}">
                <ion-icon name="card-outline"></ion-icon>
                Formas de Pago
            </a>
        @else
            <a href="{{ route('admin.settings.payments.getwompi') }}" class="{{isset($activeMenu) && $activeMenu == 'payment' ? 'settings-menu-active' : '' }}">
                <ion-icon name="card-outline"></ion-icon>
                Formas de Pago
            </a>
        @endif
	</li>
	<li role="presentation">
		<a href="{{ route('admin.settings.getshipping') }}" class="{{isset($activeMenu) && $activeMenu == 'shipping' ? 'settings-menu-active' : '' }}">
			<ion-icon name="send-outline"></ion-icon>
			Formas de Envio
		</a>
	</li>
	<li role="presentation">
		<a href="{{ route('admin.settings.getscriptchat') }}" class="{{isset($activeMenu) && $activeMenu == 'whatsapp' ? 'settings-menu-active' : '' }}">
			<ion-icon name="chatbubble-ellipses-outline"></ion-icon>
            Chatbot y WhatsApp
		</a>
	</li>
	{{--<li role="presentation">
		<a href="{{ route('admin.settings.getgoals') }}" class="{{isset($activeMenu) && $activeMenu == 'goals' ? 'settings-menu-active' : '' }}">
			<i class="fas fa-money-bill-wave"></i>
			Meta a Cumplir
		</a>
	</li> --}}
	@if (get_active_template_obj()->tipo_negocio == "restaurant")
		<li role="presentation">
			<a href="{{ route('admin.settings.getschedule') }}" class="{{isset($activeMenu) && $activeMenu == 'schedule' ? 'settings-menu-active' : '' }}">
				<ion-icon name="alarm-outline"></ion-icon>
				Horarios
			</a>
		</li>
	@endif
</ul>
