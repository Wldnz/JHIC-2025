@include('_components._headerCandidate', [
    'title' => 'Formulir Tahap Kedua'
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
            <h2>Tahap Kedua</h2>
            <div class="description">
                <h4>Mengisi Data Diri & Asal Sekolah</h4>
                <p>Calon peserta didik melakuakan pendaftaran tahap pertama, yakni pendaftaran data diri</p>
            </div>
        </div>
        <form class="form-stage" action={{ route('candidate.stage.save-stage2') }} method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="fields">
                <div class="wrapper-document">
                    <div class="wrapper-file">
                        <p class="floating-title">{{ $formDocument->name }} <span>*</span></p>
                        <p class="description">Belum ada file yang diuploud nih</p>
                        <input type="file" accept="{{ $formDocument->mime_types }}" id="biodata_form" name="biodata_form" aria-describeBy="formulir" required>
                    </div>
                    <span class="download">
                        Download File : <a class="link"
                        href="{{ $formDocument->download_file_url ?? '' }}"
                        download="formulir Biodata Binfor 2026-2025"
                        >Formulir Biodatau.docs</a>
                    </span>
                </div>
            </div>
            <div class="s-submit">
                <p>Dengan menekan tombol "Simpan", data yang Anda cantumkan di atas adalah benar dan dapat dipertanggungjawabkan.</p>
                <div class="w-buttons">
                    <button class="submit-form" type="submit">Simpan Data</button>
                    @if ($formDocument)
                        <div class="pages">
                            <button class="pagination-action" type="button" onclick="location.href='{{ route('candidate.stage1') }}'">Sebelumnya</button>
                            <button class="pagination-action" type="button" onclick="location.href='{{ route('candidate.stage3') }}'">Selanjutnya</button>
                        </div>
                    @endif
                </div>
            </div>
        </form>
    </div>
</main>

<script defer>
    let descriptionFile = null;
    document.getElementById('biodata_form').addEventListener('change', (e) => {
        if(descriptionFile == null) descriptionFile = e.target.parentElement.querySelector('.description');
        const file = e.target.files[0];
        if(!file) return;
        descriptionFile.textContent = file.name;
    });
</script>

@include('_components._footerCandidate')
