<form class="card-form" id="card-form-{{ $name }}">
    @csrf
    <h4>Tambahkan Variant Produk</h4>
    @foreach ($columns as $key => $column)
        <div class="wrapper-input">
            <label for="{{ $key }}">{{ $column['label-text'] }}
                @if(isset($column['required']) && $column['required'])
                    <span> *</span>
                @endif
            </label>
            <input type="{{ $column['type'] ?? 'text' }}" name="{{ $key . $loop->index + 1 }}" id="{{ $key }}"
                placeholder="{{ $column['placeholder'] }}" {{ isset($column['min']) ? isset($column['type']) && $column['type'] == 'number' ? 'min=' . $column['min'] . '' : 'minlength=' . $column['min'] . '' : 'minlength=3' }} maxlength="250" {{ isset($column['required']) && $column['required'] ? 'required' : '' }}>
        </div>
    @endforeach
    <button type="submit" class="btn-yes-anouncement">Tambahkan Variant</button>
    <button type="button" class="btn-close-anouncement">Tutup Pemberitahuan</button>
</form>