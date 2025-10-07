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
        <img src="{{ $placeholder }}" alt="profile-image">
        <p>NIS: {{ $user->nis }}</p>
        <p>Nama Lengkap: {{ $user->fullname }}</p>
        <p>Email: {{ $user->email }}</p>
        <button class="button" id="editButton">Edit Profile</button>
        <div class="editDisplay">
            <span class="editBackdrop"></span>
            <form method="POST" id="editForm">
                @csrf
                @method('PUT')

                <h3>Edit Profile</h3>
                <label for="fullname">Nama Lengkap</label>
                <input type="text" name="fullname" id="fullname" value="{{ $user->fullname }}" required>

                <label for="email">Email</label>
                <input type="email" name="email" id="email" value="{{ $user->email }}" required>

                <label for="password">Password</label>
                <input type="password" name="password" id="password">

                <label for="password_confirmation">Confirm Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation">

                <button type="submit" class="button" style="align-self: center;">Submit</button>
            </form>
        </div>
    </div>
    <div class="transaction-history">
        <input type="text" placeholder="Search" id="search-input">
        <div id="transactions-container">
        </div>
    </div>
</div>
@include('_components._footer')

<script>
    const numFormat = Intl.NumberFormat('id-ID');

    const placeholderImage = @js($placeholder);
    const transactions = @json($transactions);

    const searchInput = document.getElementById("search-input");
    const transactionsContainer = document.getElementById("transactions-container");

    function loadTransactionsHistory(arr) {
        transactionsContainer.innerHTML = arr.map((transaction) => {
            return `
            <a href="/transactions/${transaction.id}" class="transaction">
                <div class="img">
                    <img src="${transaction.orders[0]?.product_variant.product.images.length > 0 ? transaction.orders[0].product_variant.product.images[0].url : placeholderImage}" alt="product-thumbnail">
                </div>
                <div class="details">
                    ${transaction.orders.map((order) => {
                        return `
                        <div class="desc">
                            <div class="left">
                                <h5>${order.product_variant.product.name}</h5>
                                <p>${order.product_variant.name}, ${order.product_variant.type}</p>
                            </div>
                            <div class="right">
                                <h5>Rp. ${numFormat.format(order.price)}</h5>
                                <p>x${order.quantity}</p>
                            </div>
                        </div>
                        `;
                    }).join("")}
                </div>
            </a>`;
        }).join("");
    }

    searchInput.addEventListener('change', (e) => {
        const searchQuery = e.target.value.toLowerCase();
        const filtered = transactions.filter((transaction) => {
            return transaction.id.toString().includes(searchQuery) ||
                transaction.orders.some((order) =>
                    order.price.toString().toLowerCase().includes(searchQuery) ||
                    order.quantity.toString().toLowerCase().includes(searchQuery) ||
                    order.product_variant.product.name.toLowerCase().includes(searchQuery) ||
                    order.product_variant.name.toLowerCase().includes(searchQuery) ||
                    order.product_variant.type.toLowerCase().includes(searchQuery)
                );
        });

        loadTransactionsHistory(filtered);
        e.target.blur();
    });

    document.querySelector("#editButton").addEventListener("click", function() {
        document.querySelector(".editDisplay").style.display = "flex";
    });

    document.querySelector(".editBackdrop").addEventListener("click", function() {
        document.querySelector(".editDisplay").style.display = "none";
    });

    loadTransactionsHistory(transactions);
</script>
