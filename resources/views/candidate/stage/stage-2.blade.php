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
        <form class="form-stage" action={{ route('candidate.stage.save-stage1') }} method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="fields">
                <div class="wrapper-document">
                    <div class="wrapper-file">
                        <p class="floating-title">Formulir Biodata Calon Peserta Didik <span>*</span></p>
                        <p class="description">Belum ada file yang diuploud nih</p>
                        <input type="file" accept="application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document" id="biodata_form" name="biodata_form" aria-describeBy="formulir" required>
                    </div>
                    <span class="download">
                        Download File : <a class="link"
                        href="https://cdn.discordapp.com/attachments/1153188890526621697/1428344759327526972/Formulir_-_Biodata_2026-2027._Pdf.pdf?ex=68f22937&is=68f0d7b7&hm=3dd6d50b90af1b4d34d7da0d76b3fd2aebb6d80e1ed18291004960870749692e&" 
                        download="formulir Biodata Binfor 2026-2025"
                        >Formulir Biodatau.docs</a>
                    </span>
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
    let descriptionFile = null;
    document.getElementById('biodata_form').addEventListener('change', (e) => {
        if(descriptionFile == null) descriptionFile = e.target.parentElement.querySelector('.description');
        const file = e.target.files[0];
        if(!file) return;
        descriptionFile.textContent = file.name;
    });
</script>

@include('_components._footerCandidate')