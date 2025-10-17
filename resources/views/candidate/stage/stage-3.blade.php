@include('_components._headerCandidate', [
    'title' => 'Formulir Tahap Ketiga'
])
<main class="content">
    <div class="stages">
        <div class="hero">
            <h2>Tahap Ketiga</h2>
            <div class="description">
                <h4>Memilah Gelombang Ujian Saringan Masuk</h4>
                <p>Calon Pesertadidik dapat mendaftar sebelum tanggal / termin yang telah ditetapkan dan selama kuota masih mencukupi. 30 Pesertadidik untuk masing – masing Jurusan.</p>
            </div>
        </div>
        <form class="form-stage" action={{ route('candidate.stage.save-stage2') }} method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <h2>Untuk Lanjut Ke Tahap Selanjutnya, Kamu Diwajibkan Memilih Gelombang USM Yang Tersedia</h2>
            <div class="fields">
                <p>Pilih Gelombang Ujian Saringan Masuk (min, max1) <span>*</span></p>
                <div class="wrapper-option-button wrapper-option-button-1">
                    @foreach($phases as $phase)
                        <button class="btn-major btn-phase" type="button" name="btn_{{ $phase->name }}" value="{{ $phase->id }}">
                            <span>{{ $phase->name}}</span>
                            <sup class="date">{{ substr($phase->started_at, 0,10) . ' - ' . substr($phase->ended_at, 0,10) }}</sup>
                        </button>
                    @endforeach
                </div>
                <div class="hidden" id="phase-section"></div>
            </div>
            <div class="fields">
                <div class="wrapper-input">
                    <label for="registration_source">Sumber Informasi Pendaftaran <span>*</span></label>
                    <div class="wrapper-select">
                        <select name="registration_source" id="registration_source" aria-describedby="registration_source" required>
                            <option value=""></option>
                            @foreach ($sources as $source)
                                <option value="{{ $source->id }}" @selected(old('registration_source', '') == $source->id)>{{ $source->name }}</option>
                            @endforeach
                        </select>
                        @include('_components._sprite-icons', [ 'name' => 'drop-down', 'size' => 25 ])
                    </div>
                </div>
                <div class="wrapper-input">
                    <label for="enrolling_reason">Alasan Masuk Sebagai Calon Peserta Didik<span>*</span></label>
                    <input type="text" name="enrolling_reason" id="enrolling_reason" placeholder="Alasan Masuk" value="{{ old('enrolling_reason') }}" aria-describedby="Alasan Masuk" minlength="6" required>
                </div>
            </div>
            <div class="s-submit">
                <p>Dengan menekan tombol "Simpan", data yang Anda cantumkan di atas adalah benar dan dapat dipertanggungjawabkan.</p>
                <div class="w-buttons">
                    <button class="submit-form" type="submit">Simpan Data</button>
                    <div class="pages">
                        @if ($isPaid ?? false)
                            <button class="pagination-action" type="button">Sebelumnya</button>
                            <button class="pagination-action" type="button">Selanjutnya</button>
                        @endif
                    </div>
                </div>
            </div>
        </form>
    </div>
</main>

<script defer>
    let currentPhase = @json($candidate->RegistrationPhase ?? []);
    const phases = @json($phases ?? []);

    function selectPhase(element){
        const currentStamps = new Date().getTime();
        const phase = phases.find(p => p.name == element.children[0].innerText);
        console.log(phase);

        if(phase && new Date(phase.ended_at).getTime() < currentStamps){
            return alert('Gelombang Sudah Tidak Tersedia!, Silahkan Pilih Gelombang Lain!');
        }else if(phase && phase.quota < 1){
            return alert(`Kuota Gelombang Pada ${phase.name} Sudah Habis!`);
        }

        currentPhase = {
            ...currentPhase,
            ...{
                selected_phase_id : phase.id,
                selected_phase_name : phase.name,
                selected_phase_id : phase.id
            }
        }
    }

    function loadSelectedPhase(){
        let stringHtml = '';
        document.querySelectorAll('.btn-phase').forEach(m => m.classList.remove('btn-phase-selected'));
        document.querySelectorAll('.btn-phase').forEach(element => {
            const isFound = currentPhase.selected_phase_name == element.children[0].textContent;
            if(isFound){
                element.classList.add('btn-phase-selected');
                stringHtml += makeObject(currentPhase);
            }
        });
        document.getElementById('phase-section').innerHTML = stringHtml;
    }

    function makeObject(phase){
        if(!phase) return;
        return `<input type="hidden" name="phase_id" value="${phase.selected_phase_id}" readonly>
        <input type="hidden" name="phase_name" value="${phase.selected_phase_name}" readonly>
        `;
    }

    document.querySelectorAll('.btn-phase').forEach(element => {
        element.addEventListener('click', (e) => {
            selectPhase(element);
            loadSelectedPhase();
        });
    });

</script>

@include('_components._footerCandidate')