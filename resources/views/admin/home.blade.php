@include('admin.header')

@if($home)
    @include('admin.products')
@else
    @include('admin.additem')
@endif

@include('admin.footer')