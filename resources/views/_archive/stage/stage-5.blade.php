@include('_components._headerCandidate', [
    'title' => 'Dashboard Calon Peserta Didik'
])
<main class="content">
    {{-- <div class="accessoris">
        <div class="rounded">
            <div class="round"></div>
        </div>
        <div class="stars">
            <img src="{{ asset('images/trinkets/star.svg') }}" alt="star">
            <img src="{{ asset('images/trinkets/star.svg') }}" alt="star">
        </div> --}}
    </div>
    <div class="stages">
        <div class="hero">
            <h2>Tahap Pertama</h2>
            <img src="{{ asset('images/usm/dashboard/step1.png') }}" alt="usm_step_1">
            <div class="description">
                <h4>Mengisi Data Diri & Asal Sekolah</h4>
                <p>Calon peserta didik melakuakan pendaftaran tahap pertama, yakni pendaftaran data diri</p>
            </div>
        </div>
        <form class="form-stage" action={{ route('candidate.stage.save-stage1') }} method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <h2>{{ Auth::user()->fullname }}, Langkah pertama ini kamu diwajibkan untuk mengisi data diri kamu ya!</h2>
            <div class="fields">
                <div class="wrapper-input">
                    <label for="nisn">Nomor Induk Nasional (NISN) <span>*</span></label>
                    <input type="text" inputmode="numeric" name="nisn" id="nisn" placeholder="Masukkan Nomor Induk Nasional" value="{{ old('nisn') }}" aria-describedby="Masukkan Nomor Induk Nasional" minlength="10" maxlength="10" required>
                </div>
                  <div class="wrapper-input">
                    <label for="fullname">Nama Lengkap  <span>*</span></label>
                    <input type="text" name="fullname" id="fullname" placeholder="Masukkan Nama Lengkap" value="{{ old('fullname') }}" aria-describedby="Masukkan Nama Lengkap" minlength="3" required>
                </div>
                  <div class="wrapper-input">
                    <label for="short_name">Nama Panggilan</label>
                    <input type="text" name="short_name" id="short_name" placeholder="Masukkan Panggilan" value="{{ old('short_name') }}" aria-describedby="Masukkan Nama Panggilan" minlength="3" required>
                </div>
                <div class="wrapper-input">
                    <label for="birthplace">Tempat Lahir <span>*</span></label>
                    <input type="text" name="birthplace" id="birthplace" placeholder="Masukkan Tempat Lahir" value="{{ old('birthplace') }}" aria-describedby="Masukkan Tempat Lahir" minlength="3" required>
                </div>
                <div class="wrapper-input-multiple">
                    <div class="wrapper-input">
                        <label for="birthdate">Tanggal Lahir <span>*</span></label>
                        <input type="date" inputmode="numeric" name="birthdate" id="birthdate" placeholder="Masukkan Tanggal Lahir" value="{{ old('birthdate') }}" aria-describedby="Masukkan Tanggal Lahir" required>
                    </div>
                    <div class="wrapper-input">
                        <label for="gender">Jenis Kelamin <span>*</span></label>
                        <div class="wrapper-select">
                            <select name="gender" id="gender" aria-describedby="Jenis Kelamin" required>
                                <option value=""></option>
                                <option value="male" @selected(old('gender', '') == 'male')>Laki - Laki</option>
                                <option value="female" @selected(old('gender', '') == 'female')>Perempuan</option>
                            </select>
                        </div>
                    </div>
                    <div class="wrapper-input">
                        <label for="religion">Agama <span>*</span></label>
                        <div class="wrapper-select">
                            <select name="religion" id="religion" aria-describedby="Agama" required>
                                <option value=""></option>
                                <option value="islam" @selected(old('religion', '') == 'islam')>Islam</option>
                                <option value="catholic" @selected(old('religion', '') == 'catholic')>Katolik</option>
                                <option value="protestant" @selected(old('religion', '') == 'protestant')>Protestan</option>
                                <option value="hindu" @selected(old('religion', '') == 'hindu')>Hindu</option>
                                <option value="buddha" @selected(old('religion', '') == 'buddha')>Buddha</option>
                                <option value="confucian" @selected(old('religion', '') == 'confucian')>Konghucu</option>
                                <option value="other" @selected(old('religion', '') == 'other')>Other</option>
                            </select>
                        </div>
                    </div>
                    <div class="wrapper-input">
                        <label for="citizenship">Kewarganegaraan <span>*</span></label>
                        <div class="wrapper-select">
                            <select name="citizenship" id="citizenship" aria-describedby="citizenship" required>
                                <option value=""></option>
                                <option value="indonesia" @selected(old('citizenship', '') == 'indonesia')>Indonesia</option>
                                <option value="other" @selected(old('citizenship', '') == 'other')>Lainnya</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="wrapper-input">
                    <label for="address">Alamat Rumah <span>*</span></label>
                    <textarea name="address" id="address" placeholder="Masukkan alamat rumah" required aria-describedby="alamat rumah">{{ old('address') }}</textarea>
                </div>
                <div class="wrapper-input">
                    <label for="status_family">Status Dalam Keluarga<span>*</span></label>
                   <div class="wrapper-select">
                        <select name="status_family" id="status_family" aria-describedby="Status Dalam Keluarga" required>
                            <option value=""></option>
                            <option value="biological_child" @selected(old('status_family', '') == 'biological_child')>Anak Kandung</option>
                            <option value="adpted_child" @selected(old('status_family', '') == 'adpted_child')>Anak Angkat</option>
                            <option value="step_child" @selected(old('status_family', '') == 'step_child')>Anak Tiri</option>
                            <option value="foster_child" @selected(old('status_family', '') == 'foster_child')>Anak Asuh</option>
                        </select>
                    </div>
                </div>
                <div class="wrapper-input-multiple wrapper-input-multiple-1">
                    <div class="wrapper-input">
                        <label for="order_familly">Anak Ke<span>*</span></label>
                        <input type="text" inputmode="numeric" name="order_familly" id="order_familly" placeholder="Anak Ke" value="{{ old('order_familly') }}" aria-describedby="Anak Ke" minlength="1" required>
                    </div>
                     <div class="wrapper-input">
                        <label for="sum_siblings">Jumlah Saudara Kandung<span>*</span></label>
                        <input type="text" inputmode="numeric" name="sum_siblings" id="sum_siblings" placeholder="Jumlah Saudara Kandung" value="{{ old('sum_siblings') }}" aria-describedby="Jumlah Saudara Kandung" minlength="1" required>
                    </div>
                      <div class="wrapper-input">
                        <label for="sum_half_siblings">Jumlah Saudara Tiri<span>*</span></label>
                        <input type="text" inputmode="numeric" name="sum_half_siblings" id="sum_half_siblings" placeholder="Jumlah Saudara Tiri" value="{{ old('sum_half_siblings') }}" aria-describedby="Jumlah Saudara Tiri" minlength="1" required>
                    </div>
                      <div class="wrapper-input">
                        <label for="sum_adopted_siblings">Jumlah Saudara Angkat<span>*</span></label>
                        <input type="text" inputmode="numeric" name="sum_adopted_siblings" id="sum_adopted_siblings" placeholder="Jumlah Saudara Angkat" value="{{ old('sum_adopted_siblings') }}" aria-describedby="Jumlah Saudara Angkat" minlength="1" required>
                    </div>
                </div>
                <div class="wrapper-input">
                    <label for="phone">Nomor Telepon (WhastApp)<span>*</span></label>
                    <input type="text" name="phone" id="phone" placeholder="Masukkan Nomor Telepon" value="{{ old('phone') }}" aria-describedby="Masukkan Nomor Telepon" minlength="11" maxlength="12" required>
                </div>
            </div>
            <div class="s-submit">
                <p>Dengan menekan tombol "Simpan", data yang Anda cantumkan di atas adalah benar dan dapat dipertanggungjawabkan.</p>
                <div class="w-buttons">
                    <button class="submit-form" type="submit">Simpan Data</button>
                    <div class="pages">
                        <button class="pagination-action" type="button">Sebelumnya</button>
                        <button class="pagination-action" type="button">Selanjutnya</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</main>

<script defer>
    let currentMajors = [];
    const majors = @json($majors ?? []);

    function selectMajor(element){
        if(currentMajors.length > 1){
            currentMajors.shift();
        }
        const { id, long_name, short_name } = majors.find(m => m.long_name == element.textContent);
        if(!id) return;
        currentMajors.push({
            id : `updated_major_${new Date().getTime()}`,
            major_id : id,
            major_long_name : long_name,
            major_short_name : short_name
        });
    }

    function deleteMajor(element){
        if(currentMajors.length <= 1) return;
        const { id, long_name } = majors.find(m => m.long_name == element.textContent);
        if(!id) return;
        currentMajors = currentMajors.filter(cm => cm.major_long_name != long_name);
    }

    function loadSelectedMajor(){
        let stringHtml = '';
        document.querySelectorAll('.btn-major').forEach(m => m.classList.remove('btn-major-selected'));
        document.querySelectorAll('.btn-major').forEach(m => {
            const isFound = currentMajors.find(cm => cm.major_long_name == m.textContent);
            if(isFound){
                m.classList.add('btn-major-selected');
                stringHtml += makeObject(isFound);
            }
        });
        document.getElementById('majors-section').innerHTML = stringHtml;
    }

    function makeObject(major){
        if(!major) return;
        return `<input type="hidden" name="majors[${major.id}]" value="${major.id}" readonly>
        <input type="hidden" name="majors[${major.id}]" value="${major.major_short_name}" readonly>
        <input type="hidden" name="majors[${major.id}]" value="${major.major_long_name}" readonly>
        `
    }

    document.querySelectorAll('.btn-major').forEach(element => {
        element.addEventListener('click', (e) => {
            selectMajor(element);
            loadSelectedMajor();
        });
        element.addEventListener('dblclick', (e) => deleteMajor(element));
    });

</script>

@include('_components._footerCandidate')