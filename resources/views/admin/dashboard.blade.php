@include('_components._headerAdmin')
@php
    $currentPath = explode('/admin/', url()->current())[1];
@endphp
<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
<main class="wrapper-admin">
    @include('_components._navigation-side')
    <aside class="right">
        @include('_components._bar-top-admin')
        <div style="width:100%; height: 25px;"></div>
        <main class="main-admin">
            <div class="header">
                <h2>Selamat Datang, {{ Auth::user()->getAttributes()['fullname'] }} </h2>
                <p>There is summary data of all things</p>
            </div>
            <div class="wrapper-section-summary-data">
                @include('_components._summary-section', [
                    'title' => 'Transactions',
                    'name' => 'transaction',
                    'summary_data' =>  $transaction,
                    'destination' => route('admin.transactions'),
                ])
                @include('_components._summary-section', [
                    'title' => 'Products',
                    'name' => 'product',
                    'summary_data' =>  $product,
                    'destination' => route('admin.products'),
                ])
                @include('_components._summary-section', [
                    'title' => 'Account & Activity',
                    'name' => 'activity',
                    'summary_data' =>  [
                        'account' => $account,
                        'activity' => $activity,    
                    ],
                    'destination' => route(name: 'admin.accounts'),
                ])
            </div>
            <div style="width:100%; height: 105px;"></div>
            <h2>What We Have? It's
                <br>Statistic About Your Product & Transaction
            </h2>
            <div style="width:100%; height: 35px;"></div>
            <div class="statistic">
                <div class="piechart" id="piechart"></div>
                <div class="barchat" id="barchat"></div>
            </div>

            <section class="management-data" id="management-table">
                <div class="wrapper-title">
                    <div class="title">
                        <h2>{{ count($transaction['ongoing']) }} Transaction On Going</h2>
                        <div class="{{ count($transaction['ongoing']) > 0 ? 'point-active' : 'point-deactive' }}"></div>
                    </div>
                    <!-- <button class="btn btn-submit" type="button">Add Transaction</button> -->
                </div>
                <div class="management-table">
                    <div class="wrapper-filter">
                        <div class="filter">
                            <div class="wrapper-select">
                                <div class="wrapper-icon">
                                    @include('_components._sprite-icons', ['name' => 'drop-down', 'color' => '#273B98', 'size' => 20])
                                </div>
                                <select name="price" id="price">
                                    <option value="">All Price</option>
                                    <option value="lowest">Lowest Price</option>
                                    <option value="lowest">Highest Price</option>
                                </select>
                            </div>
                        </div>
                        <form class="wrapper-search-engine" action="#management-table">
                            @csrf
                            <input type="text" name="search" placeholder="BINA00004" value="{{ old('searc') ?? ''}}"
                                required>
                            <button type="submit">
                                @include('_components._sprite-icons', ['name' => 'search', 'color' => 'white', 'size' => 40])
                            </button>
                        </form>
                    </div>
                    <table>
                        <tr>
                            <th>Transaction ID</th>
                            <th>FullName</th>
                            <th>Total Product</th>
                            <th>Total Price</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                        <!-- data -->
                        @if (count($transaction['ongoing']) > 0)
                            @foreach ($transaction['ongoing'] as $ongoing)
                                <tr>
                                    <td>{{ $ongoing->id }}</td>
                                    <td>{{ $ongoing->user_nis }}</td>
                                    <td>{{ $ongoing->total_product }} Products</td>
                                    <td>IDR {{ $ongoing->total_price }}</td>
                                    <td>{{ $ongoing->created_at }}</td>
                                    <td>On Going
                                        <div class="profile">
                                            @include('_components._sprite-icons', ['name' => 'tree-dots', 'color' => '#273B98', 'size' => '20'])
                                            <ul class="main-menu" style="top:25px">
                                                <li>
                                                    <a href="{{ route("admin.detail-transaction" ,[ 'transaction' => $ongoing->id ]) }}">
                                                        @include('_components._sprite-icons', ['name' => 'eye', 'color' => '#273B98', 'size' => 25])
                                                        View Transaction
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ route("logout") }}">
                                                        @include('_components._sprite-icons', ['name' => 'box-edit', 'color' => '#273B98', 'size' => 25])
                                                        Edit Transaction
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ route("logout") }}">
                                                        @include('_components._sprite-icons', ['name' => 'trash', 'color' => '#273B98', 'size' => 25])
                                                        Delete Transaction
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <th colspan=6 style="height:80px;text-align:center; font-weight:normal;">Take a rest!, There's no transaction here.</td>
                            </tr>
                        @endif
                    </table>
                </div>
            </section>

            <script>
                window.onload = () => {
                    makePieChart("Interested Products Category", [
                        { "label": "Seragam", "y": 65.0, },
                        { "label": "Attribut", "y": 45.0 }
                    ]).render();
                    makeBarChart("Transactions Over 14 Days", [
                        { "label": "8 August", "y": [4, 400000] },
                        { "label": "9 August", "y": [1, 40000] },
                        { "label": "10 August", "y": [1, 40000] },
                        { "label": "11 August", "y": [0, 0] },
                        { "label": "12 August", "y": [3, 140000] },
                        { "label": "13 August", "y": [1, 2140000] },
                        { "label": "11 August", "y": [0, 0] },
                        { "label": "12 August", "y": [3, 140000] },
                        { "label": "13 August", "y": [1, 2140000] },
                        { "label": "11 August", "y": [0, 0] },
                        { "label": "12 August", "y": [3, 140000] },
                        { "label": "13 August", "y": [1, 2140000] },
                        { "label": "11 August", "y": [0, 0] },
                        { "label": "12 August", "y": [3, 140000] },
                    ]).render();
                }
            </script>
        </main>
    </aside>
</main>

@include('_components._footerAdmin')