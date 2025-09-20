@include('_components._headerAdmin', ['title' => 'Management Transaksi'])
@php
    $currentPath = explode('/admin/', url()->current())[1];
@endphp
<main class="wrapper-admin">
    @include('_components._navigation-side')

</main>