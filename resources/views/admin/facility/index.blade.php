@include('_components._headerAdmin', ['title' => 'Facilitities Management'])
@php
    $currentPath = explode('/admin/', url()->current())[1];
    logger('as', [$facilities])
@endphp
<main class="content">
    @include('_components._summary-section', [
        'title' => 'Facilities',
        'data' => $stats,
        'icon' => [ 
            'name' => 'facility',
        ]
    ])
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
                <a class="wrapper-card-media"
                href="{{ route('admin.detail-facility', ['facility' => $facility->id]) }}"
            >
                <div class="card-media">
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
                            {{-- <div class="action">
                                <form id="action">
                                    <button type="button" name="visible" id="button-visible" value="public">
                                        @include('_components._sprite-icons', ['name' => 'eye', 'size' => 20])
                                    </button>
                                </form>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</main>

@include('_components._footerAdmin')