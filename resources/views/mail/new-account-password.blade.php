<div>
    <h1>Halo, {{ $account->fullname }}</h1>
    <br>
    <h5>Berikut ialah informasi akun yang dapat kamu gunakan untuk login ke SMK Bina Informatika:</h5>
    <p>ID Akun : {{ $account->id }}</p>
    <p>Nama Akun : {{ $account->fullname }}</p>
    <p>Peran Akun : {{ $account->role }}</p>
    <br>
    <p>Email Akun : {{ $account->email }}</p>
    <p>Password : {{ $password }}</p>
</div>
