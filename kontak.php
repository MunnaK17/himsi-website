<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/functions.php';
$pageTitle = 'Kontak';
$activePage = 'kontak';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';
?>
<main>
    <section class="page-hero"><div class="container"><span class="eyebrow light">Kontak</span><h1>Hubungi HIMSI UBSI</h1><p>Informasi kontak dan media sosial organisasi.</p></div></section>
    <section class="section contact-preview"><div class="container two-column">
        <div class="content-box">
            <h2>Kontak Organisasi</h2>
            <div class="contact-list">
                <div><strong>Telepon</strong><span>+62 21 8000 000</span></div>
                <div><strong>Email</strong><span>himsi@bsi.ac.id</span></div>
                <div><strong>Alamat</strong><span>Jl. Kemanggisan Utama Raya, RT.3/RW.2, Slipi, Kec. Palmerah, Kota Jakarta Barat, Daerah Khusus Ibukota Jakarta 11480</span></div>
                <div><strong>Sosial Media</strong><span>Instagram, TikTok, YouTube</span></div>
            </div>
        </div>
        <div class="map-card">
            <div class="map-frame">
                <iframe
                    src="https://www.google.com/maps?q=Universitas+Bina+Sarana+Informatika+Kampus+Slipi&output=embed"
                    width="100%"
                    height="320"
                    style="border:0;"
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                    allowfullscreen
                    title="Lokasi HIMSI UBSI di Google Maps">
                </iframe>
            </div>
            <a class="map-link" href="https://www.google.com/maps/search/?api=1&query=Universitas+Bina+Sarana+Informatika+Kampus+Slipi" target="_blank" rel="noopener">Buka di Google Maps →</a>
            <div class="office-hour"><span>Jam Operasional</span><strong>09:00 - 17:00</strong></div>
        </div>
    </div></section>
</main>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
