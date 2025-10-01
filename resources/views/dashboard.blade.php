@include('_components._header', ['title' => 'product'])
<div class="dashboard">
    <a href="{{ route ('student.products')}}"><div class="hugeimg">
        <h1>
            THE UNIFORM OF
        </h1>
        <img src="{{asset('/images/bi.png')}}">
    </div></a>


    <div class="categories">
        <h3>PILIH SERAGAM SESUAI KEBUTUHAN MU!</h3>
        <div class="category-section">
            <a href="{{ route('student.products') }}">
                <div class="category-tab">
                    <img src="{{asset('images/thumbnail/sergamlaki.png')}}" alt="">
                    <div class="vignette"></div>
                    <h3>Seragam <br>Laki-Laki</h3>
                    <p>Temukan seragam sekolah yang kamu butuhkan</p>
                </div>
            </a>
            <a href="{{ route('student.products') }}">
                <div class="category-tab">
                    <img src="{{asset('images/thumbnail/sergamprmp.png')}}" alt="">
                    <div class="vignette"></div>
                    <h3>Seragam <br>Perempuan</h3>
                    <p>Temukan seragam sekolah yang kamu butuhkan</p>
                </div>
            </a>
        </div>
    <br><br>
        <h3>PILIH ATRIBUT SESUAI KEBUTUHAN MU!</h3>

        <div class="category-section">
        <a href="{{ route('student.products') }}">
            <div class="category-tab">
                <img src="{{asset('images/thumbnail/dasi.png')}}" alt="">
                <div class="vignette"></div>
                <h3>Dasi</h3>
                <p>Temukan seragam sekolah yang kamu butuhkan</p>
            </div>
        </a>
        <a href="{{ route('student.products') }}">
            <div class="category-tab">
                <img src="{{asset('images/thumbnail/rapot.png')}}" alt="">
                <div class="vignette"></div>
                    <h3>MAP Rapot</h3>
                    <p>Temukan seragam sekolah yang kamu butuhkan</p>
            </div>
        </a>
        <a href="{{ route('student.products') }}">
            <div class="category-tab">
                <img src="{{asset('images/thumbnail/sabuk.png')}}" alt="">
                <div class="vignette"></div>
                    <h3>Sabuk</h3>
                    <p>Temukan seragam sekolah yang kamu butuhkan</p>
            </div>
        </a>
        <a href="{{ route('student.products') }}">
            <div class="category-tab">
                <img src="{{asset('images/thumbnail/kartu.png')}}" alt="">
                <div class="vignette"></div>
                <h3>Kartu <br> Pelajar</h3>
                <p>Temukan seragam sekolah yang kamu butuhkan</p>
            </div>
        </a>
        <a href="{{ route('student.products') }}">
            <div class="category-tab">
                <img src="{{asset('images/thumbnail/badge.png')}}" alt="">
                <div class="vignette"></div>
                <h3>Badge <br>Seragam</h3>
                <p>Temukan seragam sekolah yang kamu butuhkan</p>
            </div>
        </a>
        <a href="{{ route('student.products') }}">
            <div class="category-tab">
                <img src="{{asset('images/thumbnail/top.png')}}" alt="">
                <div class="vignette"></div>
                <h3>Topi</h3>
                <p>Temukan seragam sekolah yang kamu butuhkan</p>
            </div>
        </a>
        <a href="{{ route('student.products') }}">
            <div class="category-tab">
                <img src="{{asset('images/thumbnail/spatu.png')}}" alt="">
                <div class="vignette"></div>
                <h3>Sepatu <br> Pantofel</h3>
                <p>Temukan seragam sekolah yang kamu butuhkan</p>
            </div>
        </a>
        </div>
    </div>

    <div class="faq-page">
        <h2>FAQ</h2>
        @php
            $faqs = [
                'Bagaimana Cara Melakukan Pemesanan?' => 'Untuk melakukan pemesanan, pilih produk yang diinginkan, tambahkan ke keranjang, dan ikuti proses checkout.',
                'Metode Pembayaran Apa Saja yang Tersedia?' => 'Kami menerima pembayaran melalui transfer bank, GOPAY, OVO, QRIS, Cash / Non-Tunai.',
                'Jika Ukuran Size Baju Tidak Ada?' => 'Silahkan Hubungi Nomor Admin atau bisa langusung ke Tata Usaha.'

                ]
        @endphp
        <div class="faq-list">
            @foreach ($faqs as $question => $answer)
            <details name="shit">
                <summary>
                    <h3>{{ $question }}</h3>
                    <img src="{{ asset('icons/arrow-down.svg') }}" alt="Arrow Down" class="arrow-icon">
                </summary>
                <p>{{ $answer }}</p>
            </details>
            @endforeach
        </div>
    </div>
</div>
@include('_components._footer')