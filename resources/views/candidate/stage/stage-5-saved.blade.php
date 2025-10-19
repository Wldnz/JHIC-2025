@include('_components._headerCandidate', [
    'title' => 'Formulir Tahap Kelima'
])
<main class="content">
    <div class="stages stages-full-h">
        <div class="form-stage">
            @include('_components._sprite-icons', [ 'name' => 'success','size' => 120 ])
            <h2 class="">🎊 Selamat, Kamu Telah Berhasil Mendaftar Sebagai Siswa Kami! 🎊</h2>
            <div class="s-submit">
                <p>{{ $message ?? 'Perjalanan Mu Masih Panjang Tahu, Segera Persiapkan Dirimu Untuk Ujian Saringan Masuk Dengan Mengakses Modul - Modul Yang Sudah Disediakan' }}</p>
                <div class="w-buttons">
                    <div class="pages pages-1">
                        <button class="pagination-action" type="button" onclick="location.href='{{ route('candidate.learning-materials') }}'">Lihat Modul</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@include('_components._footerCandidate')
