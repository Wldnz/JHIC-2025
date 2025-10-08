@include('_components._headerAdmin', ['title' => 'Tambahkan Artikel/Blog'])
@php
    $currentPath = explode('/admin/', url()->current())[1];
@endphp
<form class="content flex-row justify-between pad-0">
    <div class="wrapper-content-media-management">
        <div class="wrapper-container-media">
           <div class="wrapper-title">
                <input type="text" name="title" id="title" placeholder="Pengenalan Apa Itu Shooting Video"
                    minlength="10" maxlength="180" required
                >
           </div>
            <div class="wrapper-thumbnail">
                <input type="text" name="title" id="title" placeholder="Pengenalan Apa Itu Shooting Video"
                    minlength="10" maxlength="180" required
                >
           </div>
        </div>
        <div class="wrapper-container-media">
           <div class="wrapper-content">
                <textarea name="content" id="content" placeholder="Ketik Sesuatu Yang Menyenangkan" required>asasas</textarea>
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
                        <label for="keyword">Kata Kunci <span>*</span></label>
                        <input type="text" name="keyword" id="keyword" minlength="5" placeholder="Aplikasi pemesanan hotel"
                            value="{{ old('title', '') }}" required>
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
                    Tambahkan Artikel
                </button>
            </div>
        </div>
    </div>
</form>

@include('_components._footerAdmin')