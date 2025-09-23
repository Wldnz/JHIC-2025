@include('_components._headerAdmin', ['title' => 'Detail Transaksi'])
@php
    logger('data', [$transaction]);
    $columns = [
        'Data Pembeli' => [
            'data' => $transaction['user'],
            'column' => [
                'nis' => 'NIS Pembeli',
                'fullname' => 'Nama Pembeli',
                'email' => 'Alamat Email',
                'created_at' => 'Akun Dibuat Pada'
            ],
        ],
        'Data Transaksi' => [
            'data' => $transaction,
            'column' => [
                'received_email' => 'Alamat Email Penerima',
                'received_phone' => 'Nomor Telepon Penerima',
                'total_product' => 'Total Produk',
                'total_price' => 'Total Harga',
                'created_at' => 'Tanggal Transaksi Dibuat',
                'updated_at' => 'Tanggal Transaksi Dibuat',
                'payment_method' => 'Metode Pembayaran',
                'status' => 'Status Transaksi',
                'expired' => 'Catatan',
            ],
            'additional_class' => ['tree-row-grid']
        ]
    ];
@endphp
<main class="content">
    @foreach ($columns as $title => $column)
        <h2>{{ $title }}</h2>
        <div class="form-data">
            <div
                class="wrapper-field container {{ isset($column['additional_class']) ? implode('', $column['additional_class']) : '' }} ">
                @foreach ($column['column'] as $key => $label)
                    <div class="wrapper-input">
                        <label for="name">{{ $label }}</label>
                        <input type="text" name="name" id="name" placeholder="Masukkan {{ $label }}"
                            value="{{ $column['data'][$key] }}" readonly>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
    @include('_components._management-table', [
        'title' => 'Produk Yang Dibeli',
        'datas' => $transaction['orders'],
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
</main>
@include('_components._footerAdmin')