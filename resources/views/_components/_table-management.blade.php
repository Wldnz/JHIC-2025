<section class="management-data" id="management-table">
    <div class="wrapper-title">
        <div class="title">
            <h2>{{ $ }}</h2>
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
                <input type="text" name="search" placeholder="BINA00004" value="{{ old('searc') ?? ''}}" required>
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
                                        <a href="{{ route("admin.detail-transaction", ['transaction' => $ongoing->id]) }}">
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
                    <th colspan=6 style="height:80px;text-align:center; font-weight:normal;">Take a rest!, There's no
                        transaction here.</td>
                </tr>
            @endif
        </table>
    </div>
</section>