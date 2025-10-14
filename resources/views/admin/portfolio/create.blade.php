@include('_components._headerAdmin', ['title' => 'Adding Portfolio'])
@php
    $currentPath = explode('/admin/', url()->current())[1];
    logger('as', [$students])
@endphp
<form class="content flex-row justify-between pad-0"
    method="POST"
    enctype="multipart/form-data"
>
    @csrf
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
                                <option value="{{ $student->nis }}">{{ $student['name'] }}</option>
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
                        <label for="major_name">Jurusan</label>
                        <input type="text" name="major_name" id="major_name" placeholder="Masukkan jurusan siswa"
                            value="{{ old('major_name', '') }}" readonly required>
                    </div>
                    <div class="wrapper-input hidden">
                        <label for="major_id">Jurusan</label>
                        <input type="text" name="major_id" id="major_id" placeholder="Masukkan jurusan siswa"
                            value="{{ old('major_id', '') }}" readonly required>
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
                            @foreach($availableLinkTypes as $key => $linkType)
                                <option value="{{ $linkType }}" @selected(old('type', '') == $linkType)>{{ $key }}</option>
                            @endforeach
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
                    Tambahkan Portofolio
                </button>
            </div>
        </div>
    </div>
</form>

@vite(['resources/js/handle/image-product.js', 'resources/js/handle/student-data.js', 'resources/js/handle/save-media.js'])

<script defer>
    const students = @json($students);
    let image = @json(old('images', [] ));
    const max_images = 2;

    const handlerStudentData = (student) => {
        document.getElementById('class').value = student.class;
        document.getElementById('major_name').value = student.major_long_name;
        document.getElementById('major_id').value = student.major_id;
        document.getElementById('fullname').value = student.name;
        document.getElementById('fullname_').textContent = student.name;
    }
</script>
@include('_components._footerAdmin')
