<aside class="left close-sidebar">
    <nav class="navigation-side" data-open="false">
        <div class="wrapper-navigation">
            <div class="wrapper-image">
                <div class="brand"></div>
                <div class="logo"></div>
            </div>
            <ul class="main-menu">
                <li class="menu" id="menu-dashboard">
                    <a class="display-menu" href="{{ route("admin.dashboard") }}">
                        @include('_components._sprite-icons', ['name' => 'dashboard', "color" => $currentPath == 'dashboard' ? '#273B98' : 'black', 'size' => 23])
                        <span>Dashboard</span>
                    </a>
                </li>
                @if(Auth::user()->role == 'admin' || Auth::user()->role == 'super_admin')

                    <li class="menu" id="menu-inventory" data-open=false>
                        <a class="display-menu" href="{{ route('admin.transactions') }}">
                            @include('_components._sprite-icons', ['name' => 'transaction', "color" => $currentPath == 'products' ? '#273B98' : 'black', 'size' => 23])
                            <span>Transactions</span>
                        </a>
                    </li>

                    <li class="menu" id="menu-accounts">
                        <a class="display-menu" href="{{ route("admin.accounts") }}">
                            @include('_components._sprite-icons', ['name' => 'account', "color" => $currentPath == 'accounts' ? '#273B98' : 'black', 'size' => 23])
                            <span>Accounts</span>
                        </a>
                    </li>

                    <li class="menu" id="menu-settings">
                        <a class="display-menu" href="{{ route("admin.settings") }}">
                            @include('_components._sprite-icons', ['name' => 'settings', "color" => $currentPath == 'settings' ? '#273B98' : 'black', 'size' => 25])
                            <span>Settings</span>
                        </a>
                    </li>

                @else

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
    const asideleft = document.querySelector('.left');
    const wp_image = asideleft.querySelector('.wrapper-image');
    const menu_chidrens = Array.from(document.querySelector('.wrapper-navigation').children[1]?.children ?? []);
    const button_close = document.querySelector('.wrapper-action').children[0];
    const button_open = document.querySelector('.wrapper-action').children[1];

    function handleMultipleMenu() {
        menu_chidrens.forEach(menu => {
            if (menu.classList.contains('multiple')) {
                menu.addEventListener('click', (e) => {
                    if (asideleft.children[0].dataset.open.includes('false')) {
                        openSideBar({ target: button_open })
                    };
                    handleSubMenu(menu);
                });
            }
        });
    }

    function handleSubMenu(menuElement, isInitialize = false) {
        if (isInitialize) return;
        const open = menuElement.dataset.open.includes('true');
        Array.from(menuElement.children)
            .filter((s, index) => s.classList.contains('sub-menu'))
            .forEach(sub => {
                sub.style.display = open ? 'none' : 'flex';
                sub.style.justifyContent = 'start';
                sub.children[0].style.display = open ? 'none' : 'flex';
            });
        menuElement.dataset.open = !open;
    }

    function openSideBar({ target }) {
        menu_chidrens.forEach(element => {
            element.children[0].children[1].style.display = 'block';
            element.children[0].style.justifyContent = 'start';
        });

        asideleft.classList.remove('close-sidebar');
        asideleft.classList.add('open-sidebar');

        button_close.style.display = 'block';
        button_open.style.display = 'none';

        // display the logo
        wp_image.children[0].style.display = 'block';
        wp_image.children[1].style.display = 'none';
        asideleft.children[0].dataset.open = true;
    }

    function closeSideBar() {
        menu_chidrens.forEach(element => {
            element.children[0].children[1].style.display = 'none';
            element.children[0].style.justifyContent = 'center';
            if (element.classList.contains('multiple')) {
                element.dataset.open = true;
                handleSubMenu(element);
            }
        });

        asideleft.classList.remove('open-sidebar');
        asideleft.classList.add('close-sidebar');

        button_close.style.display = 'none';
        button_open.style.display = 'block';

        // display the logo
        wp_image.children[0].style.display = 'none';
        wp_image.children[1].style.display = 'block';
        asideleft.children[0].dataset.open = false;
    }

    // handle active and non active main-menu
    function handleActiveAndNonActiveMainMenu() {
        const pathname = (location.pathname).split('/admin/')[1];
        const locations = {
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
            ]
        };
        menu_chidrens.forEach(menu => {
            const name = menu.id.split('-')[1];
            const isMultiple = menu.classList.contains('multiple');
            const display_name = menu.children[0];
            if (isMultiple) {
                const isCurrentLocation = locations[name].includes(pathname);
                if (isCurrentLocation) {
                    display_name.classList.add('active');
                    Array.from(menu.children)
                        .find(sub => sub.id == pathname)
                        ?.classList.add('active');
                    handleSubMenu(menu, true);
                }
            } else if (name == pathname) {
                display_name.classList.add('active');
            }
        });
    }


    button_open.addEventListener('click', openSideBar);

    button_close.addEventListener('click', closeSideBar);
    handleActiveAndNonActiveMainMenu();
    handleMultipleMenu();
</script>