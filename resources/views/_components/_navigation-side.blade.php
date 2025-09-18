<aside class="left close-sidebar">
    <nav class="navigation-side">
        <div class="wrapper-navigation">
            <div class="wrapper-image">
                <div class="brand"></div>
                <div class="logo"></div>
            </div>
            <ul class="main-menu">
                <li id="menu-dashboard">
                    <a href="{{ route("admin.dashboard") }}">
                        @include('_components._sprite-icons', ['name' => 'dashboard', "color" => $currentPath == 'dashboard' ? '#273B98' : 'black', 'size' => 25])
                        <span>Dashboard</span>
                    </a>
                </li>
                <li id="menu-products">
                    <a href="{{ route("admin.products") }}">
                        @include('_components._sprite-icons', ['name' => 'product', "color" => $currentPath == 'products' ? '#273B98' : 'black', 'size' => 25])
                        <span>Products</span>
                    </a>
                </li>
                <li id="menu-transactions">
                    <a href="{{ route("admin.transactions") }}">
                        @include('_components._sprite-icons', ['name' => 'transaction', "color" => $currentPath == 'transactions' ? '#273B98' : 'black', 'size' => 25])
                        <span>Transactions</span>
                    </a>
                </li>
                <li id="menu-accounts">
                    <a href="{{ route("admin.accounts") }}">
                        @include('_components._sprite-icons', ['name' => 'account', "color" => $currentPath == 'accounts' ? '#273B98' : 'black', 'size' => 25])
                        <span>Accounts</span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="wrapper-action">
            @include('_components._sprite-icons', ['name' => 'exception', 'color' => '#273B98', 'size' => 25])
            @include('_components._sprite-icons', ['name' => 'hamburger-menu', 'color' => '#273B98', 'size' => 25])
        </div>
    </nav>
</aside>

<script defer>

    // handle close and open the sideBar
    const asideleft = document.querySelector('.left');
    const main_menu = document.querySelector('.wrapper-navigation').children[1];
    const button_close = document.querySelector('.wrapper-action').children[0];
    const button_open = document.querySelector('.wrapper-action').children[1];

    function openSideBar(e) {
        Array.from(main_menu.children).forEach(element => {
            element.children[0].children[1].style.display = 'block';
            element.children[0].style.justifyContent = 'start';
        });
        // asideleft.style.width = '350px';

        asideleft.classList.remove('close-sidebar');
        asideleft.classList.add('open-sidebar');

        this.parentElement.children[0].style.display = 'block';
        this.parentElement.children[1].style.display = 'none';

        // display the logo
        this.parentElement.parentElement.children[0].children[0].children[0].style.display = 'block';
        this.parentElement.parentElement.children[0].children[0].children[1].style.display = 'none';
    }

    function closeSideBar(e) {
        Array.from(main_menu.children).forEach(element => {
            element.children[0].children[1].style.display = 'none';
            element.children[0].style.justifyContent = 'center';
        });

        // asideleft.style.width = '100px';

        asideleft.classList.remove('open-sidebar');
        asideleft.classList.add('close-sidebar');

        this.parentElement.children[0].style.display = 'none';
        this.parentElement.children[1].style.display = 'block';
        // display the logo
        this.parentElement.parentElement.children[0].children[0].children[0].style.display = 'none';
        this.parentElement.parentElement.children[0].children[0].children[1].style.display = 'block';
    }

    // handle active and non active main-menu
    function handleActiveAndNonActiveMainMenu() {
        const pathname = (location.pathname).split('/admin/')[1];
        Array.from(main_menu.children).forEach(element => {
            if ((element.id).split('menu-')[1] == pathname && !element.classList.contains('active')) {
                element.classList.add('active');
            } else {
                element.classList.remove('active')
            }
        });
    }

    button_open.addEventListener('click', openSideBar);

    button_close.addEventListener('click', closeSideBar);
    handleActiveAndNonActiveMainMenu();
</script>