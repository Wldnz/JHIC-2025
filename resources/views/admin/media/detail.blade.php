@include('_components._headerAdmin', ['title' => 'Tambahkan Media (Foto / Image)'])
@php
    $currentPath = explode('/admin/', url()->current())[1];
@endphp
<form class="content flex-row justify-between pad-0" method="post" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="wrapper-content-media-management">
        <div class="wrapper-container-media">
            <h2>Foto - Foto Fasilitas</h2>
            <div class="form-data">
                <div class="wrapper-image justify-start" id="image-picker">
                    <div class="image-product">
                        <img src="/icons/default-image.png" alt="image-default_image">
                        <div class="action-product">
                            <button class="btn-choose" type="button">
                                <span class="">Pilih Gambar</span>
                                <input type="file" accept="image/jpeg, image/png" multiple name="default_image">
                            </button>
                        </div>
                        <div class="identifier">
                            <span class="">➕</span>
                        </div>
                    </div>
                </div>
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
                    <div class="wrapper-input">
                        <label for="type">Media Type<span>*</span></label>
                        <select name="type" id="type" required>
                            <option value="image" @selected(old('type', '') == 'image')>Image</option>
                            <option value="video" @selected(old('type', '') == 'video')>Video</option>
                        </select>
                    </div>
                    <div class="wrapper-input">
                        <label for="visible">Visible<span>*</span></label>
                        <select name="visible" id="visible" required>
                            <option value="public" @selected(old('type', '') == 'public')>Public</option>
                            <option value="arhcive" @selected(old('type', '') == 'archive')>Archive</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-media">
                    Tambahkan Media
                </button>
            </div>
        </div>
    </div>
</form>

@vite(['resources/js/handle/image-product.js', 'resources/js/handle/save-media.js'])

<script defer>
    let image = @json(old('images', [] ));
    const max_images = 1;
</script>
@include('_components._footerAdmin')