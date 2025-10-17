@php
    $placeholder = '';
@endphp

@include('_components._header')

<div class="detail-news">
    <h2>BI NEWS</h2>

    <div class="searchbar">
        <input type="text" placeholder="Cari Berita..." value="{{ $placeholder }}">
        <div class="search-icon">
            <a href="">
                <img src="{{ asset('icons/search-icon.svg') }}" alt="Search">
            </a>
        </div>
    </div>

    <div class="detail-content">
        <h3>SEKOLAH SISWA MENOLAK SEKOLAH GRATIS BLA BLA BLA AKU CINTA JHIC SELAMANYA TEST TEST TEST</h3>

        <div class="writeby-content">
            <div class="wrapper-writter">
                <div class="writeby">
                    <img src="{{ asset('icons/user.svg') }}">
                </div>
                <div class="user-upload">
                    <p>Written by <b> Wildan Izhar Al-Haqq </b></p>
                </div>
            </div>
            <div class="date">
                <p>Kamis, 16 Oktober 2025 20:30</p>
            </div>
        </div>

        <img src="{{ asset('images/news/mamah aku menang.png') }}" alt="mamah aku menang">
        <p class="img-description">
            foto para juara yang memenangkan lomba bi got talent
        </p>
    </div>

    <div class="news-content">
        <h3>19 Oktober, 25</h3>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore
            magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea
            commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat
            nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit
            anim id est laborum.</p>
    </div>
</div>

@include('_components._footer')
