@include('_components._headerAdmin', ['title' => 'Detail Transaksi'])
@php
    logger('data', [$transaction]);
    $columns = [
        'Data Calon Peserta Didik' => [
            'data' => $transaction,
            'column' => [
                'candidate_nisn' => 'Nisn',
                'candidate_full_name' => 'Nama Lengkap',
            ],
        ],
        'Data Transaksi' => [
            'data' => $transaction,
            'column' => [
                'total_cost' => 'Nominal Yang Dibayar',
                'payment_method_display_name' => 'Jenis Pembayaran',
                'created_at' => 'Dibuat Pada',
                'updated_at' => 'Terakhir Diubah Pada',
                'expired_at' => 'Transaksi Kadaluarsa Pada',
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
    @if(false)
        <button class="button-submit-form">
            <span>Merubah Data Transaksi</span>
            @include('_components._sprite-icons', ['name' => 'add', 'size' => 18])
        </button>
    @endif
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

@include('_components._footerAdmin')
