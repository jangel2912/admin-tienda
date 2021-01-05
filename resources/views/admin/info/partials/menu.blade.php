<ul class="nav nav-pills nav-stacked">
    <li role="presentation">
        <a href="{{ route('admin.info.getsocialnetworks') }}" class="{{isset($activeMenu) && $activeMenu == 'social' ? 'settings-menu-active' : '' }}">
            Redes Sociales
        </a>
    </li> 
    <li role="presentation">
        <a href="{{ route('admin.info.getcontactus') }}" class="{{isset($activeMenu) && $activeMenu == 'contact' ? 'settings-menu-active' : '' }}">
            Contáctanos
        </a>
    </li>
    <li role="presentation">
        <a href="{{ route('admin.info.getaboutus') }}" class="{{isset($activeMenu) && $activeMenu == 'aboutus' ? 'settings-menu-active' : '' }}">
            Nosotros
        </a>
    </li>
    <li role="presentation">
        <a href="{{ route('admin.info.getterms') }}" class="{{isset($activeMenu) && $activeMenu == 'terms' ? 'settings-menu-active' : '' }}">
            Términos y Condiciones
        </a>
    </li>
</ul>
