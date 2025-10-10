@include('_components._headerAdmin', ['title' => 'Portfolio Management'])
@php
    $currentPath = explode('/admin/', url()->current())[1];
@endphp
<main class="content">
    @include('_components._management-table',[
        'title' => 'Transaksi',
        'management' => [ 'title' => 'Tambahkan Transaksi', ],
        'datas' => [],
        'columns' => [
            'ID' => 'ID Transaksi',
            'nisn' => 'Nomor Induk Nasional',
            'full_name' => 'Nama Lengkap',
            'payment_method' => 'Jenis Pembayaran',
            'status' => 'Status',  
            'created_at' => 'Dibuat Pada'
        ]    
    ])
</main>

@include('_components._footerAdmin')