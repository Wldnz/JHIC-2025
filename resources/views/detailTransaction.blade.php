@php
        $transaction_id = "HJ23892U8R21E";

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
@include('_components._header')

<div class="detailTransaction">
    <h3>Detail Transaksi : {{ $transaction_id }}</h3>
    <div class="content">

        <div class="products-list">
            <div class="product picked">
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
        <div class="details">
            <h4>Product Information</h4>
            <h5>Product ID : <p>{{ $product_id }}</p></h5>
            <h5>Product Name : <p>{{ $product_name }}</p></h5>
            <h5>Product Type : <p>{{ $product_type }}</p></h5>
            <h5>Product Stock : <p>{{ $product_stok }}</p></h5>
            <h5>Quantity Bought : <p>{{ $product_qty }}</p></h5>
            <br>
            <h4>Variant</h4>
            <h5>Size : <p>{{ $product_size }}</p></h5>
            <h5>Gender : <p>{{ $product_gender }}</p></h5>
            <br>
            <h4>Price</h4>
            <h5>Price : <p>{{ $product_price }}</p></h5>
            <h5>Total Price : <p>{{ $product_price * $product_qty }}</p></h5>
            <br><br>
            <h6><- bikin kalo di click datanya muncul diatas</h5>
        </div>
    </div>
</div>
    @include('_components._footer')

    <script>
        document.querySelectorAll(".product").forEach(tab => {
        tab.addEventListener("click", function () {
            document.querySelectorAll(".product").forEach(opt => {
                opt.classList.remove("picked");
            });   
        this.classList.add("picked");
        });
    });
    </script>