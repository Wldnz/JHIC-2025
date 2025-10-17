@php
    $placeholder = '';
@endphp

@include('_components._header')

<div class="detail-news">
    <h2>BI NEWS</h2>

    <div class="searchbar">
        <input type="text" id="input-search" placeholder="Cari Berita..." value="{{ request('search') }}">
        <div class="search-icon">
            <a class="button-search">
                <img src="{{ asset('icons/search-icon.svg') }}" alt="Search">
            </a>
        </div>
    </div>

    <div class="detail-content">
        <h3>{{ $article->title }}</h3>

        <div class="writeby-content">
            <div class="wrapper-writter">
                <div class="writeby">
                    <img src="{{ asset('icons/user.svg') }}">
                </div>
                <div class="user-upload">
                    <p>Written by <b> {{ $article->written_by }} </b></p>
                </div>
            </div>
            <div class="date">
                <p>{{ date_format($article->updated_at, "l, d F Y H:i") }}</p>
            </div>
        </div>

        <img src="{{ $article->thumbnail_url }}" alt="thumbnail-image">
    </div>

    <div class="news-content" id="loading-viewer">
        <span>Sedang Menarik Data...</span>
    </div>
    <div class="news-content" id="viewer">
    </div>
</div>

@include('_components._footer')

<script defer>
    const articleContentUrl = @js(route('user.news-content', ['article' => $article]))

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
    });
</script>

@vite(['resources/js/handle/detail-news.js'])
