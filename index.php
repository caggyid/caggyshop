<?php require_once 'includes/header.php'; ?>

<section class="hero">
    <div class="hero-content">
        <h1>Selamat Datang di CaggyShop</h1>
        <p>Tempat terbaik untuk membeli kebutuhan game Anda</p>
    </div>
</section>

<section class="products" id="products">
    <div class="container">
        <h2>Produk Kami</h2>
        <div class="product-grid">
            <?php $products = getProducts($conn); ?>
            <?php foreach ($products as $product): ?>
            <div class="product-card">
                <img src="uploads/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
                <h3><?php echo $product['name']; ?></h3>
                <p><?php echo $product['description']; ?></p>
                <div class="price">Rp <?php echo number_format($product['price'], 0, ',', '.'); ?></div>
                <button class="btn-beli" data-id="<?php echo $product['id']; ?>" data-name="<?php echo $product['name']; ?>" data-price="<?php echo $product['price']; ?>">Beli</button>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Modal Form Pembelian -->
<div id="modal-beli" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h3>Form Pembelian</h3>
        <form id="form-beli">
            <input type="hidden" name="product_id" id="product_id">
            <div class="form-group">
                <label for="nickname">Nickname:</label>
                <input type="text" id="nickname" name="nickname" required>
            </div>
            <div class="form-group">
                <label for="id_game">ID Game:</label>
                <input type="text" id="id_game" name="id_game" required>
            </div>
            <div class="form-group">
                <label for="wa">Nomor WhatsApp:</label>
                <input type="text" id="wa" name="wa" required>
            </div>
            <button type="submit" class="btn-bayar">Bayar Sekarang</button>
        </form>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>