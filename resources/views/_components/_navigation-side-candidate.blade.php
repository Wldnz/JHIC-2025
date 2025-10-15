<aside class="left close-sidebar-candidate">
    <nav class="navigation-side" data-open="false">
        <div class="wrapper-navigation">
            <div class="wrapper-image">
                <a href="{{ route('admin.dashboard') }}" class="brand">
                    <img src="{{ asset('images/bi-full.png') }}" alt="logo-bi">
                </a>
                <a href="{{ route('admin.dashboard') }}" class="logo">
                    <img src="{{ asset('images/logo-bi.png') }}" alt="logo-bi">
                </a>
            </div>
            <ul class="main-menu">
                <li class="menu" id="menu-dashboard">
                    <a class="display-menu" href="{{ route("candidate.dashboard") }}">
                        @include('_components._sprite-icons', ['name' => 'dashboard', "color" => $currentPath == 'dashboard' ? '#273B98' : 'black', 'size' => 23])
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="menu" id="menu-form">
                    <a class="display-menu" href="{{ route("candidate.dashboard") }}">
                        @include('_components._sprite-icons', ['name' => 'document', "color" => $currentPath == 'dashboard' ? '#273B98' : 'black', 'size' => 23])
                        <span>Formulir Pendaftaran</span>
                    </a>
                </li>
                <li class="menu multiple" id="menu-usm" data-open="false">
                    <a class="display-menu">
                        @include('_components._sprite-icons', ['name' => 'form-time', "color" => $currentPath == 'dashboard' ? '#273B98' : 'black', 'size' => 23])
                        <span>Ujian Sharigan Masuk</span>
                    </a>
                    <a class="sub-menu" href="{{ route('candidate.schedule') }}"  id="schedule">
                        <span>Jadwal Pelaksanaan</span>
                    </a>
                    <a class="sub-menu" href="{{ route('candidate.learning-materials') }}" id="learning-materials">
                       <span>Materi - Materi</span>
                    </a>
                </li>
                <li class="menu" id="menu-contact">
                    <a class="display-menu" href="{{ route("candidate.contact") }}">
                        @include('_components._sprite-icons', ['name' => 'customer-service', "color" => $currentPath == 'contact' ? '#273B98' : 'black', 'size' => 23])
                        <span>Kontak Kami</span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="wrapper-action">
            <button class="btn-svg">
                @include('_components._sprite-icons', ['name' => 'exception', 'color' => '#273B98', 'size' => 25])
            </button>
            <button class="btn-svg">
                @include('_components._sprite-icons', ['name' => 'hamburger-menu', 'color' => '#273B98', 'size' => 25])
            </button>
        </div>
    </nav>
</aside>

<script defer>
    const setupNeededData = {
        pathname : 'candidate',
        locations : {
            usm : [
                'schedule',
                'learning-materials'
            ]
        }
    };

    const animationSideBar = {
        open : 'open-sidebar-candidate',
        close : 'close-sidebar-candidate',
    };

    const additionalHandler = (isOpen = true, element) => {
        element.style.display = isOpen ? 'none' : 'block';
    }

</script>

@vite('resources/js/handle/navigation-side.js')