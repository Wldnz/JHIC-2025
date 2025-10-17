@include('_components._headerAdmin', ['title' => "Articles/Blogs/News ($article->visited_times Pengunjung)"])
@php
    $currentPath = explode('/admin/', url()->current())[1];
    logger('as', [$article])
@endphp
<form class="content flex-row justify-between pad-0" id="management-form-news"
    method="POST"
    enctype="multipart/form-data"
>
    @method('PUT')
    @csrf
    <div class="wrapper-content-media-management">
        <div class="wrapper-container-media form-news">
            <div class="wrapper-title">
                <input type="text" name="title" id="title" placeholder="Pengenalan Apa Itu Shooting Video"
                    minlength="10" maxlength="180" value="{{ old('title', $article->title) }}"
                    required>
            </div>


            <div class="wrapper-thumbnail">
                <img class="thumbnail" id="thumbnail" src="{{ $article->thumbnail_url }}" alt="thumbnail-image">
                <input type="file" accept="image/jpeg, image/png" id="thumbnail_image" name="thumbnail">
                <input type="hidden" name="isUpdated" id="isUpdated" value="0" >
            </div>

            <div class="wrapper-content wrapper-content-action">
                <div id="editor"></div>
            </div>
        </div>
    </div>
    <div class="wrapper-save-media" id="wrapper-save-media">
        <div class="card-save-media" id="card-save-media">
            <div class="wrapper-action">
                <button class="btn-svg" id="btn-open-media" type="button">
                    @include('_components._sprite-icons', ['name' => 'hamburger-menu', 'size' => 20])
                </button>
                <button class="btn-svg" id="btn-close-media" type="button">
                    @include('_components._sprite-icons', ['name' => 'exception', 'size' => 20])
                </button>
            </div>
            <div class="wrapper-content">
                <div class="card-content">
                    <div class="wrapper-tags">
                        <label for="keyword">Kata Kunci <span>*</span></label>
                        <div class="tags" id="tags-tag"></div>
                    </div>
                    <div class="wrapper-input">
                        <label for="date">Dibuat Pada</label>
                        <input type="date" name="numeric" id="date"
                            aria-describedby="dibuat-pada"
                            value="{{ substr($article->created_at, 0,10) }}"
                            disabled
                        >
                    </div>
                     <div class="wrapper-input">
                        <label for="date">Terakhir Diubah Pada</label>
                        <input type="date" name="numeric" id="date"
                            aria-describedby="dibuat-pada"
                            value="{{ substr($article->updated_at, 0,10) }}"
                            disabled
                        >
                    </div>
                    <div class="wrapper-input">
                        <label for="visible">Visible<span>*</span></label>
                        <select name="visible" id="visible" required>
                            @foreach ($availableStatus as $statusName => $status)
                                <option value="{{ $status }}" @selected(old('visible', $article->status) == $status)>{{ $statusName }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="wrapper-hidden" id="tags_sender"></div>
                </div>
                <button type="button" class="btn btn-media" id="btn-submit-news">
                    Tambahkan Artikel
                </button>
            </div>
        </div>
    </div>
</form>


<script defer>
    const thumbnail = document.getElementById('thumbnail_image');
    const image = document.getElementById('thumbnail');
    let prev_filelist = null;
    
    let defaultContent = @js(old('content', ''));
    let keywords = @json(old('tags', $article->keywords ?? []));
    const defaultImage = @js($article->thumbnail_url ?? asset('images/default.png'));
    
    if (!defaultContent) {
        const xhr = new XMLHttpRequest();
        xhr.open('GET', @js(route('user.news-content', ['article' => $article])), true);
        xhr.onload = function () {
            if (xhr.status === 200) {
                defaultContent = xhr.responseText;
            }
        };
        xhr.send();
    }
</script>

@include('_components._footerAdmin')

@vite(['resources/js/handle/create-news.js'])
@vite(['resources/js/handle/save-media.js', 'resources/js/handle/article.js'])