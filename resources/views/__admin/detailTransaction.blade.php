@include('_components._headerAdmin', ['title' => 'Detail Transaksi'])
@php
    logger('data', [$transaction]);
    $columns = [
        'Data Pembeli' => [
            'data' => $transaction['user'],
            'column' => [
                'nis' => 'NIS Pembeli',
                'fullname' => 'Nama Pembeli (Saat Ini)',
                'email' => 'Alamat Email',
                'created_at' => 'Akun Dibuat Pada'
            ],
        ],
        'Data Transaksi' => [
            'data' => $transaction,
            'column' => [
                'user_fullname' => 'Nama Pembeli',
                'received_email' => 'Alamat Email Penerima',
                'received_phone' => 'Nomor Telepon Penerima',
                'total_product' => 'Total Produk',
                'total_price' => 'Total Harga',
                'created_at' => 'Tanggal Transaksi Dibuat',
                'updated_at' => 'Tanggal Transaksi Dirubah',
                'payment_method' => 'Metode Pembayaran',
                'note' => 'Catatan',
            ],
            'additional_class' => ['tree-row-grid']
        ]
    ];
@endphp
<form class="content" method="post">
    @csrf
    @method('PUT')
    @foreach ($columns as $title => $column)
        <h2>{{ $title }}</h2>
        <div class="form-data">
            <div
                class="wrapper-field container {{ isset($column['additional_class']) ? implode('', $column['additional_class']) : '' }} ">
                @foreach ($column['column'] as $key => $label)
                    <div class="wrapper-input">
                        <label for="name">{{ $label }}</label>
                        <input type="text" name="name" id="name" placeholder="Masukkan {{ $label }}"
                            value="{{ $column['data'][$key] ?? '' }}" readonly>
                    </div>
                    @if($loop->last)
                        @if($title == 'Data Transaksi')
                            <div class="wrapper-input">
                                <label for="status">Status Transaksi</label>
                                @if($transaction['status'] == 'pending')
                                    <select name="status" id="status" required>
                                        <option value="{{ $transaction['status'] }}">{{ $transaction['status'] }}</option>
                                        <option value="ongoing">Berlangsung (Sudah Bayar)</option>
                                    </select>
                                @else
                                     <input type="text" name="status" id="status" placeholder="Masukkan status" value="{{ $transaction['status'] }}" readonly>
                                @endif
                            </div>
                        @endif
                    @endif
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
            'received_quantity' => 'Jumlah Diterima',
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
        ],
        'actions' => $transaction['status'] != 'ongoing' ? [] : [
            'Edit Received Quantity' => [
                'action-name' => 'transaction',
                'icon-name' => 'box-edit'
            ],
        ],
    ])
    <button class="button-submit-form">
        <span>Merubah Data Transaksi</span>
        @include('_components._sprite-icons', ['name' => 'add', 'size' => 18])
    </button>
</form>

<div class="alert-message" id="form-received_order" style='display:none'>
    <form class="card-form" id="card-form-order_received" data-action='add' style='display:none'>
        @csrf
        <h4>Merubah Jumlah Produk Diterima</h4>
        <div class="wrapper-input">
            <label for="received_product">Jumlah Produk Diterima</label>
            <input type="number" name="received_product" id="received_product" required>
        </div>
        <input type="hidden" name='id_order' id="id_received_order" readonly>
        <button type="submit" class="btn-yes-anouncement btn-yes-anouncement-received" data-action="orderan">Merubah Orderan</button>
        <button type="button" class="btn-close-anouncement btn-close-anouncement-received">Tutup Pemberitahuan</button>
    </form>
</div>

@if ($transaction['status'] == 'ongoing')
    <script defer>
        let orders = @json(old('orders', $transaction['orders']));
        const alert_message = document.getElementById('form-received_order');
        const form_quantity = document.getElementById('card-form-order_received');
    </script>
    @vite('resources/js/handle/detail-transaction.js')
@endif
@include('_components._footerAdmin')
