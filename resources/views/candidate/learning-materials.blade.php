@php
    $placeholder = "https://www.svgrepo.com/show/508699/landscape-placeholder.svg";
@endphp
@include('_components._headerCandidate',[
    'title' => 'Materi - Materi Ujian Saringan Masuk'
])
<main class="modul">
    <div class="header">
        <h1>Modul-modul untuk belajar persiapan USM</h1>
    </div>
    <div class="body">
        @if ($isAllUploads)
            @php
                $moduls =
                [
                    ["nama" => "Operating System", "link" => "https://cdn.discordapp.com/attachments/827171809764835408/1428756518886572083/os.pdf?ex=68f3a8b3&is=68f25733&hm=193ff11a65bf88b6280a5ec73f6c29179be3aca3258837f0a5cf8e878b5e672c&"],
                    ["nama" => "MS. Excel", "link" => "https://cdn.discordapp.com/attachments/827171809764835408/1428756524041502760/excel.pdf?ex=68f3a8b4&is=68f25734&hm=0c96b7b87e292e66dea701f483d3b39c06f71a1cda44fccdf9937c6529157b91&"],
                    ["nama" => "MS. Word", "link" => "https://cdn.discordapp.com/attachments/827171809764835408/1428756520165965834/word.pdf?ex=68f3a8b3&is=68f25733&hm=dd869d5f386e0fda5fae034360a0a0080a9cbd09c1c3158688937d7cf18cfcbd&"],
                    ["nama" => "Rekayasa Perangkat Lunak", "link" => "https://cdn.discordapp.com/attachments/827171809764835408/1428756519339688038/rpl.pdf?ex=68f3a8b3&is=68f25733&hm=5d772a9dd8931399f47b428f52b733c06067860d11fa2487abddb58d10381773&"],
                    ["nama" => "Teknik Komputer Jaringan", "link" => "https://cdn.discordapp.com/attachments/827171809764835408/1428756519825965066/tkj.pdf?ex=68f3a8b3&is=68f25733&hm=8965a6ffc9a3818a72d71a5a08f610858bfee3a039948037c118d559df60125d&"],
                    ["nama" => "Broadcasting", "link" => "https://cdn.discordapp.com/attachments/827171809764835408/1428756523332665468/bc.pdf?ex=68f3a8b4&is=68f25734&hm=b06275e2f7d4efb428f1bbf2f3cfa13ec089c2b88c9b60bccb8acec1a0acd59c&"],
                    ["nama" => "Desain Komunikasi Visual", "link" => "https://cdn.discordapp.com/attachments/827171809764835408/1428756523647242280/dkv.pdf?ex=68f3a8b4&is=68f25734&hm=08758fca7f91ddbd4d88da2853f56f6b412393ec3062f8464da84fcd1af9381c&"],
                    ["nama" => "Animasi", "link" => "https://cdn.discordapp.com/attachments/827171809764835408/1428756520426016929/anim.pdf?ex=68f3a8b3&is=68f25733&hm=8eb1e84f33650904d490c78d3e1c8ec0d9b0702dc80cdd161e1a615a5d44f07a&"],
                ]
            @endphp

            @foreach ($moduls as $modul)
                <div class="card">
                    <h2>Modul {{ $modul["nama"] }}</h2>
                    <img src="{{ asset("icons/book.svg") }}" alt="">
                    <a download href=" {{ $modul['link'] }}">Download Modul</a>
                </div>
            @endforeach
        @else
            <h1>Halo, kamu harus membayar terlebih dahulu ya</h1>
        @endif
    </div>
</main>


@include('_components._footerCandidate')
