<div class="management-table">
    <div class="title">
        <h3 class=''>{{ $articles->count() }} Total Article Been Created</h3>
    </div>
    <div class="wrapper-content-media items-start">
        @foreach ($articles as $article)
            <a class="wrapper-card-news" href="{{ route('admin.detail-news', ['news' => $article->id]) }}">
                <div class="card-media">
                    <div class="wrapper-image">
                        <img src="{{ $article->thumbnail_url }}" alt="thumbnail-image-article">
                    </div>
                    <div class="detail-media">
                        <div class="information">
                            <h3 class="title">{{ $article->title }}</h3>
                            <!-- <p class="description"></i> -->
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
        @endforeach
    </div>
</div>