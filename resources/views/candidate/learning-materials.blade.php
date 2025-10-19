@php
    $placeholder = "https://www.svgrepo.com/show/508699/landscape-placeholder.svg";
    $mascots = ['BINA', 'TIKA'];
    $mascotLoad = $mascots[rand(0, 1)];
    $moduls =
        [
            ["nama" => "Operating System", "link" => "https://drive.google.com/file/d/10IjT7o70578HOSvBuopwEu7jnkKaaNt4/view?usp=drive_link"],
            ["nama" => "MS. Excel", "link" => "https://drive.google.com/file/d/1g4MJJHIc_ElJ4XW01fz1GBne7BaI_fKC/view?usp=drive_link"],
            ["nama" => "MS. Word", "link" => "https://drive.google.com/file/d/1JRl7CAm2d-FpbmNN2pRk9V-vfCoIx2dg/view?usp=drive_link"],
            ["nama" => "Rekayasa Perangkat Lunak", "link" => "https://drive.google.com/file/d/1Jlr5B1Ep9bKm8PHu90hmU9YLqgsqBycd/view?usp=drive_link"],
            ["nama" => "Teknik Komputer Jaringan", "link" => "https://drive.google.com/file/d/1ZhEeFbN5PjwLiBg-5F3kZdtavzAKKmp9/view?usp=drive_link"],
            ["nama" => "Broadcasting", "link" => "https://drive.google.com/file/d/1z1avEKtmpnNyBvonvDdu7YMPvI55UPAl/view?usp=drive_link"],
            ["nama" => "Desain Komunikasi Visual", "link" => "https://drive.google.com/file/d/1VC-_HFKwe09yeCfiFE7Pg5vTQVdvetA7/view?usp=drive_link"],
            ["nama" => "Animasi", "link" => "https://drive.google.com/file/d/1mTQ5ErrXon7KUhfnHy5fD86EW9-ZeTwl/view?usp=drive_link"],
        ]
@endphp
@include('_components._headerCandidate', [
    'title' => 'Materi - Materi Ujian Saringan Masuk'
])
<main class="modul">
    <div class="header">
        <h1>{{ $isAllUploads ? 'Modul-modul untuk binforelajar persiapan USM' : 'Kamu Harus Membayar Biaya Sandang & Menyelesaikan 5 Tahapan Ya!' }}</h1>
    </div>
    <div class="body">
        @if ($isAllUploads)
            @foreach ($candidate->candidateMajors ?? [] as $selectedMajor) 
                @foreach ($moduls as $modul)
                     @if($selectedMajor->major_long_name == $modul['nama']) 
                        <div class="card">
                            <h2>Modul {{ $modul["nama"] }}</h2>
                            <img src="{{ asset("icons/book.svg") }}" alt="">
                            <a download href=" {{ $modul['link'] }}">Download Modul</a>
                        </div>
                     @endif 
                @endforeach
            @endforeach 
        @else
        <div class="information-to-buy {{ $mascotLoad == 'BINA' ? 'reverse' : '' }}">
            <img class="mascot-image" src="{{ asset('images/mascots/' . $mascotLoad . '.png') }}" alt="{{ $mascotLoad }}">
            <div class="message">
                 <h4>Haloo, Perkenalkan Aku {{ $mascotLoad }}</h4>
                <p>Sebelum kamu mengakses halaman ini, pastikan kamu sudah membayar biaya sandang & menyelesaikan sampai tahap 5 ya!</p>
            </div>
        </div>
    @endif
    </div>
</main>


@include('_components._footerCandidate')
