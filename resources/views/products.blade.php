@include('_components._header', ['title' => 'product'])
<div class="cart">
<div class="products">
    
</div>
<div class="filter">
    <h2 class="toggle-filter">Seragam <img src="{{ asset("icons/arrow-down.svg") }}" alt=""></h2>
    <div class="content-filter">
        <p>Seragam</p>
        <p>Seragam</p>
        <p>Seragam</p>
        <p>Seragam</p>
        <p>Seragam</p>
        <p>Seragam</p>
    </div>
</div>
</div>

<script>
    document.querySelector(".toggle-filter").addEventListener("click", function () {
        document.querySelector(".toggle-filter").classList.toggle("open");
        document.querySelector(".content-filter").classList.toggle("open");
    })
</script>
@include('_components._footer')