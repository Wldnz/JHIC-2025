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
@include('_components._header')
<div class="profile-student">
    <div class="profile-tab">
        <img src="{{ $placeholder }}" alt="">
        <p>Pe: {{ auth::user()->nis }}</p>
        <p>Usename: {{ auth::user()->fullname }}</p>
        <p>Email: {{ auth::user()->email }}</p>
        <button class="button" id="editButton">Edit Profile</button>
        <div class="editDisplay">
            <span class="editBackdrop"></span>
            <form method="POST" id="editForm">
                <h3>Edit Profile</h3>
                <label for="username">Username</label>
                <input type="text" name="username" id="username">

                <label for="email">Email</label>
                <input type="email" name="email" id="email">

                <label for="password">Password</label>
                <input type="password" name="password" id="password">
                
                <label for="password_confirmation">Confirm Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation">
                
                <button type="submit" class="button" style="align-self: center;">Submit</button>
            </form>
        </div>
    </div>
    <div class="transaction-history">
        <input type="text" placeholder="Search">
        <a href="{{ route("student.detail-transaction", 1)}}" class="transaction">
            <div class="img">
                <img src="{{ $placeholder }}" alt="">
            </div>
            <div class="details">

                <div class="desc">
                    <div class="left">
                        <h5>{{ $product_name }}</h5>
                        <p>{{ $product_size }}, {{ $product_gender }}</p>
                    </div>
                    <div class="right">
                        <h5>Rp.{{ $product_price }}</h5>
                        <p>x{{ $product_qty }}</p>
                    </div>
                </div>
                <div class="desc">
                    <div class="left">
                        <h5>{{ $product_name }}</h5>
                        <p>{{ $product_size }}, {{ $product_gender }}</p>
                    </div>
                    <div class="right">
                        <h5>Rp.{{ $product_price }}</h5>
                        <p>x{{ $product_qty }}</p>
                    </div>
                </div>
                <div class="desc">
                    <div class="left">
                        <h5>{{ $product_name }}</h5>
                        <p>{{ $product_size }}, {{ $product_gender }}</p>
                    </div>
                    <div class="right">
                        <h5>Rp.{{ $product_price }}</h5>
                        <p>x{{ $product_qty }}</p>
                    </div>
                </div>
            </div>
        </a>
        <a href="{{ route("student.detail-transaction", 1)}}" class="transaction">
            <div class="img">
                <img src="{{ $placeholder }}" alt="">
            </div>
            <div class="details">

                <div class="desc">
                    <div class="left">
                        <h5>{{ $product_name }}</h5>
                        <p>{{ $product_size }}, {{ $product_gender }}</p>
                    </div>
                    <div class="right">
                        <h5>Rp.{{ $product_price }}</h5>
                        <p>x{{ $product_qty }}</p>
                    </div>
                </div>
                <div class="desc">
                    <div class="left">
                        <h5>{{ $product_name }}</h5>
                        <p>{{ $product_size }}, {{ $product_gender }}</p>
                    </div>
                    <div class="right">
                        <h5>Rp.{{ $product_price }}</h5>
                        <p>x{{ $product_qty }}</p>
                    </div>
                </div>
                <div class="desc">
                    <div class="left">
                        <h5>{{ $product_name }}</h5>
                        <p>{{ $product_size }}, {{ $product_gender }}</p>
                    </div>
                    <div class="right">
                        <h5>Rp.{{ $product_price }}</h5>
                        <p>x{{ $product_qty }}</p>
                    </div>
                </div>
            </div>
        </a>
        <a href="{{ route("student.detail-transaction", 1)}}" class="transaction">
            <div class="img">
                <img src="{{ $placeholder }}" alt="">
            </div>
            <div class="details">

                <div class="desc">
                    <div class="left">
                        <h5>{{ $product_name }}</h5>
                        <p>{{ $product_size }}, {{ $product_gender }}</p>
                    </div>
                    <div class="right">
                        <h5>Rp.{{ $product_price }}</h5>
                        <p>x{{ $product_qty }}</p>
                    </div>
                </div>
                <div class="desc">
                    <div class="left">
                        <h5>{{ $product_name }}</h5>
                        <p>{{ $product_size }}, {{ $product_gender }}</p>
                    </div>
                    <div class="right">
                        <h5>Rp.{{ $product_price }}</h5>
                        <p>x{{ $product_qty }}</p>
                    </div>
                </div>
                <div class="desc">
                    <div class="left">
                        <h5>{{ $product_name }}</h5>
                        <p>{{ $product_size }}, {{ $product_gender }}</p>
                    </div>
                    <div class="right">
                        <h5>Rp.{{ $product_price }}</h5>
                        <p>x{{ $product_qty }}</p>
                    </div>
                </div>
            </div>
        </a>
        <a href="{{ route("student.detail-transaction", 1)}}" class="transaction">
            <div class="img">
                <img src="{{ $placeholder }}" alt="">
            </div>
            <div class="details">

                <div class="desc">
                    <div class="left">
                        <h5>{{ $product_name }}</h5>
                        <p>{{ $product_size }}, {{ $product_gender }}</p>
                    </div>
                    <div class="right">
                        <h5>Rp.{{ $product_price }}</h5>
                        <p>x{{ $product_qty }}</p>
                    </div>
                </div>
                <div class="desc">
                    <div class="left">
                        <h5>{{ $product_name }}</h5>
                        <p>{{ $product_size }}, {{ $product_gender }}</p>
                    </div>
                    <div class="right">
                        <h5>Rp.{{ $product_price }}</h5>
                        <p>x{{ $product_qty }}</p>
                    </div>
                </div>
                <div class="desc">
                    <div class="left">
                        <h5>{{ $product_name }}</h5>
                        <p>{{ $product_size }}, {{ $product_gender }}</p>
                    </div>
                    <div class="right">
                        <h5>Rp.{{ $product_price }}</h5>
                        <p>x{{ $product_qty }}</p>
                    </div>
                </div>
            </div>
        </a>
        <a href="{{ route("student.detail-transaction", 1)}}" class="transaction">
            <div class="img">
                <img src="{{ $placeholder }}" alt="">
            </div>
            <div class="details">

                <div class="desc">
                    <div class="left">
                        <h5>{{ $product_name }}</h5>
                        <p>{{ $product_size }}, {{ $product_gender }}</p>
                    </div>
                    <div class="right">
                        <h5>Rp.{{ $product_price }}</h5>
                        <p>x{{ $product_qty }}</p>
                    </div>
                </div>
                <div class="desc">
                    <div class="left">
                        <h5>{{ $product_name }}</h5>
                        <p>{{ $product_size }}, {{ $product_gender }}</p>
                    </div>
                    <div class="right">
                        <h5>Rp.{{ $product_price }}</h5>
                        <p>x{{ $product_qty }}</p>
                    </div>
                </div>
                <div class="desc">
                    <div class="left">
                        <h5>{{ $product_name }}</h5>
                        <p>{{ $product_size }}, {{ $product_gender }}</p>
                    </div>
                    <div class="right">
                        <h5>Rp.{{ $product_price }}</h5>
                        <p>x{{ $product_qty }}</p>
                    </div>
                </div>
            </div>
        </a>
        <a href="{{ route("student.detail-transaction", 1)}}" class="transaction">
            <div class="img">
                <img src="{{ $placeholder }}" alt="">
            </div>
            <div class="details">

                <div class="desc">
                    <div class="left">
                        <h5>{{ $product_name }}</h5>
                        <p>{{ $product_size }}, {{ $product_gender }}</p>
                    </div>
                    <div class="right">
                        <h5>Rp.{{ $product_price }}</h5>
                        <p>x{{ $product_qty }}</p>
                    </div>
                </div>
                <div class="desc">
                    <div class="left">
                        <h5>{{ $product_name }}</h5>
                        <p>{{ $product_size }}, {{ $product_gender }}</p>
                    </div>
                    <div class="right">
                        <h5>Rp.{{ $product_price }}</h5>
                        <p>x{{ $product_qty }}</p>
                    </div>
                </div>
                <div class="desc">
                    <div class="left">
                        <h5>{{ $product_name }}</h5>
                        <p>{{ $product_size }}, {{ $product_gender }}</p>
                    </div>
                    <div class="right">
                        <h5>Rp.{{ $product_price }}</h5>
                        <p>x{{ $product_qty }}</p>
                    </div>
                </div>
            </div>
        </a>
        <a href="{{ route("student.detail-transaction", 1)}}" class="transaction">
            <div class="img">
                <img src="{{ $placeholder }}" alt="">
            </div>
            <div class="details">

                <div class="desc">
                    <div class="left">
                        <h5>{{ $product_name }}</h5>
                        <p>{{ $product_size }}, {{ $product_gender }}</p>
                    </div>
                    <div class="right">
                        <h5>Rp.{{ $product_price }}</h5>
                        <p>x{{ $product_qty }}</p>
                    </div>
                </div>
                <div class="desc">
                    <div class="left">
                        <h5>{{ $product_name }}</h5>
                        <p>{{ $product_size }}, {{ $product_gender }}</p>
                    </div>
                    <div class="right">
                        <h5>Rp.{{ $product_price }}</h5>
                        <p>x{{ $product_qty }}</p>
                    </div>
                </div>
                <div class="desc">
                    <div class="left">
                        <h5>{{ $product_name }}</h5>
                        <p>{{ $product_size }}, {{ $product_gender }}</p>
                    </div>
                    <div class="right">
                        <h5>Rp.{{ $product_price }}</h5>
                        <p>x{{ $product_qty }}</p>
                    </div>
                </div>
            </div>
        </a>
        <a href="{{ route("student.detail-transaction", 1)}}" class="transaction">
            <div class="img">
                <img src="{{ $placeholder }}" alt="">
            </div>
            <div class="details">

                <div class="desc">
                    <div class="left">
                        <h5>{{ $product_name }}</h5>
                        <p>{{ $product_size }}, {{ $product_gender }}</p>
                    </div>
                    <div class="right">
                        <h5>Rp.{{ $product_price }}</h5>
                        <p>x{{ $product_qty }}</p>
                    </div>
                </div>
                <div class="desc">
                    <div class="left">
                        <h5>{{ $product_name }}</h5>
                        <p>{{ $product_size }}, {{ $product_gender }}</p>
                    </div>
                    <div class="right">
                        <h5>Rp.{{ $product_price }}</h5>
                        <p>x{{ $product_qty }}</p>
                    </div>
                </div>
                <div class="desc">
                    <div class="left">
                        <h5>{{ $product_name }}</h5>
                        <p>{{ $product_size }}, {{ $product_gender }}</p>
                    </div>
                    <div class="right">
                        <h5>Rp.{{ $product_price }}</h5>
                        <p>x{{ $product_qty }}</p>
                    </div>
                </div>
            </div>
        </a>
        <a href="{{ route("student.detail-transaction", 1)}}" class="transaction">
            <div class="img">
                <img src="{{ $placeholder }}" alt="">
            </div>
            <div class="details">

                <div class="desc">
                    <div class="left">
                        <h5>{{ $product_name }}</h5>
                        <p>{{ $product_size }}, {{ $product_gender }}</p>
                    </div>
                    <div class="right">
                        <h5>Rp.{{ $product_price }}</h5>
                        <p>x{{ $product_qty }}</p>
                    </div>
                </div>
                <div class="desc">
                    <div class="left">
                        <h5>{{ $product_name }}</h5>
                        <p>{{ $product_size }}, {{ $product_gender }}</p>
                    </div>
                    <div class="right">
                        <h5>Rp.{{ $product_price }}</h5>
                        <p>x{{ $product_qty }}</p>
                    </div>
                </div>
                <div class="desc">
                    <div class="left">
                        <h5>{{ $product_name }}</h5>
                        <p>{{ $product_size }}, {{ $product_gender }}</p>
                    </div>
                    <div class="right">
                        <h5>Rp.{{ $product_price }}</h5>
                        <p>x{{ $product_qty }}</p>
                    </div>
                </div>
            </div>
        </a>
        <a href="{{ route("student.detail-transaction", 1)}}" class="transaction">
            <div class="img">
                <img src="{{ $placeholder }}" alt="">
            </div>
            <div class="details">

                <div class="desc">
                    <div class="left">
                        <h5>{{ $product_name }}</h5>
                        <p>{{ $product_size }}, {{ $product_gender }}</p>
                    </div>
                    <div class="right">
                        <h5>Rp.{{ $product_price }}</h5>
                        <p>x{{ $product_qty }}</p>
                    </div>
                </div>
                <div class="desc">
                    <div class="left">
                        <h5>{{ $product_name }}</h5>
                        <p>{{ $product_size }}, {{ $product_gender }}</p>
                    </div>
                    <div class="right">
                        <h5>Rp.{{ $product_price }}</h5>
                        <p>x{{ $product_qty }}</p>
                    </div>
                </div>
                <div class="desc">
                    <div class="left">
                        <h5>{{ $product_name }}</h5>
                        <p>{{ $product_size }}, {{ $product_gender }}</p>
                    </div>
                    <div class="right">
                        <h5>Rp.{{ $product_price }}</h5>
                        <p>x{{ $product_qty }}</p>
                    </div>
                </div>
            </div>
        </a>
        
    </div>
</div>
@include('_components._footer')

<script>
    document.querySelector("#editButton").addEventListener("click", function() {
        document.querySelector(".editDisplay").style.display = "flex";
    })
    
    document.querySelector(".editBackdrop").addEventListener("click", function() {
        document.querySelector(".editDisplay").style.display = "none";
    })
</script>