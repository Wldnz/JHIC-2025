@include('_components._headerAdmin', ["title" => "Dashboard | Bina Tata Usaha"])
<main class="content">
    <div class="greeting">
        <h3>Selamat Datang, {{ Auth::user()->fullname }}</h3>
        <span>Kami sudah memberikan ringkasan data terbaru!</span>
    </div>
    @includeWhen(isset($transaction), "_components._summary-section", [
        "name" => "Transaction",
        "destination" => route("admin.transactions"),
        "data" => $transaction
    ])
    @includeWhen(isset($product), "_components._summary-section", [
        "name" => "Product",
        "destination" => route("admin.products"),
        "data" => $product
    ])
    @includeWhen(isset($activity), "_components._summary-section", [
        "name" => "Accounts & Activities",
        "data" => [
            "Account" => $account,
            "Activity" => $activity
        ]
    ])
    @include('_components._management-table', [
        'title' => 'Total Transaksi Sedang Berlangsung',
        'total' => $transaction['ongoing'],
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
        ],
        'pagination' => [
            'current' => $currentPage,
            'max' => $maxPage
        ],
    ])
</main>

@include('_components._footerAdmin')