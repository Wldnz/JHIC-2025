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
                <input type="file" accept="image/jpeg, image/png" id="thumbnail_image" name="thumbnail" required>
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

@vite(['resources/js/handle/save-media.js'])

<script defer>
    const thumbnail = document.getElementById('thumbnail_image');
    const image = document.getElementById('thumbnail');
    let prev_filelist = null;

    const defaultContent = "{{ old('content', '') }}";
    let keywords = @json(old('tags', [
        [
            "id" => 1,
            "keyword" => "informasi sekolah"
        ]
    ]));

    function initProject() {
        image.src = "{{ asset('images/default.png') }}";
        loadKeywords();
    }

    function loadKeywords() {
        let keywordsHTML = '';
        keywords.forEach(key => {
            keywordsHTML += createKeyword(key);
        });
        if (keywords.length < 10) keywordsHTML += createKeyword({});
        document.getElementById('tags-tag').innerHTML = keywordsHTML;
        handleFunctionKeywords();
        createTagsSender();
    }

    function createKeyword({ keyword = null, id = null }) {
        return `<div class="wrapper-tag">
                <div class="tag" id="${id ?? 'default'}" contenteditable="true">${keyword ?? "Tambahkan Keyword"}</div>
                <button class="btn-tag" type="button">X</button>
            </div>`;
    }

    function createTagsSender() {
        let keywordsHTML = '';
        keywords.forEach((key, index) => {
            keywordsHTML += `<input type="hidden" name="tags[${index}]" id="tags_sender_${index}" value="${key.keyword}" readonly">`;
        });
        document.getElementById('tags_sender').innerHTML = keywordsHTML;
    }

    function handleFunctionKeywords() {
        document.querySelectorAll('.wrapper-tag').forEach(wrapper => {
            wrapper.children[0].addEventListener('input', (e) => {
                const text = e.target.textContent;
                if (!text) return handleRemoveKeyword(e.target, true);
                if (e.inputType == "insertParagraph") return handleRemoveParagraph(e.target);
                if (e.target.id == "default") handleAddKeyword(e.target);
                handleUpdateKeyword(e.target);
            });
            wrapper.children[1].addEventListener('click', (e) => {
                if (confirm('apakah anda yakin ingin menghapus tag ini?')) {
                    handleRemoveKeyword(wrapper.children[0]);
                }
            });
        });
    }

    function handleAddKeyword(keyword) {
        if (keyword.id != "default") return;
        const id = `added_keyword_${new Date().getTime()}`;
        keywords.push({
            id,
            keyword: "Keyword Baru"
        });
        loadKeywords();
    }

    function handleUpdateKeyword(keyword) {
        keywords = keywords.map(key => {
            if (key.id == keyword.id) {
                key = {
                    ...key, ...{
                        keyword: keyword.textContent
                    }
                }
            }
            return key;
        })
    }

    function handleRemoveKeyword(keyword) {
        const wrapper = keyword.parentElement;
        if (wrapper.children[0].id == "default") {
            keyword.textContent = "Tidak Bisa Dihapus!";
            setTimeout(() => {
                keyword.textContent = "Tambahkan Keyword!"
            }, 2000)
            return;
        };
        wrapper.remove();
        keywords = keywords.filter(key => key.id != keyword.id);
    }

    function handleRemoveParagraph(element) {
        const cleantInput = element.innerText.replace('\n', '');
        element.textContent = cleantInput;
    }

    thumbnail.addEventListener('change', (e) => {
        let file = e.target.files[0];
        if (!file && !prev_filelist) return;
        if (!file && prev_filelist) {
            e.target.files = prev_filelist;
            file = prev_filelist.item(0);
        };
        image.src = URL.createObjectURL(file);
        prev_filelist = e.target.files;
    });

    initProject();
</script>

@vite(['resources/js/handle/create-news.js'])
@include('_components._footerAdmin')