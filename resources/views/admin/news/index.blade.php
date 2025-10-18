@include('_components._headerAdmin', ['title' => 'Articles/Blogs/News Management'])
<main class="content">
    @include('_components._summary-section',[
        'title' => 'Articles',
        'greeting' => true,
        'data' => $stats
    ])
    <div class="management-table">
        <div class="title">
            <h3 class=''>Show {{ $articles->count() }} / {{ $total }} Articles</h3>
            <a href='{{ route('admin.create-news') }}' class="btn" id="btn-add-management">
                <span class=""> Tambahkan Artikel </span>
                @include('_components._sprite-icons', ['name' => 'add', 'size' => 15])
            </a>
        </div>
        <div class="find-something">
            <form class="wrapper-filter" id="wrapper-filter">
                <div class="wrapper-select">
                    <select name="search_status" required>
                        <option value="">Status: Semuanya</option>
                        <option value="published" @selected(app('request')->get('search_status') == 'published')>Status: Publish</option>
                        <option value="archived" @selected(app('request')->get('search_status') == 'archived')>Status: Archive</option>
                        <option value="draft" @selected(app('request')->get('search_status') == 'draft')>Status: Draft</option>
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
            @foreach ($articles as $article)
                <a class="wrapper-card-news" href="{{ route('admin.detail-news', ['news' => $article->id]) }}">
                    <div class="card-media">
                        <div class="wrapper-image">
                            <img src="{{ $article->thumbnail_url }}" alt="thumbnail-image-article" loading="lazy">
                        </div>
                        <div class="detail-media">
                            <div class="information">
                                <h3 class="title">{{ $article->title }}</h3>
                                <p class="description">{{ $article->description }}</i>
                                <p class="title">Author: {{ $article->written_by }}</p>
                            </div>
                            <div class="bottom">
                                <div class="tags">
                                    @if (count($article->keywords) == 0)
                                        <div class="tag">
                                            <p>Belum ada tag</p>
                                        </div>
                                    @else
                                        @foreach ($article->keywords as $keyword)
                                            @if ($loop->index + 1 < 2)
                                                <div class="tag">
                                                    <p>{{ $keyword->name }}</p>
                                                </div>
                                            @endif
                                        @endforeach
                                        @if (count($article->keywords) > 2)
                                            <p>{{ count($article->keywords) - 2 }}+ more</p>
                                        @endif
                                    @endif
                                </div>
                                <div class="identifier">
                                    <p>{{ substr($article->created_at, 0, 10) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
                <form class="floating-action"
                    action="{{ route('admin.delete-news', ['news' => $article->id]) }}"
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
                        <span>Delete Article</span>
                    </button>
                </form>
            @endforeach
        </div>
         @include('_components._pagination-media', [
            'max' => $max,
            'page' => $page,
            'totalPage' => $total
        ])
    </div>
</main>
@include('_components._footerAdmin')
