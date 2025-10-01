@include('_components._headerAdmin', [ 'title' => 'Profile Akun Anda' ])
@php
    $currentPath = 'accounts';
    @logger('as', [$user])
@endphp
<main class="content">
   <h2>Menambahkan Data Pengguna</h2>
    <form method='POST' class="form-data" id="student-siswa-form">
        <div class="wrapper-field container tree-row-grid">
            <div class="wrapper-input">
                <label for="nis">
                    NIS
                    <span>*</span>
                </label>
                <input type="text" inputmode="numeric" name="nis" id="nis" placeholder="Masukkan NIS/NISN" minLength="8"
                    maxlength="8" value="{{ old('nis') ?? $user['nis'] ?? '' }}" required readonly>
            </div>
            <div class="wrapper-input">
                <label for="fullname">
                    Nama Lengkap
                    <span>*</span>
                </label>
                <input type="text" name="fullname" id="fullname" placeholder="Masukkan Nama Lengkap" minLength="3"
                    maxlength="120" value="{{ old('fullname') ?? $user['fullname'] ?? '' }}" required>
            </div>
            <div class="wrapper-input">
                <label for="email">
                    Alamat Email
                    <span>*</span>
                </label>
                <input type="text" inputmode="email" name="email" id="email" placeholder="Masukkan email" minLength="8"
                    maxlength="120" value="{{ old('email') ?? $user['email'] ?? '' }}" required>
            </div>
            <div class="wrapper-input">
                <label for="role">
                    Role (Penting)
                    <span>*</span>
                </label>
                <select name="role" id="role" required>
                    <option value="admin" @selected(old('role') ?? '' == 'admin')>Admin</option>
                </select>
            </div>
        </div>
        <button class="button-submit-form">
            <span>Ubah Data Akun</span>
            @include('_components._sprite-icons', ['name' => 'add', 'size' => 18])
        </button>
    </form>

    
</main>