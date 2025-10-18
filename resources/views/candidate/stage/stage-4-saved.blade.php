@include('_components._headerCandidate', [
    'title' => 'Formulir Tahap Keempat'
])
<main class="content">
    <div class="stages stages-full-h">
        <div class="form-stage">
            @include('_components._sprite-icons', [ 'name' => 'success','size' => 120 ])
            <h2 class="">Pembayaran Biaya Sandang Berhasil!</h2>
            <div class="s-submit">
                <p>{{ $message ?? 'Keren Banget!, Sedikit Lagi Untuk Kamu Menjadi Siswa/i Kami!' }}</p>
                <div class="w-buttons">
                    <div class="pages">
                        <button class="pagination-action" type="button" onclick="location.href='{{ route('candidate.stage.stage4') }}'">Kembali</button>
                        <button class="pagination-action" type="button" onclick="location.href='{{ route('candidate.stage.stage5') }}'">Lanjutkan Perjalanan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@include('_components._footerCandidate')