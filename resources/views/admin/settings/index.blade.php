@include('_components._headerAdmin', ['title' => 'Settings'])
@php
    $currentPath = explode('/admin/', url()->current())[1];
    logger('as', [$payments]);
@endphp
<form method="post" action="{{ route('admin.update-settings') }}" class="content">
    @method('PUT')
    @csrf
    <div class="container">
        <details class="container-details">
            <summary>
                Metode Pembayaran
            </summary>
            <div class="inside-container">
                @foreach ($payments as $payment)
                    <div class="wrapper-input wrapper-payment-methode">
                        <input type="checkbox" name="payment_methods[{{ $payment->code_name }}]" id="{{ $payment->code_name }}" {{ $payment->is_enable ? "checked" : '' }}>
                        <div class="wrapper-detail-payment">
                            <img src="{{ $payment->icon_url }}" alt="{{ $payment->display_name }}">
                            <label for="{{ $payment->code_name }}">{{ $payment->display_name }}</label>
                        </div>
                    </div>
                @endforeach
            </div>
        </details>
        <div class="inside-container">
            <div class="wrapper-input">
                
            </div>
        </div>
    </div>
    <button class="button-submit-form">
        <span>Simpan Perubahan</span>
        @include('_components._sprite-icons', ['name' => 'add', 'size' => 18])
    </button>
</form>
