<?= $this->extend("dashboard/template/index"); ?>

<!-- sidebar -->
<?= $this->section("sidebar"); ?>
<div class="sidebar h-100" id="sidebar-menu">
  <button id="btn-close-side" class="btn shadow-none d-block d-lg-none text-white ms-auto"><i class="fas fa-chevron-left"></i></button>
  <h1 class="fw-bold mb-4 text-white">Dashboard</h1>
  <ul>
    <li class="<?= ($active  == 'home') ? 'active' : '' ?>">
      <a href="<?= base_url() ?>/dashboard/user_kti_iot/home"><i class="fa-solid fa-house"></i> Home</a>
    </li>
    <li class="<?= ($active  == 'abstrak') ? 'active' : '' ?>">
      <a href="<?= base_url() ?>/dashboard/user_kti_iot/abstrak"><i class="fa-solid fa-note-sticky"></i> Abstrak</a>
    </li>
    <li class="<?= ($active  == 'full_paper') ? 'active' : '' ?>">
      <a href="<?= base_url() ?>/dashboard/user_kti_iot/full_paper"><i class="fas fa-newspaper"></i> Full Paper</a>
    </li>

    <li class="<?= ($active  == 'final') ? 'active' : '' ?>">
      <a href="<?= base_url() ?>/dashboard/user_kti_iot/final"><i class="fa-solid fa-trophy"></i> Final</a>
    </li>
  </ul>
</div>
<?= $this->endSection(); ?>
<!-- /end sidebar -->

<!-- content -->
<?= $this->section("content"); ?>
<h3 class="mb-3">Final</h3>
<!-- Selamat -->
<div class="card-dashboard">
  <h4>Selamat, tim anda lolos ke babak final!</h4>
  <ul>
    <li>Segera persiapkan tim anda untuk mempresentasikan full paper anda.</li>
  </ul>
</div>
<!-- Technical Meeting -->
<div class="card-dashboard">
  <h4>Technical Meeting</h4>
  <ul>
    <li><i class="fas fa-clock"></i> Waktu: 1 Juni</li>
    <li><i class="fas fa-external-link-alt"></i> Link: <span class="important">Coming Soon</span></li>
  </ul>
</div>
<!-- informasi -->
<div class="card-dashboard">
  <h4>Presentasi Final</h4>
  <ul>
    <li><i class="fas fa-clock"></i> Waktu: 4 Juni</li>
    <li><i class="fas fa-headset"></i> Pantau email dan grup whatsapp untuk mengecek sesi kamu.</li>
  </ul>
</div>
<!-- hasil akhir -->
<?php if($juara == 1) :?>
<div class="card-dashboard">
  <h4>Pengumuman Pemenang</h4>
  <ul>
    <h2><li><i class="fas fa-trophy"></i> <span class="important">SELAMAT! <?= $nama?> BERHASIL MERAIH JUARA 1 DALAM LOMBA KTI IOT ARA 2022</span></li></h2>
  </ul>
</div>
<?php elseif($juara == 2):?>
<div class="card-dashboard">
<h4>Pengumuman Pemenang</h4>
  <ul>
    <h2><li><i class="fas fa-trophy"></i> <span class="important">SELAMAT! <?= $nama?> BERHASIL MERAIH JUARA 2 DALAM LOMBA KTI IOT ARA 2022</span></li></h2>
  </ul>
</div>
<?php elseif($juara == 3):?>
<div class="card-dashboard">
<h4>Pengumuman Pemenang</h4>
  <ul>
    <h2><li><i class="fas fa-trophy"></i> <span class="important">SELAMAT! <?= $nama?> BERHASIL MERAIH JUARA 3 DALAM LOMBA KTI IOT ARA 2022</span></li></h2>
  </ul>
</div>
<?php else:?>
<div class="card-dashboard">
  <h4>Pengumuman Pemenang</h4>
  <ul>
  <h2><li><i class="fas fa-trophy"></i> <span class="important">MOHON MAAF, <?= $nama?> DINYATAKAN BELUM DAPAT UNTUK MENJUARAI PERLOMBAAN KTI IOT ARA 2022</span></li></h2>
  </ul>
</div>
<?php endif;?>
<?= $this->endSection(); ?>
<!-- /end content -->