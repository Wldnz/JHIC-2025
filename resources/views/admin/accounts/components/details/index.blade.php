<div class="selection" id="selection">
    <div class="menu menu-selected" id="selection-self">
        <span>Data Pribadi</span>
    </div>
    <div class="menu" id="selection-guard">
        <span>Data Orang Tua</span>
    </div>
    <div class="menu" id="selection-document">
        <span>Dokumen Pendukung</span>
    </div>
    <div class="menu" id="selection-transaction">
        <span>Data Transaksi</span>
    </div>
</div>

@include('admin.accounts.components.details.self')
@include('admin.accounts.components.details.guard')
@include('admin.accounts.components.details.document')
@include('admin.accounts.components.details.transaction')