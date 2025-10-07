@include('_components._headerAdmin', ['title' => 'Management News/Article/Blog'])
@php
    $currentPath = explode('/admin/', url()->current())[1];
    logger('as', [$transactions])
@endphp
<main class="content">
</main>

@include('_components._footerAdmin')