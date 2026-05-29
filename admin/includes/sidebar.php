<aside class="sidebar">
    <h2>HIMSI Admin</h2>
    <a class="<?= ($activeAdmin ?? '') === 'dashboard' ? 'active' : ''; ?>" href="<?= url('admin/dashboard.php'); ?>">Dashboard</a>
    <a class="<?= ($activeAdmin ?? '') === 'press-release' ? 'active' : ''; ?>" href="<?= url('admin/press-release/index.php'); ?>">Press Release</a>
    <a class="<?= ($activeAdmin ?? '') === 'program' ? 'active' : ''; ?>" href="<?= url('admin/program/index.php'); ?>">Program Kerja</a>
    <a class="<?= ($activeAdmin ?? '') === 'divisi' ? 'active' : ''; ?>" href="<?= url('admin/divisi/index.php'); ?>">Divisi</a>
    <a class="<?= ($activeAdmin ?? '') === 'members' ? 'active' : ''; ?>" href="<?= url('admin/members/index.php'); ?>">Anggota Divisi</a>
    <a class="<?= ($activeAdmin ?? '') === 'open-recruitment' ? 'active' : ''; ?>" href="<?= url('admin/open-recruitment/index.php'); ?>">Open Recruitment</a>
    <a href="<?= url('index.php'); ?>" target="_blank">Lihat Website</a>
    <a href="<?= url('admin/logout.php'); ?>">Logout</a>
</aside>
