@php

    $monthly_incomes = [
        'Dibawah 500 Ribu',
        'Sekitar 500 Ribu - 1 Juta',
        'Sekitar 1 Juta - 5 Juta',
        'Diatas 5 Juta',
    ];

    $candidate_guardian = $candidate->candidateGuardian ?? [];

@endphp
<div class="form-data-profile" id="candidate-guard-form">
    <div class="wrapper-form" id="wrapper-form-guard">
        <h2>Data Pribadi Wali</h2>
        <div class="container container-3">
            <div class="wrapper-input">
                <label for="candidate_guardian_name">Nama Lengkap Wali <span>*</span></label>
                <input type="text" name="candidate_guardian_name" id="candidate_guardian_name" minlength="1"
                    aria-describedby="candidate_guardian_name" value="{{ old('candidate_guardian_name', $candidate_guardian->full_name ?? '') }}"
                    required>
            </div>
            <div class="wrapper-input">
                <label for="candidate_guardian_birthplace">Tempat Lahir Wali <span>*</span></label>
                <input type="text" name="candidate_guardian_birthplace" id="candidate_guardian_birthplace" minlength="1"
                    aria-describedby="candidate_guardian_birthplace"
                    value="{{ old('candidate_guardian_birthplace', $candidate_guardian->birthplace ?? '') }}" required>
            </div>
            <div class="wrapper-input">
                <label for="candidate_guardian_birthdate">Tanggal Lahir Wali <span>*</span></label>
                <input type="date" inputmode="numeric" name="candidate_guardian_birthdate" id="candidate_guardian_birthdate"
                    minlength="1" aria-describedby="candidate_guardian_birthdate"
                    value="{{ old('candidate_guardian_birthdate', substr($candidate_guardian->birthdate ?? '', 0, 10)) }}" required>
            </div>
            <div class="wrapper-input">
                <label for="candidate_guardian_education">Pendidikan Wali <span>*</span></label>
                <input type="text" name="candidate_guardian_education" id="candidate_guardian_education" minlength="1"
                    aria-describedby="candidate_guardian_education"
                    value="{{ old('candidate_guardian_education', $candidate_guardian->education ?? '') }}" required>
            </div>
            <div class="wrapper-input">
                <label for="candidate_guardian_job">Pekerjaan Wali <span>*</span></label>
                <input type="text" name="candidate_guardian_job" id="candidate_guardian_job" minlength="1"
                    aria-describedby="candidate_guardian_job" value="{{ old('candidate_guardian_job', $candidate_guardian->job ?? '') }}" required>
            </div>
            <div class="wrapper-input">
                <label for="candidate_guardian_monthly_income">Penghasilan / Sebulan Wali <span>*</span></label>
                <select name="candidate_guardian_monthly_income" id="candidate_guardian_monthly_income" required>
                    @foreach ($monthly_incomes as $key => $monthly_income)
                        <option value="{{ $key }}" @selected(old('candidate_guardian_monthly_income', $candidate_guardian->monthly_income ?? '') == $key)>
                            {{ $monthly_income }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="wrapper-input">
                <label for="candidate_guardian_citizenship">Kewarganegaraan Wali <span>*</span></label>
                <select name="candidate_guardian_citizenship" id="candidate_guardian_citizenship" required>
                    <option value="indonesia" @selected(old('candidate_guardian_citizinship', $candidate_guardian->citizenship ?? '') == 'indonesia')>
                        Indonesia</option>
                    <option value="other" @selected(old('candidate_guardian_citizinship', $candidate_guardian->citizenship ?? '') == 'other')>
                        Lainnya
                    </option>
                </select>
            </div>
            <div class="wrapper-input">
                <label for="candidate_guardian_religion">Agama Wali <span>*</span></label>
                <select name="candidate_guardian_religion" id="candidate_guardian_religion" required>
                    @foreach ($religions as $key => $religion)
                        <option value="{{ $key }}" @selected(old('candidate_guardian_religion', $candidate_guardian->religion ?? '') == $key)>
                            {{ $religion }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="wrapper-form" id="wrapper-form-guard">
        <h2>Data Rumah Wali</h2>
        <div class="container container-3">
            <div class="wrapper-input">
                <label for="candidate_guardian_city">Kabupaten/Kota Wali <span>*</span></label>
                <input type="text" name="candidate_guardian_city" id="candidate_guardian_city" minlength="1"
                    aria-describedby="candidate_guardian_city" value="{{ old('candidate_guardian_city', $candidate_guardian->city ?? '') }}" required>
            </div>
            <div class="wrapper-input">
                <label for="candidate_guardian_district">Kelurahan Wali <span>*</span></label>
                <input type="text" name="candidate_guardian_district" id="candidate_guardian_district" minlength="1"
                    aria-describedby="candidate_guardian_district" value="{{ old('candidate_guardian_district', $candidate_guardian->district ?? '') }}"
                    required>
            </div>
            <div class="wrapper-input">
                <label for="candidate_guardian_sub_district">Kecamatan Wali <span>*</span></label>
                <input type="text" name="candidate_guardian_sub_district" id="candidate_guardian_sub_district" minlength="1"
                    aria-describedby="candidate_guardian_sub_district"
                    value="{{ old('candidate_guardian_sub_district', $candidate_guardian->sub_district ?? '') }}" required>
            </div>
            <div class="wrapper-input">
                <label for="candidate_guardian_rt_rw">Kode Pos Wali <span>*</span></label>
                <input type="text" name="candidate_guardian_rt_rw" id="candidate_guardian_rt_rw" minlength="1"
                    aria-describedby="candidate_guardian_rt_rw" value="{{ old('candidate_guardian_rt_rw', $candidate_guardian->rt_rw ?? '') }}" required>
            </div>
            <div class="wrapper-input">
                <label for="candidate_guardian_postal_code">RT/RW Wali <span>*</span></label>
                <input type="text" name="candidate_guardian_postal_code" id="candidate_guardian_postal_code" minlength="1"
                    aria-describedby="candidate_guardian_postal_code"
                    value="{{ old('candidate_guardian_postal_code', $candidate_guardian->postal_code ?? '') }}" required>
            </div>
            <div class="wrapper-input wrapper-input-full">
                <label for="candidate_guardian_address">Alamat Rumah Wali <span>*</span></label>
                <textarea name="candidate_guardian_address" id="candidate_guardian_address" aria-describedby="candidate_guardian_address"
                    required>{{old('address', $candidate_guardian->home_address ?? '') }}</textarea>
            </div>
        </div>
    </div>
    <div class="wrapper-form" id="wrapper-form-guard">
        <h2>Kontak Wali Yang Dapat Dihubungi</h2>
        <div class="container">
            <div class="wrapper-input">
                <label for="candidate_guardian_office_phone_number">Nomor Telepon Kantor Wali</label>
                <input type="text" inputmode="numeric" name="candidate_guardian_office_phone_number"
                    id="candidate_guardian_office_phone_number" minlength="1"
                    aria-describedby="candidate_guardian_office_phone_number"
                    value="{{ old('candidate_guardian_office_phone_number', $candidate_guardian->office_phone_number ?? '') }}">
            </div>
            <div class="wrapper-input">
                <label for="candidate_guardian_home_phone_number">Nomor Telepon Rumah Wali</label>
                <input type="text" inputmode="numeric" name="candidate_guardian_home_phone_number"
                    id="candidate_guardian_home_phone_number" minlength="1" aria-describedby="candidate_guardian_home_phone_number"
                    value="{{ old('candidate_guardian_home_phone_number', $candidate_guardian->home_phone_number ?? '') }}">
            </div>
            <div class="wrapper-input">
                <label for="candidate_guardian_phone_number">Nomor Telepon Wali <span>*</span></label>
                <input type="text" inputmode="numeric" name="candidate_guardian_phone_number" id="candidate_guardian_phone_number"
                    minlength="11" minlength="12" aria-describedby="candidate_guardian_phone_number"
                    value="{{ old('candidate_guardian_phone_number', $candidate_guardian->phone_number ?? '') }}" required>
            </div>
        </div>
    </div>
</div>

<script defer>
    document.querySelectorAll('#wrapper-form-guard').forEach(element => {
        element.querySelector('h2').addEventListener('click', (e) => {
            Array.from(e.target.parentElement.children).forEach((wrapper, index) => {
                if (index == 0) return;
                wrapper.classList.toggle('hidden');
                element.classList.toggle('wrapper-form-border');
            })
        })
    })
</script>
