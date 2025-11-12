<style>
  .mapel-card {
    border-radius: 10px;
    transition: transform 0.2s, box-shadow 0.2s;
    cursor: pointer;
    border: none;
  }
  .mapel-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 16px rgba(0,0,0,0.15);
  }
  .mapel-icon {
    width: 100%;
    height: 8rem;
    font-size: 1.5rem;
    border-radius: 5%;
  }
  .badge-status {
    font-size: 0.85rem;
    padding: 5px 10px;
    border-radius: 20px;
  }
</style>

<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Mata Pelajaran - Kelas <?= $kelas['kelas'] ?></h3>
        <div class="card-tools">
          <a href="<?= base_url('dashboard/lms/kelas/'.$kelas['tingkat_kelas_id']) ?>" class="btn btn-sm btn-secondary">
            <i class="fa fa-arrow-left"></i> Kembali
          </a>
        </div>
      </div>
      <div class="card-body">
        <?php if ($active_periode['status'] < 2): ?>
          <div class="alert alert-danger" role="alert">
            <i class="fa fa-exclamation-triangle"></i> Periode ini belum membuka akses LMS. Silakan hubungi administrator untuk informasi lebih lanjut.
          </div>
        <?php endif ?>

        <?php if (empty($list_mapel)): ?>
          <div class="alert alert-info" role="alert">
            <i class="fa fa-info-circle"></i> Belum ada mata pelajaran yang terdaftar untuk kelas <?= $kelas['kelas'] ?>
          </div>
        <?php else: ?>
          <div class="row">
            <?php
            $colors = ['primary', 'success', 'info', 'warning', 'danger', 'dark', 'indigo', 'purple'];
            foreach($list_mapel as $i => $mapel):
              $color = $colors[$i % count($colors)];
              $status_badge = '';
              $status_text = '';
              if ($mapel['jumlah_pertemuan'] > 0 && $mapel['status'] == 0) {
                $status_badge = 'success';
                $status_text = 'ACTIVE';
              } elseif ($mapel['status'] == 1) {
                $status_badge = 'warning';
                $status_text = 'CLOSED';
              } else {
                $status_badge = 'danger';
                $status_text = 'INACTIVE';
              }
            ?>
            <div class="col-md-4 col-lg-3 mb-4">
              <div class="card shadow h-100 mapel-card">
                <div class="card-body d-flex flex-column justify-content-between">
                  <div class="align-items-center mb-3">
                    <div class="bg-<?= $color ?> text-white d-flex align-items-center justify-content-center mapel-icon">
                      <i class="fa fa-book-open" style="font-size:50px;"></i>
                    </div>
                  </div>
                  <div>
                    <div class="font-weight-bold mb-2" style="font-size:1.1rem;">
                      <?= $mapel['nama_mapel'] ?>
                    </div>
                    <div class="text-muted mb-2" style="font-size:0.85rem;">
                      <i class="fa fa-chalkboard-teacher"></i> Kelas: <strong><?= $mapel['kelas'] ?></strong>
                    </div>
                    <div class="mb-2">
                      <span class="badge badge-<?= $status_badge ?> badge-status">
                        <?= $status_text ?>
                      </span>
                    </div>
                    <hr>
                    <div style="font-size:0.9rem;">
                      <i class="fa fa-calendar-alt text-primary"></i>
                      <strong><?= $mapel['jumlah_pertemuan'] ?></strong> Pertemuan
                    </div>
                  </div>
                  <hr style="border: 1px solid #dee2e6; width:100%">
                  <?php if ($mapel['jumlah_pertemuan'] > 0): ?>
                    <button class="btn btn-block btn-outline-<?= $color ?> btnLihatLMS mt-auto" data-mapelid="<?= $mapel['id'] ?>">
                      <i class="fa fa-eye"></i> Lihat LMS
                    </button>
                  <?php else: ?>
                    <button class="btn btn-block btn-secondary mt-auto" disabled>
                      <i class="fa fa-ban"></i> Belum Ada Pertemuan
                    </button>
                  <?php endif ?>
                </div>
              </div>
            </div>
            <?php endforeach ?>
          </div>
        <?php endif ?>
      </div>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.btnLihatLMS').forEach(function(btn) {
      btn.addEventListener('click', function(e) {
        var mapelId = this.getAttribute('data-mapelid');
        window.location.href = '<?= base_url('dashboard/lms/detail/') ?>' + mapelId;
      });
    });
  });
</script>
