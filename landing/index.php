<?php

require '../function/koneksi.php';
$admins = query("SELECT * FROM admin WHERE idAdmin = 3");
$admin = !empty($admins) ? $admins[0] : ['noHp' => '08123456789'];

?>


<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kiyay Gold Fish - Jual Ikan Mas Koki Premium</title>
  <link rel="stylesheet" href="../assets/css/main.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;800&display=swap" rel="stylesheet">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="icon" type="image/jpeg" href="../assets/img/logo.jpg">

</head>
<body>

<header class="header">
  <nav class="container">
    <a href="?page=beranda" class="logo"><img style="width: 50px; margin-right: 10px" src="../assets/img/logo.jpg">Kiyay GoldFish Lampung</a>
    <div class="header-right">
    <form id="search-form" class="search-form">
      <input type="text" id="search-input" placeholder="Cari Ikan..." aria-label="Cari Ikan">
      <button type="submit" title="Cari"><i class="fas fa-search"></i></button>
    </form>

  <ul class="nav-links">
    <li><a href="?page=beranda">Beranda</a></li>
    <li><a href="?page=produk">Produk</a></li>
    <li><a href="?page=beranda#testimoni">Testimoni</a></li>
    <li><a href="?page=beranda#kontak" class="cta-nav">Hubungi Kami</a></li>
  </ul>

  <!-- Hamburger -->
  <div class="hamburger">
      <span></span>
      <span></span>
      <span></span>
  </div>
</div>

  </nav>
</header>

<main>

  <?php
    
    $pages = (isset($_GET['page'])) ? $_GET['page'] : 'beranda';
    require $pages . '.php';

?>

</main>

    <footer id="kontak" class="footer">
        <div class="container">
            <p>&copy; 2025 Kiyay Gold Fish. Solusi Ikan Mas Koki Premium Anda.</p>
           
        </div>
    </footer>

    <a href="https://wa.me/<?= $admin['noHp']?>?text=Halo%20Kiyay%20Gold%20Fish%2C%20saya%20mau%20bertanya%20tentang%20koleksi%20ikan." target="_blank" class="floating-wa" title="Chat via WhatsApp">
        <i class="fab fa-whatsapp"></i>
    </a>
    
    <div id="detailModal" class="modal">
        <div class="modal-content">
            <span class="close-button" onclick="closeDetail()">&times;</span>
            <h3 id="detailName"></h3>
            <p id="detailSpecs"></p>
            <hr>
            <h4>Deskripsi:</h4>
            <p id="detailDesc"></p>
            <hr>
            <p class="detail-stock">Stok Tersisa: <span id="detailStock"></span> ekor</p>
            <p class="detail-price">Harga: <span id="detailPrice"></span></p>
            <a id="detailWaLink" href="#" target="_blank" class="wa-buy-button full-width-wa">Pesan Sekarang via WhatsApp</a>
        </div>
    </div>

   
    
<script src="../assets/js/main.js" defer></script>
<script src="../assets/js/header-menu.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
<script>
const hamburger = document.querySelector('.hamburger');
const navLinks = document.querySelector('.nav-links');

hamburger.addEventListener('click', () => {
    hamburger.classList.toggle('active');
    navLinks.classList.toggle('show');
});
</script>

<script>
document.querySelectorAll('.nav-links a').forEach(link => {
  link.addEventListener('click', () => {
    document.querySelector('.nav-links').classList.remove('show');
    document.querySelector('.hamburger').classList.remove('active');
  });
});
</script>

</body>
</html>