@php
    $placeholder = 'https://www.svgrepo.com/show/508699/landscape-placeholder.svg'
@endphp
@include('_components._header', ['title' => 'product'])
<div class="cart">
<div class="products">
    <a href="{{ route('student.detail-product',['product' => 1]) }}" class="product">
        <span>
        <img src="{{ $placeholder }}" alt="">
        </span>
        <h3>$produk</h3>
        <br>
        <p>$jenis</p>
        <p>$stok</p>
        <br>
        <h3>$price</h3>
    </a>
    <a href="" class="product out">
        <!-- nanti kalo stok == 0 {this.classList.add("out")} -->
        <span>
            <img src="{{ $placeholder }}" alt="">
        </span>
        <h3>$produk</h3>
        <br>
        <p>$jenis</p>
        <p>$stok</p>
        <br>
        <h3>$price</h3>
    </a>
    <a href="" class="product">
        <span>
            <img src="{{ $placeholder }}" alt="">
        </span>
        <h3>Seragam Batik aaaaaaaaaaaaaaaaaaaaaaa</h3>
        <br>
        <p>$jenis</p>
        <p>$stok</p>
        <br>
        <h3>$price</h3>
    </a>
    <a href="" class="product">
        <span>
            <img src="{{ $placeholder }}" alt="">
        </span>
        <h3>$produk</h3>
        <br>
        <p>$jenis</p>
        <p>$stok</p>
        <br>
        <h3>$price</h3>
    </a>
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