@include('_components._headerAdmin', ['title' => 'Detail Transaksi'])
@php
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
                    @if($title == 'Data Transaksi' && $loop->last)
                        <div class="wrapper-input">
                            <label for="status">Status Transaksi</label>
                            <input type="text" name="status" id="status" placeholder="Masukkan status" value="{{ $transaction['status'] }}" readonly>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    @endforeach
</form>

@include('_components._footerAdmin')
