@include('_components._headerAdmin', ['title' => 'Tambahkan Artikel/Blog'])
@php
    $currentPath = explode('/admin/', url()->current())[1];
@endphp
<form class="content flex-row justify-between pad-0">
    <div class="wrapper-content-media-management">
        <div class="wrapper-container-media form-news">
            <div class="wrapper-title">
                <input type="text" name="title" id="title" placeholder="Pengenalan Apa Itu Shooting Video"
                    minlength="10" maxlength="180" required>
            </div>
            
            <div class="wrapper-thumbnail">
               <img class="thumbnail" id="thumbnail" src="" alt="thumbnail-datas">
                <input type="file"  accept="image/jpeg, image/png" 
                    id="thumbnail_image" name="thumbnail"
                    required
                >
            </div>

            <div class="wrapper-content wrapper-content-action">
                <div id="editor"></div>
            </div>

            <!-- <div class="wrapper-content wrapper-content-action">
                <div class="action">
                    <button class="btn-svg">
                        @include('_components._sprite-icons', ['name' => 'add', 'color' => '#485bb1' ,'size' => 20])
                    </button>
                </div>
                <textarea name="content" id="a" placeholder="Write Your Story!"></textarea>
            </div> -->
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
                        <div class="tags">
                            <div class="wrapper-tag">
                                <span class="tag" contenteditable="true">nama</span>
                                <button class="btn-tag" type="button">X</button>
                            </div>
                            <div class="wrapper-tag">
                                <span class="tag" contenteditable="true">nama</span>
                                <button class="btn-tag" type="button">X</button>
                            </div>
                        </div>
                    </div>
                    <div class="wrapper-input">
                        <label for="visible">Visible<span>*</span></label>
                        <select name="visible" id="visible" required>
                            <option value="public" @selected(old('type', '') == 'public')>Public</option>
                            <option value="arhcive" @selected(old('type', '') == 'archive')>Archive</option>
                        </select>
                    </div>

                </div>
                <button type="submit" class="btn btn-media" id="btn-submit-news">
                    Tambahkan Artikel
                </button>
            </div>
        </div>
    </div>
</form>

<script defer>
    const thumbnail = document.getElementById('thumbnail_image');
    const image = document.getElementById('thumbnail');

    function initProject(){
        image.src = "{{ asset('images/default.png') }}";
        image.style.display = "block";
    }

    function createNewFile(file){
        const blob = new Blob(file);
        return new File(
            blob,
            file.name.split('.')[0],
            file.type
        )
    }

    thumbnail.addEventListener('change' ,(e) => {
        const file = e.target.files[0];
        
    });
    
    initProject();
</script>

@vite(['resources/js/handle/create-news.js'])
@include('_components._footerAdmin')