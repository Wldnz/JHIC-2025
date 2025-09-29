@php
        $product_id = 1;
        $product_name = "Seragam Buriq";
        $product_type = "Seragam";
        $product_stok = 90;
        $product_price = 1000000;
        $product_gender = "Male";
        $product_size = "XL";
        $placeholder = "https://www.svgrepo.com/show/508699/landscape-placeholder.svg";
@endphp
@include('_components._header')

<div class="cart">
    <div class="products-list">
        @foreach ($carts as $index => $cart)
            <div class="product" data-index="{{ $index }}">
                <div class="check"><span id="checkbox"></span></div>
                <div class="middle"><img src="{{ $placeholder }}" alt=""></div>
                <div class="right">
                    <h3>{{ $cart->variantProduct->product->name }}</h3>
                    <p>{{ $cart->variantProduct->name }}, {{ $cart->variantProduct->type }}</p>
                    <h4>Stok: {{ $cart->variantProduct->stock }}</h4>
                    <br>
                    <br>
                    <div class="counter">
                        <img src="{{ asset('icons/Remove_Minus.svg') }}" alt="">
                        <Input type="number" inputmode="numeric">
                        <img src="{{ asset('icons/Add_Plus.svg') }}" alt="">
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="checkout-tab">
        <h3>Checkout</h3>
        <div id="selected-cart-list" style="display:flex; flex-direction: column; gap: 10px;">
        </div>
        <br>
        <p>Rp. <span id="total-price-label">0</span></p>
        <a id="result-checkout-url" href="{{ route('student.checkout') }}"><button class="button">Bayar Sekarang!</button></a>
    </d>
</div>
<input type="text" value="{{ $product_stok }}" id="max-counter" hidden>
@include('_components._footer')

<script>
    const numFormat = Intl.NumberFormat('id-ID');

    const carts = @json($carts);
    const selectedCartList = [];
    const checkoutUrlGenerator = new URL(@js(route('student.checkout')));

    const selectedCartListElement = document.getElementById("selected-cart-list");
    const resultCheckoutUrl = document.getElementById("result-checkout-url");
    const totalPriceLabelElement = document.getElementById("total-price-label");

    document.querySelectorAll("#checkbox").forEach(element => {
        element.parentElement.addEventListener('click', () => {
            const productItemElement = element.parentElement.parentElement;
            const selectedCart = carts[parseInt(productItemElement.getAttribute('data-index'))];

            if (element.classList.contains('checked')) {
                element.classList.remove('checked');
                selectedCartList.splice(selectedCartList.indexOf(selectedCart), 1);
            } else {
                element.classList.add('checked');
                selectedCartList.push(selectedCart);
            }

            if (selectedCartList.length > 0) {
                selectedCartListElement.innerHTML = selectedCartList.reduce((pre, current) => {
                    return pre + `<p>${current.quantity}x ${current.variant_product.product.name} (${current.variant_product.name} ${current.variant_product.type})</p>`;
                }, "");
                totalPriceLabelElement.innerText = numFormat.format(
                    selectedCartList.reduce((pre, current) => {
                        return pre + current.variant_product.price * current.quantity;
                    }, 0)
                );
            } else {
                selectedCartListElement.innerHTML = "";
                totalPriceLabelElement.innerText = 0;
            }

            checkoutUrlGenerator.searchParams.set("cart_ids", selectedCartList.map(element => element.id).join(","));
            resultCheckoutUrl.href = checkoutUrlGenerator.toString();
        });
    });

    document.querySelectorAll(".counter").forEach(element => {

        var counter = 1;
        var maxcounter = document.querySelector("#max-counter").value;
        const inputCounter = element.children[1];
        const addButton = element.children[2];
        const subButton = element.children[0];
        inputCounter.value = counter;

        addButton.addEventListener("click", function() {
            if (counter < maxcounter)
            {
                counter++;
            }
            inputCounter.value = counter;
        })

        subButton.addEventListener("click", function() {
            if (counter > 1) {
                counter--;
            };
            inputCounter.value = counter;
        })
        inputCounter.addEventListener("input", function() {
            let val = parseInt(inputCounter.value, 10);
            if (!isNaN(val) && val > 0)
                {
                    counter = val;
                    inputCounter.value = counter;
                }
        })

        inputCounter.addEventListener("blur", function() {
            let val = parseInt(inputCounter.value, 10);
            if (isNaN(val) || val < 1 || val > maxcounter)
                {
                    counter = 1;
                    inputCounter.value = counter;
                }
        })
    })

</script>
