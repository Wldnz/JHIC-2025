@include('_components._headerAdmin', ['title' => 'Management Akun'])
@php
    $currentPath = explode('/admin/', url()->current())[1];
    logger('a', [$stats, $accounts])
@endphp
<main class="content">
    @includeWhen(isset($stats), "_components._summary-section", [
        "name" => "Accounts & Activities",
        "data" => [
            "Account" => $stats['account'],
            "Siswa" => $stats['siswa'],
            "Admin" => $stats['admin'],
            "Activity" => $stats['activity']
        ]
    ])
    @include('_components._management-table', [
        'title' => 'Total Akun '. strtoupper($search_role[0]) . substr($search_role, 1),
        'management' => ['title' => 'Tambahkan Akun', 'destination' => route('admin.create-account')],
        'findDataWith' => [
            'filters' => [
                'search_role' => [
                    'options' => [
                        'siswa' => 'Siswa',
                        'admin' => 'Admin'
                    ]
                ]
            ],
            'search-engine' => [
                'name' => 'search',
                'placeholder' => 'Cari nama pengguna disini...'
            ]
        ],
        'columns' => [
            'nis' => 'NIS/NISN',
            'fullname' => 'Nama Lengkap',
            'email' => 'Email Pengguna',
            'role' => 'Role'
        ],
        'total' => $stats[(string) $search_role]['total'],
        'datas' => $accounts,
        'actions' => [
            'Edit Akun' => [
                'action-name' => 'account',
                'icon-name' => 'account',
                'route-name' => 'admin.detail-account',
            ],
            'Hapus Akun' => [
                'action-name' => 'delete',
                'icon-name' => 'account',
                'destination' => [
                    'name' => 'admin.delete-account',
                    'parameter' => 'account'
                ]
            ]
        ],
        'pagination' => [
            'current' => $currentPage,
            'max' => $maxPage    
        ]
    ])
</main>
@includeWhen(session()->has('alert'), '_components._alert-message', ['data' => session()->get('alert'), 'icon_name' => 'product'])
<script defer>
    setActionDelete(true, {
        title : 'Akun Dengan NIS',
    });
</script>
@include('_components._footerAdmin')