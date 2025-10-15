@php
    $stages = [
        'stage-1' => [
            'requirements' => $candidate,
            'sub-requirements' => [],
            'destination' => route('candidate.stage.stage1')
        ],
        'stage-2' => [
            'requirements' => $candidate,
            'sub-requirements' => [
                $candidate->candidateMajors ?? null,
                $candidate->candidatePhases ?? null
            ],
            'destination' => route('candidate.stage.stage2')
        ],
        'stage-3' => [
            'requirements' => $candidate,
            'sub-requirements' => [
                $candidate->candidateMajors ?? null,
                $candidate->candidatePhases ?? null,
                $candidate->candidateGuardian ?? null
            ],
            'destination' => route('candidate.stage.stage3')
        ],
        
    ]
@endphp

<div class="bar-top">
    <div class="side-left">
        <h4>{{ $title }}</h4>
    </div>
    <div class="profile-candidate" id="profile-candidate">
        <span class="icon" id="profile-admin" data-show_main_menu="true">
            @include('_components._sprite-icons', ['name' => 'hamburger-menu', 'size' => 20])
        </span>
        <ul class="main-menu close-sidebar-candidate" id="main-menu-navigation">
            <div class="logo">
                <img src="{{ asset('images/bi-full.png') }}" alt="">
            </div>
            <div class="menus">
                <li class="menu menu-selected">
                    <a href="{{ route('candidate.dashboard') }}">
                        @include('_components._sprite-icons', [ 'name' => 'dashboard','color' => $currentPath == 'dashboard' ? 'white' : 'black' ,'size' => 25 ])
                        Dashboard
                    </a>
                </li>
                 <li class="menu">
                    <a href="">
                        @include('_components._sprite-icons', [ 'name' => 'form-time','color' => $currentPath == 'usm' ? 'white' : 'black' ,'size' => 25 ])
                        Ujian Saringan Masuk
                    </a>
                </li>
                 <li class="menu">
                    <a href="">
                        @include('_components._sprite-icons', [ 'name' => 'customer-service','color' => $currentPath == 'contact' ? 'white' : 'black' ,'size' => 25 ])
                        Kontak Kami
                    </a>
                </li>
            </div>
            <div class="actions" id="main-menu-actions">
                @include('_components._sprite-icons', ['name' => 'exception', 'size' => 30])
            </div>
        </ul>
    </div>
</div>

<script defer>
    const main_menu = document.getElementById('main-menu-navigation');
    const main_menu_actions = document.getElementById('main-menu-actions');
    const open_btn = document.getElementById('profile-admin');
    const close_btn = main_menu_actions.children[0];

    function closeNavigation(){
        main_menu.classList.remove('open-sidebar-candidate');
        main_menu.classList.add('close-sidebar-candidate');
        // main_menu.style.display = 'none'
    }

    function openNavigation(){
        // main_menu.style.display = 'flex';
        main_menu.classList.remove('close-sidebar-candidate');
        main_menu.classList.add('open-sidebar-candidate');
    }

    close_btn.addEventListener('click', (e) => closeNavigation());
    open_btn.addEventListener('click', (e) => openNavigation());
</script>