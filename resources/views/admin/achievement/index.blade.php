@include('_components._headerAdmin', ['title' => 'Achievements Management'])
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
                <div class="wrapper-card-media-achievement"
            >
                <a class="card-media" href="{{ route('admin.detail-achievement', ['achievement' => $achievement->id]) }}">
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
                </a>
                <div class="floating-action">
                    <a class="action action-detail btn-action"
                        href="{{ route('admin.detail-achievement', ['achievement' => $achievement->id]) }}"
                    >
                       <button class="btn-action" type="button">
                            @include('_components._sprite-icons', [
                                'name' => 'eye',
                                'color' => 'white',
                                'size' => 20,
                            ])
                            <span>Detail Achievement</span>
                       </button>
                    </a>
                    <form class="action"
                        action="{{ route('admin.delete-achievement', ['achievement' => $achievement->id]) }}"
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
                            <span>Delete Achievement</span>
                        </button>
                    </form>
                </div>
            </div>
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
@vite('resources/js/handle/delete-media.js');