@php
        $placeholder = "https://www.svgrepo.com/show/508699/landscape-placeholder.svg";
        $firstVariant = $product->firstVariant();
@endphp
@include('_components._header')
<div class="detailproduct">
    <div class="container">
    <div class="left"><img src="{{ count($product->images) > 0 ? $product->thumbnail()->url : $placeholder }}"></div>
    <div class="right">
        <h2>{{ $product->name }}</h2>
        <h3>Rp. <span id="price-label">{{ number_format($firstVariant->price, 0, ',', '.') }}</span></h3>
        <p>Stok {{ $product->category == 'uniform' ? 'Seragam' : "Atribut" }} : <span id="stock-label">{{ $firstVariant->stock }}</span></p>
        @if ($product->category == "uniform")
            <br>
            <h3>Jenis Kelamin: <label id="gender-label">{{ $firstVariant->name == "male" ? 'Male' : 'Female' }}</label></h3>
            <div class="radio-selector">
                <img onclick="pick(this)" name="Male" src="{{ asset("icons/user.svg") }}" class="radio-tab {{ $firstVariant->name == "male" ? 'picked' : '' }}">
                <img onclick="pick(this)" name="Female" src="{{ asset("icons/User_Female.png") }}" class="radio-tab {{ $firstVariant->name == "female" ? 'picked' : '' }}">
            </div>
        @else
            <label id="gender-label" style="display: none;">Universal</label>
        @endif
        <br>
            <h3>Size: <label id="size-label">{{ $firstVariant->type }}</label></h3>
        <div class="radio-selector">
            @foreach ($product->variants->unique("type") as $variant)
                <p name="{{ $variant->type }}" onclick="pick(this)" class="radio-tab {{ $firstVariant->type == $variant->type ? 'picked' : '' }}">{{ $variant->type }}</p>
            @endforeach
        </div>
        <a href="https://youtube.com"><h4>My Size Doesn't Exist</h4></a>
        <br>
        <div class="bottom">
            <div class="counter">
                <img src="{{ asset('icons/Remove_Minus.svg') }}" alt="" id="sub">
                <Input type="number" id="inp" inputmode="numeric">
                <img src="{{ asset('icons/Add_Plus.svg') }}" alt="" id="add">
            </div>
            <form action="{{ route("student.store-cart") }}" method="post">
                @csrf
                <input type="text" id="selected-variant-id-value" name="product_variant_id" hidden>
                <input type="text" id="selected-qty-value" name="quantity" hidden>
                <button type="submit" class="button button-circle"> Add to Cart</button>
            </form>
        </div>
    </div>
</div>
</div>
@include('_components._footer');

@includeWhen(session()->has('alert'), '_components._alert-message', ['data' => session()->get('alert'), 'icon_name' => 'product'])

<script>
    const numFormat = Intl.NumberFormat('id-ID');
    const maxStock = @js($product->totalStock());
    const variants = @json($product->variants);
    const images = @json($product->images);
    const firstVariant = @json($product->firstVariant());

    const priceLabel = document.getElementById("price-label");
    const stockLabel = document.getElementById("stock-label");
    const genderLabel = document.getElementById("gender-label");
    const sizeLabel = document.getElementById("size-label");
    const inputCounter = document.querySelector("#inp");

    var maxcounter = firstVariant.stock;
    var counter = 1;

    const selectedVariantIdValue = document.getElementById("selected-variant-id-value");
    const selectedQtyValue = document.getElementById("selected-qty-value");

    selectedVariantIdValue.value = firstVariant.id;
    selectedQtyValue.value = 1;

    function pick(el)
    {
        el.parentElement.querySelectorAll(".radio-tab").forEach(opt => {
            opt.classList.remove("picked");
        });

        el.classList.add("picked");
        let picked = el.getAttribute("name");
        el.parentElement.previousElementSibling.lastElementChild.innerText = picked;

        const selectedVariantFromInput = variants.find(variant => variant.name == genderLabel.innerText.toLowerCase() && variant.type == sizeLabel.innerText);
        if (selectedVariantFromInput) {
            selectedVariantIdValue.value = selectedVariantFromInput.id;
            maxcounter = selectedVariantFromInput.stock;
            priceLabel.innerText = numFormat.format(selectedVariantFromInput.price);
            stockLabel.innerText = selectedVariantFromInput.stock;

            if (parseInt(inputCounter.value) > selectedVariantFromInput.stock) {
                counter = selectedVariantFromInput.stock;
                inputCounter.value = counter;
                selectedQtyValue.value = counter;
            }
        }
    }

    const addButton = document.querySelector("#add");
    const subButton = document.querySelector("#sub");

    inputCounter.value = counter;
    selectedQtyValue.value = counter;

    addButton.addEventListener("click", function() {
        if (counter < maxcounter) {
            counter++;
        }
        inputCounter.value = counter;
        selectedQtyValue.value = counter;
    })

    subButton.addEventListener("click", function() {
        if (counter > 1) {
            counter--;
        };
        inputCounter.value = counter;
        selectedQtyValue.value = counter;
    })
    inputCounter.addEventListener("input", function() {
        let val = parseInt(inputCounter.value, 10);
        if (!isNaN(val) && val > 0) {
            counter = val;
            inputCounter.value = counter;
            selectedQtyValue.value = counter;
        }
    })

    function onQuantityInput() {
        let val = parseInt(inputCounter.value, 10);

        if (val > maxcounter) {
            counter = maxcounter;
        } else if (isNaN(val) || val < 1) {
            counter = 1;
        }

        inputCounter.value = counter;
        selectedQtyValue.value = counter;
    };

    inputCounter.addEventListener("blur", onQuantityInput);
    inputCounter.addEventListener("keydown", (e) => {
        if (e.key != "Enter") return;
        onQuantityInput();
        inputCounter.blur();
    });


</script>
