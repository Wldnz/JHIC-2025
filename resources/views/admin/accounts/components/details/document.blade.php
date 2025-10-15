<div class="form-data-profile" id="candidate-document-form">
   @foreach ($candidate->candidateDocuments ?? [] as $cd)
    @foreach($documents as $document)
        @if($cd->name == $document->name)
            <div class="wrapper-form">
                <h2>{{ $document->name }}</h2>
                <div class="container container-1">
                    <div class="wrapper-document">
                        <div class="wrapper-thumbnail">
                            <input type="file" accept="{{ $document->mime_types }}" name="documents[{{ $cd->id }}][file]">
                            <span>{{ $cd->name }}</span>
                        </div>
                    </div>
                    <div class="wrapper-input">
                        <label for="{{ $document->name}}_valid">Dokumen Sudah Valid</label>
                        <select name="{{ $document->name }}_valid" id="{{ $document->name }}_valid">
                            <option value="0" @selected(old($document->name . '_valid') == '0')>Belum Valid</option>
                            <option value="1" @selected(old($document->name . '_valid') == '1')>Valid</option>
                        </select>
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
                        <input type="file" accept="{{ $document->mime_types }}" name="{{ $document->name }}" required>
                        <input type="hidden" name="{{ $document->name }}_updated" value="0">
                        <span id="{{ $document->name }}_preview_name">{{ $document->name }} (Tambahkan Uploud)</span>
                    </div>
                    <div class="wrapper-input">
                        <label for="{{ $document->name}}_valid">Dokumen Sudah Valid</label>
                        <select name="{{ $document->name }}_valid" id="{{ $document->name }}_valid">
                            <option value="0" @selected(old($document->name . '_valid') == '0')>Belum Valid</option>
                            <option value="1" @selected(old($document->name . '_valid') == '1')>Valid</option>
                        </select>
                    </div>
                </div>
                <div class="wrapper-input">
                    <label for="{{ $document->name}}_valid">Dokumen Sudah Valid</label>
                    <select name="{{ $document->name }}_valid" id="{{ $document->name }}_valid">
                        <option value="0" @selected(old($document->name . '_valid') == '0')>Belum Valid</option>
                        <option value="1" @selected(old($document->name . '_valid') == '1')>Valid</option>
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
                const input_isUpdated = document.getElementById(event.target.name + '_updated');
                const input_isDownload = document.getElementById(event.target.name + '_download');
                const preview_name = document.getElementById(event.target.name + '_preview_name');
                const file = event.target.files[0];
                if(input_isDownload && file) input_isUpdated.value = 1;
                if(input_isDownload && !file) input_isUpdated.value = 0;
                if(file) preview_name.textContent = file.name;
                if(!file) preview_name.textContent = event.target.name + ' (Tambahkan Dokumen Disini)';
            });
        }
    });
</script>
