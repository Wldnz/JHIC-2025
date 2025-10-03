@include('_components._headerAdmin', ['title' => 'Settings'])
@php
    $currentPath = explode('/admin/', url()->current())[1];
@endphp
<form method="post" class="content">
    @csrf
    <div class="container">
        <details class="container-details">
            <summary>
                Metode Pembayaran
            </summary>
            <div class="inside-container">
                @foreach ($payment_methods as $method)
                    <div class="wrapper-input wrapper-payment-methode">
                        <input type="checkbox" name="{{ $method->code_name }}" id="{{ $method->code_name }}" {{ $method->is_enable ? "checked" : '' }} required>
                        <div class="wrapper-image">
                            <img src="{{ $method->icon_url }}" alt="{{ $method->display_name }}">
                            <label for="{{ $method->code_name }}">{{ $method->display_name }}</label>
                        </div>
                    </div>
                @endforeach
            </div>
        </details>
    </div>
    <button class="button-submit-form">
        <span>Simpan Perubahan</span>
        @include('_components._sprite-icons', ['name' => 'add', 'size' => 18])
    </button>
</form>
