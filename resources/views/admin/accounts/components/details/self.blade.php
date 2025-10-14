<div class="form-data-profile" id="candidate-self-form">
    <div class="wrapper-form">
        <h2>Data Pribadi</h2>
        <div class="container container-3">
            <div class="wrapper-input">
                <label for="gender">Jenis Kelamin <span>*</span></label>
                <select name="gender" id="gender" required>
                    <option value="male" @selected(old('gender', $candidate->gender) == 'male')>Laki - Laki</option>
                    <option value="female" @selected(old('gender', $candidate->gender) == 'female')>Perempuan</option>
                </select>
            </div>
            <div class="wrapper-input">
                <label for="religion">Agama <span>*</span></label>
                <select name="religion" id="religion" required>
                    @foreach ($religions as $key => $religion)
                        <option value="{{ $key }}" @selected(old('religion', $candidate->religion) == $key)>{{ $religion }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="wrapper-input">
                <label for="citizenship">Kewarganegraan <span>*</span></label>
                <select name="citizenship" id="citizenship" required>
                    <option value="indonesia" @selected(old('citizinship', $candidate->citizenship) == 'indonesia')>
                        Indonesia</option>
                    <option value="other" @selected(old('citizinship', $candidate->citizenship) == 'other')>Lainnya
                    </option>
                </select>
            </div>
            <div class="wrapper-input wrapper-input-full">
                <label for="address">Alamat Rumah <span>*</span></label>
                <textarea name="address" id="address" aria-describedby="address"
                    required>{{old('address', $candidate->address) }}</textarea>
            </div>
        </div>
    </div>
    <div class="wrapper-form">
        <h2>Data Keluarga</h2>
        <div class="container">
            <div class="wrapper-input">
                <label for="status_family">Status Dalam Keluarga <span>*</span></label>
                <select name="status_family" id="status_family" required>
                    @foreach ($status_families as $key => $status_family)
                        <option value="{{ $key }}" @selected(old('status_family', $candidate->status_family) == $key)>
                            {{ $status_family }}</option>
                    @endforeach
                </select>
            </div>
            <div class="wrapper-input">
                <label for="order_family">Anak Ke <span>*</span></label>
                <input type="text" inputmode="numeric" name="order_family" id="order_family" minlength="1"
                    aria-describedby="order_family" value="{{ old('order_family', $candidate->order_family) }}"
                    required>
            </div>
            <div class="wrapper-input">
                <label for="order_family">Jumlah Saudara Kandung <span>*</span></label>
                <input type="text" inputmode="numeric" name="sum_siblings" id="sum_siblings" minlength="1"
                    aria-describedby="sum_siblings" value="{{ old('sum_siblings', $candidate->sum_siblings) }}"
                    required>
            </div>
            <div class="wrapper-input">
                <label for="sum_half_siblings">Jumlah Saudara Tiri <span>*</span></label>
                <input type="text" inputmode="numeric" name="sum_half_siblings" id="sum_half_siblings" minlength="1"
                    aria-describedby="sum_half_siblings"
                    value="{{ old('sum_half_siblings', $candidate->sum_half_siblings) }}" required>
            </div>
            <div class="wrapper-input">
                <label for="sum_adopted_siblings">Jumlah Saudara Adopsi <span>*</span></label>
                <input type="text" inputmode="numeric" name="sum_adopted_siblings" id="sum_adopted_siblings"
                    minlength="1" aria-describedby="sum_adopted_siblings"
                    value="{{ old('sum_adopted_siblings', $candidate->sum_adopted_siblings) }}" required>
            </div>
        </div>
    </div>

    <div class="wrapper-form">
        <h2>Kontak Yang Dapat Dihubungi</h2>
        <div class="container">
            <div class="wrapper-input">
                <label for="phone">Nomor Telepon <span>*</span></label>
                <input type="text" inputmode="numeric" name="phone" id="phone" placeholder="081234567890" minlength="11"
                    maxlength="12" aria-describedby="phone" value="{{ old('phone', $candidate->phone) }}" required>
            </div>
            <div class="wrapper-input">
                <label for="email">Alamat Email <span>*</span></label>
                <input type="email" name="email" id="email" placeholder="name@example.com" minlength="8"
                    aria-describedby="email" value="{{ old('email', $account->email) }}" required>
            </div>
        </div>
    </div>

    <div class="wrapper-form">
        <h2>Asal Sekolah</h2>
        <div class="container">
            <div class="wrapper-input wrapper-input-full">
                <label for="origin_school">Asal Sekolah <span>*</span></label>
                <input type="text" inputmode="numeric" name="origin_school" id="origin_school"
                    placeholder="SMP LIMA DASAR 04" minlength="6" aria-describedby="origin_school"
                    value="{{ old('origin_school', $candidate->origin_school) }}" required>
            </div>
            <div class="wrapper-input wrapper-input-full">
                <label for="origin_school_address">Alamat Sekolah <span>*</span></label>
                <textarea type="origin_school_address" name="origin_school_address" id="origin_school_address"
                    placeholder="Jalan Abc, 154423" minlength="10" aria-describedby="origin_school_address"
                    required>{{ old('origin_school_address', $candidate->origin_school_address) }}</textarea>
            </div>
            <div class="wrapper-input wrapper-input-full">
                <label for="enrolling_reason">Alasan Masuk <span>*</span></label>
                <textarea type="enrolling_reason" name="enrolling_reason" id="enrolling_reason"
                    placeholder="Saya ingin menjadi orang yang hebat & disiplin" minlength="10"
                    aria-describedby="enrolling_reason"
                    required>{{ old('enrolling_reason', $candidate->candidatePhases->enrolling_reason ?? '') }}</textarea>
            </div>
        </div>
    </div>

    <div class="wrapper-form">
        <h2>Minat Jurusan (max* 2)</h2>
        <div class="container">
            <div class="wrapper-choose">
                @foreach ($majors as $major)
                    @foreach ($candidate->candidateMajors as $selected_major)
                        <div class="choose-card {{ $selected_major->major_short_name == $major->short_name ? 'choose-card-selected' : '' }}"
                            id="major-card">
                            <span>{{ $major->long_name }}</span>
                        </div>
                    @endforeach
                @endforeach
            </div>
            <div class="choosen-major" id="choosen-majors" style="display:none">

            </div>
        </div>
    </div>

    <div class="wrapper-form">
        <h2>Gelombang USM <span>*</span></h2>
        <div class="container container-1">
            <div class="wrapper-phase">
                @foreach ($phases as $phase)
                    <div class="phase-card {{ $candidate->registrationPhase->id ?? '' == $phase->id ? 'phase-card-selected' : '' }}"
                        id="phase-card">
                        <span>{{ $phase->name }}</span>
                    </div>
                @endforeach
            </div>
            <div class="choosen-phase" id="choosen-phase" style="display:none">
            </div>
        </div>
    </div>

    <div class="wrapper-form">
        <h2>Sumber Informasi Masuk <span>*</span></h2>
        <div class="container container-1">
            <div class="wrapper-input">
                <select name="registration_source" id="registration_source" required>
                    @foreach ($sources as $source)
                        <option value="{{ $source->id }}" @selected(old('registration_source', $candidate->registrationSource->id ?? '') ?? $source->id)>{{ $source->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="choosen-phase" id="choosen-phase" style="display:none">
            </div>
        </div>
    </div>    

</div>