<style>
  .kelas-card {
    border-radius: 10px;
    transition: transform 0.2s, box-shadow 0.2s;
    cursor: pointer;
    border: none;
  }
  .kelas-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 16px rgba(0,0,0,0.15);
  }
  .kelas-icon {
    width: 100%;
    height: 10rem;
    font-size: 1.5rem;
    border-radius: 5%;
  }
</style>

<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Kelas Tingkat <?= $tingkat_kelas ?></h3>
        <div class="card-tools">
          <a href="<?= base_url('dashboard/lms') ?>" class="btn btn-sm btn-secondary">
            <i class="fa fa-arrow-left"></i> Kembali
          </a>
        </div>
      </div>
      <div class="card-body">
        <?php if (empty($list_kelas)): ?>
          <div class="alert alert-info" role="alert">
            <i class="fa fa-info-circle"></i> Belum ada kelas yang terdaftar untuk tingkat <?= $tingkat_kelas ?>
          </div>
        <?php else: ?>
          <div class="row">
            <?php
            $colors = ['primary', 'success', 'info', 'warning', 'danger', 'dark'];
            foreach($list_kelas as $i => $kelas):
              $color = $colors[$i % count($colors)];
            ?>
            <div class="col-md-4 col-lg-3 mb-4">
              <div class="card shadow h-100 kelas-card">
                <div class="card-body d-flex flex-column justify-content-between">
                  <div class="align-items-center mb-3">
                    <div class="bg-<?= $color ?> text-white d-flex align-items-center justify-content-center kelas-icon">
                      <i class="fa fa-users" style="font-size:60px;"></i>
                    </div>
                  </div>
                  <div>
                    <div class="font-weight-bold mb-2" style="font-size:1.3rem;">
                      Kelas <?= $kelas['kelas'] ?>
                    </div>
                    <div class="text-muted" style="font-size:0.9rem;">
                      <i class="fa fa-user-tie"></i> Wali Kelas:<br>
                      <strong><?= $kelas['guru_nama'] ?></strong>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between" style="font-size:0.9rem;">
                      <div>
                        <i class="fa fa-book text-primary"></i>
                        <strong><?= $kelas['total_mapel'] ?></strong> Mapel
                      </div>
                      <div>
                        <i class="fa fa-user text-success"></i>
                        <strong><?= $kelas['total_siswa'] ?></strong> Siswa
                      </div>
                    </div>
                  </div>
                  <hr style="border: 1px solid #dee2e6; width:100%">
                  <button class="btn btn-block btn-outline-<?= $color ?> btnLihatMapel mt-auto" data-kelasid="<?= $kelas['id'] ?>">
                    <i class="fa fa-eye"></i> Lihat Mata Pelajaran
                  </button>
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
    document.querySelectorAll('.btnLihatMapel').forEach(function(btn) {
      btn.addEventListener('click', function(e) {
        var kelasId = this.getAttribute('data-kelasid');
        window.location.href = '<?= base_url('dashboard/lms/kelas/mapel/') ?>' + kelasId;
      });
    });
  });
</script>
