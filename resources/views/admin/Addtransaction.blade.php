@include('_components._headerAdmin', ['title' => 'Menambahkan Transaksi'])
@php
    $sections = [
        'Data Pembeli' => [
            'data' => [],
            'input' => [
                'nis' => 'NIS',
                'fullname' => 'Nama',
                'email' => 'Alamat Email',
                'created_at' => 'Akun Dibuat Pada'
            ],
        ],
        'Data Transaksi' => [
            'column' => [
                'received_email' => 'Alamat Email Penerima',
                'received_phone' => 'Nomor Telepon Penerima',
                'total_product' => 'Total Produk',
                'total_price' => 'Total Harga',
                'payment_method' => 'Metode Pembayaran',
                'expired' => 'Catatan',
            ],
            'additional_class' => ['tree-row-grid']
        ]
    ];
@endphp
<form class="content">
    <h2>Data Pembeli</h2>
    <div class="form-data">
        <div class="wrapper-field container">
            <div class="wrapper-input">
                <label for="nis">NIS</label>
                <input type="text" name="nis" id="nis" placeholder="Masukkan nama" readonly required>
            </div>
            <div class="wrapper-input">
                <label for="name">Nama Pembeli</label>
                <select name="name" id="name">
                    <option value="12345678">Wildan Izhar Al Haqq</option>
                    <option value="12345679">Starfours</option>
                    <option value="123456710">Rizky SS</option>
                    <option value="123456711">Rizky Andri</option>
                    <option value="123456712">Diageng Hidayat</option>
                    <option value="123456714">Raditya Ferdiyanto</option>
                </select>
            </div>
            <div class="wrapper-input">
                <label for="email">Emal Pembeli</label>
                <input type="text" name="email" id="email" placeholder="Masukkan email Pembeli" readonly required>
            </div>
            <div class="wrapper-input">
                <label for="created_at">Dibuat Pada</label>
                <input type="text" name="created_at" id="created_at" placeholder="Masukkan angka" readonly required>
            </div>
        </div>
    </div>

    <h2>Data Transaksi</h2>
    <div class="form-data">
        <div class="wrapper-field container tree-row-grid">
            <div class="wrapper-input">
                <label for="received_email">Email Penerima <span>*</span></label>
                <input type="email" name="received_email" id="received_email" placeholder="Masukkan email penerima"
                    min="8" required>
            </div>
            <div class="wrapper-input">
                <label for="received_phone">No Telepon Penerima <span>*</span></label>
                <input type="text" inputmode="numeric" name="received_phone" id="received_phone"
                    placeholder="Masukkan email penerima" min="11" max="12" required>
            </div>
            <div class="wrapper-input">
                <label for="total_product">Total Produk</label>
                <input type="text" inputmode="numeric" name="total_product" id="total_product" placeholder="0" value="0"
                    min=0 required readonly>
            </div>
            <div class="wrapper-input">
                <label for="total_price">Total Harga</label>
                <input type="text" inputmode="numeric" name="total_price" id="total_price"
                    placeholder="Masukkan total harga" min="0" required readonly>
            </div>
            <div class="wrapper-input">
                <label for="note">Catatan</label>
                <textarea name="note" id="note" placeholder="masukakn catatan"></textarea>
            </div>
            <div class="wrapper-input">
                <label for="payment_method">Nama Pembeli</label>
                <select name="payment_method" id="payment_method">
                    <option value="gopay">Gopay</option>
                    <option value="dana">Dana</option>
                    <option value="ovo">Ovo</option>
                    <option value="virtual_bca">Virtual BCA</option>
                    <option value="virtual_mandiri">Virtual Mandiri</option>
                    <option value="virtual_bni">Virtual BNI</option>
                </select>
            </div>
        </div>
        <button class="button-submit-form">
            <span>Tambahkan Transaksi</span>
            @include('_components._sprite-icons', ['name' => 'add', 'size' => 18])
        </button>
    </div>
</form>

@include('_components._management-table', [
    'title' => 'Produk Yang Dibeli',
    'management' => ['title' => 'Tambahkan Produk'],
    'datas' => [],
    'columns' => [
        'id' => 'ID ORDER',
        'product' => 'Produk',
        'product_variant' => 'Variant Produk',
        'category' => 'Kategori',
        'quantity' => 'Jumlah',
        'price' => 'Total Harga'
    ],
    'column_relations' => [
        'product_variant' => 'name',
        'product' => [
            'parent' => 'product_variant',
            'name' => 'product',
            'column' => 'name'
        ],
        'category' => [
            'parent' => 'product_variant',
            'name' => 'product',
            'column' => 'category'
        ]
    ]
])

<div class="alert-message" id="form-order" style='display:flex'>
    <form class="card-form" id="card-form-order" style='display:flex'>
        @csrf
        <h4>Tambahkan Orderan</h4>
        <div class="wrapper-input">
            <label for="">Nama Product</label>
            <select name="" id="">
                <option value="almet">Almet</option>
                <option value="almet">Almet</option>
                <option value="almet">Almet</option>
                <option value="almet">Almet</option>
            </select>
        </div>
        <div class="wrapper-input">
            <label for="">Product Variant</label>
            <select name="" id="">
                <option value="almet">Almet</option>
                <option value="almet">Almet</option>
                <option value="almet">Almet</option>
                <option value="almet">Almet</option>
            </select>
        </div>
        <div class="wrapper-input">
            <label for="">Tipe / Size</label>
            <select name="" id="">
                <option value="almet">Almet</option>
                <option value="almet">Almet</option>
                <option value="almet">Almet</option>
                <option value="almet">Almet</option>
            </select>
        </div>
        <div class="wrapper-input">
            <label for="">Jumlah Produk</label>
            <input type="numeric">
        </div>
        <div class="wrapper-input">
            <label for="">Total Harga</label>
            <input type="numeric" name="" id="" min=0 required readonly>
        </div>
        <button type="submit" class="btn-yes-anouncement" data-action="orderan">Tambahkan Orderan</button>
        <button type="button" class="btn-close-anouncement">Tutup Pemberitahuan</button>
    </form>
</div>

<script defer>
    const orders = [];
    const products = [];
    const variants = [];

    function addOrder({
        product_id,
        variant_id,
        quantity,
    }){
        const product = products.find(p => p.id == product_id);
        const variant = variants.find(v => v.id == variant_id);
        orders.push({
            id : `added_order_${orders.length + 1}`,
            product_name : product[0].name,
            variant_name : variant[0].name,
            variant_type : variant[0].type,
            category : product[0].category,
            quantity,
            total_price : variant[0].price * quantity,
        });
    }

    function updateOrder(id,{
        product_id,
        variant_id,
        quantity,
    }){
        const product = products.find(p => p.id == product_id);
        const variant = variants.find(v => v.id == variant_id);
        orders = orders.map(order => {
            if(order.id == id){
                product_name : product[0].name,
                variant_name : variant[0].name,
                variant_type : variant[0].type,
                category : product[0].category,
                quantity,
                total_price : variant[0].price * quantity,
            }
            return order;
        });
    }

    function deleteOrder(id){
        if(orders.length <= 1) return;
        orders = orders.filter(order => order.id != id);
    }

</script>