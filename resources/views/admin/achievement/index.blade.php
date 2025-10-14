@include('_components._headerAdmin', ['title' => 'Achievements Management'])
@php
    $currentPath = explode('/admin/', url()->current())[1];
    logger('achievements', [$achievements]);
@endphp
<main class="content">
    @include('_components._summary-section', [
        'title' => 'Achievement',
        'greeting' => true,
        'data' => $stats,
    ])
    <div class="management-table">
        <div class="title">
            <h3 class=''>Show {{ count($achievements) }}/{{ $stats['total'] }} Achievements</h3>
            <a href='{{ route('admin.create-achievement') }}' class="btn" id="btn-add-management">
                <span class=""> Tambahkan Achievement </span>
                @include('_components._sprite-icons', ['name' => 'add', 'size' => 15])
            </a>
        </div>
        <div class="find-something">
            <form class="wrapper-filter">
                <div class="wrapper-select">
                    <select name="search_major" required>
                        <option value="">Semuanya</option>
                        @foreach ($majors as $major)
                            <option value="{{ $major->long_name }}" @selected(app('request')->get('search_major') == $major->long_name)>{{ $major->long_name }}</option>
                        @endforeach
                    </select>
                    <div class="wrapper-icon">
                        @include("_components._sprite-icons", ["name" => "drop-down", "size" => 20])
                    </div>
                </div>
                <div class="wrapper-select">
                    <select name="search_class" required>
                        <option value="">Semuanya</option>
                        <option value="X" @selected(app('request')->get('search_class') == 'X')>Kelas 10</option>
                        <option value="XI" @selected(app('request')->get('search_class') == 'XI')>Kelas 11</option>
                        <option value="XII" @selected(app('request')->get('search_class') == 'XII')>Kelas 12</option>
                    </select>
                    <div class="wrapper-icon">
                        @include("_components._sprite-icons", ["name" => "drop-down", "size" => 20])
                    </div>
                </div>
            </form>
            <form class="wrapper-search">
                <input type="text" name="search" placeholder="Cari Achievement Disini..">
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
        @include('_components._pagination-media', [
                'max' => $max,
                'totalPage' => $totalPage,
                'page' => $page
        ])
    </div>
</main>

@include('_components._footerAdmin')