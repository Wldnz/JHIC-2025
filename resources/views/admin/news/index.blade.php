@include('_components._headerAdmin', ['title' => 'Portfolio Management'])
@php
    $currentPath = explode('/admin/', url()->current())[1];
@endphp
<main class="content">
    <div class="management-table">
        <div class="title">
            <h3 class=''>Ada 10 Artikel</h3>
            <a href='{{ route('admin.create-news') }}' class="btn" id="btn-add-management">
                <span class=""> Tambahkan Artikel </span>
                @include('_components._sprite-icons', ['name' => 'add', 'size' => 15])
            </a>
        </div>
        <div class="find-something">
            <form class="wrapper-filter">
                <div class="wrapper-select">
                    <select name="search_status" required>
                        <option value="">Status: Semuanya</option>
                        <option value="public">Status: Public</option>
                        <option value="private">Status: Private</option>
                    </select>
                    <div class="wrapper-icon">
                        @include("_components._sprite-icons", ["name" => "drop-down", "size" => 20])
                    </div>
                </div>
            </form>
            <form class="wrapper-search">
                <input type="text" name="search" placeholder="Cari Artikel Disini..">
                <button type="submit" class="search-engine">
                    @include("_components._sprite-icons", ["name" => "search", "color" => "white", "size" => 20])
                </button>
            </form>
        </div>
        <div class="wrapper-content-media items-start">
            <a class="wrapper-card-news"
                href="{{ route('admin.detail-news', ['news' => 1]) }}"
            >
                <div class="card-media">
                    <div class="wrapper-image">
                        <img src="https://static01.nyt.com/images/2024/12/26/multimedia/23Labov-ltbc-print1/23Labov-ltbc-videoSixteenByNine3000.jpg" alt="wrapper-iamge">
                    </div>
                    <div class="detail-media">
                        <div class="information">
                            <h3 class="title">Aplikasi Pemesanan Website</h3>
                            <p class="description">Aplikasi pemesanan hotel adalah sebuah aplikasi yang dibuat dan khussukan untuk penggun yang
                                ingin memesan hotel secara online</p>
                            <i>Wildan Izhar A.</i>
                        </div>
                        <div class="bottom">
                            <div class="tags">
                                <div class="tag"><p>Informasi Sekolah</p></div>
                            </div>
                            <div class="identifier">
                                <p>2025-10-07</p>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
</main>

@include('_components._footerAdmin')