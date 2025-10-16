@include('_components._headerAdmin', ['title' => 'Portfolio Management'])
@php
    $currentPath = explode('/admin/', url()->current())[1];
    logger('as', [$portfolios])
@endphp
<main class="content">
    @include('_components._summary-section',[
        'title' => 'Portfolios',
        'greeting' => true,
        'data' => $stats
    ])
    <div class="management-table">
        <div class="title">
            <h3 class=''>Show {{ $max }} / {{ $stats['total'] }} Portfolios</h3>
            <a href='{{ route('admin.create-portfolio') }}' class="btn" id="btn-add-management">
                <span class=""> Tambahkan Portfolio </span>
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
                        <option value="XI" @selected(app('request')->get('search_class') == 'XI')>Kelas 12</option>
                        <option value="XII" @selected(app('request')->get('search_class') == 'XII')>Kelas 12</option>
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
            @foreach ($portfolios as $key=>$portfolio)
               <div class="wrapper-card-media"
                href="{{ route('admin.detail-portfolio', ['portfolio' => $portfolio->id]) }}"
            >
                <a class="card-media">
                    <div class="wrapper-image">
                        <img src="{{  $portfolio->portfolioImages[0]['url'] ?? asset('images/default.png') }}" alt="wrapper-iamge">
                    </div>
                    <div class="detail-media">
                        <h3 class="title">{{ $portfolio->title }}</h3>
                        <p class="description">{{ $portfolio->description }}</p>
                        <div class="profile">
                            <div class="tag-name">
                                <h5>{{ $portfolio->student_name }}</h5>
                            </div>

                        </div>
                        <div class="profile">
                            <div class="tag-name">
                                <h5>{{ $portfolio->student_class }}</h5>
                                <h5>{{ $portfolio->student_major_name }}</h5>
                            </div>
                        </div>
                    </div>
                </a>
                <form class="floating-action"
                    action="{{ route('admin.delete-portfolio', ['portfolio' => $portfolio->id]) }}"
                    method="POST"
                    id="media-floating-icon"
                >
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="action">
                        @include('_components._sprite-icons', [
                            'name' => 'trash',
                            'size' => 20,
                        ])
                        <span>Delete Portfolio</span>
                    </button>
                </form>
            </div>
            @endforeach
        </div>
        @include('_components._pagination-media', [
            'max' => $max,
            'page' => $page,
            'totalPage' => $total
        ])
    </div>
</main>

@vite('resources/js/handle/delete-media.js');

@include('_components._footerAdmin')
