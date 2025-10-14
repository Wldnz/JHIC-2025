@include('_components._headerAdmin', ['title' => 'Detail Account'])
@php
    $currentPath = explode('/admin/', url()->current())[1];
    logger('x', [$student])
@endphp
<form class="content" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="profile-container">
        <div class="wrapper-profile-image">
            <img src="{{ asset('images/default.png') }}" alt="profile-{nama}">
            <span class="name" id="name-preview">{{ $student->name }}</span>
            <span class="sub-name" id="role-preview">Student</span>
        </div>
        <div class="form-data-profile" id="student-siswa-form">
            <div class="container">
                <div class="wrapper-input wrapper-input-full">
                    <label for="nis">Nomor Induk Siswa</label>
                    <input type="text" name="nis" id="nis" placeholder="Nis Peserta Didik"
                        value="{{ old('nis', $student->nis) }}" aria-describedby="nis" required>
                </div>
                <div class="wrapper-input">
                    <label for="name">Nama Lengkap</label>
                    <input type="text" name="name" id="name" placeholder="Nama Lengkap Peserta Didik"
                        value="{{ old('name', $student->name) }}" aria-describedby="name" required>
                </div>
                <div class="wrapper-input">
                    <label for="birth_date">Tanggal Lahir</label>
                    <input type="date" inputmode="numeric" name="birth_date" id="birth_date"
                        placeholder="Tanggal Lahir Calon Peserta Didik"
                        value="{{ old('birth_date', substr($student->birthdate, 0, 10)) }}" aria-describedby="birthdate"
                        required>
                </div>
                <div class="wrapper-input">
                    <label for="gender">Kelas</label>
                    <select name="gender" id="gender" required>
                        <option value=""></option>
                        <option @selected(old('gender', $student->gender) == 'male') value="gender">Laki - Laki</option>
                        <option @selected(old('gender', $student->gender) == 'female') value="gender">Perempuan</option>
                    </select>
                </div>
                <div class="wrapper-input">
                    <label for="class">Kelas</label>
                    <select name="class" id="class" required>
                        <option value=""></option>
                        <option @selected(old('class', $student->class) == 'X') value="class">Kelas 10</option>
                        <option @selected(old('class', $student->class) == 'XI') value="class">Kelas 11</option>
                        <option @selected(old('class', $student->class) == 'XII') value="class">Kelas 12</option>
                    </select>
                </div>
                <div class="wrapper-input">
                    <label for="major_id">Jurusan</label>
                    <select name="major_id" id="major_id" required>
                        <option value=""></option>
                        @foreach ($majors as $major)
                            <option @selected(old('major_id', $major->id) == $student->major_id) value="major">{{ $major->long_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="wrapper-input">
                    <label for="role">Role</label>
                    <select name="role" id="role" required>
                        <option @selected(old('role') == 'candidate') value="candidate">Calon Peserta
                            Didik</option>
                        <option @selected(old('role', 'student') == 'student') value="student">Siswa</option>
                        <option @selected(old('role'))value="article_creator">
                            Pembuat Artikel</option>
                        @if (Auth::user()->role == 'super_admin')
                            <option @selected(old('role' )) value="admin">Administrasi
                            </option>
                            <option @selected(old('role' )) value="owner">Owner</option>
                        @endif
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="wrapper-button">
        <button class="btn" type="submit">Simpan Perubahan</button>
    </div>
</form>
<script defer>
    document.getElementById('role').addEventListener('change', (e) => {
        document.getElementById('role-preview').textContent = e.target.value;
    });
    document.getElementById('name').addEventListener('input', (e) => {
        document.getElementById('name-preview').textContent = e.target.value;
    });
</script>

@include('_components._footerAdmin')