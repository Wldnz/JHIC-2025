@php
    $guardian_types = [
        'father' => 'Ayah',
        'mother' => 'Ibu',
        'other' => 'Wali Calon Peserta Didik'
    ];

    $monthly_incomes = [
        'Dibawah 500 Ribu',
        'Sekitar 500 Ribu - 1 Juta',
        'Sekitar 1 Juta - 5 Juta',
        'Diatas 5 Juta',
    ];

@endphp
<div class="form-data-profile" id="candidate-guard-form">
    @foreach ($candidate->candidateGuardians as $guardian)
        @foreach ($guardian_types as $type => $type_guardian_indonesia)
            @if($guardian->guardian_type == $type)
                @php
                    unset($guardian_types[$type])
                @endphp
                <div class="wrapper-form" id="wrapper-form-guard">
                    <h2>Data Pribadi {{ $type_guardian_indonesia }}</h2>
                    <div class="container container-3">
                        <div class="wrapper-input">
                            <label for="{{ $type }}_name">Nama Lengkap</label>
                            <input type="text" name="{{ $type }}_name" id="{{ $type }}_name" minlength="1"
                                aria-describedby="{{ $type }}_name" value="{{ old($type . '_name', $guardian->full_name) }}"
                                required>
                        </div>
                        <div class="wrapper-input">
                            <label for="{{ $type }}_birthplace">Tempat Lahir</label>
                            <input type="text" name="{{ $type }}_birthplace" id="{{ $type }}_birthplace" minlength="1"
                                aria-describedby="{{ $type }}_birthplace"
                                value="{{ old($type . '_birthplace', $guardian->birthplace) }}" required>
                        </div>
                        <div class="wrapper-input">
                            <label for="{{ $type }}_birthdate">Tanggal Lahir</label>
                            <input type="date" inputmode="numeric" name="{{ $type }}_birthdate" id="{{ $type }}_birthdate"
                                minlength="1" aria-describedby="{{ $type }}_birthdate"
                                value="{{ old($type . '_birthdate', substr($guardian->birthdate, 0, 10)) }}" required>
                        </div>
                        <div class="wrapper-input">
                            <label for="{{ $type }}_education">Pendidikan</label>
                            <input type="text" name="{{ $type }}_education" id="{{ $type }}_education" minlength="1"
                                aria-describedby="{{ $type }}_education"
                                value="{{ old($type . '_education', $guardian->education) }}" required>
                        </div>
                        <div class="wrapper-input">
                            <label for="{{ $type }}_job">Pekerjaan</label>
                            <input type="text" name="{{ $type }}_job" id="{{ $type }}_job" minlength="1"
                                aria-describedby="{{ $type }}_job" value="{{ old($type . '_job', $guardian->job) }}" required>
                        </div>
                        <div class="wrapper-input">
                            <label for="{{ $type }}_monthly_income">Penghasilan / Sebulan</label>
                            <select name="{{ $type }}_monthly_income" id="{{ $type }}_monthly_income" required>
                                @foreach ($monthly_incomes as $key => $monthly_income)
                                    <option value="{{ $key }}" @selected(old($type . '_monthly_income', $guardian->monthly_income) == $key)>
                                        {{ $monthly_income }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="wrapper-input">
                            <label for="{{ $type }}_citizenship">Kewarganegaraan</label>
                            <select name="{{ $type }}_citizenship" id="{{ $type }}_citizenship" required>
                                <option value="indonesia" @selected(old($type . '_citizinship', $guardian->citizenship) == 'indonesia')>
                                    Indonesia</option>
                                <option value="other" @selected(old($type . '_citizinship', $guardian->citizenship) == 'other')>
                                    Lainnya
                                </option>
                            </select>
                        </div>
                        <div class="wrapper-input">
                            <label for="{{ $type }}_religion">Agama</label>
                            <select name="{{ $type }}_religion" id="{{ $type }}_religion" required>
                                @foreach ($religions as $key => $religion)
                                    <option value="{{ $key }}" @selected(old($type . '_religion', $guardian->religion) == $key)>
                                        {{ $religion }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="wrapper-form" id="wrapper-form-guard">
                    <h2>Data Rumah {{ $type_guardian_indonesia }}</h2>
                    <div class="container container-3">
                        <div class="wrapper-input">
                            <label for="{{ $type }}_city">Kabupaten/Kota</label>
                            <input type="text" name="{{ $type }}_city" id="{{ $type }}_city" minlength="1"
                                aria-describedby="{{ $type }}_city" value="{{ old($type . '_city', $guardian->city) }}" required>
                        </div>
                        <div class="wrapper-input">
                            <label for="{{ $type }}_district">Kelurahan</label>
                            <input type="text" name="{{ $type }}_district" id="{{ $type }}_district" minlength="1"
                                aria-describedby="{{ $type }}_district" value="{{ old($type . '_district', $guardian->district) }}"
                                required>
                        </div>
                        <div class="wrapper-input">
                            <label for="{{ $type }}_sub_district">Kecamatan</label>
                            <input type="text" name="{{ $type }}_sub_district" id="{{ $type }}_sub_district" minlength="1"
                                aria-describedby="{{ $type }}_sub_district"
                                value="{{ old($type . '_sub_district', $guardian->sub_district) }}" required>
                        </div>
                        <div class="wrapper-input">
                            <label for="{{ $type }}_rt_rw">Kode Pos</label>
                            <input type="text" name="{{ $type }}_rt_rw" id="{{ $type }}_rt_rw" minlength="1"
                                aria-describedby="{{ $type }}_rt_rw" value="{{ old($type . '_rt_rw', $guardian->rt_rw) }}" required>
                        </div>
                        <div class="wrapper-input">
                            <label for="{{ $type }}_postal_code">RT/RW</label>
                            <input type="text" name="{{ $type }}_postal_code" id="{{ $type }}_postal_code" minlength="1"
                                aria-describedby="{{ $type }}_postal_code"
                                value="{{ old($type . '_postal_code', $guardian->postal_code) }}" required>
                        </div>
                        <div class="wrapper-input wrapper-input-full">
                            <label for="{{ $type }}_address">Alamat Rumah</label>
                            <textarea name="{{ $type }}_address" id="{{ $type }}_address" aria-describedby="{{ $type }}_address"
                                required>{{old('address', $guardian->home_address) }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="wrapper-form" id="wrapper-form-guard">
                    <h2>Kontak {{ $type_guardian_indonesia }} Yang Dapat Dihubungi</h2>
                    <div class="container">
                        <div class="wrapper-input">
                            <label for="{{ $type }}_office_phone_number">Nomor Telepon Kantor</label>
                            <input type="text" inputmode="numeric" name="{{ $type }}_office_phone_number"
                                id="{{ $type }}_office_phone_number" minlength="1"
                                aria-describedby="{{ $type }}_office_phone_number"
                                value="{{ old($type . '_office_phone_number', $guardian->office_phone_number) }}">
                        </div>
                        <div class="wrapper-input">
                            <label for="{{ $type }}_home_phone_number">Nomor Telepon Rumah</label>
                            <input type="text" inputmode="numeric" name="{{ $type }}_home_phone_number"
                                id="{{ $type }}_home_phone_number" minlength="1"
                                aria-describedby="{{ $type }}_home_phone_number"
                                value="{{ old($type . '_home_phone_number', $guardian->home_phone_number) }}">
                        </div>
                        <div class="wrapper-input">
                            <label for="{{ $type }}_phone_number">Nomor Telepon</label>
                            <input type="text" inputmode="numeric" name="{{ $type }}_phone_number" id="{{ $type }}_phone_number"
                                minlength="11" minlength="12" aria-describedby="{{ $type }}_phone_number"
                                value="{{ old($type . '_phone_number', $guardian->phone_number) }}" required>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    @endforeach
        @foreach ($guardian_types as $type => $type_guardian_indonesia)
            <div class="wrapper-form mt-25" id="wrapper-form-guard">
                <h2>Data Pribadi {{ $type_guardian_indonesia }}</h2>
                <div class="container container-3">
                    <div class="wrapper-input">
                        <label for="{{ $type }}_name">Nama Lengkap</label>
                        <input type="text" name="{{ $type }}_name" id="{{ $type }}_name" minlength="1"
                            aria-describedby="{{ $type }}_name" value="{{ old($type . '_name', '') }}" required>
                    </div>
                    <div class="wrapper-input">
                        <label for="{{ $type }}_birthplace">Tempat Lahir</label>
                        <input type="text" name="{{ $type }}_birthplace" id="{{ $type }}_birthplace" minlength="1"
                            aria-describedby="{{ $type }}_birthplace" value="{{ old($type . '_birthplace', '') }}" required>
                    </div>
                    <div class="wrapper-input">
                        <label for="{{ $type }}_birthdate">Tanggal Lahir</label>
                        <input type="date" inputmode="numeric" name="{{ $type }}_birthdate" id="{{ $type }}_birthdate"
                            minlength="1" aria-describedby="{{ $type }}_birthdate"
                            value="{{ old($type . '_birthdate', '') }}" required>
                    </div>
                    <div class="wrapper-input">
                        <label for="{{ $type }}_education">Pendidikan</label>
                        <input type="text" name="{{ $type }}_education" id="{{ $type }}_education" minlength="1"
                            aria-describedby="{{ $type }}_education" value="{{ old($type . '_education', '') }}" required>
                    </div>
                    <div class="wrapper-input">
                        <label for="{{ $type }}_job">Pekerjaan</label>
                        <input type="text" name="{{ $type }}_job" id="{{ $type }}_job" minlength="1"
                            aria-describedby="{{ $type }}_job" value="{{ old($type . '_job', '') }}" required>
                    </div>
                    <div class="wrapper-input">
                        <label for="{{ $type }}_monthly_income">Penghasilan / Sebulan</label>
                        <select name="{{ $type }}_monthly_income" id="{{ $type }}_monthly_income" required>
                            @foreach ($monthly_incomes as $key => $monthly_income)
                                <option value="{{ $key }}" @selected(old($type . '_monthly_income', '') == $key)>
                                    {{ $monthly_income }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="wrapper-input">
                        <label for="{{ $type }}_citizenship">Kewarganegaraan</label>
                        <select name="{{ $type }}_citizenship" id="{{ $type }}_citizenship" required>
                            <option value="indonesia" @selected(old($type . '_citizinship', '') == 'indonesia')>
                                Indonesia</option>
                            <option value="other" @selected(old($type . '_citizinship', '') == 'other')>Lainnya
                            </option>
                        </select>
                    </div>
                    <div class="wrapper-input">
                        <label for="{{ $type }}_religion">Agama</label>
                        <select name="{{ $type }}_religion" id="{{ $type }}_religion" required>
                            @foreach ($religions as $key => $religion)
                                <option value="{{ $key }}" @selected(old($type . '_religion', '') == $key)>
                                    {{ $religion }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="wrapper-form" id="wrapper-form-guard">
                <h2>Data Rumah {{ $type_guardian_indonesia }}</h2>
                <div class="container container-3">
                    <div class="wrapper-input">
                        <label for="{{ $type }}_city">Kabupaten/Kota</label>
                        <input type="text" name="{{ $type }}_city" id="{{ $type }}_city" minlength="1"
                            aria-describedby="{{ $type }}_city" value="{{ old($type . '_city', '') }}" required>
                    </div>
                    <div class="wrapper-input">
                        <label for="{{ $type }}_district">Kelurahan</label>
                        <input type="text" name="{{ $type }}_district" id="{{ $type }}_district" minlength="1"
                            aria-describedby="{{ $type }}_district" value="{{ old($type . '_district', '') }}" required>
                    </div>
                    <div class="wrapper-input">
                        <label for="{{ $type }}_sub_district">Kecamatan</label>
                        <input type="text" name="{{ $type }}_sub_district" id="{{ $type }}_sub_district" minlength="1"
                            aria-describedby="{{ $type }}_sub_district" value="{{ old($type . '_sub_district', '') }}"
                            required>
                    </div>
                    <div class="wrapper-input">
                        <label for="{{ $type }}_rt_rw">Kode Pos</label>
                        <input type="text" name="{{ $type }}_rt_rw" id="{{ $type }}_rt_rw" minlength="1"
                            aria-describedby="{{ $type }}_rt_rw" value="{{ old($type . '_rt_rw', '') }}" required>
                    </div>
                    <div class="wrapper-input">
                        <label for="{{ $type }}_postal_code">RT/RW</label>
                        <input type="text" name="{{ $type }}_postal_code" id="{{ $type }}_postal_code" minlength="1"
                            aria-describedby="{{ $type }}_postal_code" value="{{ old($type . '_postal_code', '') }}"
                            required>
                    </div>
                    <div class="wrapper-input wrapper-input-full">
                        <label for="{{ $type }}_address">Alamat Rumah</label>
                        <textarea name="{{ $type }}_address" id="{{ $type }}_address" aria-describedby="{{ $type }}_address"
                            required>{{old('address', '') }}</textarea>
                    </div>
                </div>
            </div>
            <div class="wrapper-form" id="wrapper-form-guard">
                <h2>Kontak {{ $type_guardian_indonesia }} Yang Dapat Dihubungi</h2>
                <div class="container">
                    <div class="wrapper-input">
                        <label for="{{ $type }}_office_phone_number">Nomor Telepon Kantor</label>
                        <input type="text" inputmode="numeric" name="{{ $type }}_office_phone_number"
                            id="{{ $type }}_office_phone_number" minlength="1"
                            aria-describedby="{{ $type }}_office_phone_number"
                            value="{{ old($type . '_office_phone_number', '') }}">
                    </div>
                    <div class="wrapper-input">
                        <label for="{{ $type }}_home_phone_number">Nomor Telepon Rumah</label>
                        <input type="text" inputmode="numeric" name="{{ $type }}_home_phone_number"
                            id="{{ $type }}_home_phone_number" minlength="1"
                            aria-describedby="{{ $type }}_home_phone_number"
                            value="{{ old($type . '_home_phone_number', '') }}">
                    </div>
                    <div class="wrapper-input">
                        <label for="{{ $type }}_phone_number">Nomor Telepon</label>
                        <input type="text" inputmode="numeric" name="{{ $type }}_phone_number"
                            id="{{ $type }}_phone_number" minlength="11" minlength="12"
                            aria-describedby="{{ $type }}_phone_number" value="{{ old($type . '_phone_number', '') }}"
                        required>
                    </div>
                </div>
            </div>
        @endforeach
        </div>

<script defer>
    document.querySelectorAll('#wrapper-form-guard').forEach(element => {
        element.querySelector('h2').addEventListener('click', (e) => {
            Array.from(e.target.parentElement.children).forEach((wrapper, index) => {
                if(index == 0)return;
                wrapper.classList.toggle('hidden');
                element.classList.toggle('wrapper-form-border');
            })
        })
    })
</script>        