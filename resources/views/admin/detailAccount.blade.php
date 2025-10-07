@include('_components._headerAdmin', ['title' => 'Management Akun'])
@php
    $currentPath = explode('/admin/', url()->current())[1];
    logger('as', [$account, $majors])
@endphp
<style>
    .wrapper-input>label>span {
        color: #273b98 !important;
    }
</style>
<main class="content">
    <h2>Menambahkan Data Pengguna</h2>
    <form method='POST' class="form-data" id="student-siswa-form">
        @method('put')
        @csrf
        <div class="wrapper-field container tree-row-grid">
            <div class="wrapper-input">
                <label for="nis">
                    NIS
                    <span>*</span>
                </label>
                <input type="text" inputmode="numeric" name="nis" id="nis" placeholder="Masukkan NIS/NISN" minLength="8"
                    maxlength="8" value="{{ old('nis',$account['nis'])}}" required readonly>
            </div>
            <div class="wrapper-input">
                <label for="fullname">
                    Nama Lengkap
                    <span>*</span>
                </label>
                <input type="text" name="fullname" id="fullname" placeholder="Masukkan Nama Lengkap" minLength="3"
                    maxlength="120" value="{{ old('fullname',$account['fullname']) }}" required>
            </div>
            <div class="wrapper-input">
                <label for="email">
                    Alamat Email
                    <span>*</span>
                </label>
                <input type="text" inputmode="email" name="email" id="email" placeholder="Masukkan email" minLength="8"
                    maxlength="120" value="{{ old('email', $account['email'])}}" required>
            </div>
            <div class="wrapper-input">
                <label for="phone">
                    Nomor Telepon
                    <span>*</span>
                </label>
                <input type="text" inputmode="numeric" name="phone" id="phone" placeholder="81234567890" minLength="11"
                    maxlength="12" value="{{ old('phone',$account['phone']) }}" required>
            </div>
            @if ($account['role'] == 'siswa')
                <div class="wrapper-input">
                    <label for="address">
                        Alamat
                        <span>*</span>
                    </label>
                    <textarea name="address" id="addresss" placeholder="Alamat Pengguna" minlength="8" maxlength="255"
                        required>{{ old('address', $account['student']['address'] ) }}
                    </textarea>
                </div>
                <div class="wrapper-input">
                    <label for="gender">
                        Jenis Kelamin
                        <span>*</span>
                    </label>
                    <select name="gender" id="gender" required>
                        <option value="male" @selected(old('gender', $account['student']['gender']) == 'male')>Laki - Laki</option>
                        <option value="female" @selected(old('gender', $account['student']['gender']) == 'female')>Perempuan</option>
                    </select>
                </div>
                <div class="wrapper-input">
                    <label for="class">
                        Kelas
                        <span>*</span>
                    </label>
                    <select name="class" id="class" required>
                        <option value="X" @selected(old('class', $account['student']['class']) == 'X')>
                            Kelas 10</option>
                        <option value="XI" @selected(old('class', $account['student']['class']) == 'XI')>
                            Kelas 11</option>
                        <option value="XII" @selected(old('class', $account['student']['class']) == 'XII')>Kelas 12</option>
                    </select>
                </div>
                <div class="wrapper-input">
                    <label for="major">
                        Jurusan
                        <span>*</span>
                    </label>
                    <select name="major" id="major" required>
                        @foreach ($majors as $major)
                            <option value="{{ $major->id }}" @selected(old('major', $account['student']['major_id']) == $major->id)>{{ $major->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="wrapper-input">
                    <label for="birthdate">
                        Tanggal Lahir
                        <span>*</span>
                    </label>
                    <input type="date" inputmode="numeric" name="birthdate" id="birthdate" placeholder="81234567890"
                        value="{{ old('birthdate') ?? explode(' ', $account['student']['birthdate'])[0] ?? '' }}" required>
                </div>
            @endif
            <div class="wrapper-input">
                <label for="role">
                    Role (Penting)
                    <span>*</span>
                </label>
                <select name="role" id="role" required>
                    <option value="{{ $account['role'] }}" @selected(old('role') ?? '' == $account['role'])>{{ strtoupper($account['role'][0]) . substr($account['role'], 1) }}</option>
                    @if (Auth::user()->role == 'superAdmin')
                        <option value="siswa" @selected(old('role') ?? '' == 'admin')>Admin</option>
                    @endif
                </select>
            </div>
        </div>
        <button class="button-submit-form">
            <span>Ubah Data Akun</span>
            @include('_components._sprite-icons', ['name' => 'add', 'size' => 18])
        </button>
    </form>

    @include('_components._management-table', [
        'title' => 'Total Aktivitas Pengguna',
        'columns' => [
            'id' => 'ID',
            'action' => 'Aksi Yang Dilakukan',
            'created_at' => 'Dilakukan Pada',
        ],
        'datas' => $account['activities'],
        'pagination' => [
            'current' => $currentPage,
            'max' => $maxPage
        ]
    ])
</main>


@include('_components._footerAdmin')
