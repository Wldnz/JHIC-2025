@include('_components._headerCandidate', [
    'title' => 'Formulir Tahap Ketiga'
])
<main class="content">
    <div class="stages stages-full-h">
        <div class="form-stage">
            @include('_components._sprite-icons', [ 'name' => 'success','size' => 120 ])
            <h2 class="">Jadwal Kegiatan Ujian Saringan Masuk Berhasil Disimpan</h2>
            <div class="s-submit">
                <p>{{ $message ?? 'Mantap!, Kamu Sudah Melakukan Perjalanan Sejauh Ini, Selanjutnya Adalah Biaya Sandang' }}</p>
                <div class="w-buttons">
                    <div class="pages">
                        <button class="pagination-action" type="button" onclick="location.href='{{ route('candidate.stage.stage3') }}'">Kembali</button>
                        <button class="pagination-action" type="button" onclick="location.href='{{ route('candidate.stage.stage4') }}'">Lanjutkan Perjalanan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@include('_components._footerCandidate')