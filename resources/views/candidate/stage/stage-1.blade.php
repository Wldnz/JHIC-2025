@include('_components._headerCandidate', [
    'title' => 'Formulir Tahap Pertama'
])
<main class="content">
    <div class="accessoris">
        <div class="stars">
            <img src="{{ asset('images/trinkets/star.svg') }}" alt="star">
            <img src="{{ asset('images/trinkets/star.svg') }}" alt="star">
        </div>
    </div>
    <div class="stages">
        <div class="hero">
            <h2>Tahap Pertama</h2>
            <div class="description">
                <h4>Membeli Formulir Pendaftaran</h4>
                <p>Calon peserta didik melakuakan pendaftaran tahap pertama, yakni melakukan pembayaran untuk mengakases formulir pendaftaran</p>
            </div>
        </div>
        <form class="form-stage" action={{ route('candidate.stage.save-stage1') }} method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <h2>{{ Auth::user()->fullname }}, Langkah pertama ini kamu diwajibkan untuk mengisi data diri kamu ya!</h2>
            @if (!$isPaid ?? false)
                <h2>Informasi Pembayaran & Rekening Bank</h2>
                <div class="fields">
                    <div class="wrapper-input wrapper-information">
                        <label for="type">Biaya Dibutuhkan Untuk</label>
                        <span id="type">Pembelian Formulir Online</span>
                    </div>
                    <div class="wrapper-input wrapper-information">
                        <label for="price">Pilih Metode Pembayaran</label>
                        <span class="price" id="price">Rp. 250.000,00</span>
                    </div>
                    <div class="wrapper-input wrapper-information">
                        <label for="payment_method">Pilih Metode Pembayaran</label>
                        <div class="wrapper-select">
                            <select name="payment_method" id="payment_method" aria-describedby="payment_method" required>
                                <option value=""></option>
                                @foreach ($payments as $payment)
                                    <option value="{{ $payment->code_name }}" @selected(old('payment_method') == $payment->code_name)>{{ $payment->display_name }}</option>
                                @endforeach
                            </select>
                            @include('_components._sprite-icons', [ 'name' => 'drop-down', 'size' => 25 ])
                        </div>
                    </div>
                </div>
            @endif
            <br>
            <div class="fields">
                <p>Selanjutnya, Isi Data Berikut Ini Ya!</p>
                 <div class="wrapper-input">
                    <label for="nisn">Nomor Induk Nasional (NISN) <span>*</span></label>
                    <input type="text" inputmode="numeric" 
                    name="nisn" id="nisn" placeholder="Masukkan Nomor Induk Nasional" value="{{ old('nisn', ) }}" aria-describedby="Masukkan Nomor Induk Nasional" 
                    minlength="10" maxlength="10" @required(!$isPaid)
                    @disabled($isPaid)
                >
                </div>
            </div>
             <div class="fields">
                <p>Minat Jurusan (min, 1 - max 2) <span>*</span></p>
                <div class="wrapper-option-button">
                   @foreach($majors as $major)
                        <button class="btn-major" type="button" name="btn_{{ $major->long_name }}" value="{{ $major->id }}">{{ $major->long_name }}</button>
                   @endforeach
                </div>
                <div class="hidden" id="majors-section">
                    
                </div>
            </div>
            <div class="s-submit">
                <p>Dengan menekan tombol "Simpan", data yang Anda cantumkan di atas adalah benar dan dapat dipertanggungjawabkan.</p>
                <div class="w-buttons">
                    <button class="submit-form" type="submit">{{ $isPaid  ? 'Simpan Data' : 'Buat Transaksi' }}</button>
                    @if ($isPaid ?? false)
                        <div class="pages pages-1">
                            <button class="pagination-action" type="button" onclikc="location.href='{{ route('candidate.stage.stage2')  }}'">Selanjutnya</button>
                        </div>
                    @endif
                </div>
            </div>
        </form>
    </div>
</main>

<script defer>
    let currentMajors = @json($candidate->majors ?? []);
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

    loadSelectedMajor();

</script>

@include('_components._footerCandidate')
