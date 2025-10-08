@include('_components._headerAdmin', ['title' => 'Achievement Management'])
@php
    $currentPath = explode('/admin/', url()->current())[1];
@endphp
<main class="content">
    <div class="management-table">
        <div class="title">
            <h3 class=''>Ada 10 Media(Foto & Video)</h3>
            <a href='{{ route('admin.create-media') }}' class="btn" id="btn-add-management">
                <span class=""> Tambahkan Media </span>
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
                <input type="text" name="search" placeholder="Cari Portfolio Disini..">
                <button type="submit" class="search-engine">
                    @include("_components._sprite-icons", ["name" => "search", "color" => "white", "size" => 20])
                </button>
            </form>
        </div>
        <div class="wrapper-content-media items-start">
            <a class="wrapper-card-media"
                href="{{ route('admin.detail-portfolio', ['portfolio' => 1]) }}"
            >
                <div class="card-media">
                    <div class="wrapper-image">
                        <img src="https://tse1.mm.bing.net/th/id/OIP.W81pUm4Cky36gAu4f7poQgHaFj?rs=1&pid=ImgDetMain&o=7&rm=3" alt="wrapper-iamge">
                    </div>
                </div>
            </a>
        </div>
    </div>
</main>

@include('_components._footerAdmin')