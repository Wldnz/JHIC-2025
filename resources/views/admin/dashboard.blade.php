@include('_components._headerAdmin', ["title" => "Dashboard"])
@php
    logger('product', )
@endphp
<main class="content">
    <div class="greeting">
        <h3>Selamat Datang, {{ Auth::user()->fullname }}</h3>
        <span>Kami sudah memberikan ringkasan data terbaru!</span>
    </div>
</main>
@include('_components._footerAdmin')