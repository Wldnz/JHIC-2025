@php
    $placeholder = "";
@endphp

@include("_components._header")
 <div class="news">
        <h2>BI NEWS</h2>

        <div class="searchbar">
            <input type="text" placeholder="Cari Berita..." value="{{ $placeholder }}">
            <div class="search-icon">
            <a href="">
                <img src="{{ asset("icons/search-icon.svg") }}" alt="">
            </a>
            </div>
        </div>
        <div class="news-group">
            @for ($i = 0; $i < 3; $i++)
            <a href="">
                <img src="{{ asset("images/news/mamah aku menang.png") }}" alt="">
                <div class="news-infodetail">
                    <div class="news-info">
                        <div class="tags">
                            <div class="tags-slider">
                                <p class="tag1">Info Sekolah</p>
                                <p class="tag2">Info PSB</p>
                                <p class="tag3">JHIC 2025</p>
                            </div>
                        </div>
                        <div class="date">
                            <p>03/12/2008</p>
                        </div>
                    </div>
                    
                    <div class="text">
                        <h3>SEKOLAH SWASTA MENOLAK SEKOLAH GRATIS BLA BLA BLA AKU CINTA JHIC SELAMANYA TEST TEST TEST</h3>
                        <h4>really long description of the news, one might say it's a paragraph of some sort i don't even know like bro wtf i'm just writing this for testing but wtf</h4>
                    </div>
                </div>
            </a>
            @endfor
        </div>
    </div>
@include("_components._footer")