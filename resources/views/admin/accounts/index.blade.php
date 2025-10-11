@include('_components._headerAdmin', ['title' => 'Accounts Management'])
@php
    $currentPath = explode('/admin/', url()->current())[1];
    logger('as', [$accounts])
@endphp
<main class="content">
      @include('_components._management-table',[
        'title' => 'Data Pengguna',
        'management' => [ 'title' => 'Tambahkan Pengguna', 'destination' => route('admin.create-account')],
        'datas' => $accounts,
        'columns' => [
            'id' => 'ID Akun',
            'fullname' => 'Nama Lengkap Pengguna',
            'email' => 'Alamat Email',
            'phone' => 'Nomor Telepon',
            'role' => 'Role',  
            'created_at' => 'Dibuat Pada'
        ],
        'findDataWith' => [
            'filters' => [
                'search_role' => [
                    'options' => [
                        'candidate' => 'Calon Peserta Didik',
                        'article_creator' => 'Pembuat Artikel',
                        ... Auth::user()->role == 'admin' || Auth::user()->role == 'super_admin' ? [
                            'super_admin' => 'Pemilik',
                            'admin' => 'Administrasi',
                        ] : [],
                    ]
                ]
            ],
            'search-engine' => [
                'name' => 'search',
                'placeholder' => 'Cari Nama Pengguna'
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

@include('_components._footerAdmin')