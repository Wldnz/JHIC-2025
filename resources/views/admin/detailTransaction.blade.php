@include('_components._headerAdmin')
@php
    $currentPath = 'transaction';
@endphp
<main class="wrapper-admin">
    @include('_components._navigation-side')
    <aside class="right">
        @include('_components._bar-top-admin')
        <div style="width:100%; height: 25px;"></div>
        <main class="main-admin">
            <div class="wrapper-input">
                <label for="nis">{{ $transaction[0]['id'] }}</label>
                <input type="text" required>
            </div>
        </main>
    </aside>
</main>