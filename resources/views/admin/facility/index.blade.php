@include('_components._headerAdmin', ['title' => 'Facilitities Management'])
<main class="content">
    @include('_components._summary-section', [
        'title' => 'Facilities',
        'greeting' => true,
        'data' => $stats,
        'icon' => [
            'name' => 'facility',
            ]
    ])
    <div class="management-table">
        <div class="title">
            <h3 class=''>Show {{ count($facilities) }} / {{ $stats['total'] }} Facilities</h3>
            <a href='{{ route('admin.create-facility') }}' class="btn" id="btn-add-management">
                <span class=""> Tambahkan Fasilitas</span>
                @include('_components._sprite-icons', ['name' => 'add', 'size' => 15])
            </a>
        </div>
        <div class="find-something">
            <form class="wrapper-filter" id="wrapper-filter">
                <div class="wrapper-select">
                    <select name="search_type" required>
                        <option value="">Status: Semuanya</option>
                        <option value="laboratorium" @selected(app('request')->get('search_type') == 'laboratorium')>Status: Laboratorium</option>
                        <option value="classroom" @selected(app('request')->get('search_type') == 'classroom')>Status: Ruangan</option>
                        <option value="public facility" @selected(app('request')->get('search_type') == 'public facility')>Status: Publik Fasilitas</option>
                    </select>
                    <div class="wrapper-icon">
                        @include("_components._sprite-icons", ["name" => "drop-down", "size" => 20])
                    </div>
                </div>
            </form>
            <form class="wrapper-search">
                <input type="text" name="search" placeholder="Cari Fasilitas Disini.."
                    value="{{ app('request')->get('search','') }}"
                    aria-describedby="search"
                >
                <button type="submit" class="search-engine">
                    @include("_components._sprite-icons", ["name" => "search", "color" => "white", "size" => 20])
                </button>
            </form>
        </div>
        <div class="wrapper-content-media items-start">
            @foreach ($facilities as $facility)
                <div class="wrapper-card-media"
                >
                <a class="card-media"
                    href="{{ route('admin.detail-facility', ['facility' => $facility->id]) }}"
                >
                    <div class="wrapper-image">
                        <img src="{{ $facility->url }}" alt="{{ $facility->name . $facility->gallery_type_name }}">
                    </div>
                    <div class="detail-media">
                        <h3 class="title">{{ substr($facility->name, 0, 20) }}...</h3>
                        <p class="description">{{ substr($facility->description, 0, 115) }}...</p>
                        <div class="profile">
                            <div class="tag-name">
                                <h5>{{ strtoupper($facility->gallery_type_name[0]) . substr($facility->gallery_type_name, 1) }}</h5>
                            </div>
                        </div>
                    </div>
                </a>
                <div class="floating-action">
                    <a class="action action-detail btn-action"
                        href="{{ route('admin.detail-facility', ['facility' => $facility->id]) }}"
                    >
                       <button class="btn-action" type="button">
                            @include('_components._sprite-icons', [
                                'name' => 'eye',
                                'color' => 'white',
                                'size' => 20,
                            ])
                            <span>Detail Facility</span>
                       </button>
                    </a>
                    <form class="action"
                        action="{{ route('admin.delete-facility', ['facility' => $facility->id]) }}"
                        method="POST"
                        id="action-delete"
                    >
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-action">
                            @include('_components._sprite-icons', [
                                'name' => 'trash',
                                'color' => 'white',
                                'size' => 20,
                            ])
                            <span>Delete Facility</span>
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
          @include('_components._pagination-media', [
            'max' => $max,
            'totalPage' => $total,
            'page' => $page
        ])
    </div>
</main>

@vite('resources/js/handle/delete-media.js');

@include('_components._footerAdmin')
