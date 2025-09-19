@include('_components._headerAdmin', [ "title" => "Dashboard | Bina Tata Usaha" ])
<main class="content">
    <div class="greeting">
        <h3>Selamat Datang, {{ Auth::user()->fullname }}</h3>
        <span>Kami sudah memberikan ringkasan data terbaru!</span>
    </div>
    @includeWhen(isset($transaction), "_components._summary-section", [
    "name" => "Transaction",
    "destination" => route("admin.products"),
    "data" => $transaction
    ])
    @includeWhen(isset($product), "_components._summary-section", [
    "name" => "Product",
    "destination" => route("admin.products"),
    "data" => $product
    ])
    @includeWhen(isset($activity), "_components._summary-section", [
    "name" => "Accounts & Activities",
    "data" => [
    "Account" => $account,
    "Activity" => $activity
    ]
    ])
</main>

@include('_components._footerAdmin')