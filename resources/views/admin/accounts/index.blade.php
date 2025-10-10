@include('_components._headerAdmin', ['title' => 'Account Management'])
@php
    $currentPath = explode('/admin/', url()->current())[1];
@endphp
<main class="content">
    @include('_components._management-table', [
        'title' => 'Akun',
        'management' => ['title' => 'Tambahkan Pengguna',],
        'datas' => [],
        'columns' => [
            'id' => 'ID Akun',
            'full_name' => 'Nama Lengkap',
            'email' => 'Alamat Email',
            'phone' => 'Nomor Telepon',
            'role' => 'Role',
            'created_at' => 'Dibuat Pada'
        ],
        'findDataWith' => [
            'filters' => [
                'serch_role' => [
                    'options' => [
                        'admin' => 'Admin',
                        'candidates' => 'Calon Peserta Didik',
                        'article_creator' => 'Pembuat Artikel'
                    ]
                ],
            ],
            'search-engine' => [
                'name' => 'search',
                'placeholder' => 'Cari Nama Pengguna'
            ]
        ],
    ])
</main>

@include('_components._footerAdmin')