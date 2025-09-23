@php
        $product_id = 1;
        $product_name = "Seragam Buriq";
        $product_type = "Seragam";
        $product_stok = 90;
        $product_qty = 4;
        $product_price = 1000000;
        $product_gender = "Male";
        $product_size = "XL";
        $placeholder = "https://www.svgrepo.com/show/508699/landscape-placeholder.svg";
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title  ?? "Bina Tata Usaha" }}</title>
    @vite(["resources/css/app.css", "resources/js/app.js"])
</head>
<body>

    <nav class="navigation-user" style="justify-content: start;">
        <a href="{{ route('student.cart') }}" style="display: flex; justify-content: center;"><img src="{{asset ('icons/left-arrow.svg')}}">Back</a>
    </nav>
    <main class="wrapper-user">
        
        

        
        
<div class="checkout">
    <div class="products-list">
        <div class="product">
            <div class="left">
                <img src="{{ $placeholder }}" alt="">
            </div>
            <div class="middle">
                <h3>{{ $product_name }}</h3>
                <p>{{ $product_gender }}, {{ $product_size }}</p>
            </div>
            <div class="right">
                <h4>Rp. </h4>
                <p>{{ number_format($product_price, 2, ",", ".") }} </p>
                <h5>x {{ $product_qty }}</h5>
            </div>
        </div>
        
    </div>
    <div class="payment-method">
        <h3>E-Money</h3>
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
            
        </div>

        <h3>Bank</h3>
        <div class="payment-method-group">
            <div class="method-tab picked">
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
        </div>
    </div>
    <div class="payment">
        <div class="left">
            <h3>Total Harga: </h3>
            <p>Rp. {{ number_format($product_price, 2, ",", ".") }}</p>
        </div>
        <div class="right">
            <a href="{{ route('student.checkout-success') }}"><button class="button2">Bayar</button></a>
        </div>
    </div>
</div>

<script>

    document.querySelectorAll(".method-tab").forEach(tab => {
        tab.addEventListener("click", function () {
            document.querySelectorAll(".method-tab").forEach(opt => {
                opt.classList.remove("picked");
            });   
        this.classList.add("picked");
        });
    });
</script>
    </main>
</body>
</html>