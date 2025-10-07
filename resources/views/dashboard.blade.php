@php
        $placeholder = "https://www.svgrepo.com/show/508699/landscape-placeholder.svg";

        $newscontent = 
        [
            [
                asset("images/banner1/bg.png"),
                asset("images/banner1/asset1.png"),
                asset("images/banner1/asset2.png"),
                asset("images/banner1/asset3.png"),
                asset("images/banner1/asset4.png"),
                asset("images/banner1/asset5.png"),
                asset("images/banner1/asset6.png")
            ],
            [
                asset("images/banner2/bg.png"),
                asset("images/banner2/asset1.png"),
                asset("images/banner2/asset2.png"),
                asset("images/banner2/asset3.png"),
                asset("images/banner2/asset4.png"),
                asset("images/banner2/asset5.png"),
                asset("images/banner2/asset6.png")
            ]
        ];

        $majors = 
        [
            [
                asset("images/majors images/bc.png"),
                asset("icons/majors icons/anim.svg"),
                "ANIMATION",
                "Menciptakan kreator animasi yang berkarakter, kreatif, aktif, dan inovatif yang mampu bekerja dan berkarya di industri animasi."
            ],
            [
                asset("images/majors images/bc.png"),
                asset("icons/majors icons/bc.svg"),
                "BROADCASTING FILM & TV",
                "Membentuk Sineas berkarakter yang kreatif, aktif, inovatif, berjiwa enterpreneur yang unggul di dunia pertelevisian dan film."
            ],
            [
                asset("images/majors images/bc.png"),
                asset("icons/majors icons/gmdv.svg"),
                "GAME DEVELOPMENT",
                "Mencetak game developer yang handal dalam pemodelan serta merancang game sesuai kebutuhan industri"
            ],
            [
                asset("images/majors images/bc.png"),
                asset("icons/majors icons/tkj.svg"),
                "IT Network",
                "Mencetak administrator server dan jaringan yang handal, cermat, inovatif dan profesional di bidang teknologi informasi dan komunikasi."
            ],
            [
                asset("images/majors images/bc.png"),
                asset("icons/majors icons/dkv.svg"),
                "DESIGN KOMUNIKASI VISUAL",
                "Mencetak Seniman Digital yang kreatif, aktif, dan inovatif yang mampu bekerja dan bersaing di industri kreatif."
            ],
            [
                asset("images/majors images/bc.png"),
                asset("icons/majors icons/rpl.svg"),
                "IT Software",
                "Menghasilkan lulusan yang cerdas, disiplin, kreatif, inovatif dan sikap profesional dibidang Rekayasa Perangkat Lunak."
            ],
            
        ];

        $gallery =
        [
            'Ruangan A1' => 'A1.png',
            'Ruangan A2' => 'A2.png',
            'Ruangan A3' => 'A3.png',
            'Ruangan A4' => 'A4.png',
            'Ruangan A5' => 'A5.png',
        ]
@endphp
@include('_components._header', ['title' => 'product'])
<div class="dashboard">
    <div class="banner">
        <div class="change-banner left"><img class="no-fade" src="{{ asset("icons/arrow-down.svg") }}" alt=""></div>
        <div class="center">
            <div class="sliding-banner">
                @foreach ($newscontent as $asset)
                <a href="" class="banner-content">
                    <img src="{{ $asset[0] }}" alt="" class="img selector">
                    <img src="{{ $asset[1] }}" alt="" class="img img1 selector">
                    <img src="{{ $asset[2] }}" alt="" class="img img2 selector">
                    <img src="{{ $asset[3] }}" alt="" class="img img3 selector">
                    <img src="{{ $asset[4] }}" alt="" class="img img4 selector">
                    <img src="{{ $asset[5] }}" alt="" class="img img5 selector">
                    <img src="{{ $asset[6] }}" alt="" class="img img6 selector">
                </a>
                @endforeach
            </div>
            <div class="banner-info">
                <span class="banner-timer"></span>
                <div class="banner-counter">
                    @foreach ( $newscontent as $count)
                    <span class="banner-count"></span>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="change-banner right"><img class="no-fade" src="{{ asset("icons/arrow-down.svg") }}" alt=""></div>
    </div>

    <h2>WE ARE</h2>
    <h1>THE PIONEER OF <br> IT SCHOOL</h1>
    <h3>THE SKILL BUILDING WE SPECIALIZE IN ARE</h3>
    <div class="majors">
        <div class="major-slider">
            @foreach ( $majors as $major )
            <a class="major-content">
                <img src="{{ $major[0] }}" alt="">
                <img class="icon" src="{{ $major[1] }}" alt=""> 
                <h2>{{ $major[2] }} </h2>
                <h3>{{ $major[3] }} </h3>
            </a>
            @endforeach
        </div>
        <div class="change-major">
            <img src="{{ asset("icons/left-arrow.svg") }}" alt="">
            <div class="major-counter">
                @foreach ($majors as $major)
                <span class="major-count"><img src="{{ $major[1] }}" alt=""></span>
                @endforeach
            </div>
            <img src="{{ asset("icons/left-arrow.svg") }}" alt="" style="rotate: 180deg;">
        </div>
    </div>

    <div class="gallery">
        <h2>Gallery</h2>
        <div class="img-group">
            @foreach ( $gallery as $title => $file )
                <span class="{{ $loop->iteration < 3 ? 'show' : '' }}">
                    <img src="{{$file}}" alt="">
                    <h3>{{ $title }}</h3>
                </span>
            @endforeach
        </div>
        <button class="button">VIEW ALL</button>
    </div>

    <div class="news">
        <h2>BI NEWS</h2>
        <div class="news-group">
            @for ($i = 0; $i < 4; $i++)
            <a href="">
                <img src="{{ $placeholder }}" alt="">
                <div class="news-info">
                    <div class="tags">
                        <p>Info Sekolah</p>
                        <p>Info PSB</p>
                        <p>JHIC 2025</p>
                    </div>
                    <div class="date">
                        <p>03/12/2008</p>
                    </div>
                </div>
                <h2>Title</h2>
                <h3>desc</h3>
            </a>
            @endfor
        </div>
    </div>


</div>






<script>
const majors = document.querySelectorAll('.major-content');
const counters = document.querySelectorAll('.major-count');

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            counters.forEach(c => c.classList.remove('selected'));
            const index = Array.from(majors).indexOf(entry.target);
            counters[index]?.classList.add('selected');
        }
    });
}, {
    threshold: 0.6,
    root: document.querySelector('.major-slider')
});

majors.forEach(major => observer.observe(major));



const nav = document.querySelector(".navigation-user");
let lastScroll = window.scrollY;
let ticking = false;

window.addEventListener("scroll", () => {
  if (!ticking) {
    window.requestAnimationFrame(() => {
      const currentScroll = window.scrollY;

      if (Math.abs(currentScroll - lastScroll) > 50) {
        if (currentScroll > lastScroll && currentScroll > 20) {
          nav.style.top = "-200px";
        } else {
          nav.style.top = "0";
        }
        lastScroll = currentScroll;
      }

      ticking = false;
    });

    ticking = true;
  }
});

document.addEventListener("DOMContentLoaded", () => {
  const elements = [...document.querySelectorAll("*:not(.no-fade)")];

  elements.forEach(el => {
    const computed = window.getComputedStyle(el);
    el.dataset.originalOpacity = computed.opacity || 1;
  });

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      const el = entry.target;
      const original = parseFloat(el.dataset.originalOpacity);
      const faded = Math.max(original - 0.5, 0);

      if (entry.isIntersecting) {
        el.style.opacity = original;
      } else {
        el.style.opacity = faded;
      }
    });
  }, { threshold: 0.1 });

  elements.forEach(el => observer.observe(el));
});



</script>


@include('_components._footer')