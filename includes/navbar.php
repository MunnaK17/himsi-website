<header class="site-header">
    <nav class="navbar container">
        <a href="<?= url('index.php'); ?>" class="brand">HIMSI UBSI</a>

        <button class="nav-toggle" type="button" aria-label="Buka menu" aria-expanded="false">
            <span></span>
            <span></span>
            <span></span>
        </button>

        <div class="nav-menu" id="navMenu">
            <a class="<?= active_menu('beranda', $activePage); ?>" href="<?= url('index.php'); ?>">Beranda</a>
            <a class="<?= active_menu('profil', $activePage); ?>" href="<?= url('profil.php'); ?>">Profil</a>
            <a class="<?= active_menu('divisi', $activePage); ?>" href="<?= url('divisi.php'); ?>">Divisi</a>
            <a class="<?= active_menu('program', $activePage); ?>" href="<?= url('program.php'); ?>">Program</a>
            <a class="<?= active_menu('open-recruitment', $activePage); ?>" href="<?= url('open-recruitment.php'); ?>">Open Recruitment</a>
            <a class="<?= active_menu('press-release', $activePage); ?>" href="<?= url('press-release.php'); ?>">Press Release</a>
            <a class="<?= active_menu('kontak', $activePage); ?>" href="<?= url('kontak.php'); ?>">Kontak</a>
        </div>

        <a class="btn btn-primary nav-cta" href="<?= url('open-recruitment.php'); ?>">Gabung Kami</a>
    </nav>
</header>
