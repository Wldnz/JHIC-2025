@include('_components._headerAdmin', ['title' => 'Management Products'])
@php
    $currentPath = explode('/admin/', url()->current())[1];
@endphp
<main class="wrapper-admin">
    @include('_components._navigation-side')
    <aside class="right">
        @include('_components._bar-top-admin')
        <div style="width:100%; height: 25px;"></div>
        <main class="main-admin">
            @include('_components._summary-section',[
                'title' => 'Products Data',
                'name' => 'product',
                'summary_data' => []
            ])
        </main>
    </aside>
</main>