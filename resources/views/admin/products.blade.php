@include('_components._headerAdmin', ['title' => 'Management Products'])
<main class="content">
    @includeWhen(isset($stats), "_components._summary-section", [
    "name" => "Product",
    "data" => $stats
    ])
    <div class="management-table">
        <div class="title">
            <h3 class='point-active'>{{ $stats['total'] }} Total Products</h3>
            <a href="{{ route('admin.store-product') }}" class="btn">
                <span class="">Tambah Produk</span>
                @include('_components._sprite-icons', ['name' => 'add', 'size' => 15])
            </a>
        </div>
        <div class="find-something">
            <div class="wrapper-filter">
                <div class="wrapper-select">
                    <select name="stock" id="select-stock">
                        <option value="all">Semuanya</option>
                        <option value="low">Stok Sedikit</option>
                        <option value="available">Stok Tersedia</option>
                        <option value="empty">Stok Habis</option>
                    </select>
                    <div class="wrapper-icon">
                        @include("_components._sprite-icons", [ "name" => "drop-down", "size" => 20 ])
                    </div>
                </div>
            </div>
            <form class="wrapper-search">
                <input type="text" name="search" placeholder="Cari Nama Produk" required>
                <button type="submit" class="search-engine">
                    @include("_components._sprite-icons", [ "name" => "search", "color" => "white", "size" => 20 ])
                </button>
            </form>
        </div>
        <table>
            <tr>
                <th>ID Product</th>
                <th>Name</th>
                <th>Variant</th>
                <th>Type/Size</th>
                <th>Stock</th>
                <th>Category</th>
            </tr>
            @php
                $count_product=0;
            @endphp
            @foreach ($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->name }}</td>
                    @if (count($product->variants) > 0)
                        <td>{{ $product->variants[0]->stock }}</td>
                        <td>{{ $product->variants[0]->type }}</td>
                        <td>{{ $product->variants[0]->stock }}</td>
                    @else
                        <td>Belum ada stock</td>
                        <td>Belum ada stock</td>
                        <td>Belum ada stock</td>
                    @endif
                    <td>
                        {{ $product->category }}
                        
                    </td>
                </tr>
            @endforeach
        </table>
        <form class="wrapper-pagination">
            <button type="{{ $currentPage - 1 <= 0 ? 'button' : 'submit' }}" class="btn-page btn-page-action {{ $currentPage - 1 <= 0? 'btn-not-allowed' : '' }}" name="page" value="{{ $currentPage - 1 }}"><</button>
            <div class="page">
                <button type="submit" class="btn-page {{ $currentPage == 1? 'btn-active' : '' }}" name="page" value="1">1</button>
                @php $countButtonPage=0; @endphp
                @for($i =$currentPage; $i <= $currentPage + 2; $i++)
                    @if ($i> 1 && $i < $maxPage)
                        <button type="submit" class="btn-page {{ $currentPage == $i? 'btn-active' : '' }}" name="page" value="{{ $i }}">{{ $i }}</button>
                    @endif
                    @if($count_product == 2) @break @endif
                @endfor
                <button type="submit" class="btn-page {{ $currentPage == $maxPage? 'btn-active' : '' }}" name="page" value="{{ $maxPage }}">{{ $maxPage }}</button>
            </div>
            <button type="{{ $currentPage + 1 > $maxPage ? 'button' : 'submit' }}" class="btn-page btn-page-action {{ $currentPage + 1 > $maxPage? 'btn-not-allowed' : '' }}" name="page" value="{{ $currentPage + 1 }}">></button>
        </form>
    </div>
</main>

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

