@include('_components._headerAdmin', ['title' => 'Adding Transaction'])
@php
    logger('as', [$students])
@endphp
<form class="content" method="post" action="{{ route('admin.store-transaction') }}" enctype="application/x-www-form-urlencoded">
    @csrf
    <h2>Data Pembeli</h2>
    <div class="form-data" id="student-siswa-form">
        <div class="wrapper-field container">
            <div class="wrapper-input">
                <label for="student_nis">NIS</label>
                <input type="text" name="student_nis" id="student_nis" placeholder="Nis Siswa" value="{{ old('user_nis','') }}" readonly required>
            </div>
            <div class="wrapper-input">
                <label for="student_name">Nama Pembeli<span> *</span></label>
                <select name="student_name" id="student_name" required>
                    <option value="">Pilih Nama Siswa</option>
                    @foreach ($students as $student)
                        <option value="{{ $student->name }}" @selected(old('student_name', '')== $student->name)>{{ $student->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <h2>Data Transaksi</h2>
    <div class="form-data" id="transaction-transaksi-form">
        <div class="wrapper-field container tree-row-grid">
            <div class="wrapper-input">
                <label for="total_cost">Total Harga</label>
                <input type="text" inputmode="numeric" name="total_cost" id="total_cost"
                    placeholder="Masukkan total harga" value="{{ old('total_cost',700000) }}"  min="0" required>
            </div>
            <div class="wrapper-input">
                <label for="payment_method">Jenis Pembayaran</label>
                <select name="payment_method" id="payment_method">
                    <option value=""></option>
                    @foreach ($payments as $payment)
                        <option value="{{ $payment->code_name }}" @selected(old('payment_method', '') == $payment->code_name)>{{ $payment->display_name }}</option>
                    @endforeach
                    <option value="cash" @selected(old('payment_method', '') == 'cash')>Uang Tunai</option>
                </select>
            </div>
            <div class="wrapper-input">
                <label for="has_paid">Sudah Dibayar?</label>
                <select name="has_paid" id="has_paid">
                    <option value="0" @selected(old('has_paid', '') == 0)>Belum Dibayar</option>
                    <option value="1" @selected(old('has_paid', '') == 1)>Sudah Dibayar</option>
                </select>
            </div>
        </div>
    </div>
    <div class="wrapper_order" id="wrapper_orders" style="display:none">

    </div>
    <button class="button-submit-form">
        <span>Tambahkan Transaksi</span>
        @include('_components._sprite-icons', ['name' => 'add', 'size' => 18])
    </button>
</form>

<script defer>
    document.getElementById('student_name').addEventListener('change', (e) => {
        const students = @json($students);
        const student = students.find(s => s.name == e.target.value);
        const student_nis =  document.getElementById('student_nis');
        if(student){
            student_nis.value = student.nis;
        }else{
            student_nis.value = "";
        }
    });
</script>
