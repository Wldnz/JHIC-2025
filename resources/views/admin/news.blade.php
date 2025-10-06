@include('_components._headerAdmin', ['title' => 'Management Artikel'])
@php
    $currentPath = explode('/admin/', url()->current())[1];
@endphp
<main class="content">

</main>

@include('_components._footerAdmin')