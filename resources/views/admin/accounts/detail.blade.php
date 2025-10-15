@include('_components._headerAdmin', ['title' => 'Detail Account'])
@php
    $currentPath = explode('/admin/', url()->current())[1];
    logger('as', [$account, $candidate, $sources]);
    $status_families = [
        'biological_child' => 'Anak Kandung',
        'step_child' => 'Anak Angkat',
        'adopted_child' => 'Anak Adopsi',
        'foster_child' => 'Anak Asuh',
    ];

    $religions = [
        'islam' => 'Islam',
        'confucion' => "Konghucu",
        'protestant' => "Protestan",
        'catholic' => "Katolik",
        'hindu' => "Hindu",
        'buddha' => "Buddha",
        'other' => "Lainnya",
    ];
@endphp
<form class="content" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="profile-container">
        <div class="wrapper-profile-image">
            <img src="{{ asset('images/default.png') }}" alt="profile-{nama}">
            <span class="name">{{ $account->fullname }}</span>
            <span class="sub-name">{{ strtoupper($account->role[0]) . substr($account->role, 1) }}</span>
        </div>
        <div class="form-data-profile" id="student-siswa-form">
            <div class="container">
                @if ($account->role == 'candidate' && $candidate)
                    <div class="wrapper-input wrapper-input-full">
                        <label for="candidate_nisn">Nomor Induk Siswa Nasional</label>
                        <input type="text" name="candidate_nisn" id="candidate_nisn" placeholder="Nisn Calon Peserta Didik"
                            value="{{ old('candidate_nisn', $candidate->nisn) }}" aria-describedby="nisn" required>
                    </div>
                @endif
                <div class="wrapper-input">
                    <label for="fullname">Nama Lengkap</label>
                    <input type="text" name="fullname" id="fullname" placeholder="Nama Lengkap Calon Peserta Didik"
                        value="{{ old('fullname', $account->fullname) }}" aria-describedby="fullname" required>
                </div>
                @if($account->role == 'candidate' && $candidate)
                    <div class="wrapper-input">
                        <label for="candidate_short_name">Nama Panggilan</label>
                        <input type="text" name="candidate_short_name" id="candidate_short_name"
                            placeholder="Nama Panggilan Calon Peserta Didik"
                            value="{{ old('candidate_short_name', $candidate->short_name) }}" aria-describedby="shortname"
                            required>
                    </div>
                    <div class="wrapper-input">
                        <label for="candidate_birth_place">Tempat Lahir</label>
                        <input type="text" name="candidate_birth_place" id="candidate_birth_place"
                            placeholder="Tempat Lahir Calon Peserta Didik"
                            value="{{ old('candidate_birth_place', $candidate->birthplace) }}" aria-describedby="birthplace"
                            required>
                    </div>
                    <div class="wrapper-input">
                        <label for="candidate_birth_date">Tanggal Lahir</label>
                        <input type="date" inputmode="numeric" name="candidate_birth_date" id="candidate_birth_date"
                            placeholder="Tanggal Lahir Calon Peserta Didik"
                            value="{{ old('candidate_birth_date', substr($candidate->birthdate, 0, 10)) }}"
                            aria-describedby="birthdate" required>
                    </div>
                @else
                    <div class="wrapper-input">
                        <label for="email">Alamat Email</label>
                        <input type="email" name="email" id="email" placeholder="Alamat Email Pengguna"
                            value="{{ old('email', $account->email) }}" aria-describedby="email" required>
                    </div>
                    <div class="wrapper-input">
                        <label for="phone">Nomor phone</label>
                        <input type="phone" name="phone" id="phone" placeholder="Nomer Telepon Pengguna"
                            value="{{ old('phone', $account->phone) }}" aria-describedby="phone" required>
                    </div>
                @endif
                <div class="wrapper-input">
                    <label for="role">Role</label>
                    <select name="role" id="role" required>
                        <option @selected(old('role', $account->role) == 'candidate') value="candidate">Calon Peserta
                            Didik</option>
                        <option @selected(old('role', $account->role) == 'siswa') value="student">Siswa</option>
                        <option @selected(old('role', $account->role) == 'article_creator') value="article_creator">
                            Pembuat Artikel</option>
                        @if ($account->role == 'super_admin')
                            <option @selected(old('role', $account->role) == 'admin') value="admin">Administrasi
                            </option>
                        @endif
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="wrapper-content">
        @includeWhen($account->role == 'candidate' && $candidate, 'admin.accounts.components.details.index')
        @includeWhen($account->role == 'article_creator' && $articles, 'admin.accounts.components.details.articles')
        @if($account->role == 'candidate' && !$candidate)
            <div class="form-data-profile" id="candidate-document-form">
                <div class="wrapper-form">
                    <div class="container container-1">
                        <div class="wrapper-document">
                            <div class="wrapper-thumbnail">
                                <h4 class="text-center">Calon Peserta Didik Belum Mengisi Formulir</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @elseif($account->role == 'article_creator' && !$articles)
            <div class="form-data-profile" id="candidate-document-form">
                <div class="wrapper-form">
                    <div class="container container-1">
                        <div class="wrapper-document">
                            <div class="wrapper-thumbnail">
                                <h4>Pembuat Artikel Belum Menambahkan Artikel</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
    <div class="wrapper-button">
        <button class="btn" type="submit">Simpan Perubahan</button>
        <!-- <button class="btn btn-back" type="button" id="reset-password-btn">Reset Password</button> -->
    </div>
</form>

<script defer>
    const csrfToken = @js(@csrf_token());
    document.getElementById('role').addEventListener('change', (e) => {
        document.getElementById('role-preview').textContent = e.target.value;
    });
    document.getElementById('fullname').addEventListener('input', (e) => {
        document.getElementById('name-preview').textContent = e.target.value;
    });

    let resetPassword = true;
    // const handlerResetPassword = (e) => {
    //     fetch("", {
    //         headers : {
    //             'Content-Type': 'application/json',
    //         },
    //         method : 'PATCH',
    //         body : JSON.stringify( {
    //             _token : csrfToken
    //         })
    //     })
    //     .then(e => e.json())
    //     .then(e => console.log(e));
    // };
    // document.getElementById('reset-password-btn').addEventListener('click', handlerResetPassword)
</script>

@include('_components._footerAdmin')
