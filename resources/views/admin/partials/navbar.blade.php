<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1" style="display:flex;">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="{{ route('admin.prices') }}"><img  placeholder="Planes" src="{{ asset('admin/icons/negro/icono_negro-06.svg') }}" alt=""></a></li>
                <li><a href="https://vendtycom.freshdesk.com/support/tickets/new" target="_blank"><img src="{{ asset('admin/icons/negro/icono_negro-02.svg') }}" alt=""></a></li>
                <li id="notification"><a href="javascript:void(false);"><img src="{{ asset('admin/icons/verde/novedades.svg') }}" alt=""></a></li>
                <li class="logout"><a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><img src="{{ asset('admin/icons/blanco/icono_blanco-03.svg') }}" alt=""> Salir</a></li>
            </ul>
            @if (url_shop())
            <a href="{{ url_shop() }}" target="_blank" class="btn btn-success" style="padding-top: 8px; margin-top: 8px; top: 10px; padding-bottom: 8px; float: right; background-color: #EF6437; border-color: #EF6437; height: 35px; margin-left: 40px;">Ver Mi Tienda</a>
            @endif
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container-fluid -->
</nav>
<form action="{{ route('logout') }}" method="POST" id="logout-form" style="display: none;">
    @csrf
</form>
