@php
    $mascots = ['BINA', 'TIKA'];
    $mascotLoad = $mascots[rand(0, 1)];
@endphp
@include('_components._headerCandidate',[
    'title' => 'Hasil Ujian Saringan Masuk'
])
<main class="result">
    <div class="header">
        <h1>{{ $candidate && $isAllUploads && $candidate->candidateUSMResult ?? false ? 'Lihat hasil USM Anda!' : 'Kamu Belum Bisa Melihat Hasil USM!' }}</h1>
        <p>{{ $candidate && $isAllUploads && $candidate->candidateUSMResult ?? false ? '' : 'Pastikan, kamu telah menyelesaikan hingga ke tahap 7 ya!, Jika sudah harap menunggu administrasi menguploud hasilnya ya!' }}</p>
    </div>
    <div class="body">
       @if ($candidate->candidateUSMResult ?? false)
           <h2>Dengan ini kami nyatakan bahwasanya {{ $candidate->candidateUSMResult->candidate_full_name ?? auth()->user()->fullname }}, Telah {{ $candidate->candidateUSMResult->is_passed ?? 0 > 0?  'LULUS!' : 'TIDAK LULUS' }} dalam mengikuti kegiatan usm</h2>
          @if($candidate->candidateUSMResult->is_passed ?? 0)
                <p>Setelah ini kamu akan melakukan pendaftaran ulang dan pengambilan sertifikat di sekolah ya!, Sampai Jumpa!</p>
            @else
                <p>Maaf, kamu belum berhasil. Tapi tenang saja kamu bisa mengulangi kegiatan ujian saringan masuk ini, dengan persyaratan yang berlaku</p>
            @endif
       @endif
    </div>
    @if (!$candidate || !$isAllUploads && $candidate->candidateUSMResult == null)
        <div class="information-to-buy {{ $mascotLoad == 'BINA' ? 'reverse' : '' }}">
            <img class="mascot-image" src="{{ asset('images/mascots/' . $mascotLoad . '.png') }}" alt="{{ $mascotLoad }}">
            <div class="message">
                <h4>Haloo, Perkenalkan Aku {{ $mascotLoad }}</h4>
                @if(!$candidate)
                    <p>Kamu Belum melakukan tahap pertama nih, lakuin sekarang yuk!</p>
                @elseif(!$isAllUploads)
                    <p>Pastikan kamu sudah menguploud semua dokumen ya!'</p>
                @elseif($isAllUploads)
                    <p>Nice!, Tinggal tunggu administrasi menguploud dokumen mu ya!</p>
                @endif
            </div>
        </div>
    @endif
</main>

@include('_components._footerCandidate')
