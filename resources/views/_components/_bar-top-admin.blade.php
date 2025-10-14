<div class="bar-top">
    <div class="side-left">
        <h4>{{ $title }} | </h4>
        <img class="logo-sponsor" src="{{ asset('icons/logo-sponsor.png') }}" alt="logo-sponsor">
    </div>
    <div class="profile" id="profile-admin">
        <span class="icon" id="profile-admin" data-show_main_menu="true">🧒🏻</span>
        <ul class="main-menu">
            <li>
                <a href="{{ route("admin.detail-account", ['account' => Auth::user()->id]) }}">
                    @include('_components._sprite-icons', ['name' => 'account', 'color' => '#273B98', 'size' => 20])
                    Profile
                </a>
            </li>
            <li>
                <form action="{{ route("admin.logout") }}" method="post">
                    @csrf
                    <button type="submit">
                        @include('_components._sprite-icons', ['name' => 'logout', 'color' => '#273B98', 'size' => 20])
                        Log Out
                    </button>
                </form>
            </li>
        </ul>
    </div>
</div>

<script defer>
    document.getElementById('profile-admin').addEventListener('click', (e) => {
        const main_menu = e.target.parentElement.querySelector('.main-menu');
        if(e.target.dataset.show_main_menu ==="true"){
            main_menu.style.display = 'none';
            e.target.dataset.show_main_menu = "false";
        }else{
            main_menu.style.display = 'flex';
            e.target.dataset.show_main_menu = "true";
        }
    });
</script>
