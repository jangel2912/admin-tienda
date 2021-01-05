<div class="row" style="margin-top: 5px;">
    <div class="col-md-2 col-md-offset-10">
        <a href="{{ route('admin.wizard.fourthstep.store') }}" onclick="event.preventDefault(); document.getElementById('out-wizard').submit();">Salir del asistente</a>
        <form action="{{ route('admin.wizard.fourthstep.store') }}" method="POST" id="out-wizard" style="display: none;">
            @csrf
        </form>
    </div>
</div>
