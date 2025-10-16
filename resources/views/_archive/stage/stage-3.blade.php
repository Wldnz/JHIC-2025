@include('_components._headerCandidate', [
    'title' => 'Dashboard Calon Peserta Didik'
])
<main class="content">
    <div class="stages">
        <div class="hero">
            <h2>Tahap Ketiga</h2>
            <img src="{{ asset('images/usm/dashboard/step3.png') }}" alt="usm_step_1">
            <div class="description">
                <h4>Konfirmasi Pembayaran</h4>
                <p>Calon Peserta Didik Melengkapi Identitas Diri, Sekolah Asal, dan Memilih Gelombang USM pesertadidik dapat melakukan konfirmasi Pembayaran Biaya Pendaftaran & Sandang.</p>
            </div>
        </div>
        <form class="form-stage" action={{ route('candidate.stage.save-stage2') }} method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
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
            <div class="s-submit">
                <p>Dengan menekan tombol "Simpan", data yang Anda cantumkan di atas adalah benar dan dapat dipertanggungjawabkan.</p>
                <div class="w-buttons">
                    <button class="submit-form" type="submit">Buat Transaksi</button>
                    <div class="pages">
                        <!-- <button class="pagination-action" type="button">Sebelumnya</button>
                        <button class="pagination-action" type="button">Selanjutnya</button> -->
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