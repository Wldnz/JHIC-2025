@include('_components._headerCandidate', [
    'title' => 'Formulir Tahap Pertama'
])
<main class="content">
    <div class="accessoris">
        <!-- {{-- <div class="rounded">
            <div class="round"></div>
        </div> --}} -->
        <div class="stars">
            <img src="{{ asset('images/trinkets/star.svg') }}" alt="star">
            <img src="{{ asset('images/trinkets/star.svg') }}" alt="star">
        </div>
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

@include('_components._footerCandidate')