@php
    $placeholder = "";
@endphp

@include("_components._header")
 <div class="news">
        <h2>BI NEWS</h2>

        <div class="searchbar">
            <input type="text" id="input-search" placeholder="Cari Berita..." value="{{ request('search', '') }}">
            <div class="search-icon">
                <a href="{{ route('user.news', ['search' => request('search', '')]) }}" id="button-search">
                    <img src="{{ asset("icons/search-icon.svg") }}" alt="">
                </a>
            </div>
        </div>
        <div class="news-group">
            @foreach ($articles as $article)
            <a href="">
                <img src="{{ $article->thumbnail_url }}" alt="article-thumbnail-{{ $article->id }}" loading="lazy">
                <div class="news-infodetail">
                    <div class="news-info">
                        <div class="tags">
                            <div class="tags-slider">
                                @foreach ($article->keywords as $i => $keyword)
                                    <p class="tag{{ $i % 3 + 1 }}">{{ $keyword->name }}</p>
                                @endforeach
                            </div>
                        </div>
                        <div class="date">
                            <p>{{ date_format($article->updated_at, "d/m/Y") }}</p>
                        </div>
                    </div>

                    <div class="text">
                        <h3>{{ $article->title }}</h3>
                        <h4>{{ $article->description }}</h4>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
@include("_components._footer")

<script defer>
    const url = new URL(location.href);
    const inputSearch = document.getElementById('input-search');
    const buttonSearch = document.getElementById('button-search');

    inputSearch.addEventListener('input', (e) => {
        url.searchParams.set('search', inputSearch.value);
        buttonSearch.href = url.href;
    });
    inputSearch.addEventListener('keydown', (e) => {
        if (e.key == 'Enter') {
            location.href = url.href;
        }
    })
</script>
