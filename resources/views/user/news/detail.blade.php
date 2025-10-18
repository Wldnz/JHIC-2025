@php
    $placeholder = '';
@endphp

@include('_components._header', 
[
    'title' => $article->title . ' | SMK Bina Informatika',
    'description' => 'SMK Bina Informatika | ' . $article->description,
    'keywords' => 'smk, SMK Bina Informatika, teknologi, informatika, sekolah, berita, news, article, important, school',
    ])

<div class="detail-news">
    <h2>BI NEWS</h2>

    <form class="searchbar">
        <input type="text" id="input-search" name="search" placeholder="Cari Berita..." value="{{ request('search') }}">
        <div class="search-icon">
            <button
                type="submit" 
                class="button-search"
            >
                <img src="{{ asset('icons/search-icon.svg') }}" alt="Search">
            </button>
        </div>
    </form>

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
</script>

@vite(['resources/js/handle/detail-news.js'])
