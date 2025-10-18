@include('_components._headerCandidate', [
    'title' => 'Formulir Tahap Pertama'
])
<main class="content">
    <div class="stages stages-full-h">
        <div class="form-stage">
            @include('_components._sprite-icons', [ 'name' => 'success','size' => 120 ])
            <h2 class="">Pembayaran Berhasil!</h2>
            <div class="s-submit">
                <p>{{ $message ?? 'Wah Wah Wah!, Pembayaran Yang Dilakukan Sudah Berhasil!, Silahkan Lanjutkan Perjalanan Mu!' }}</p>
                <div class="w-buttons">
                    <div class="pages pages-1">
                        <button class="pagination-action" type="button" onclick="location.href='{{ route('candidate.stage.stage2') }}'">Lanjutkan Perjalanan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@include('_components._footerCandidate')