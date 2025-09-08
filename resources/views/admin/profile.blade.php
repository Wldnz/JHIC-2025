@include('_components._headerAdmin')
@php
    $currentPath = 'accounts';
@endphp
<main class="wrapper-admin">
    @include('_components._navigation-side')
    <aside class="right">
        @include('_components._bar-top-admin')
        <div style="width:100%; height: 25px;"></div>
        <main class="main-admin">
        </main>
    </aside>
</main>