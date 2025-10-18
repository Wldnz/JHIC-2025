@include('_components._headerAdmin', ['title' => 'Transactions Management'])
<main class="content">
    @include('_components._summary-section',
    [
        'title' => 'Transactions',
        'greeting' => true,
        'data' => $stats
    ])
    @include('_components._management-table',[
        'title' => 'Transactions',
        'management' => [ 'title' => 'Tambahkan Transaksi', 'destination' => route('admin.add-transaction')],
        'datas' => $transactions,
        'columns' => [
            'id' => 'ID Transaksi',
            'candidate_nisn' => 'Nomor Induk Nasional',
            'candidate_full_name' => 'Nama Lengkap',
            'payment_method_display_name' => 'Jenis Pembayaran',
            'total_cost' => 'Total Biaya',
            'status' => 'Status',
            'created_at' => 'Dibuat Pada'
        ],
        'findDataWith' => [
            'filters' => [
                'search_status' => [
                    'options' => [
                        '' => 'Semuanya',
                        'success' => 'Terbayar',
                        'canceled' => 'Dibatalkan',
                        'refund' => 'Dikembalikan',
                        'expire' => 'Kadaluarsa'
                    ]
                ]
            ],
            'search-engine' => [
                'name' => 'search',
                'placeholder' => 'Cari nama calon peserta didik'
            ]
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
            'current' => $page,
            'total' => $total
        ]
    ])
</main>

<script defer>
    setActionDelete(false, {
        title : 'Transaksi Dengan ID'
    });
</script>

@include('_components._footerAdmin')
