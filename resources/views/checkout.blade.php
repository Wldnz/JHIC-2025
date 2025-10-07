@php
        $placeholder = "https://www.svgrepo.com/show/508699/landscape-placeholder.svg";
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title  ?? "Bina Tata Usaha" }}</title>
    <title>{{ $title  ?? "Bina Tata Usaha" }}</title>
    @vite(["resources/css/app.css", "resources/js/app.js"])
</head>
<body>

    <nav class="navigation-user" style="justify-content: start;">
        <a href="{{ route('student.cart') }}" style="display: flex; justify-content: center;"><img src="{{asset ('icons/left-arrow.svg')}}">Back</a>
    </nav>
    <main class="wrapper-user">
<div class="checkout">
    <div class="products-list">
        @foreach ($selectedCarts as $cart)
            <div class="product">
                <div class="left">
                    <img src="{{ $placeholder }}" alt="">
                </div>
                <div class="middle">
                    <h3>{{ $cart->variantProduct->product->name }}</h3>
                    <p>{{ $cart->variantProduct->name }}, {{ $cart->variantProduct->type }}</p>
                </div>
                <div class="right">
                    <h4>Rp. </h4>
                    <p>{{ number_format($cart->variantProduct->price, 0, ",", ".") }} </p>
                    <h5>x {{ $cart->quantity }}</h5>
                </div>
            </div>
        @endforeach
    </div>
    <div class="payment-method">
        {{-- <h3 class="group-button">E-Money <img src="{{ asset('icons/arrow-down.svg') }}" alt=""></h3>
        <div class="payment-method-group">
            <div class="method-tab">
                <img src="{{ asset("icons/payment/qris.png") }}" alt="">
                <h5>QRIS</h5>
            </div>
            <div class="method-tab">
                <img src="{{ asset("icons/payment/gopay.png") }}" alt="">
                <h5>GoPay</h5>
            </div>
            <div class="method-tab">
                <img src="{{ asset("icons/payment/ovo.png") }}" alt="">
                <h5>OVO</h5>
            </div>
            <div class="method-tab">
                <img src="{{ asset("icons/payment/dana.png") }}" alt="">
                <h5>Dana</h5>
            </div>


        </div> --}}

        {{-- <h3 class="group-button">Bank <img src="{{ asset('icons/arrow-down.svg') }}" alt=""></h3>
        <div class="payment-method-group">
            <div class="method-tab">
                <img src="{{ asset("icons/payment/bca.png") }}" alt="">
                <h5>BCA</h5>
            </div>
        <div class="method-tab">
            <img src="{{ asset("icons/payment/bni.png") }}" alt="">
            <h5>BNI</h5>
        </div>
        <div class="method-tab">
            <img src="{{ asset("icons/payment/bri.png") }}" alt="">
            <h5>BRI</h5>
        </div>
        <div class="method-tab">
            <img src="{{ asset("icons/payment/danamon.png") }}" alt="">
            <h5>Danamon</h5>
        </div> --}}

        <h3 class="group-button">Pilih Metode Pembayaran <img src="{{ asset('icons/arrow-down.svg') }}" alt=""></h3>
        <div class="payment-method-group">
            @foreach ($paymentTypes as $paymentType)
                <div class="method-tab" data-code-name="{{ $paymentType->code_name }}">
                    <img src="{{ $paymentType->icon_url }}" alt="payment-icon" loading="lazy">
                    <h5>{{ $paymentType->display_name }}</h5>
                </div>
            @endforeach
        </div>
    </div>
    <form class="payment" action="{{ route('student.store-transaction') }}" method="post">
        <div style="display: none;">
            @csrf
            @foreach ($selectedCarts as $cart)
                <input type="hidden" name="carts[]" value="{{ $cart->id }}">
            @endforeach
            <input type="hidden" name="payment_method" id="payment_method">
        </div>
        <div class="left">
            <h3>Total Harga: </h3>
            <p>Rp. {{ number_format($totalPrice, 0, ",", ".") }}</p>
        </div>
        <div class="right">
            <button class="button2">Bayar</button>
        </div>
    </form>
</div>

@includeWhen(session()->has('alert'), '_components._alert-message', ['data' => session()->get('alert'), 'icon_name' => 'transaction'])

<script>
    const paymentMethod = document.getElementById('payment_method');

    document.querySelectorAll(".method-tab").forEach(tab => {
        tab.addEventListener("click", function () {
            document.querySelectorAll(".method-tab").forEach(opt => {
                opt.classList.remove("picked");
            });
            tab.classList.add("picked");
            paymentMethod.value = tab.getAttribute("data-code-name");
        });
    });

    document.querySelectorAll(".group-button").forEach(button => {
        button.addEventListener("click", function () {
            const panel = this.nextElementSibling;
            const isOpen = panel.style.maxHeight && panel.style.maxHeight !== "0px";

            document.querySelectorAll(".payment-method-group").forEach(group => {
                group.style.maxHeight = "0";
                group.style.padding = "0 20px";
                button.firstElementChild.style.rotate = "0deg";
            });


            document.querySelectorAll(".group-button").forEach(btn => {
                btn.firstElementChild.style.rotate = "0deg";
            });


            if (!isOpen) {
                panel.style.maxHeight = "1000px";
                panel.style.padding = "15px 20px";
                button.firstElementChild.style.rotate = "180deg";
            }
    });
});


</script>
    </main>
</body>
</html>
