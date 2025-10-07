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
    <h3>Detail Transaksi : BITU-TRX {{ $transaction->id }}</h3>
    <div class="content">

        <div class="products-list" id="orders-container">
        </div>
        <div class="details">
            <h4>Order Details Information</h4>
            <h5>Product Price : <p id="order-price"></p></h5>
            <h5>Quantity : <p id="order-qty"></p></h5>
            <h5>Received Quantity : <p id="order-received-qty"></p></h5>
            <h5>Order Status : <p id="order-status"></p></h5>
            <br>
            <h4>Product Information</h4>
            <h5>Product ID : <p id="product-id"></p></h5>
            <h5>Product Name : <p id="product-name"></p></h5>
            <h5>Product Category : <p id="product-category"></p></h5>
            <h5>Current Stock : <p id="product-stock"></p></h5>
            <br>
            <h4>Variant</h4>
            <h5>Gender : <p id="variant-name"></p></h5>
            <h5>Size : <p id="variant-type"></p></h5>
            <br>
            <h4>Payment Details</h4>
            <h5>Payment Method : <p id="payment-method"></p></h5>
            <h5>Total Price : <p id="payment-total-price"></p></h5>
            <br><br>
        </div>
    </div>
</div>
    @include('_components._footer')

<script>
    const numFormat = Intl.NumberFormat('id-ID');

    const transaction = @json($transaction);
    const orders = transaction.orders;
    const placeholderThumbnail = @js($placeholder);

    const ordersContainer = document.getElementById('orders-container');
    const orderPrice = document.getElementById("order-price");
    const orderQty = document.getElementById("order-qty");
    const orderReceivedQty = document.getElementById("order-received-qty");
    const orderStatus = document.getElementById("order-status");
    const productId = document.getElementById("product-id");
    const productName = document.getElementById("product-name");
    const productCategory = document.getElementById("product-category");
    const productStock = document.getElementById("product-stock");
    const variantName = document.getElementById("variant-name");
    const variantType = document.getElementById("variant-type");
    const paymentMethod = document.getElementById("payment-method");
    const paymentTotalPrice = document.getElementById("payment-total-price");

    function loadOrdersContainer(arr) {
        ordersContainer.innerHTML = arr.map((order, i) => {
            return `
            <div class="product" data-order-index="${i}">
                <div class="left">
                    <img src="${order.product_variant.product.images.length > 0 ? order.product_variant.product.images[0].url : placeholderThumbnail}" alt="">
                </div>
                <div class="middle">
                    <h3>${order.product_variant.product.name}</h3>
                    <p>${order.product_variant.name}, ${order.product_variant.type}</p>
                </div>
                <div class="right">
                    <h4>Rp. </h4>
                    <p>${numFormat.format(order.price)}</p>
                    <h5>x ${numFormat.format(order.quantity)}</h5>
                    </div>
            </div>
            `;
        }).join('');

        document.querySelectorAll(".product").forEach(tab => {
            tab.addEventListener("click", (e) => {
                document.querySelectorAll(".product").forEach(opt => {
                    opt.classList.remove("picked");
                });
                tab.classList.add("picked");

                const orderIndex = tab.getAttribute("data-order-index");
                const selectedOrder = orders[orderIndex];

                if (!selectedOrder) return;

                orderPrice.innerText = numFormat.format(selectedOrder.price);
                orderQty.innerText = numFormat.format(selectedOrder.quantity);
                orderReceivedQty.innerText = numFormat.format(selectedOrder.received_quantity);
                orderStatus.innerText = selectedOrder.status;
                productId.innerText = selectedOrder.product_variant.product.id;
                productName.innerText = selectedOrder.product_variant.product.name;
                productCategory.innerText = selectedOrder.product_variant.product.category == 'uniform' ? "Seragam" : "Attribute";
                productStock.innerText = numFormat.format(selectedOrder.product_variant.stock);
                variantName.innerText = selectedOrder.product_variant.name;
                variantType.innerText = selectedOrder.product_variant.type;
                paymentMethod.innerText = transaction.payment_method;
                paymentTotalPrice.innerText = numFormat.format(selectedOrder.price * selectedOrder.quantity);
            });
        });
    }

    loadOrdersContainer(orders);
</script>
