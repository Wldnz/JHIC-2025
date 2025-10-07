@include('_components._headerAdmin', ['title' => 'Portfolio Management'])
@php
    $currentPath = explode('/admin/', url()->current())[1];
@endphp
<main class="content">
    
</main>
@include('_components._footerAdmin')