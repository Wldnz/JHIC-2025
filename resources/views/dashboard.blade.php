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
            ],
            [
                asset("images/banner3/bg.png"),
                asset("images/banner3/asset1.png"),
                asset("images/banner3/asset2.png"),
                asset("images/banner3/asset3.png"),
                asset("images/banner3/asset4.png"),
                asset("images/banner3/asset5.png"),
                asset("images/banner3/asset6.png")
            ],
            [
                asset("images/banner4/bg.png"),
                asset("images/banner4/asset1.png"),
                asset("images/banner4/asset2.png"),
                asset("images/banner4/asset3.png"),
                asset("images/banner4/asset4.png"),
                asset("images/banner4/asset5.png"),
                asset("images/banner4/asset6.png")
            ],
            [
                asset("images/banner5/bg.png"),
                asset("images/banner5/asset1.png"),
                asset("images/banner5/asset2.png"),
                asset("images/banner5/asset3.png"),
                asset("images/banner5/asset4.png"),
                asset("images/banner5/asset5.png"),
                asset("images/banner5/asset6.png")
            ]
        ];

        $majors = 
        [
            [
                asset("images/majors images/bc.png"),
                asset("icons/majors icons/bc.svg"),
                "BROADCASTING FILM & TV",
                "broadcast suara atau teks seperti broadcast dan super broadcast di game growtopia"
            ],
            [
                asset("images/majors images/bc.png"),
                asset("icons/majors icons/bc.svg"),
                "BROADCASTING FILM & TV",
                "broadcast suara atau teks seperti broadcast dan super broadcast di game growtopia"
            ],
            [
                asset("images/majors images/bc.png"),
                asset("icons/majors icons/bc.svg"),
                "BROADCASTING FILM & TV",
                "broadcast suara atau teks seperti broadcast dan super broadcast di game growtopia"
            ],
            [
                asset("images/majors images/bc.png"),
                asset("icons/majors icons/bc.svg"),
                "BROADCASTING FILM & TV",
                "broadcast suara atau teks seperti broadcast dan super broadcast di game growtopia"
            ],
            [
                asset("images/majors images/bc.png"),
                asset("icons/majors icons/bc.svg"),
                "BROADCASTING FILM & TV",
                "broadcast suara atau teks seperti broadcast dan super broadcast di game growtopia"
            ],
            
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
                <span class="major-count"></span>
                @endforeach
            </div>
            <img src="{{ asset("icons/left-arrow.svg") }}" alt="" style="rotate: 180deg;">
        </div>
    </div>

    <div class="gallery">
      <h2>Gallery</h2>
      <div class="img-group">
        <img src="{{ $placeholder }}" alt="" class="show">
        <img src="{{ $placeholder }}" alt="" class="show">
        <img src="{{ $placeholder }}" alt="">
        <img src="{{ $placeholder }}" alt="">
        <img src="{{ $placeholder }}" alt="">
        <img src="{{ $placeholder }}" alt="">
      </div>
    </div>


</div>

<script>
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