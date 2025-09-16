@include('_components._headerAdmin', ['title' => 'Detail Product {{ $product->name }}'])
<main class="content">
    @php
        logger("data-detail", [$product])
    @endphp
        <h2>Merubah Data Product {{ $product->name }}</h2>
    <form>
        <div class="wrapper-input">
            <label for="name">Nama Produk</label>
            <input type="text" name="name" id="name" placeholder="Masukkan nama product" minlength="3" maxlength="120" required>
        </div>
        <div class="wrapper-input">
            <label for="description">Deskripsi Produk</label>
            <textarea name="description" id="description" placeholder="Masukkan Deskripsi" minlength="10" maxlength="1000" required></textarea>
        </div>
        <div class="wrapper-input">
            <label for="category">Kategori Produk</label>
            <select name="category" id="category">
                <option value="uniform">Seragam Sekolah</option>
                <option value="attribute">Attribut Sekolah</option>
            </select>   
        </div>
        <div class="wrapper-image">
            <input type="file" accept="image/jpeg, image/png" name="product_image" id="product_image" required>
        </div>
    </form> 
</main>

@include('_components._footerAdmin'):