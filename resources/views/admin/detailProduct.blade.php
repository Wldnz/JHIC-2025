@include('_components._headerAdmin', ['title' => 'Detail Product - ' . $product->name])
<main class="content">
    @php
        logger("data-detail", [$product])
    @endphp
    <h2>Merubah Data Product {{ $product->name }}</h2>
    <form class="form-data">
        <div class="wrapper-field">
            <div class="wrapper-input">
                <label for="name">Nama Produk <span>*</span></label>
                <input type="text" name="" id="" placeholder="Masukkan nama produk" value="{{ $product->name }}" required>
            </div>
            <div class="wrapper-input">
                <label for="description">Deskripsi Produk <span>*</span></label>
                <textarea name="description" id="description" placeholder="Masukkan Deskripsi" minlength="10"
                    maxlength="1000" required>{{ $product->description }}</textarea>
            </div>
            <div class="wrapper-input">
                <label for="category">Kategori Produk <span>*</span></label>
                <select name="category" id="category">
                    <option value="uniform" {{ $product->category == "uniform" ? 'selected' : '' }}>Seragam Sekolah</option>
                    <option value="attribute" {{ $product->category == "attribute" ? 'selected' : '' }}>Attribut Sekolah</option>
                </select>
            </div>
        </div>
        <div class="wrapper-image">
            <input type="file" accept="image/jpeg, image/png" name="product_image" id="product_image" required>
        </div>
    </form>
    <h2>Varian - Varian Produk - {{ $product->name }}</h2>
</main>

@include('_components._footerAdmin'):