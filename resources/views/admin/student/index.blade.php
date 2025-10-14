@include('_components._headerAdmin', ['title' => 'Accounts Management'])
@php
    $currentPath = explode('/admin/', url()->current())[1];
    logger('as', [$students])
@endphp
<main class="content">
      @include('_components._summary-section', [
        'title' => 'Siswa',
        'greeting' => true,
        'data' => $stats,
        'icon' => [ 
            'name' => 'candidate',
        ]
    ])
      @include('_components._management-table',[
        'title' => 'Data Siswa',
        'management' => [ 'title' => 'Tambahkan Siswa', 'destination' => route('admin.create-student')],
        'datas' => $students,
        'columns' => [
            'nis' => 'Nomor Induk Siswa',
            'name' => 'Nama Lengkap Siswa',
            'gender' => 'Jenis Kelamin',
            'class' => 'Kelas',  
            'major_long_name' => 'Jurusan',
            'birthdate' => 'Tanggal Lahir',
            'created_at' => 'Dibuat Pada'
        ],
        'findDataWith' => [
            'filters' => [
                'search_major' => [
                    'options' => [
                        '' => 'Semuanya',
                        'RPL' => 'Rekaysa Perangkat Lunak',
                        'TKJ' => 'Teknik Komputer & Jaringan',
                        'DKV' => 'Desain Komunikasi Visual',
                        'ANM' => 'Animasi',
                        'BC' => 'Broadcasting',
                        'GAMEDEV' => 'Game Development',
                    ],
                ],
                'search_class' => [
                    'options' => [
                        '' => 'Semuanya',
                        'X' => 'Kelas 10',
                        'XI' => 'Kelas 11',
                        'XII' => 'Kelas 12',
                    ],
                ]
            ],
            'search-engine' => [
                'name' => 'search',
                'placeholder' => 'Cari Nama/NISN Siswa'
            ]
        ],
        'actions' => [
            'Lihat Siswa' => [
                'action-name' => 'student',
                'route-name' => 'admin.detail-student',
                'icon-name' => 'eye'
            ],
            'Hapus Siswa' => [
                'action-name' => 'delete',
                'icon-name' => 'trash',
                'destination' => [
                    'name' => 'admin.delete-student',
                    'parameter' => 'student'
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