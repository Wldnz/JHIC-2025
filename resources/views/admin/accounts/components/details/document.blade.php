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
                        <a href="{{ route('admin.detail-account.download-document', ['account' => $candidate->user_id, 'candidateDocument' => $cd->id])  }}" download target="_blank">
                            @include('_components._sprite-icons', [ 'name' => 'convert', 'size' => 20 ])
                        </a>
                    </div>
                </div>
            </div>
        @endif
    @endforeach
   @endforeach
</div>
