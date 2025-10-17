@include('_components._headerCandidate', [
    'title' => 'Formulir Tahap Kelima'
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
            <h2>Tahap Kelima</h2>
            <img src="{{ asset('images/usm/dashboard/step1.png') }}" alt="usm_step_1">
            <div class="description">
                <h4>Mengisi Surat Pendukung Pendaftaran</h4>
                <p>Calon peserta didik melakuakan pendaftaran tahap terakhir, yakni menguploud surat - surat pendukung</p>
            </div>
        </div>
        <form class="form-stage" action={{ route('candidate.stage.save-stage5') }} method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="fields fields-document">
                @foreach ($documents as $document)
                    <div class="wrapper-document">
                        <div class="wrapper-file">
                            <p class="floating-title">{{ $document->name }} <span>*</span></p>
                            <p class="description">{{ $as ?? 'Belum ada file yang diuploud nih' }}</p>
                            <input type="file" accept="{{ $document->mime_types }}" id="{{ $document->name }}" name="{{ $document->id }}" aria-describeBy="biodata" @required($document->is_required)>
                        </div>
                        @if ($document->download_file_url)
                            <span class="download">
                                Download File : <a class="link"
                                href="{{ $document->download_file_url }}"
                                download="{{ $document->name }}"
                                >Klik Disini..</a>
                            </span>
                        @endif
                    </div>
                @endforeach
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
