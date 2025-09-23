@include('_components._headerAdmin', ['title' => 'Management Transaksi'])
@php
    $currentPath = explode('/admin/', url()->current())[1];
    logger('as', [$transactions])
@endphp
<main class="content">
    @includeWhen(isset($stats), "_components._summary-section", [
        "name" => "Transaction",
        "data" => $stats
    ])
    @include('_components._management-table', [
        'title' => 'Total Transaksi (' . $stats['on Going'] . ' Sedang Berlangsung)',
        'total' => $stats['total'],
        'management' => ['title' => 'Tambahkan Transaksi'],
        'findDataWith' => [
            'filters' => [
                'search_status' => [
                    'options' => [
                        '' => 'Semua Transaksi',
                        'pending' => 'Menunggu Pembayaran',
                        'ongoing' => 'Tranasksi Berlangsung',
                        'success' => 'Transaksi Berhasil',
                        'fail' => 'Transaksi Gagal'
                    ]
                ]
            ],
            'search-engine' => [
                'name' => 'search',
                'placeholder' => 'Cari ID Transaksi Atau Nama Pembeli'
            ]
        ],
        'datas' => $transactions,
        'columns' => [
            'id' => 'ID Transaksi',
            'user' => 'Nama Pembeli',
            'total_product' => 'Total Produk',
            'total_price' => 'Total Harga',
            'created_at' => 'Tanggal',
            'status' => 'Status',
        ],
        'column_relations' => [
            'user' => 'fullname'
        ],
        'actions' => [
            'Lihat Transaksi' => [
                'action-name' => 'transaction',
                'route-name' => 'admin.detail-transaction',
                'icon-name' => 'eye'
            ],
            'Hapus Transaksi' => [
                'action-name' => 'delete',
                'icon-name' => 'trash',
                'destination' => [
                    'name' => 'admin.delete-transaction',
                    'parameter' => 'transaction'
                ]
            ]
        ],
        'pagination' => [
            'current' => $currentPage,
            'max' => $maxPage
        ],
    ])
</main>

@includeWhen(session()->has('alert'), '_components._alert-message', ['data' => session()->get('alert'), 'icon_name' => 'product'])

<script defer>
    setActionDelete(false);
</script>