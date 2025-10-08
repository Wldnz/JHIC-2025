@include('_components._headerAdmin', ['title' => 'Portfolio Management'])
@php
    $currentPath = explode('/admin/', url()->current())[1];
    logger('as', [$students])
@endphp
<form class="content flex-row justify-between pad-0">
    <div class="wrapper-content-media">
        <div class="wrapper-container-media">
            <h2>Data Siswa</h2>
            <div class="form-data" id="student-siswa-form">
                <div class="wrapper-field container">
                    <div class="wrapper-input">
                        <label for="nis">Nama Siswa<span> *</span></label>
                        <select name="nis" id="nis" required>
                            <option value=""></option>
                            @foreach ($students as $student)
                                <option value="{{ $student->nis }}">{{ $student['user']['fullname'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="wrapper-input" style="display:none">
                        <label for="fullname">Nama Siswa<span> *</span></label>
                        <input type="hidden" name="fullname" id="fullname" value="{{ old('fullname', '') }}" readonly>
                    </div>
                    <div class="wrapper-input">
                        <label for="class">Kelas</label>
                        <input type="text" name="class" id="class" placeholder="Masukkan kelas siswa"
                            value="{{ old('class', '') }}" readonly required>
                    </div>
                    <div class="wrapper-input">
                        <label for="major">Jurusan</label>
                        <input type="text" name="major" id="major" placeholder="Masukkan jurusan siswa"
                            value="{{ old('major', '') }}" readonly required>
                    </div>
                </div>
            </div>
        </div>
        <div class="wrapper-container-media">
            <h2>Hasil Karya Siswa - <span id="fullname_">{{ old('fullname', '') }}</span></h2>
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
                        <label for="title">Title <span>*</span></label>
                        <input type="text" name="title" id="title" minlength="5" placeholder="Aplikasi pemesanan hotel"
                            value="{{ old('title', '') }}" required>
                    </div>
                    <div class="wrapper-input">
                        <label for="description">Description <span>*</span></label>
                        <textarea name="description" id="description" minlength="10"
                            placeholder="Kelompok ini dapat membuat sebuah aplikasi yang amat keren"
                            required>{{ old('description', '') }}</textarea>
                    </div>
                    <div class="wrapper-input">
                        <label for="type">Portfolio Type<span>*</span></label>
                        <select name="type" id="type" required>
                            <option value="youtube" @selected(old('type', '') == 'youtube')>Youtube</option>
                            <option value="instragam" @selected(old('type', '') == 'instragam')>Instragam</option>
                            <option value="tiktok" @selected(old('type', '') == 'tiktok')>Tiktok</option>
                            <option value="website" @selected(old('type', '') == 'website')>Website</option>
                            <option value="other" @selected(old('type', '') == 'other')>Lainnya</option>
                        </select>
                    </div>
                    <div class="wrapper-input">
                        <label for="link">Result<span>*</span></label>
                        <input type="url" name="link" id="link" minlength="6" placeholder="https://aplikasi.xyz" value{{ old('link', '') }} required>
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
                    Simpan Perubahan
                </button>
            </div>
        </div>
    </div>
</form>

@vite('resources/js/handle/image-product.js')

<script defer>
    
    let image = @json(old('images', [] ));
    const max_images = 2;

    document.getElementById('nis').addEventListener('change', (e) => {
        const students = @json($students);
        const student = students.find(s => s.nis == e.target.value);
        if(!student) return;
        document.getElementById('class').value = student.class;
        document.getElementById('major').value = student.major_name;
        document.getElementById('fullname').value = student.user.fullname;
        document.getElementById('fullname_').textContent = student.user.fullname;
    });

    function handleMedia(){
        const btn_close_media = document.getElementById('btn-close-media');
        const btn_open_media = document.getElementById('btn-open-media');
        const wrapper_save_media = document.getElementById('wrapper-save-media');
        const card_media = document.getElementById('card-save-media');
        btn_close_media.addEventListener('click', () => {
            wrapper_save_media.classList.add('close-sidebar');
            wrapper_save_media.classList.remove('open-sidebar');
            Array.from(card_media.children)
                .filter((_,index) => index != 0)
                .forEach(c => c.style.display = 'none');
            btn_close_media.style.display = 'none';
            btn_open_media.style.display = 'flex';
        });

        btn_open_media.addEventListener('click', () => {
            wrapper_save_media.classList.remove('close-sidebar');
            wrapper_save_media.classList.add('open-sidebar');
            Array.from(card_media.children)
                .filter((_,index) => index != 0)
                .forEach(c => c.style.display = 'flex');
            btn_close_media.style.display = 'flex';
            btn_open_media.style.display = 'none';
        });
    }

    handleMedia();

</script>
@include('_components._footerAdmin')