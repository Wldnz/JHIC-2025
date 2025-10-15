<aside class="left close-sidebar">
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
                    <a class="display-menu" href="{{ route("admin.dashboard") }}">
                        @include('_components._sprite-icons', ['name' => 'dashboard', "color" => $currentPath == 'dashboard' ? '#273B98' : 'black', 'size' => 23])
                        <span>Dashboard</span>
                    </a>
                </li>
                @if(Auth::user()->role == 'admin' || Auth::user()->role == 'super_admin')


                    <li class="menu" id="menu-transactions" data-open=false>
                        <a class="display-menu" href="{{ route('admin.transactions') }}">
                            @include('_components._sprite-icons', ['name' => 'transaction', "color" => $currentPath == 'products' ? '#273B98' : 'black', 'size' => 23])
                            <span>Transactions</span>
                        </a>
                    </li>
                    <li class="menu multiple" id="menu-public" data-open=false>
                        <a class="display-menu">
                            @include('_components._sprite-icons', ['name' => 'eye', "color" => $currentPath == 'public' ? '#273B98' : 'black', 'size' => 23])
                            <span>Public</span>
                        </a>
                        <a class="sub-menu" href="{{ route("admin.news") }}" id="news">
                            <span>News</span>
                        </a>
                        <a class="sub-menu" href="{{ route("admin.facility") }}" id="faciliti">
                            <span>Facility</span>
                        </a>
                        <a class="sub-menu" href="{{ route("admin.portfolio") }}" id="portfolio">
                            <span>Portfolio</span>
                        </a>
                        <a class="sub-menu" href="{{ route("admin.achievement") }}" id="achievement">
                            <span>Achievement</span>
                        </a>
                    </li>

                    <li class="menu multiple" id="menu-accounts" data-open=false>
                        <a class="display-menu">
                            @include('_components._sprite-icons', ['name' => 'account', "color" => $currentPath == 'accounts' ? '#273B98' : 'black', 'size' => 23])
                            <span>Accounts</span>
                        </a>
                        <a class="sub-menu" href="{{ route("admin.accounts") }}" id="account">
                            <span>Accounts</span>
                        </a>
                        <a class="sub-menu" href="{{ route("admin.students") }}" id="student">
                            <span>Students</span>
                        </a>
                    </li>

                    <li class="menu" id="menu-settings">
                        <a class="display-menu" href="{{ route("admin.settings") }}">
                            @include('_components._sprite-icons', ['name' => 'settings', "color" => $currentPath == 'settings' ? '#273B98' : 'black', 'size' => 25])
                            <span>Settings</span>
                        </a>
                    </li>

                @elseif(Auth::user()->role == 'article_creator')
                    <li class="menu multiple" id="menu-public" data-open=false>
                        <a class="display-menu">
                            @include('_components._sprite-icons', ['name' => 'eye', "color" => $currentPath == 'public' ? '#273B98' : 'black', 'size' => 23])
                            <span>Public</span>
                        </a>
                        <a class="sub-menu" href="{{ route("admin.news") }}" id="news">
                            <span>News</span>
                        </a>
                    </li>

                @endif
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
        locations = {
            pathname : 'admin',
            "inventory": [
                "products",
                "transactions",
            ],
            "public": [
                "news-create",
                "news",
                "medias",
                "medias-create",
                "portfolios-create",
                "portfolios",
                "achievements-create",
                "achievements",
                "facilities-create",
                "facilities"
            ],
            "accounts" : [
                "accounts-create",
                "accounts",
                "students-create",
                "students"
            ]
        };
    }
</script>
@vite('resources/js/handle/navigation-side.js')
