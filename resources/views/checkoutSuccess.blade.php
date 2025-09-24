@include ('_components._header')
<div class="checkoutsuccess">
    <div class="checkoutsuccess-page">
        <img src="{{ asset('icons/success.svg') }}" alt="Success" class="success-icon">
    <h1>Thank you for your order!</h1>
    <p>Your order has been successfully processed. A confirmation email has been sent to your email address.</p>

    <div class="ordersummary">
        <h2>Order Summary</h2>
    </div>
    <a href="{{ url('/') }}" class="btn btn-primary">Continue Shopping</a>
    </div>
</div>
@include ('_components._footer')