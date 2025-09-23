@php
        $product_id = 1;
        $product_name = "Seragam Buriq";
        $product_type = "Seragam";
        $product_stok = 90;
        $product_price = 1000000;
        $placeholder = "https://www.svgrepo.com/show/508699/landscape-placeholder.svg";
@endphp
@include('_components._header')
<div class="detailproduct">
    <div class="container">
    <div class="left"><img src="{{ $placeholder }}"></div>
    <div class="right">
        <h2>{{ $product_name }}</h2>
        <h3>Rp. {{ number_format($product_price, 2, ',','.') }}</h3>
        <p>Stok {{ $product_type }} : {{ $product_stok }}</p>
        <br>
        <h3>Jenis Kelamin: <label id="gender-label">Male</label></h3>
        <div class="radio-selector">
            <img onclick="pick(this)" name="Male" src="{{ asset("icons/user.svg") }}" class="radio-tab picked">
            <img onclick="pick(this)" name="Female" src="{{ asset("icons/User_Female.png") }}" class="radio-tab">
        </div>
        <br>
            <h3>Size: <label id="size-label">Small</label></h3>
        <div class="radio-selector">
            <p name="Small" onclick="pick(this)" class="radio-tab picked">S</p>
            <p name="Medium" onclick="pick(this)" class="radio-tab">M</p>
            <p name="Large" onclick="pick(this)" class="radio-tab">L</p>
            <p name="Extra Large" onclick="pick(this)" class="radio-tab">XL</p>
            <p name="Double Extra Large" onclick="pick(this)" class="radio-tab">2XL</p>
            <p name="Triple Extra Large" onclick="pick(this)" class="radio-tab">3XL</p>
            <p name="Quadruple Extra Large" onclick="pick(this)" class="radio-tab">4XL</p>
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
                <input type="text" id="variant" name="product_variant_id" hidden>
                <input type="text" id="qty" name="quantity" hidden>
                <button type="submit" class="button button-circle"> Add to Cart</button>
            </form>
        </div>
    </div>
</div>
</div>
@include('_components._footer');
<input type="text" id="max-counter" value="{{ $product_stok }}" hidden>

<script>
    function pick(el)
    {
        el.parentElement.querySelectorAll(".radio-tab").forEach(opt => {
            opt.classList.remove("picked");
        });
        
        el.classList.add("picked");
        
        let picked = el.getAttribute("name");
        
        el.parentElement.previousElementSibling.lastElementChild.innerText = picked;
    }
    
    var counter = 1;
    var maxcounter = document.querySelector("#max-counter").value;
    const inputCounter = document.querySelector("#inp");
    const addButton = document.querySelector("#add");
    const subButton = document.querySelector("#sub");
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

    document.querySelector("#variant");


</script>
