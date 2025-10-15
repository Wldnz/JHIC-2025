<div class="form-data-profile" id="candidate-document-form">
    @foreach ($candidate->candidateDocuments ?? [] as $cd)
        @foreach($documents as $key => $document)
            @if($cd->name == $document->name)
                @php
                    unset($documents[$key]);
                @endphp
                <div class="wrapper-form">
                    <h2>{{ $document->name }}</h2>
                    <div class="container container-1">
                        <div class="wrapper-document">
                            <div class="wrapper-thumbnail">
                                <input type="file" accept="{{ $document->mime_types }}" name="documents[{{ $cd->id }}][file]">
                                <span>{{ $cd->name }}</span>
                            </div>
                            <a href="{{ route('admin.detail-account.download-document', ['account' => $candidate->user_id, 'candidateDocument' => $cd->id]) }}" download="{{ $cd->name }}" id="{{ $document->name }}_download">
                                @include('_components._sprite-icons', ['name' => 'convert', 'size' => 20])
                            </a>
                        </div>
                        <div class="wrapper-input">
                            <label for="documents[{{ $cd->id }}][is_valid]">Dokumen Sudah Valid</label>
                            <select name="documents[{{ $cd->id }}][is_valid]]" id="documents[{{ $cd->id }}][is_valid]">
                                <option value="0" @selected(old("documents.{$cd->id}.is_valid", $cd->is_valid ? '1' : '0') == '0')>Belum Valid</option>
                                <option value="1" @selected(old("documents.{$cd->id}.is_valid", $cd->is_valid ? '1' : '0') == '1')>Valid</option>
                            </select>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    @endforeach
    @foreach($documents as $document)
        <div class="wrapper-form">
            <h2>{{ $document->name }}</h2>
            <div class="container container-1">
                <div class="wrapper-document">
                    <div class="wrapper-thumbnail">
                        <input type="file" accept="{{ $document->mime_types }}" name="documents[added_{{ $document->name }}][file]" required>
                        <input type="hidden" name="documents[added_{{ $document->name }}][name]" value="{{ $document->name }}">
                        <input type="hidden" name="documents[added_{{ $document->name }}][mime_types]" value="{{ $document->mime_types }}">
                        <span id="{{ $document->name }}_preview_name">{{ $document->name }} (Tambahkan Uploud)</span>
                    </div>
                </div>
                <div class="wrapper-input">
                    <label for="documents[added_{{ $document->name }}][is_valid]">Dokumen Sudah Valid</label>
                    <select name="documents[added_{{ $document->name }}][is_valid]" id="documents[added_{{ $document->name }}][is_valid]">
                        <option value="0" @selected(old("documents.added_{$document->name}.is_valid") == '0')>Belum Valid</option>
                        <option value="1" @selected(old("documents.added_{$document->name}.is_valid") == '1')>Valid</option>
                    </select>
                </div>
            </div>
        </div>
    @endforeach
</div>

<script defer>
    document.querySelectorAll('.wrapper-thumbnail').forEach(e => {
        if(e.children[0].type === 'file'){
            e.children[0].addEventListener('change', (event) => {
                // const input_isUpdated = document.getElementById(event.target.name + '_updated');
                const input_isDownload = document.getElementById(event.target.name + '_download');
                const preview_name = document.getElementById(event.target.name + '_preview_name');
                const file = event.target.files[0];
                // if(input_isDownload && file) input_isUpdated.value = 1;
                // if(input_isDownload && !file) input_isUpdated.value = 0;
                if(file) preview_name.textContent = file.name;
                if(!file) preview_name.textContent = event.target.name + ' (Tambahkan Dokumen Disini)';
            });
        }
    });
</script>
