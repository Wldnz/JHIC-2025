@include('_components._headerAdmin', ['title' => 'Menambahkan Transaksi'])
@php
    $table_management = [
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
    ];
    logger('data', [$products, $students])
@endphp
<form class="content" method="post" enctype="application/x-www-form-urlencoded">
    @csrf
    <h2>Data Pembeli</h2>
    <div class="form-data" id="student-siswa-form">
        <div class="wrapper-field container">
            <div class="wrapper-input">
                <label for="nis">NIS</label>
                <input type="text" name="nis" id="nis" placeholder="Nis Siswa" readonly required>
            </div>
            <div class="wrapper-input">
                <label for="user_nis">Nama Pembeli<span> *</span></label>
                <select name="user_nis" id="user_nis" required>
                    <option value="">Pilih Nama Siswa</option>
                    @foreach ($students as $student)
                        <option value="{{ $student->nis }}">{{ $student->fullname }}</option>
                    @endforeach
                </select>
            </div>
            <div class="wrapper-input">
                <label for="email">Email Pembeli</label>
                <input type="text" name="email" id="email" placeholder="Masukkan email Pembeli" readonly required>
            </div>
            <div class="wrapper-input">
                <label for="created_at">Dibuat Pada</label>
                <input type="text" name="created_at" id="created_at" placeholder="Masukkan angka" readonly required>
            </div>
        </div>
    </div>

    <h2>Data Transaksi</h2>
    <div class="form-data" id="transaction-transaksi-form">
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
                    @foreach ($payment_methods as $payment_method)
                        <option value="{{ $payment_method->code_name }}">{{ $payment_method->display_name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="wrapper_order" id="wrapper_orders" style="display:none">

    </div>
    <button class="button-submit-form">
        <span>Tambahkan Transaksi</span>
        @include('_components._sprite-icons', ['name' => 'add', 'size' => 18])
    </button>
</form>

@include('_components._management-table', $table_management)

<div class="alert-message" id="form-order" style='display:none'>
    <form class="card-form" id="card-form-order" data-action='add' style='display:none'>
        @csrf
        <h4>Tambahkan Orderan</h4>
        <div class="wrapper-input">
            <label for="product_name">Nama Product</label>
            <select name="product_name" id="product_name" required>
                <option value=""></option>
                @foreach ($products as $product)
                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="wrapper-input">
            <label for="variant_name">Product Variant</label>
            <select name="variant_name" id="variant_name" required>
            </select>
        </div>
        <div class="wrapper-input">
            <label for="variant_type">Tipe / Size</label>
            <select name="variant_type" id="variant_type" required>
            </select>
        </div>
        <div class="wrapper-input">
            <label for="total_product">Jumlah Produk</label>
            <input type="numeric" name="total_product" id="total_product" min=1 value="1" required>
        </div>
        <div class="wrapper-input">
            <label for="total_price">Total Harga</label>
            <input type="text" inputmode="numeric" name="total_price" id="total_price" required readonly>
        </div>
        <input type="hidden" name='id_order' id="id-order" readonly>
        <button type="submit" class="btn-yes-anouncement btn-yes-anouncement-add" data-action="orderan">Tambahkan
            Orderan</button>
        <button type="button" class="btn-close-anouncement btn-close-anouncement-add">Tutup Pemberitahuan</button>
    </form>
</div>

<script defer>
    let orders = [];
    const products = @json($products);
    const students = @json($students);
    const columns = @json($table_management['columns']);
    let currentProduct = [];
</script>

@vite(['resources/js/handle/trasactions.js'])