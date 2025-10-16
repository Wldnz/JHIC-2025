<div>
    <h1>Halo, {{ $account->fullname }}</h1>
    <br>
    <h5>Akun kamu habis di reset ya password nya? Nih password baru nya: </h5>
    <p>ID Akun : {{ $account->id }}</p>
    <p>Nama Akun : {{ $account->fullname }}</p>
    <p>Peran Akun : {{ $account->role }}</p>
    <br>
    <p>Email Akun : {{ $account->email }}</p>
    <p>Password : {{ $password }}</p>
</div>
