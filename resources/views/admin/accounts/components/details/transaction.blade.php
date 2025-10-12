<div class="form-data-profile" id="candidate-transaction-form">
    <div class="wrapper-form">
        <h2>Data Transaksi</h2>
        <div class="container container-3">
            <div class="wrapper-input">
                <label for="total_cost">Nominal Yang Dibayarkan</label>
                <input type="text" name="total_cost" id="total_cost" 
                    placeholder="total_cost" aria-describedby="total_cost" 
                    value="{{ $candidate->transactions[0]['total_cost'] }}" 
                    disabled
                >
            </div>
            <div class="wrapper-input">
                <label for="payment_methode">Jenis Pembayara</label>
                <input type="text" name="payment_methode" id="payment_methode" 
                    placeholder="payment_methode" aria-describedby="payment_methode" 
                    value="{{ $candidate->transactions[0]['payment_method_display_name'] }}" 
                    disabled
                >
            </div>
            <div class="wrapper-input">
                <label for="status">Status Pembayaran</label>
                <input type="text" name="status" id="status" 
                    placeholder="status" aria-describedby="status" 
                    value="{{ $candidate->transactions[0]['status'] }}" 
                    disabled
                >
            </div>
        </div>
    </div>
</div>