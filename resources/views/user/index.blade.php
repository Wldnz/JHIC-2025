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
                asset("images/banner2/bg.png"),
                asset("images/banner2/asset1.png"),
                asset("images/banner2/asset2.png"),
                asset("images/banner2/asset3.png"),
                asset("images/banner2/asset4.png"),
                asset("images/banner2/asset5.png"),
                asset("images/banner2/asset6.png")
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
                asset("images/banner2/bg.png"),
                asset("images/banner2/asset1.png"),
                asset("images/banner2/asset2.png"),
                asset("images/banner2/asset3.png"),
                asset("images/banner2/asset4.png"),
                asset("images/banner2/asset5.png"),
                asset("images/banner2/asset6.png")
            ],
        ];

    $majors =
        [
            [
                asset("images/majors images/anim.png"),
                asset("icons/majors icons/anim.svg"),
                "Animation",
                "Menciptakan kreator animasi yang berkarakter, kreatif, aktif, dan inovatif yang mampu bekerja dan berkarya di industri animasi.",
                asset("icons/majors icons/rpl.svg"),
                asset("icons/majors icons/bc.svg"),
                route("user.majors.animation"),
            ],
            [
                asset("images/majors images/bc.png"),
                asset("icons/majors icons/bc.svg"),
                "Broadcasting Film & TV",
                "Membentuk Sineas berkarakter yang kreatif, aktif, inovatif, berjiwa enterpreneur yang unggul di dunia pertelevisian dan film.",
                asset("icons/majors icons/anim.svg"),
                asset("icons/majors icons/gmdv.svg"),
                route("user.majors.broadcasting"),
            ],
            [
                asset("images/majors images/gmdv.png"),
                asset("icons/majors icons/gmdv.svg"),
                "Game Development",
                "Mencetak game developer yang handal dalam pemodelan serta merancang game sesuai kebutuhan industri",
                asset("icons/majors icons/bc.svg"),
                asset("icons/majors icons/dkv.svg"),
                route("user.majors.game-development")
            ],
            [
                asset("images/majors images/dkv.png"),
                asset("icons/majors icons/dkv.svg"),
                "Visual Communication Design",
                "Mencetak Seniman Digital yang kreatif, aktif, dan inovatif yang mampu bekerja dan bersaing di industri kreatif.",
                asset("icons/majors icons/gmdv.svg"),
                asset("icons/majors icons/tkj.svg"),
                route("user.majors.visual-communication-design")
            ],
            [
                asset("images/majors images/tkj.png"),
                asset("icons/majors icons/tkj.svg"),
                "IT Network",
                "Mencetak administrator server dan jaringan yang handal, cermat, inovatif dan profesional di bidang teknologi informasi dan komunikasi.",
                asset("icons/majors icons/dkv.svg"),
                asset("icons/majors icons/rpl.svg"),
                route("user.majors.network-engineering")
            ],
            [
                asset("images/majors images/rpl.png"),
                asset("icons/majors icons/rpl.svg"),
                "IT Software",
                "Menghasilkan lulusan yang cerdas, disiplin, kreatif, inovatif dan sikap profesional dibidang Rekayasa Perangkat Lunak.",
                asset("icons/majors icons/tkj.svg"),
                asset("icons/majors icons/anim.svg"),
                route("user.majors.software-engineering")
            ],
        ];

    $gallery =
        [
            'Ruangan A1' => asset("images/kelas king/a1.svg"),
            'Ruangan A2' => asset("images/kelas king/a2.svg"),
            'Ruangan A3' => asset("images/kelas king/a3.svg"),
            'Lapangan Basket' => asset("images/kelas king/lapbasket.svg"),
            'Lapangan Futsal' => asset("images/kelas king/lapfutsal.svg"),
            'Ruangan B1' => asset("images/kelas king/b1.svg"),
        ];
@endphp
@include('_components._header', ['title' => 'product'])
<div class="dashboard no-fade">
    <div class="banner">
        <div class="trinkets star-group star-group-1 no-fade">
            <img src="{{ asset("images/trinkets/star.svg") }}" alt="">
            <img src="{{ asset("images/trinkets/star.svg") }}" alt="">
        </div>
        <span class="trinkets circle circle-1 no-fade"></span>
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
                    @foreach ($newscontent as $count)
                        <span class="banner-count selected"></span>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="change-banner right"><img class="no-fade" src="{{ asset("icons/arrow-down.svg") }}" alt=""></div>
    </div>

    <h2>WE ARE</h2>
    <h1>THE PIONEER OF IT&nbspSCHOOL</h1>
    <h3>THE SKILL BUILDING WE SPECIALIZE IN ARE</h3>
    <div class="majors">
        <div class="up">
            <div class="change-major arrow-left"><img src="{{ asset("icons/arrow-down.svg") }}" alt=""><img
                    src="{{ $majors[0][4] }}" class="floating-major left"></div>
            <div class="major-slider">
                @foreach ($majors as $major)
                    <a href="{{ $major[6] }}" class="major-content">
                        <img src="{{ $major[0] }}" alt="">
                        <img class="icon" src="{{ $major[1] }}" alt="">
                        <h2>{{ $major[2] }} </h2>
                        <h3>{{ $major[3] }} </h3>
                    </a>
                @endforeach
            </div>
            <div class="change-major arrow-right"><img src="{{ asset("icons/arrow-down.svg") }}" alt=""><img
                    src="{{ $majors[0][5] }}" class="floating-major right"></div>
        </div>
        <div class="down">

            <div class="change-major">
                <img src="{{ asset("icons/left-arrow.svg") }}" class="arrow-left">
                <div class="major-counter">
                    @foreach ($majors as $major)
                        <span class="major-count"><img src="{{ $major[1] }}" alt=""></span>
                    @endforeach
                </div>
                <img src="{{ asset("icons/left-arrow.svg") }}" class="arrow-right" style="rotate: 180deg">
            </div>
        </div>
    </div>

    <div class="gallery">
        <img src="{{ asset("images/trinkets/wave.svg") }}" alt="" class="trinkets wave wave-1 no-fade">
        <div class="trinkets star-group star-group-2 no-fade">
            <img src="{{ asset("images/trinkets/star.svg") }}" alt="">
            <img src="{{ asset("images/trinkets/star.svg") }}" alt="">
        </div>
        <h2>Gallery</h2>
        <div class="img-group">
            @foreach ($galleries as $gallery)
                <span class="show gallery-img">
                    <img src="{{$gallery->url}}" alt="{{ $gallery->name }}">
                    <h3>{{ $gallery->name }}</h3>
                </span>
            @endforeach
        </div>
        <div class="img-full no-fade">
            <div class="bar">
                <p>Kelas A1</p>
                <img src="{{ asset("icons/Add_Plus.svg") }}" alt="" class="close-img-full">
            </div>
            <img src="{{ $placeholder }}" alt="">
            <div class="other-img">
                <img src="{{ $placeholder }}" alt="" class="this">
                <img src="{{ $placeholder }}" alt="">
                <img src="{{ $placeholder }}" alt="">
                <img src="{{ $placeholder }}" alt="">
                <img src="{{ $placeholder }}" alt="">
            </div>
        </div>
        <button class="button" onclick="location.href='{{ route('user.galleries') }}'">VIEW ALL</button>
    </div>

    <div class="news">
        <h2>BI NEWS</h2>
        <div class="news-group">
            @foreach ($articles as $article)
                <a href="{{ route('user.news', ['news' => $article->id]) }}">
                    <img src="{{ $article->thumbnail_url }}" alt="{{ $article->title }}">
                    <div class="news-info">
                        <div class="tags">
                            <div class="tags-slider">
                                @if ($article->keywords->count() == 0)
                                    <p class="tag{{ rand(1, 3) }}">Artikel Belum Memiliki Keyword</p>
                                @else
                                    @foreach ($article->keywords ?? [] as $keyword)
                                        <p class="tag{{ rand(1, 3) }}">{{ $keyword->name }}</p>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        <div class="date">
                            <p>{{ substr($article->created_at, 0, 10) }}</p>
                        </div>
                    </div>
                    <h3>{{ $article->title }}</h3>
                    <h4>{{ $article->description }}</h4>
                </a>
            @endforeach
        </div>
    </div>

</div>

<script>
    // ========================================================================================================================================

    document.addEventListener("DOMContentLoaded", () => {
        const banner = document.querySelector(".sliding-banner")
        const leftBtn = document.querySelector(".change-banner.left")
        const rightBtn = document.querySelector(".change-banner.right")
        const counters = document.querySelectorAll(".banner-count")
        const banners = document.querySelectorAll(".banner-content")

        const scrollStep = banner.clientWidth
        const scrollSpeed = 5000
        let autoScroll
        let scrollTimeout

        const updateCounter = () => {
            const index = Math.round(banner.scrollLeft / scrollStep)
            counters.forEach((c, i) => c.classList.toggle("selected", i === index))
        }

        const scrollLeft = () => {
            if (banner.scrollLeft <= 0) {
                banner.scrollTo({ left: banner.scrollWidth - scrollStep, behavior: "instant" })
            } else {
                banner.scrollBy({ left: -scrollStep, behavior: "smooth" })
            }
            setTimeout(updateCounter, 600)
        }

        const scrollRight = () => {
            if (banner.scrollLeft + banner.clientWidth >= banner.scrollWidth - 1) {
                banner.scrollTo({ left: 0, behavior: "smooth" })
            } else {
                banner.scrollBy({ left: scrollStep, behavior: "smooth" })
            }
            setTimeout(updateCounter, 600)
        }

        const startAutoScroll = () => {
            stopAutoScroll()
            autoScroll = setInterval(() => {
                scrollRight()
            }, scrollSpeed)
        }

        const stopAutoScroll = () => clearInterval(autoScroll)

        leftBtn.addEventListener("click", () => {
            scrollLeft()
            stopAutoScroll()
            startAutoScroll()
        })

        rightBtn.addEventListener("click", () => {
            scrollRight()
            stopAutoScroll()
            startAutoScroll()
        })

        banner.addEventListener("mouseenter", stopAutoScroll)
        banner.addEventListener("mouseleave", startAutoScroll)

        banner.addEventListener("scroll", () => {
            stopAutoScroll()
            clearTimeout(scrollTimeout)
            scrollTimeout = setTimeout(() => {
                updateCounter()
                startAutoScroll()
            }, 200)
        })

        // Initialize everything
        updateCounter()
        startAutoScroll()
    })


    // ========================================================================================================================================

    const gallery_img = document.querySelectorAll(".gallery-img")
    const full_img = document.querySelector(".img-full")
    const close_full_img = document.querySelector(".close-img-full")

    gallery_img.forEach(image => {
        image.addEventListener("click", () => {
            full_img.classList.add("active")
            document.body.style.overflowY = "hidden"
        })
    })

    close_full_img.addEventListener("click", () => {
        full_img.classList.remove("active")
        document.body.style.overflowY = "auto"
    })

    // ========================================================================================================================================

    const majors = document.querySelectorAll('.major-content')
    const counters = document.querySelectorAll('.major-count')
    const leftIcon = document.querySelector('.floating-major.left')
    const rightIcon = document.querySelector('.floating-major.right')

    const majorsData = @json($majors)

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                counters.forEach(c => c.classList.remove('selected'))

                const index = Array.from(majors).indexOf(entry.target)
                counters[index]?.classList.add('selected')

                if (majorsData[index]) {
                    leftIcon.src = majorsData[index][4]
                    rightIcon.src = majorsData[index][5]
                }
            }
        })
    }, {
        threshold: 0.6,
        root: document.querySelector('.major-slider')
    })

    majors.forEach(major => observer.observe(major))

    // =================================================================================================================

    const nav = document.querySelector(".navigation-user")
    let lastScroll = window.scrollY
    let ticking = false

    window.addEventListener("scroll", () => {
        if (!ticking) {
            window.requestAnimationFrame(() => {
                const currentScroll = window.scrollY

                if (Math.abs(currentScroll - lastScroll) > 50) {
                    if (currentScroll > lastScroll && currentScroll > 20) {
                        nav.style.top = "-200px"
                    } else {
                        nav.style.top = "0"
                    }
                    lastScroll = currentScroll
                }

                ticking = false
            })

            ticking = true
        }
    })

    // ==========================================================================================================================================================================

    document.addEventListener("DOMContentLoaded", () => {
        const elements = [...document.querySelectorAll(
            "*:not(.no-fade):not(body):not(html):not(main):not(header):not(footer):not(nav):not(.container):not(.wrapper)"
        )]


        elements.forEach(el => {
            const computed = window.getComputedStyle(el)
            el.dataset.originalOpacity = computed.opacity || 1
        })

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                const el = entry.target
                const original = parseFloat(el.dataset.originalOpacity)
                const faded = Math.max(original - 0.5, 0)

                if (entry.isIntersecting) {
                    el.style.opacity = original
                } else {
                    el.style.opacity = faded
                }
            })
        }, { threshold: 0.1 })

        elements.forEach(el => observer.observe(el))
    })

    // ========================================================================================================================================

    document.addEventListener("DOMContentLoaded", () => {
        const slider = document.querySelector(".major-slider")
        const leftArrows = document.querySelectorAll(".arrow-left")
        const rightArrows = document.querySelectorAll(".arrow-right")

        const slideWidth = slider.querySelector(".major-content").offsetWidth

        leftArrows.forEach(arrow => {
            arrow.addEventListener("click", () => {
                if (slider.scrollLeft <= 0) {
                    slider.scrollBy({
                        left: majors.length * slideWidth,
                        behavior: "smooth"
                    })
                    return;
                }
                slider.scrollBy({
                    left: -slideWidth,
                    behavior: "smooth"
                })
            })
        });

        rightArrows.forEach(arrow => {
            arrow.addEventListener("click", () => {
                if (slider.scrollLeft >= ((majors.length - 1) * slideWidth)) {
                    slider.scrollBy({
                        left: -(majors.length * slideWidth),
                        behavior: "smooth"
                    })
                    return;
                }
                slider.scrollBy({
                    left: slideWidth,
                    behavior: "smooth"
                })
            })
        });
    })


</script>


@include('_components._footer')