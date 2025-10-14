@include('_components._headerAdmin', ['title' => 'Adding Account'])
@php
    $currentPath = explode('/admin/', url()->current())[1];
@endphp
<form class="content" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="profile-container">
        <div class="wrapper-profile-image">
            <img src="{{ asset('images/default.png') }}" alt="profile-{nama}">
            <span class="name" id="name-preview">????</span>
            <span class="sub-name" id="role-preview">???</span>
            <span class="sub-name">Password Dikirim Melalui Email</span>
        </div>
        <div class="form-data-profile" id="student-siswa-form">
            <div class="container">
                <div class="wrapper-input wrapper-input-full">
                    <label for="fullname">Nama Lengkap</label>
                    <input type="text" name="fullname" id="fullname" placeholder="Masukkan Nama Lengkap"
                        value="{{ old('fullname', '') }}" aria-describedby="nisn" required>
                </div>
                    <div class="wrapper-input">
                        <label for="email">Alamat Email</label>
                        <input type="email" name="email" id="email" placeholder="Alamat Email Pengguna"
                            value="{{ old('email', '') }}" aria-describedby="email" required>
                    </div>
                    <div class="wrapper-input">
                        <label for="phone">Nomor phone</label>
                        <input type="phone" name="phone" id="phone" placeholder="Nomer Telepon Pengguna"
                            value="{{ old('phone', '') }}" aria-describedby="phone" required>
                    </div>
                <div class="wrapper-input">
                    <label for="role">Role</label>
                    <select name="role" id="role" required>
                        <option value=""></option>
                        <option @selected(old('role', '') == 'candidate') value="candidate">Calon Peserta Didik</option>
                        <option @selected(old('role', '') == 'siswa') value="student">Siswa</option>
                        <option @selected(old('role', '') == 'article_creator') value="article_creator">Pembuat Artikel</option>
                        @if (Auth::user()->role == 'super_admin')
                            <option @selected(old('role', '') == 'administrasi') value="admin">Administrasi</option>
                            <option @selected(old('role', '') == 'owner') value="owner">Owner</option>
                        @endif
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="wrapper-content">
    </div>
    <div class="wrapper-button">
        <button class="btn" type="submit">Tambahkan Akun</button>
    </div>
</form>

<script defer>
    document.getElementById('role').addEventListener('change', (e) => {
        document.getElementById('role-preview').textContent = e.target.value;
    });
    document.getElementById('fullname').addEventListener('input', (e) => {
        document.getElementById('name-preview').textContent = e.target.value;
    });
</script>

@include('_components._footerAdmin')