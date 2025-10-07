@include('_components._headerAdmin', ["title" => "Dashboard | Bina Tata Usaha"])
@php
    logger('product', [$statictis['uniform']])
@endphp
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
                    
    <h2>Statistika Penjualan Seragam</h2>
    <div class="wrapper-charts">
        <div class="wrapper-chart">
            <div class="piechart">
                <canvas id="piechart"></canvas>
            </div>
        </div>
        <div class="wrapper-chart">
            <div class="linechart">
                <canvas id="linechart"></canvas>
            </div>
            <form class="chart-action">
                @for ($index_y = 0; $index_y < 3; $index_y++)
                    <button
                        class="btn {{ request()->get('year', date('Y')) == date('Y') - $index_y ? 'btn-submit' : '' }}"
                        name="year" value="{{ date('Y') - $index_y }}"
                    >
                        {{ date('Y') - $index_y }}
                    </button>
                @endfor
            </form>
        </div>

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
<script defer>
    const dataset_transactions = @json($statictis);
</script>

@vite(['resources/js/chart.js'])

@include('_components._footerAdmin')