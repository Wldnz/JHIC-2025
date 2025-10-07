@include('_components._headerAdmin', ['title' => 'Facilitities Management'])
@php
    $currentPath = explode('/admin/', url()->current())[1];
@endphp
<main class="content">
    <div class="management-table">
        <div class="title">
            <h3 class=''>Ada 10 Fasilitas</h3>
            <a href='{{ route('admin.create-facility') }}' class="btn" id="btn-add-management">
                <span class=""> Tambahkan Fasilitas</span>
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
                        <img src="https://eljayakonstruksi.com/wp-content/uploads/2020/11/2.jpg" alt="wrapper-iamge">
                    </div>
                    <div class="detail-media">
                        <h3 class="title">Ruangan 10</h3>
                        <p class="description">Ruangan 10 dirancang, untuk para siswa mempelajari hal - hal akademik</p>
                        <div class="profile">
                            <div class="tag-name">
                                <h5>Ruangan</h5>
                            </div>
                            <div class="action">
                                <form id="action">
                                    <button type="button" name="visible" id="button-visible" value="public">
                                        @include('_components._sprite-icons', ['name' => 'eye', 'size' => 20])
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
</main>

@include('_components._footerAdmin')