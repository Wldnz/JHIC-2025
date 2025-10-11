@include('_components._headerAdmin', ['title' => 'Facilities Management'])
@php
    $currentPath = explode('/admin/', url()->current())[1];
@endphp
<form class="content flex-row justify-between pad-0" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="wrapper-content-media-management">
        <div class="wrapper-container-media">
            <h2>Data Siswa</h2>
            <div class="form-data" id="student-siswa-form">
                <div class="wrapper-field container">
                    <div class="wrapper-input">
                        <label for="student_nis">Nama Siswa<span> *</span></label>
                        <select name="student_nis" id="student_nis" required>
                            <option value=""></option>
                            @foreach ($students as $student)
                                <option value="{{ $student->nis }}" @selected(old('student_nis', '') == $student->nis)>{{ $student->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="wrapper-input" style="display:none">
                        <label for="student_name">Nama Siswa<span> *</span></label>
                        <input type="hidden" name="student_name" id="student_name"
                            value="{{ old('student_name', ) }}" readonly>
                    </div>
                    <div class="wrapper-input">
                        <label for="class">Kelas</label>
                        <input type="text" name="class" id="class" placeholder="Masukkan kelas siswa"
                            value="{{ old('class', '') }}" readonly required>
                    </div>
                    <div class="wrapper-input" style="display:none">
                        <label for="major_id">Jurusan</label>
                        <input type="text" name="major_id" id="major_id" placeholder="Masukkan jurusan siswa"
                            value="{{ old('major_id', '') }}" readonly>
                    </div>
                    <div class="wrapper-input">
                        <label for="major_name">Jurusan</label>
                        <input type="text" name="major_name" id="major_name" placeholder="Masukkan jurusan siswa"
                            value="{{ old('major', '') }}" readonly required>
                    </div>
                </div>
            </div>
        </div>
        <div class="wrapper-container-media">
            <h2>Foto Siswa <span id="fullname_">{{ old('student_name', '') }}</span> </h2>
            <div class="form-data">
                <div class="wrapper-image justify-start" id="image-picker">
                    <div class="image-product">
                        <img src="{{ '' ?? asset('icons/default-image.png') }}"
                            alt="image-default_image">
                        <div class="action-product">
                            <button class="btn-choose" type="button">
                                <span class="">Pilih Gambar</span>
                                <input type="file" accept="image/jpeg, image/png" multiple name="default_image"
                                    required>
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
                        <label for="competition_position">Juara <span>*</span></label>
                        <select name="competition_position" id="competition_position" required>
                            @foreach($competitionPositions as $key => $position)
                                <option value="{{ $position }}" @selected(old('competition_position', '') == $position)>{{ $key }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="wrapper-input">
                        <label for="competition_name">Nama Perlombaan <span>*</span></label>
                        <input type="text" name="competition_name" id="competition_name" minlength="5"
                            placeholder="Perlombaan Pembuatan Video"
                            value="{{ old('competition_name', '') }}" required>
                    </div>
                    <div class="wrapper-input">
                        <label for="won_at">Dimenangkan Pada <span>*</span></label>
                        <input type="date" inputmode="numeric" name="won_at" id="won_at" minlength="5"
                            value="{{ old('won_at', substr('', 0, 10)) }}" required>
                    </div>
                    <div class="wrapper-input">
                        <label for="competition_level">Tingkat Perlombaan <span>*</span></label>
                        <select name="competition_level" id="competition_level" required>
                            @foreach ($competitionLevels as $key => $level)
                                <option value="{{ $level }}" @selected(old('competition_level', '') == $level)>{{ $key }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="wrapper-input">
                        <label for="visible">Visible <span>*</span></label>
                        <select name="visible" id="visible" required>
                            <option value="public" @selected(old('visible', '') == 'public')>Public</option>
                            <option value="arhcive" @selected(old('visible', '') == 'archive')>Archive</option>
                        </select>
                    </div>
                    <div class="wrapper-input wrapper-preview">
                        <label for="preview" id="preview-btn">
                            Lihat Preview
                            @include('_components._sprite-icons', ['name' => 'drop-down', 'size' => 15])
                        </label>
                    </div>
                </div>
                <button type="submit" class="btn btn-media">
                    Simpan Perubahan
                </button>
            </div>
        </div>
    </div>

    <div class="alert-message">
        <div class="preview-media" id="preview-media">
            <div class="management-table">
                <div class="wrapper-content-media flex-row justify-center">
                    <div class="wrapper-card-media-achievement">
                        <div class="card-media">
                            <div class="wrapper-image">
                                <img src="{{ old('thumbnail_url', asset('images/default.png') ) }}" alt="wrapper-iamge"
                                    id="_preview_image">
                            </div>
                            <div class="detail-media">
                                <div class="ranking" id="_preview_competition_position">
                                    @include('_components._sprite-icons', ['name' => 'rank-3', 'size' => 25])
                                </div>
                                <div class="profile">
                                    <div class="horizontal">
                                        <h5 id="_preview_fullname">(Nama Lengkap)</h5>
                                    </div>
                                    <div class="horizontal">
                                        <h6 id="_preview_competition_name">(Nama Lomba)</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</form>

@vite(['resources/js/handle/image-product.js', 'resources/js/handle/student-data.js', 'resources/js/handle/save-media.js', 'resources/js/handle/add-achievement.js'])
<script defer>
    const students = @json($students);
    let image = @json(old('images',[]) );
    const additionalHandlerImage = (file) => {
        document.getElementById("_preview_image").src = URL.createObjectURL(file);
    };
    const max_images = 1;

    const handlerStudentData = (student) => {
        document.getElementById('fullname_').textContent = student.name;
        document.getElementById('_preview_fullname').textContent = student.name;
        document.getElementById('class').value = student.class;
        document.getElementById('major_id').value = student.major_id;
        document.getElementById('major_name').value = student.major_long_name;
    };
</script>
@include('_components._footerAdmin')