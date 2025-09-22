@include('_components._headerAdmin', ['title' => 'Management Products'])
<main class="content">
    @includeWhen(isset($stats), "_components._summary-section", [
        "name" => "Product",
        "data" => $stats
    ])
    @include('_components._management-table', [
        'management' => ['title' => 'Tambahkan Produk', 'destination' => route('admin.add-product')],
        'findDataWith' => [
            'filters' => [
                'search_stock' => [
                    'options' => [
                        'all' => 'Semuanya',
                        'available' => 'Tersedia',
                        'low' => 'Hampir Habis',
                        'empty' => 'Stok Habis'
                    ]
                ],
            ],
            'search-engine' => [
                'name' => 'search',
                'placeholder' => 'Cari ID Produk Atau Nama Produk'
            ]
        ],
        'columns' => [
            'id' => 'ID Produk',
            'name' => 'Nama Produk',
            'variants' => [
                'variant' => 'Variant Produk',
                'type' => 'Tipe / Size',
                'stock' => 'Stok Produk',
            ],
            'created_at' => 'Dibuat Pada',
        ],
        'total' => $stats['total'],
        'datas' => $products,
        'actions' => [
            'Edit Produk' => [
                'action-name' => 'product',
                'icon-name' => 'product',
                'route-name' => 'admin.detail-product',
            ],
            'Hapus Produk' => [
                'action-name' => 'product',
                'icon-name' => 'trash',
                'route-name' => 'admin.detail-product',
            ]
        ],
        'pagination' => [
            'current' => $currentPage,
            'max' => $maxPage
        ]
    ])
</main>

@php
    logger('as', [$products])
@endphp

<div class="alert-message">
    <div class="card-message">
        <h4>Produk Berrhasil Ditambahkan</h4>
        @include('_components._sprite-icons', ['name' => 'product', 'size' => 50])
        <span>Selamat!, Produk berhasil ditambahkan,<br>Nikmati keuntungannya</span>
        <button class="btn-close-annoucement">Tutup Pemberitahuan</button>
    </div>
</div>

<script defer>
   document.querySelector('.card-message').children[3].addEventListener('click', (e) => e.target.parentElement.parentElement.style.display = "none" );
</script>

