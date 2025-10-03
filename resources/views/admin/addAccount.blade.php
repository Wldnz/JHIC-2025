@include('_components._headerAdmin', ['title' => 'Menambahkan Akun'])
@php
    $currentPath = explode('/admin/', string: url()->current())[1];
    $columns = [
        'nis' => [
            'label' => 'NIS',
            'placeholder' => 'Masukkan NIS',
            'type' => 'text',
            'min' => 8,
            'max' => 16,
        ],
        'fullname' => [
            'label' => 'Nama Lengkap',
            'placeholder' => 'Masukkan Nama Lengkap',
            'min' => 8,
            'max' => 120
        ],
        'address' => [
            'label' => 'Alamat',
            'placeholder' => 'Masukkan Alamat',
            'min' => 1,
            'max' => 255,
            'type' => 'textarea'
        ],
        'gender' => [
            'label' => 'Jenis Kelamin',
            'type' => 'select',
            'placeholder' => 'Jenis Kelamin',
            'options' => [
                'male' => 'Laki - Laki',
                'female' => 'Perempuan'
            ],
        ],
        'birthdate' => [
            'label' => 'Tanggal Lahir',
            'placeholder' => 'Masukkan Tanggal Lahir',
            'type' => 'date'
        ],
        'email' => [
            'label' => 'Email',
            'placeholder' => 'pengguna@gmail.com',
            'type' => 'email',
            'min' => 8,
            'max' => 120,
        ],
        'no_telp' => [
            'label' => 'Nomor Telepon',
            'placeholder' => '81234567891',
            'type' => 'number',
            'min' => 11,
            'max' => 12
        ],
        'class' => [
            'label' => 'Kelas',
            'placeholder' => 'Pilih Kelas',
            'type' => 'select',
            'options' => [
                'X' => 'Kelas 10',
                'XI' => 'Kelas 11',
                'XII' => 'Kelas 12'
            ],
        ],
        'major' => [
            'label' => 'Jurusan',
            'type' => 'select',
            'options' => [
                'rpl' => 'Rekayasa Perangkat Lunak',
                'dkv' => 'Desain Komunikasi Visual',
                'tkj' => 'Teknik Komputer & Jaringan',
                'anm' => 'Animasi',
                'bc' => 'Broadcasting',
                'gamedev' => 'Game Developer'
            ],
        ],
    ]
@endphp

<main class="content">
    <h2>Menambahkan Data Pengguna</h2>
    <form class="form-data" id="student-siswa-form">
        <div class="wrapper-field container tree-row-grid">
            @foreach ($columns as $key => $column)
                <div class="wrapper-input">
                    <label for="{{ $key }}">{{ $column['label'] }}
                        @if (empty($column['required']) || isset($column['required']) && $column['required'])
                            <span style="color:#273b98">*</span>
                        @endif
                    </label>
                    @if (isset($column['type']) && $column['type'] == 'textarea')
                        <textarea name="{{ $key }}" id="{{ $key }}" placeholder="{{ $column['placeholder'] }}" {{ isset($column['required']) && !$column['required'] ? '' : 'required' }}></textarea>
                    @elseif(isset($column['type']) && $column['type'] == 'select')
                        <select name="{{ $key }}" id="{{ $key }}" {{ isset($column['required']) && !$column['required'] ? '' : 'required' }}>
                            <option value="">{{ $column['placeholder'] ?? '' }}</option>
                            @foreach ($column['options'] as $key_option => $label_option)
                                <option value="{{ $key_option }}">{{ $label_option }}</option>
                            @endforeach
                        </select>
                    @else
                        <input type="{{ $column['type'] ?? 'text' }}" name="{{ $key }}" id="{{ $key }}"
                            placeholder="{{ $column['placeholder'] }}" {{ isset($column['required']) && !$column['required'] ? '' : 'required' }}>
                    @endif
                </div>
            @endforeach
            <div class="wrapper-input">
                <label for="role">
                    Jurusan
                    <span>*</span>
                </label>
                <select name="role" id="role" required>
                    <option value="siswa" @selected(old('role') ?? '' == 'siswa')>Siswa</option>
                    @if (Auth::user()->role == 'superAdmin')
                        <option value="siswa" @selected(old('role') ?? '' == 'admin')>Admin</option>
                    @endif
                </select>
            </div>
        </div>
        <button class="button-submit-form">
            <span>Tambahkan Akun</span>
            @include('_components._sprite-icons', ['name' => 'add', 'size' => 18])
        </button>
    </form>
</main>


@include('_components._footerAdmin')