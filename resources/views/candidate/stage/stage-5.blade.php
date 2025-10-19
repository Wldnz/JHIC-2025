@include('_components._headerCandidate', [
    'title' => 'Formulir Tahap Kelima'
])

@php
    $currentDocuments = [];
    foreach($candidateDocuments as $candidateDocument){
        foreach($documents as $key=>$document){
            $isFound = array_search([ ['name' => $document->name] ], $currentDocuments);
            if($document->name == $candidateDocument['name'] && !$isFound){
                array_push($currentDocuments, $candidateDocument);
            }else if($document->name != $candidateDocument['name'] && !$isFound){
                array_push($currentDocuments, $document);
            }
            unset($documents[$key]);
        }
    }
    if(count($currentDocuments) == 0) $currentDocuments = $documents;
@endphp

<main class="content">
    <div class="accessoris">
        <div class="stars">
            <img src="{{ asset('images/trinkets/star.svg') }}" alt="star">
            <img src="{{ asset('images/trinkets/star.svg') }}" alt="star">
        </div>
    </div>
    <div class="stages">
        <div class="hero">
            <h2>Tahap Kelima</h2>
            <div class="description">
                <h4>Mengisi Surat Pendukung Pendaftaran</h4>
                <p>Calon peserta didik melakuakan pendaftaran tahap terakhir, yakni menguploud surat - surat pendukung</p>
            </div>
        </div>
        <form class="form-stage" action={{ route('candidate.stage.save-stage5') }} method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="fields fields-document">
                @foreach ($currentDocuments as $document)
                       @if($document['is_required'] ?? false)
                        <div class="wrapper-document">
                         <div class="wrapper-file">
                            <p class="floating-title">{{ $document['name'] }} <span>*</span></p>
                            <p class="description">Belum Uploud Dokumen</p>
                            <input type="file" accept="{{ $document['mime_types'] }}" id="{{ $document['name'] }}" name="{{ $document['id'] }}" aria-describeBy="biodata"
                              @required($document['is_required'])
                              class="input-form-uploud"
                            >
                        </div>
                        @else
                         <div class="wrapper-document">
                         <div class="wrapper-file">
                            <p class="floating-title">{{ $document['name'] }} {{  $document['is_valid'] ? ' (Valid)' : '' }} <span class="{{ $document['is_valid'] ? 'hidden' : ''  }}">*</span></p>
                            <p class="description">{{ $document['is_valid']? 'Dokumen Sudah Valid' : 'Dokumen Sedang Diperiksa/Tidak Valid!' }}</p>
                            <input type="file" accept="{{ $document['mime_types'] }}" id="{{ $document['name'] }}" name="{{ $document['id'] }}" aria-describeBy="biodata"
                              @required(!$document['is_valid'])
                              @disabled($document['is_valid'])
                              class="input-form-uploud"
                            >
                        </div>
                       @endif
                    @if ($document['download_file_url'] ?? false)
                        <span class="download">
                            Download File : <a class="link"
                            href="{{ $document['download_file_url'] }}"
                            download="{{ $document['name'] }}"
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
                       @if ($isAllUplouds)
                            <div class="pages">
                                <button class="pagination-action" type="button" onclick="location.href='{{ route('candidate.stage.stage4') }}'">Sebelumnya</button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </form>
    </div>
</main>

<script defer>
    document.querySelectorAll('.input-form-uploud').forEach(element => {
       element.addEventListener('change', (e) => {
            const descriptionFile = e.target.parentElement.querySelector('.description');
            const file = e.target.files[0];
            if(!file) return;
            descriptionFile.textContent = file.name;
        });
    })
</script>

@include('_components._footerCandidate')
