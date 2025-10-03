<div class="bar-top">
    <h4>{{ $title }}</h4>
    <div class="profile" id="profile-admin">
        <span class="icon" id="profile-admin" data-show_main_menu="true">🧒🏻</span>
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

<script defer>
    document.getElementById('profile-admin').addEventListener('click', (e) => {
        if(e.target.dataset.show_main_menu){
            e.target.parentElement.children[1].style.display = 'none';
        }else{
            e.target.parentElement.children[1].style.display = 'flex';
        }
        e.target.dataset.show_main_menu = !e.target.dataset.show_main_menu;
    });
</script>
