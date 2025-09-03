@include('_components._headerAdmin')

<main class="wrapper-admin">
    <aside class="dummy-left"></aside>
    <aside class="left">
        <nav class="navigation-side">
            <div class="wrapper-navigation">
                <div class="wrapper-image">
                    <img src="{{ asset("icons/default-logo.png") }}" alt="logo-bitu" height="50">
                </div>
                <ul class="main-menu">
                    <li class="active">
                        <img src="{{ asset("icons/logo-active-dashboard.png") }}" alt="logo-account">
                        <a href="{{ route("logout") }}">Dashboard</a>
                    </li>
                    <li>
                        <img src="{{ asset("icons/logo-products.png") }}" alt="logo-product">
                        <a href="{{ route("logout") }}">Products</a>
                    </li>
                    <li>
                        <img src="{{ asset("icons/logo-transactions.svg") }}" alt="logo-transction">
                        <a href="{{ route("logout") }}">Transaction</a>
                    </li>
                    <li>
                        <img src="{{ asset("icons/logo-account.png") }}" alt="logo-account">
                        <a href="{{ route("logout") }}">Account</a>
                    </li>
                </ul>
            </div>
            <!-- <img src="#" alt="hamburger-menu"> -->
            <img src="#" alt="x-menu">
        </nav>
    </aside>
    <aside class="right">
        <div class="bar-top">
            <h4>{{ $title ?? "Dashboard" }}</h4>
            <div class="profile">
                 <img src="{{ asset("icons/logo-active-account.svg") }}" alt="logo-account">
                <ul class="main-menu">
                    <li>
                        <a href="{{ route("logout") }}">
                            <img src="{{ asset("icons/logo-active-account.svg") }}" alt="logo-profile">    
                            Profile
                        </a>
                    </li>
                    <li>
                        <a href="{{ route("logout") }}">
                            <img src="{{ asset("icons/logo-close.svg") }}" alt="logo-logout">    
                            Log Out
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <main class="main-admin">
        </main>
    </aside>
</main>

@include('_components._footerAdmin')