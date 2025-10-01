@php
    $placeholder = 'https://www.svgrepo.com/show/508699/landscape-placeholder.svg'
@endphp
@include('_components._header', ['title' => 'product'])
<div class="products">
<div class="products-group">
    @foreach ($products as $product)
        <a href="{{ route('student.detail-product',['product' => $product]) }}" class="product {{ $product->totalStock() == 0 ? 'out' : '' }}">
            <span>
            <img src="{{ count($product->images) > 0 ? $product->images[0]->url : 'https://www.svgrepo.com/show/508699/landscape-placeholder.svg' }}" alt="">
            </span>
            <h3>{{ $product->name }}</h3>
            <br>
            <p>{{ $product->category == 'uniform' ? 'Seragam' : 'Atribut' }}</p>
            <p>{{ $product->totalStock() }}</p>
            <br>
            <h3>{{ 'Rp. ' . number_format(count($product->variants) > 0 ? $product->variants[0]->price : 0, 0, ',', '.') }}</h3>
        </a>
    @endforeach
</div>
<div class="filter">
    <form method="GET">
        <input type="text" name="q" placeholder="Search" required>
        <button type="submit" class="">
            <img src="{{ asset("icons/search.svg") }}" alt="">
        </button>
    </form>

    <h2 class="toggle-filter">Seragam <img src="{{ asset("icons/arrow-down.svg") }}" alt=""></h2>
    <div class="content-filter">
        <!-- silahkan masukan link + idnya kakak :) -->
        <a href=""><p>Almamater</p></a>
        <a href=""><p>Seragam Pramuka</p></a>
        <a href=""><p>Seragam Batik</p></a>
        <a href=""><p>Seragam Taqwa</p></a>
        <a href=""><p>Seragam Praktek</p></a>
        <a href=""><p>Seragam Olahraga</p></a>
    </div>
    <h2 class="toggle-filter">Atribut<img src="{{ asset("icons/arrow-down.svg") }}" alt=""></h2>
    <div class="content-filter">
        <a href=""><p>Dasi</p></a>
        <a href=""><p>Topi</p></a>
        <a href=""><p>Sabu</p></a>
        <a href=""><p>Badge</p></a>
        <a href=""><p>MAP Rapot</p></a>
        <a href=""><p>Sepatu</p></a>
    </div>
</div>
</div>

<script>
    document.querySelectorAll(".toggle-filter").forEach(toggle => {
        toggle.addEventListener("click", () => {
            toggle.classList.toggle("open");
            toggle.nextElementSibling.classList.toggle("open")
        });
    });


</script>
@include('_components._footer')
