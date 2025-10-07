@php
    $placeholder = 'https://www.svgrepo.com/show/508699/landscape-placeholder.svg'
@endphp
@include('_components._header', ['title' => 'product'])
<div class="products">
<div class="products-group">
</div>
<div class="filter">
    <form action="#" id="search-form">
        <input type="text" name="search" placeholder="Search" value="">
        <button type="submit" class="">
            <img src="{{ asset("icons/search.svg") }}" alt="">
        </button>
    </form>

    <h2 class="toggle-filter" data-product-type="uniform">Seragam <img src="{{ asset("icons/arrow-down.svg") }}" alt=""></h2>
    <div class="content-filter" data-product-type="uniform">
        @foreach ($products->where('category', 'uniform') as $product)
            <a href="{{ $product->id }}"><p>{{ $product->name }}</p></a>
        @endforeach
    </div>
    <h2 class="toggle-filter"data-product-type="attribute">Atribut<img src="{{ asset("icons/arrow-down.svg") }}" alt=""></h2>
    <div class="content-filter" data-product-type="attribute">
        @foreach ($products->where('category', 'attribute') as $product)
            <a href="{{ route('student.detail-product', ['product' => $product]) }}"><p>{{ $product->name }}</p></a>
        @endforeach
    </div>
</div>
</div>

<script>
    const numFormat = Intl.NumberFormat('id-ID');
    const products = @json($products);

    const productsGroup = document.querySelector(".products-group");
    const searchForm = document.querySelector("#search-form");

    function countProductTotalStock(item) {
        return item.variants.reduce((total, variant) => total + variant.stock, 0);
    }

    function productsToCardItem(arr) {
        return arr.map(product => {
            const totalStock = countProductTotalStock(product);
            return`
            <a href="/products/${product.id}" class="product ${totalStock == 0 ? 'out' : ''}">
                <span>
                    <img src="${product.images.length > 0 ? product.images[0].url : 'https://www.svgrepo.com/show/508699/landscape-placeholder.svg' }" alt="" loading="lazy">
                </span>
                <h3>${product.name}</h3>
                <br>
                <p>${product.category == 'uniform' ? 'Seragam' : 'Atribut'}</p>
                <p>${totalStock}</p>
                <br>
                <h3>${'Rp. ' + numFormat.format(product.variants.length > 0 ? product.variants[0].price : 0)}</h3>
            </a>`
        }).join('');
    }

    productsGroup.innerHTML = productsToCardItem(products);

    searchForm.onsubmit = (e) => {
        e.preventDefault();

        const search = e.target[0].value;
        const filtered = products.filter(product => product.name.toLowerCase().includes(search.toLowerCase()));

        productsGroup.innerHTML = productsToCardItem(filtered);
    }

    document.querySelectorAll(".toggle-filter").forEach(toggle => {
        toggle.addEventListener("click", () => {
            toggle.classList.toggle("open");
            toggle.nextElementSibling.classList.toggle("open")
        });
    });


</script>
@include('_components._footer')
