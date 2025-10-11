@include('_components._headerAdmin', ['title' => 'Achievement Management'])
@php
    $currentPath = explode('/admin/', url()->current())[1];
    logger('achievements', [$achievements]);
@endphp
<main class="content">
    <div class="management-table">
        <div class="title">
            <h3 class=''>Ada 10 Achievement</h3>
            <a href='{{ route('admin.create-achievement') }}' class="btn" id="btn-add-management">
                <span class=""> Tambahkan Achievement </span>
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
        <div class="wrapper-content-media flex-row items-start">
            @foreach ($achievements as $achievement)
                <a class="wrapper-card-media-achievement"
                href="{{ route('admin.detail-achievement', ['achievement' => $achievement->id]) }}"
            >
                <div class="card-media">
                    <div class="wrapper-image">
                        <img src="{{ $achievement->thumbnail_url }}" alt="{{ $achievement->student_name }}">
                    </div>
                    <div class="detail-media">
                        <div class="ranking">
                            @include('_components._sprite-icons', ['name' => 'rank-'. explode('_', $achievement->competition_position)[1] , 'size' => 25])
                        </div>
                        <div class="profile">
                            <div class="horizontal">
                                <h5>{{ $achievement->student_name }}</h5>
                            </div>
                            <div class="horizontal">
                                <h6>{{ $achievement->competition_name}}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</main>

@include('_components._footerAdmin')