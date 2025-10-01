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
                <div class="middle"><img src="{{ count($cart->variantProduct->product->images) > 0 ? $cart->variantProduct->product->thumbnail()->url : $placeholder }}" alt="" loading="lazy"></div>
                <div class="right">
                    <h3>{{ $cart->variantProduct->product->name }}</h3>
                    <p>{{ $cart->variantProduct->name }}, {{ $cart->variantProduct->type }}</p>
                    <h4>Stok: {{ $cart->variantProduct->stock }}</h4>
                    <br>
                    <br>
                    <div class="counter">
                        <img src="{{ asset('icons/Remove_Minus.svg') }}" alt="">
                        <Input type="number" inputmode="numeric" value="{{ $cart->quantity }}">
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
@include('_components._footer')

@includeWhen(session()->has('alert'), '_components._alert-message', ['data' => session()->get('alert'), 'icon_name' => 'transaction'])

<script>
    const numFormat = Intl.NumberFormat('id-ID');

    const csrfToken = @js(csrf_token());
    const carts = @json($carts);
    const selectedCartList = [];
    const checkoutUrlGenerator = new URL(@js(route('student.checkout')));

    const selectedCartListElement = document.getElementById("selected-cart-list");
    const resultCheckoutUrl = document.getElementById("result-checkout-url");
    const totalPriceLabelElement = document.getElementById("total-price-label");

    function changeCartItemElementQuantity(index, qty) {
        const selectedCart = carts[index];
        const cartItemElement = document.getElementById(`cart-item-${selectedCart.id}`);

        if (!cartItemElement) return;
        cartItemElement.innerText = `${qty}x ${selectedCart.variant_product.product.name} (${selectedCart.variant_product.name} ${selectedCart.variant_product.type})`;
    }

    async function updateCartToApi(selectedCart) {
        const response = await fetch(`/cart/${selectedCart.id}/`, {
            method: "PUT",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrfToken,
            },
            body: JSON.stringify({
                quantity: selectedCart.quantity
            })
        });

        console.log(response);
        if (!response.ok) return;
        const data = await response.json();

        console.log(data);
    }

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
                    return pre + `<p id="cart-item-${current.id}">${current.quantity}x ${current.variant_product.product.name} (${current.variant_product.name} ${current.variant_product.type})</p>`;
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
        const productItemElement = element.parentElement.parentElement;
        const selectedCartIndex = parseInt(productItemElement.getAttribute('data-index'));
        const selectedCart = carts[selectedCartIndex];

        const inputCounter = element.children[1];
        const addButton = element.children[2];
        const subButton = element.children[0];

        var counter = selectedCart.quantity;
        const maxcounter = selectedCart.variant_product.stock;

        inputCounter.value = counter;

        addButton.addEventListener("click", function() {
            if (counter < maxcounter) {
                counter++;
            }

            selectedCart.quantity = counter;
            inputCounter.value = counter;

            changeCartItemElementQuantity(selectedCartIndex, counter);
            updateCartToApi(selectedCart);
        });

        subButton.addEventListener("click", function() {
            if (counter > 1) {
                counter--;
            }

            selectedCart.quantity = counter;
            inputCounter.value = counter;

            changeCartItemElementQuantity(selectedCartIndex, counter);
            updateCartToApi(selectedCart);
        });

        inputCounter.addEventListener("input", function() {
            let val = parseInt(inputCounter.value, 10);
            if (!isNaN(val) && val > 0) {
                counter = val;
                selectedCart.quantity = counter;
                inputCounter.value = counter;

                changeCartItemElementQuantity(selectedCartIndex, counter);
            }
        });

        function onQuantityInput() {
            let val = parseInt(inputCounter.value, 10);

            if (val > maxcounter) {
                counter = maxcounter;
            } else if (isNaN(val) || val < 1) {
                counter = 1;
            }

            selectedCart.quantity = counter;
            inputCounter.value = counter;
            changeCartItemElementQuantity(selectedCartIndex, counter);
            updateCartToApi(selectedCart);
        }

        inputCounter.addEventListener("blur", onQuantityInput);
        inputCounter.addEventListener("keydown", (e) => {
            if (e.key != "Enter") return;
            inputCounter.blur();
        });
    })

</script>

<script type="module">
    const userNis = @js(Auth::user()->nis);
    const test = Echo.private(`self-cart.${userNis}`)
        .listen('SelfCartQuantityUpdated', (ev) => {
            console.log(ev);
        })

    test.whisper('update-qty', {
        cart_id: 1,
        quantity: 10,
    })
    window.test123 = test;

    // test.send_event("test", {});
</script>
