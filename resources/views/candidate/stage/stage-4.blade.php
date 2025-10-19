@include('_components._headerCandidate', [
    'title' => 'Formulir Tahap Keempat'
])
<main class="content">
    <div class="accessoris">
        <div class="stars">
            <img src="{{ asset('images/trinkets/star.svg') }}" alt="star">
            <img src="{{ asset('images/trinkets/star.svg') }}" alt="star">
        </div>
    </div>
    <div class="stages">
        <div class="hero">
            <h2>Tahap Keempat</h2>
            <div class="description">
                <h4>Membeli Formulir Pendaftaran</h4>
                <p>Calon peserta didik melakuakan pendaftaran tahap pertama, yakni melakukan pembayaran untuk mengakases formulir pendaftaran</p>
            </div>
        </div>
        <form class="form-stage" action={{ route('candidate.stage.save-stage4') }} method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <h2>{{ !$isPaid ? Auth::user()->fullname .', Langkah keempat ini kamu diwajibkan membayar biaya sandang ya, untuk bisa mengikuti kegiatan ujian saringan masuk' : 'Kamu Sudah Bayar!, Silahkan merubah data jika terjadi kesalahan dalam pengimputan data!' }}</h2>
            @if (!$isPaid)
            <h2>Informasi Pembayaran & Rekening Bank</h2>
            <div class="fields">
                <div class="wrapper-input wrapper-information">
                    <label for="type">Biaya Dibutuhkan Untuk</label>
                    <span id="type">Biaya Sandang & Pendaftaran USM</span>
                </div>
                <div class="wrapper-input wrapper-information">
                    <label for="price">Pilih Metode Pembayaran</label>
                    <span class="price" id="price">Rp. 5.032.000,00</span>
                </div>
                <div class="wrapper-input wrapper-information">
                    <label for="payment_method">Pilih Metode Pembayaran</label>
                    <div class="wrapper-select">
                        <select name="payment_method" id="payment_method" aria-describedby="payment_method" required>
                            <option value=""></option>
                            @foreach ($payments as $payment)
                                <option value="{{ $payment->code_name }}" @selected(old('payment_method') == $payment->code_name)>{{ $payment->display_name }}</option>
                            @endforeach
                        </select>
                        @include('_components._sprite-icons', [ 'name' => 'drop-down', 'size' => 25 ])
                    </div>
                </div>
            </div>
            @endif
            <div class="s-submit">
                @if (!$isPaid)
                    <p>Dengan menekan tombol "Simpan", data yang Anda cantumkan di atas adalah benar dan dapat dipertanggungjawabkan.</p>
                @endif
                <div class="w-buttons">
                    @if (!$isPaid)
                        <button class="submit-form" type="submit">Buat Transaksi</button>
                    @endif
                    @if ($isPaid)
                        <div class="pages">
                            <button class="pagination-action" type="button" onclick="location.href='{{ route('candidate.stage.stage3') }}'">Sebelumnya</button>
                            <button class="pagination-action" type="button" onclick="location.href='{{ route('candidate.stage.stage5') }}'">Selanjutnya</button>
                        </div>
                    @endif
                </div>
            </div>
        </form>
    </div>
</main>

@include('_components._footerCandidate')
