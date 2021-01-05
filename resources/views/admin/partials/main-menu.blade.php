<nav class="main-menu">
	<a href="{{ route('admin.dashboard') }}">
		<img src="{{ asset('admin/img/logodas.fw.png') }}" class="logo" alt="Vendty POS">
	</a>
<a href="{{ route('admin.dashboard') }}" class="{{ \Route::current()->getName() == "admin.dashboard" ? 'active' : ''}}">
		<img src="{{ asset('admin/icons/icons-svg/home.svg') }}" class="icons filter-white" alt="Dashboard">
		<h5>Inicio</h5>
  </a>
  <a href="{{ route('admin.orders') }}" class="{{ \Route::current()->getName() == "admin.orders" ? 'active' : ''}}">
		<img src="{{ asset('admin/icons/icons-svg/receipt.svg') }}" class="icons filter-white" alt="Pedidos">
		<h5>Pedidos</h5>
	</a>
  <a href="{{ route('admin.products.index') }}" class="{{ \Request::is('admin/products*') || \Request::is('admin/categories*') ? 'active' : ''}}">
      <img src="{{ asset('admin/icons/blanco/icono_blanco-07.svg') }}" class="icons" alt="Inventario">
      <h5>Productos</h5>
  </a>
	<a href="{{ route('admin.customers') }}" class="{{ \Route::current()->getName() == "admin.customers" ? 'active' : ''}}">
    <img src="{{ asset('admin/icons/icons-svg/clients.svg') }}" class="icons filter-white" alt="Clientes">
    <h5>Clientes</h5>
  </a>
  <a href="{{ route('admin.coupons.index') }}" class="{{ \Request::is('admin/coupons*') ? 'active' : ''}}">
    <img src="{{ asset('admin/icons/icons-svg/coupons.svg') }}" class="icons filter-white" alt="Cupones">
    <h5>Cupones</h5>
  </a>
  <a href="{{ route('admin.info.getaboutus') }}" class="{{ \Request::is('admin/info*') ? 'active' : ''}}">
    <img src="{{ asset('admin/icons/icons-svg/pages.svg') }}" class="icons filter-white" alt="Páginas">
    <h5>Páginas</h5>
  </a>
  <a href="{{ route('admin.settings.getbasic') }}" class="{{ \Request::is('admin/settings*') || \Request::is('admin/payments*') ? 'active' : ''}}">
		<img src="{{ asset('admin/icons/icons-svg/cog.svg') }}" class="icons filter-white" alt="Ajustes">
		<h5>Ajustes</h5>
  </a>
  <a href="https://pos.vendty.com" target="_blank">
		<img src="{{ asset('admin/icons/icons-svg/pos.svg') }}" class="icons filter-white" alt="POS">
		<h5>POS</h5>
	</a>
    {{--<a href="{{ route('admin.promotions.index') }}">
        <img src="{{ asset('admin/icons/blanco/icono_blanco-08.svg') }}" class="icons" alt="Promociones">
        <h5>Promociones</h5>
    </a>--}}
</nav>
<style>
.main-menu {
  overflow-y: auto;
  scrollbar-color: dark light;
  scrollbar-width: thin;
}
/* width */
::-webkit-scrollbar {
  width: 3px;
}

/* Track */
::-webkit-scrollbar-track {
  background: #f1f1f1;
}

/* Handle */
::-webkit-scrollbar-thumb {
  background: #888;
}

/* Handle on hover */
::-webkit-scrollbar-thumb:hover {
  background: #555;
}

.filter-white {
    filter: invert(100%) sepia(0%) saturate(7499%) hue-rotate(183deg) brightness(98%) contrast(97%);
}
</style>
