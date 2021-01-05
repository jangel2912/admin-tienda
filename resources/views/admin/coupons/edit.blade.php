@extends('admin.layout.content')
@section('title', 'Editar Promoción')
@section('panel-content')
    <hr/>
    @include('admin.partials.alerts')
    <form action="{{ route('admin.coupons.update', $coupon->id) }}" method="POST">
        @csrf
        @method('PUT')
        @include('admin.coupons.fields')
    </form>
@endsection

@push('styles')
<link href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}" rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('admin/css/tag-editor.css') }}">
<link rel="stylesheet" href="{{ asset('css/products.css') }}">
<style>

</style>
@endpush

@push('scripts')
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js" integrity="sha256-eGE6blurk5sHj+rmkfsGYeKyZx3M4bG+ZlFyA7Kns7E=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote.js"></script>
<script src="{{ asset('js/products.js') }}"></script>
<script src="{{ asset('admin/js/tag-editor.min.js') }}"></script>
<script src="{{ asset('admin/js/voucher_codes.js') }}"></script>
<script src="{{ asset('bower_components/select2/dist/js/select2.min.js') }}"></script>
<script>
    $(document).ready(function(){
        $('#correos_electronicos').tagEditor({
            delimiter: ',',
            //onChange: makeProducts,
        }).css('display', 'block').attr('readonly', true);
        $("#productos, #productos_excluidos, #categorias, #categorias_excluidas").select2({width: "100%"});
        $('[data-toggle="tooltip"]').tooltip();
        $("#generate-name").click(function(){
            $("#nombre").val(voucher_codes.generate({
                length: 8,
                count: 1
            }));
        });
        checkIfIncludeProductOrCategoryIsChecked("#incluir_productos", "#include_products_container");
        checkIfIncludeProductOrCategoryIsChecked("#incluir_categorias", "#include_category_container");
        $("#incluir_productos").change(function(){
            checkIfIncludeProductOrCategoryIsChecked("#incluir_productos", "#include_products_container");
        });
        $("#incluir_categorias").change(function(){
            checkIfIncludeProductOrCategoryIsChecked("#incluir_categorias", "#include_category_container");
        });
    });
    function checkIfIncludeProductOrCategoryIsChecked(checkId, containerId){
        if($(checkId).is(":checked")){
            $(containerId).show('slow');
        }
        else{
            $(containerId).hide('slow');
        }
    }
</script>
@endpush
