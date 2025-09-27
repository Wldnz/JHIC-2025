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
        <div class="product">
            <div class="check"><span id="checkbox"></span></div>
            <div class="middle"><img src="{{ $placeholder }}" alt=""></div>
            <div class="right">
                <h3>{{ $product_name }}</h3>
                <p>{{ $product_gender }}, {{ $product_size }}</p>
                <h4>Stok: {{ $product_stok }}</h4>
                <br>
                <br>
                <div class="counter">
                    <img src="{{ asset('icons/Remove_Minus.svg') }}" alt="">
                    <Input type="number" inputmode="numeric">
                    <img src="{{ asset('icons/Add_Plus.svg') }}" alt="">
                </div>
            </div>

        </div>
        <div class="product">
            <div class="check"><span id="checkbox"></span></div>
            <div class="middle"><img src="{{ $placeholder }}" alt=""></div>
            <div class="right">
                <h3>{{ $product_name }}</h3>
                <p>{{ $product_gender }}, {{ $product_size }}</p>
                <h4>Stok: {{ $product_stok }}</h4>
                <br>
                <br>
                <div class="counter">
                    <img src="{{ asset('icons/Remove_Minus.svg') }}" alt="">
                    <Input type="number" inputmode="numeric">
                    <img src="{{ asset('icons/Add_Plus.svg') }}" alt="">
                </div>
            </div>

        </div>
    </div>
    <div class="checkout-tab">
        <h3>Checkout</h3>
        <p>1x {{ $product_name }}</p>
        <p>4x {{ $product_name }}</p>
        <p>2x {{ $product_name }}</p>
        <br>
        <p>Rp. {{ $product_price }}</p>
        <a href="{{ route('student.checkout') }}"><button class="button">buy buy buy</button></a>
    </div>
</div>
<input type="text" value="{{ $product_stok }}" id="max-counter" hidden>
@include('_components._footer')

<script>
    document.querySelectorAll("#checkbox").forEach(element => {
        element.parentElement.addEventListener('click', () => element.classList.toggle('checked')); 
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
