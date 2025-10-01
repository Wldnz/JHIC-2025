@include('_components._headerAdmin', ['title' => 'Settings'])
@php
    $currentPath = explode('/admin/', url()->current())[1];
@endphp
<main class="content">
    <div class="container">
        <details>
            <summary>
                Management Transaksi
            </summary>
            <div class="inside-container">
                <div class="wrapper-transaction">
                    <details>
                        <summary>
                            E Wallet
                        </summary>
                    </details>
                </div>
            </div>
        </details>
    </div>
</main>

@includeWhen(session()->has('alert'), '_components._alert-message', ['data' => session()->get('alert'), 'icon_name' => 'product'])

<script defer>
    setActionDelete(true, {
        title : 'Transaksi Dengan ID'
    });
</script>