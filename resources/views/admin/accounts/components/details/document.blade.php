@php
    $datas = [
        [
            'name' => 'Surat Akte Kelahiran.pdf',
            'file_url' => asset('download.pdf')
        ],
        [
            'name' => 'Surat Akte Kelahiran.pdf',
            'file_url' => asset('download.pdf')
        ],
        [
            'name' => 'Surat Akte Kelahiran.pdf',
            'file_url' => asset('download.pdf')
        ],
        [
            'name' => 'Surat Akte Kelahiran.pdf',
            'file_url' => asset('download.pdf')
        ],
    ];

    $requirements = [
        
    ];
@endphp

<div class="form-data-profile" id="candidate-document-form">
    @foreach ($datas as $data)
    <div class="wrapper-form">
        <h2>{{ $data['name'] }}</h2>
        <div class="container container-1">
            <div class="wrapper-document">
                <div class="wrapper-thumbnail">
                    <input type="file" 
                        accept=".pdf, .doc, .docx"
                        aria-describedby="requirement document"
                    >
                    <span>{{ $data['name'] }}</span>
                </div>
                <a href="{{ $data['file_url'] }}" download="">
                    @include('_components._sprite-icons', [ 'name' => 'convert', 'size' => 25 ])
                </a>
            </div>
        </div>
    </div>
    @endforeach
</div>