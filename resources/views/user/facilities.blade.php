@php
    $placeholder = "https://www.svgrepo.com/show/508699/landscape-placeholder.svg";
@endphp
@include('_components._header', [
    'title' => 'Fasilitas | SMK Bina Informatika',
    'description' => 'SMK BINA INFORMATIKA MEMILIKI BANYAK FASILITAS YANG DAPAT MEMBANTU SERTA MENGEMBANGKAN KEMAMPUSAN SISWA/I',
    'keywords' => 'Fasilitas, facility, Virtuality, 3D Fasilitas, fasilitas sekolah, 3d, unity, game, javascript unity, gallery, blender, 3d game, unity engine'
])
<div class="facility no-fade">
    <div class="unity">
        <h1>3D School View</h1>
        <iframe class="frame" src="https://aqil-atepi.github.io/TourSekolahBI/"></iframe>
    </div>

    <div class="info-facility">
        <div class="fill"></div>
        <div class="rooms pc">
            <p>10+ Classes <br> 6+ Computer Lab</p>
        </div>
        <p>ALL THE FACILITY<br> YOU NEED</p>
        <div class="rooms">
            <p>10+ Classes</p>
            <p>6+ Computer Lab</p>
        </div>
        <p>Complete With<br> AC, Fan, And Wifi</p>
        <div class="fill"></div>
    </div>

    <div class="gallery">
        <h1>Gallery</h1>
        <div class="gallery-images">
            @foreach ($facilities as $gallery)
                <span class="gallery-image">
                    <img class="gallery-image-url" src="{{$gallery->url}}" alt="{{ $gallery->name }}">
                    <p class="gallery-name">{{ $gallery->name }}</p>
                </span>
            @endforeach
            <div class="gallery-full">
                <div class="button-wrapper">
                    <p class="preview-gallery-name">Kamar Wildan</p>
                    <img class="gallery-close" src="{{ asset("icons/Add_Plus.svg") }}" alt="">
                </div>
                <div class="img-wrapper">
                    <img class="preview-gallery-url" src="" alt="">
                </div>
                <div class="other-images">
                    <img src="" alt="">
                </div>
            </div>
        </div>
    </div>

    <div class="location no-fade">
        <h1>Our Location</h1>
        <div class="location-body no-fade">
            <div class="left no-fade">

                <div class="map lobby">
                    <img src="{{ asset("images/maps/lobby.png") }}" class="clickable">
                    <div class="full no-fade">
                        <div class="img-wrapper">
                            <img class="close-full" src="{{ asset("icons/Add_Plus.svg") }}" alt="">
                        </div>
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!4v1760449481240!6m8!1m7!1sCAoSLEFGMVFpcE1yUzdBUXNtc3lYakdhQWhTazNEYlhpdElsMTBEVlJReVl3b1Fl!2m2!1d-6.2815895!2d106.7243392!3f1.5085195514287264!4f-0.6134822258928807!5f0.7820865974627469"
                            style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>

                <div class="map lab">
                    <img src="{{ asset("images/maps/lab.png") }}" class="clickable">
                    <div class="full no-fade">
                        <div class="img-wrapper">
                            <img class="close-full" src="{{ asset("icons/Add_Plus.svg") }}" alt="">
                        </div>
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!4v1760449733181!6m8!1m7!1sCAoSLEFGMVFpcE14VG5HNk43M1lWczNHQmwwdkozZHpFLU5oTkJzQV9pM0FRbFVM!2m2!1d-6.281604799999999!2d106.7241371!3f222.42348368603106!4f-15.311259695616542!5f0.7820865974627469"
                            style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
            <div class="right no-fade">
                <p>Jl. Tegal Rotan Raya No.9 A, Sawah Baru, Kec. Ciputat, Kota Tangerang Selatan, Banten 15412</p>

                <div class="map gmap">
                    <img src="{{ asset("images/maps/map.png") }}" class="clickable">
                    <div class="full no-fade">
                        <div class="img-wrapper">
                            <img class="close-full" src="{{ asset("icons/Add_Plus.svg") }}" alt="">
                        </div>
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d3965.864806476786!2d106.7244724!3d-6.2814977!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f0754ef56067%3A0x8220dbf978d54527!2sSMK%20Bina%20Informatika!5e0!3m2!1sen!2sid!4v1760442033037!5m2!1sen!2sid"
                            style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>

                <div class="map kelas">
                    <img src="{{ asset("images/maps/kelas.png") }}" class="clickable">
                    <div class="full no-fade">
                        <div class="img-wrapper">
                            <img class="close-full" src="{{ asset("icons/Add_Plus.svg") }}" alt="">
                        </div>
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!4v1760441766203!6m8!1m7!1sCAoSLEFGMVFpcFBtX2VvTHZGbDNKa3k1R2NBUHhscjdjWlB1OWVpUTIwSnZjNUVI!2m2!1d-6.2814159!2d106.7244954!3f344.4937744066999!4f-4.216318889908663!5f0.7820865974627469"
                            style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    // fade script

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

    // ===============================================================
    // navbar script

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


    // ===============================================================
    // expandable

    document.querySelectorAll(".clickable").forEach(el => {
        el.addEventListener("click", () => {
            el.nextElementSibling.classList.add("active")
            document.body.style.overflow = "hidden"
        })
    })
    document.querySelectorAll(".close-full").forEach(el => {
        el.addEventListener("click", () => {
            el.parentElement.parentElement.classList.remove("active")
            document.body.style.overflow = "auto"
        })
    })

    // ===============================================================
    // gallery-img

const gallery_preview_name = document.querySelector('.preview-gallery-name');
const gallery_preview_image = document.querySelector('.preview-gallery-url');
const other_images = document.querySelector('.other-images');
const galleries = @json($facilities ?? []);

document.querySelectorAll(".gallery-image").forEach(el => {
    el.addEventListener("click", () => {
        gallery_preview_name.textContent = el.querySelector('.gallery-name').textContent;
        gallery_preview_image.src = el.querySelector('.gallery-image-url').src;
        document.querySelector(".gallery-full").classList.add("active")
        document.body.style.overflow = "hidden"

        const { name, gallery_type_name } = galleries.find(g => g.name == el.querySelector('.gallery-name').textContent);
        if(!name || !gallery_type_name) return;
        const gs = galleries.filter(g => {
            return g.name != name && g.gallery_type_name == gallery_type_name;
        });

        let string_images = '';
        gs.forEach(g => string_images += `<img src="${g.url}" alt="${g.name}">`);
        other_images.innerHTML = string_images;
    })
})
document.querySelector(".gallery-close").addEventListener("click", () => {
    document.querySelector(".gallery-full").classList.remove("active")
    document.body.style.overflow = "auto"
})


</script>


@include('_components._footer')