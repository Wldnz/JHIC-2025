@include('_components._headerAdmin', ["title" => "Dashboard"])
@php
    logger('product', [$stats, $summary])
@endphp
<main class="content">
    <div class="greeting">
        <h3>Selamat Datang, {{ Auth::user()->fullname }}</h3>
        <span>Kami sudah memberikan ringkasan data terbaru!</span>
    </div>
    @if (Auth::user()->role == 'admin' || Auth::user()->role == 'super_admin')
        @include('_components._summary-section', [
            'title' => 'Transactions',
            'greeting' => true,
            'data' => $stats['transaction'],
            'destination' => route('admin.transactions'),
            'icon' => [
                'name' => 'transaction'
            ]
        ])


                     @include('_components._summary-section', [
                        'title' => 'Account',
                        'greeting' => true,
                        'data' => $stats['account'],
                        'destination' => route('admin.accounts'),
                        'icon' => [
                            'name' => 'account'
                        ]
                    ])
        @include('_components._summary-section', [
            'title' => 'Students',
            'greeting' => true,
            'data' => $stats['student'],
            'icon' => [
                'name' => 'candidate'
            ]
        ])
    @endif
    @include('_components._summary-section', [
        'title' => 'Media',
        'greeting' => true,
        'data' => $stats['media'],
        'icon' => [
            'name' => 'account'
        ]
    ])
    @if (Auth::user()->role == 'admin' || Auth::user()->role == 'super_admin')
        <section class="section-chart">
            <div class="wrapper-chart">
                <h2>Ringkasan Calon Peserta Didik (Dari Tahun Ajaran {{ intval(date('m')) >= $registrationMonth ? intval(date('Y')) + 1 . ' - ' . intval(date('Y')) + 2 : intval(date('Y')) - 1 . ' - ' . intval(date('Y'))  }})</h2>
                <canvas class="chart chart-barchart" id="barchart"></canvas>
        </section>
    @endif
</main>
    @if (Auth::user()->role == 'admin' || Auth::user()->role == 'super_admin')
        <script defer>
            const barChartOptions = [
                {
                    idElement : 'barchart',
                    data : @json($summary['candidates'])
                }
            ];
        </script>
        @vite(['resources/js/chart.js'])
    @endif
@include('_components._footerAdmin')