@include('_components._headerCandidate', [
    'title' => 'Formulir Tahap Kedua'
])
<main class="content">
    <div class="stages stages-full-h">
        <div class="form-stage">
            @include('_components._sprite-icons', [ 'name' => 'success','size' => 120 ])
            <h2 class="">Formulir Data Diri Berhasil Disimpan</h2>
            <div class="s-submit">
                <p>{{ $message ?? 'Wahhhh, Kamu sudah berhasil mengumpulkan Formulir Data Diri, Silahkan Lanjutkan Perjalanan Mu!' }}</p>
                <div class="w-buttons">
                    <div class="pages">
                        <button class="pagination-action" type="button" onclick="location.href='{{ route('candidate.stage.stage2') }}'">Kembali</button>
                        <button class="pagination-action" type="button" onclick="location.href='{{ route('candidate.stage.stage3') }}'">Lanjutkan Perjalanan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@include('_components._footerCandidate')