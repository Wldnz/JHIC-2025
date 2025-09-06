@include('_components._headerAdmin')
@php
    $currentPath = explode('/admin/', url()->current())[1];
@endphp
<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
<main class="wrapper-admin">
    <aside class="left">
        <nav class="navigation-side">
            <div class="wrapper-navigation">
                <div class="wrapper-image">
                    <img src="{{ asset("icons/default-logo.png") }}" alt="logo-bitu" height="50">
                    @include('_components._sprite-icons', ['name' => 'dashboard', "color" => "black", 'size' => 40])
                </div>
                <ul class="main-menu">
                    <li id="menu-dashboard">
                        <a href="{{ route("admin.dashboard") }}">
                            @include('_components._sprite-icons', ['name' => 'dashboard', "color" => $currentPath == 'dashboard'? '#273B98' : 'black', 'size' => 40])
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li id="menu-products">
                        <a href="{{ route("admin.products") }}">
                            @include('_components._sprite-icons', ['name' => 'product', "color" => $currentPath == 'products'? '#273B98' : 'black', 'size' => 40])
                            <span>Products</span>
                        </a>
                    </li>
                    <li id="menu-transactions">
                        <a href="{{ route("logout") }}">
                            @include('_components._sprite-icons', ['name' => 'transaction', "color" => $currentPath == 'transactions'? '#273B98' : 'black', 'size' => 40])
                            <span>Transactions</span>
                        </a>
                    </li>
                    <li id="menu-accounts">
                        <a href="{{ route("logout") }}">
                            @include('_components._sprite-icons', ['name' => 'account', "color" => $currentPath == 'accounts'? '#273B98' : 'black', 'size' => 40])
                            <span>Accounts</span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="wrapper-action">
                @include('_components._sprite-icons', ['name' => 'exception', 'color' => '#273B98', 'size' => 40])
                @include('_components._sprite-icons', ['name' => 'hamburger-menu', 'color' => '#273B98', 'size' => 40])
            </div>
        </nav>
        <script>
            
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

                asideleft.style.width = '350px';
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

                asideleft.style.width = '100px';
                this.parentElement.children[0].style.display = 'none';
                this.parentElement.children[1].style.display = 'block';
                // display the logo
                this.parentElement.parentElement.children[0].children[0].children[0].style.display = 'none';
                this.parentElement.parentElement.children[0].children[0].children[1].style.display = 'block';
            }

            // handle active and non active main-menu
            function handleActiveAndNonActiveMainMenu(){
                const pathname = (location.pathname).split('/admin/')[1];
                Array.from(main_menu.children).forEach(element => {
                    if((element.id).split('menu-')[1] == pathname && !element.classList.contains('active')){
                        element.classList.add('active');
                    }else{
                        element.classList.remove('active')
                    }
                });
            }

            button_open.addEventListener('click', openSideBar);

            button_close.addEventListener('click', closeSideBar);
            handleActiveAndNonActiveMainMenu();
        </script>
    </aside>
    <aside class="right">
        <div class="bar-top">
            <h4>{{ $title ?? "Dashboard" }}</h4>
            <div class="profile">
                <span class="icon">🧒🏻</span>
                <ul class="main-menu">
                    <li>
                        <a href="{{ route("logout") }}">
                            @include('_components._sprite-icons', ['name' => 'account', 'color' => '#273B98', 'size' => 25])
                            Profile
                        </a>
                    </li>
                    <li>
                        <a href="{{ route("logout") }}">
                            @include('_components._sprite-icons', ['name' => 'logout', 'color' => '#273B98', 'size' => 25])
                            Log Out
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div style="width:100%; height: 25px;"></div>
        <main class="main-admin">
            <div class="header">
                <h2>Selamat Datang, {{ $user['fullname'] }} </h2>
                <p>There is summary data of all things</p>
            </div>
            <div class="wrapper-section-summary-data">
                <div class="section-summary-data">
                    <div class="title">
                        <h4>Transactions</h4>
                        <a href="{{ route("admin.dashboard") }}">Manage ></a>
                    </div>
                    <div class="wrapper-summary-data">
                        <div class="summary-data">
                            <div class="icon-data">
                                @include('_components._sprite-icons', ['name' => 'transaction', 'color' => 'white', 'size' => 45])
                            </div>
                            <div class="info-data">
                                <div class="data">
                                    <h5>1000 Transactions</h5>
                                </div>
                                <p>Total</p>
                            </div>
                        </div>
                        <div class="summary-data">
                            <div class="icon-data">
                                @include('_components._sprite-icons', ['name' => 'transaction', 'color' => 'white', 'size' => 45])
                            </div>
                            <div class="info-data">
                                <div class="data">
                                    <h5>890 Transactions</h5>
                                </div>
                                <p>Success</p>
                            </div>
                        </div>
                        <div class="summary-data">
                            <div class="icon-data">
                                @include('_components._sprite-icons', ['name' => 'transaction', 'color' => 'white', 'size' => 45])
                            </div>
                            <div class="info-data">
                                <div class="data">
                                    <h5>10 Transactions</h5>
                                </div>
                                <p class="">On Going</p>
                            </div>
                        </div>
                        <div class="summary-data">
                            <div class="icon-data">
                                @include('_components._sprite-icons', ['name' => 'transaction', 'color' => 'white', 'size' => 45])
                            </div>
                            <div class="info-data">
                                <div class="data">
                                    <h5>1000 Transactions</h5>
                                </div>
                                <p>Fail</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="section-summary-data">
                    <div class="title">
                        <h4>Products</h4>
                        <a href="{{ route("admin.dashboard") }}">Manage ></a>
                    </div>
                    <div class="wrapper-summary-data">
                        <div class="summary-data">
                            <div class="icon-data">
                                @include('_components._sprite-icons', ['name' => 'product', 'color' => 'white', 'size' => 40])
                            </div>
                            <div class="info-data">
                                <div class="data">
                                    <h5>28 Products</h5>
                                </div>
                                <p>Total</p>
                            </div>
                        </div>
                        <div class="summary-data">
                            <div class="icon-data">
                                @include('_components._sprite-icons', ['name' => 'product', 'color' => 'white', 'size' => 40])
                            </div>
                            <div class="info-data">
                                <div class="data">
                                    <h5>20 Products</h5>
                                </div>
                                <p>Available</p>
                            </div>
                        </div>
                        <div class="summary-data">
                            <div class="icon-data">
                                @include('_components._sprite-icons', ['name' => 'product', 'color' => 'white', 'size' => 40])
                            </div>
                            <div class="info-data">
                                <div class="data">
                                    <h5>5 Products</h5>
                                </div>
                                <p>Almost Sold Out</p>
                            </div>
                        </div>
                        <div class="summary-data">
                            <div class="icon-data">
                                @include('_components._sprite-icons', ['name' => 'product', 'color' => 'white', 'size' => 40])
                            </div>
                            <div class="info-data">
                                <div class="data">
                                    <h5>23 Products</h5>
                                </div>
                                <p>Sold Out</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Activity & Admin -->
                <div class="section-summary-data">
                    <div class="title">
                        <h4>Account & Activity</h4>
                        <a href="{{ route("admin.dashboard") }}">Manage ></a>
                    </div>
                    <div class="wrapper-summary-data">
                        <div class="summary-data">
                            <div class="icon-data">
                                @include('_components._sprite-icons', ['name' => 'account', 'color' => 'white', 'size' => 40])
                            </div>
                            <div class="info-data">
                                <div class="data">
                                    <h5>4 Accounts</h5>
                                </div>
                                <p>Total</p>
                            </div>
                        </div>
                        <div class="summary-data">
                            <div class="icon-data">
                                @include('_components._sprite-icons', ['name' => 'activity', 'color' => 'white', 'size' => 40])
                            </div>
                            <div class="info-data">
                                <div class="data">
                                    <h5>10000 Activities</h5>
                                </div>
                                <p>Total</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div style="width:100%; height: 105px;"></div>
            <h2>What We Have? It's
                <br>Statistic About Your Product & Transaction
            </h2>
            <div style="width:100%; height: 35px;"></div>
            <div class="statistic">
                <div class="piechart" id="piechart"></div>
                <div class="barchat" id="barchat"></div>
            </div>

            <section class="management-data" id="management-table">
                <div class="wrapper-title">
                    <div class="title">
                        <h2>5 Transaction On Going</h2>
                        <div class="point-active"></div>
                    </div>
                    <button class="btn btn-submit" type="button">Add Transaction</button>
                </div>
                <div class="management-table">
                    <div class="wrapper-filter">
                        <div class="filter">
                            <div class="wrapper-select">
                                <div class="wrapper-icon">
                                    @include('_components._sprite-icons', ['name' => 'drop-down', 'color' => '#273B98', 'size' => 20])
                                </div>
                                <select name="price" id="price">
                                    <option value="">All Price</option>
                                    <option value="lowest">Lowest Price</option>
                                    <option value="lowest">Highest Price</option>
                                </select>
                            </div>
                        </div>
                        <form class="wrapper-search-engine" action="#management-table">
                            @csrf
                            <input type="text" name="search" placeholder="BINA00004" value="{{ old('searc') ?? ''}}"
                                required>
                            <button type="submit">
                                @include('_components._sprite-icons', ['name' => 'search', 'color' => 'white', 'size' => 40])
                            </button>
                        </form>
                    </div>
                    <table>
                        <tr>
                            <th>Transaction ID</th>
                            <th>FullName</th>
                            <th>Total Product</th>
                            <th>Total Price</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                        <!-- data -->
                        <tr>
                            <td>BINA00001</td>
                            <td>Wildan Izhar Al Haqq</td>
                            <td>10 Products</td>
                            <td>IDR 2.300.000,00</td>
                            <td>21-08-2025</td>
                            <td>On Going
                                <div class="profile">
                                    @include('_components._sprite-icons', ['name' => 'tree-dots', 'color' => '#273B98', 'size' => '20'])
                                    <ul class="main-menu" style="top:25px">
                                        <li>
                                            <a href="{{ route("logout") }}">
                                                @include('_components._sprite-icons', ['name' => 'eye', 'color' => '#273B98', 'size' => 25])
                                                View Transaction
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route("logout") }}">
                                                @include('_components._sprite-icons', ['name' => 'box-edit', 'color' => '#273B98', 'size' => 25])
                                                Edit Transaction
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route("logout") }}">
                                                @include('_components._sprite-icons', ['name' => 'trash', 'color' => '#273B98', 'size' => 25])
                                                Delete Transaction
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </section>

            <script>
                window.onload = () => {
                    makePieChart("Interested Products Category", [
                        { "label": "Seragam", "y": 65.0, },
                        { "label": "Attribut", "y": 45.0 }
                    ]).render();
                    makeBarChart("Transactions Over 14 Days", [
                        { "label": "8 August", "y": [4, 400000] },
                        { "label": "9 August", "y": [1, 40000] },
                        { "label": "10 August", "y": [1, 40000] },
                        { "label": "11 August", "y": [0, 0] },
                        { "label": "12 August", "y": [3, 140000] },
                        { "label": "13 August", "y": [1, 2140000] },
                        { "label": "11 August", "y": [0, 0] },
                        { "label": "12 August", "y": [3, 140000] },
                        { "label": "13 August", "y": [1, 2140000] },
                        { "label": "11 August", "y": [0, 0] },
                        { "label": "12 August", "y": [3, 140000] },
                        { "label": "13 August", "y": [1, 2140000] },
                        { "label": "11 August", "y": [0, 0] },
                        { "label": "12 August", "y": [3, 140000] },
                    ]).render();
                }
            </script>
        </main>
    </aside>
</main>

@include('_components._footerAdmin')