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
                        <label for="user_fullname">Nama Pembeli<span> *</span></label>
                        <select name="user_fullname" id="user_fullname" required>
                            @foreach ($students as $student)
                                <option value="{{ $student->nis }}">{{ $student['user']['fullname'] }}</option>
                            @endforeach
                        </select>
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
            <h2>Hasil Karya Siswa - Wildan</h2>
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
    <div class="wrapper-save-media">
        <div class="card-save-media">
            <button class="btn-svg" id="btn-" type="button">
                @include('_components._sprite-icons', ['name' => 'exception', 'size' => 25])
            </button>
            <div class="card-content">
                
            </div>
        </div>
    </div>
</form>

@vite('resources/js/handle/image-product.js')

<script defer>
    let image = [];
    const max_images = 8;
</script>
@include('_components._footerAdmin')