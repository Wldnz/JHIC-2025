<div class="bar-top">
    <h4>{{ $title }}</h4>
    <div class="profile">
        <span class="icon">🧒🏻</span>
        <ul class="main-menu">
            <li>
                <a href="{{ route("profile") }}">
                    @include('_components._sprite-icons', ['name' => 'account', 'color' => '#273B98', 'size' => 20])
                    Profile
                </a>
            </li>
            <li>
                <a href="{{ route("logout") }}">
                    @include('_components._sprite-icons', ['name' => 'logout', 'color' => '#273B98', 'size' => 20])
                    Log Out
                </a>
            </li>
        </ul>
    </div>
</div>
