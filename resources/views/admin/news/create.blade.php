@include('_components._headerAdmin', ['title' => 'Tambahkan Artikel/Blog'])
@php
    $currentPath = explode('/admin/', url()->current())[1];
@endphp
<form class="content flex-row justify-between pad-0" id="management-form-news" method="POST"
    enctype="multipart/form-data">
    @csrf
    <div class="wrapper-content-media-management">
        <div class="wrapper-container-media form-news">
            <div class="wrapper-title">
                <input type="text" name="title" id="title" placeholder="Pengenalan Apa Itu Shooting Video"
                    minlength="10" maxlength="180" {{ old('title') != null ? 'value="' . old('title') . '"' : ''  }}
                    required>
            </div>

            <div class="wrapper-thumbnail">
                <img class="thumbnail" id="thumbnail" src="" alt="thumbnail-image">
                <input type="file" accept="image/jpeg, image/png" id="thumbnail_image" name="thumbnail_image" required>
                <input type="hidden" id="isUpdated" name="isUpdated" value="0" required>
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
                        <div class="tags" id="tags-tag">

                        </div>
                    </div>
                    <div class="wrapper-input">
                        <label for="visible">Visible<span>*</span></label>
                        <select name="visible" id="visible" required>
                            <option value="public" @selected(old('type', '') == 'public')>Public</option>
                            <option value="arhcive" @selected(old('type', '') == 'archive')>Archive</option>
                        </select>
                    </div>

                    <div class="wrapper-hidden" id="tags_sender">

                    </div>
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

    const defaultContent = "{{ old('content', '') }}";
    let keywords = @json(old('tags', []));
    const defaultImage = "{{ asset('images/default.png') }}";
</script>

@vite(['resources/js/handle/create-news.js', 'resources/js/handle/save-media.js', 'resources/js/handle/article.js'])
@include('_components._footerAdmin')